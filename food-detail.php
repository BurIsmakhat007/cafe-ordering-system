<?php
require_once("includes/connection.php");

// Check if the foodId query parameter is present
if (isset($_GET['foodId'])) {
    // Get the foodId from the query parameter
    $foodId = $_GET['foodId'];

    // Prepare the SQL query to fetch the food item
    $sqlQuery = "SELECT f.*, c.categoryName 
                 FROM food_tbl AS f 
                 INNER JOIN category_tbl AS c ON f.foodCategory = c.category_id
                 WHERE f.id = :foodId";

    // Prepare the statement and bind the parameter
    $statement = $conn->prepare($sqlQuery);
    $statement->bindValue(':foodId', $foodId);
    $statement->execute();

    // Fetch the food item
    $item = $statement->fetch();

    // Check if the item exists
    if ($item) {
        // Extract the item details
        $foodName = $item["foodName"];
        $foodPrice = $item["foodPrice"];
        $categoryName = $item["categoryName"];
        $imageUrl = $item["image_url"];
    }
}
?>

<?php include("./user/menu/header.php") ?>
<?php include("./user/menu/nav.php") ?>

<!-- Product section -->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="./includes/images/<?php echo $imageUrl; ?>" alt="..." /></div>
            <div class="col-md-6">
                <!-- <div class="small mb-1">SKU: BST-498</div> -->
                <h1 class="display-5 fw-bolder"><?php echo $foodName; ?></h1>
                <div class="fs-5 mb-5">
                    <!-- <span class="text-decoration-line-through">$45.00</span> -->
                    <span><?php echo "Tzs " . $foodPrice; ?></span>
                </div>
                <p class="lead">Food Category: <?php echo $categoryName; ?></p>
                <div class="d-flex">
                    <?php if (isset($_SESSION['customer_id'])) : ?>
                        <form action="./includes/Cart.php" method="post">
                            <input class="form-control text-center me-3" id="inputQuantity" name="quantity" type="num" value="1" style="max-width: 3rem" />
                            <input class="form-control" id="foodId" name="foodId" type="text" value="<?php echo $foodId; ?>" hidden />
                            <button class="btn btn-outline-dark flex-shrink-0 mt-3" type="submit" name="addToCart">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        </form>
                    <?php else : ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            You need to be logged in to make an order.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Comment Section -->
<?php if (isset($_SESSION['customer_id'])) : ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="mt-4 col-lg-6">
                <h4>Customer Reviews</h4>
                <hr>

                <!-- Comment Form -->
                <form action="./includes/Comment.php" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="fullName" placeholder="Enter your name" name="fullName">
                        <input type="text" class="form-control" id="fullName" placeholder="Enter your name" name="foodId" value="<?php echo $foodId ?>" hidden>
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" id="comment" rows="3" placeholder="Enter your comment" name="comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4" name="addComment">Submit</button>
                </form>
                <hr>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Comments -->
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-5">
            <?php
            $commentQuery = "SELECT * FROM comment_tbl WHERE foodId = :foodId";
            $commentStatement = $conn->prepare($commentQuery);
            $commentStatement->bindValue(':foodId', $foodId);
            $commentStatement->execute();
            $comments = $commentStatement->fetchAll(PDO::FETCH_ASSOC);

            if ($comments) {
                foreach ($comments as $comment) {
                    $commentName = $comment["fullname"];
                    $commentText = $comment["comment"];
            ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $commentName; ?></h5>
                            <p class="card-text"><?php echo $commentText; ?></p>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No comments yet.</p>";
            }
            ?>
        </div>
    </div>
</div>


<?php include("user/menu/footer.php") ?>