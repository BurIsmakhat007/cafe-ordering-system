<?php
session_start();
if (isset($_SESSION['customer_id']) || !empty($_SESSION['customer_id'])) {
    // Redirect to the login page
    $userId = $_SESSION['customer_id'];
    $cust = true;
}
else {
    $cust = false;
}
require_once("./includes/connection.php");

$id=$_GET["id"];

$sqlQuery = "SELECT f.*, c.categoryName 
             FROM food_tbl AS f 
             INNER JOIN category_tbl AS c ON f.foodCategory = c.category_id WHERE c.category_id = $id";
$statement = $conn->prepare($sqlQuery);
$statement->execute();
$result = $statement->fetchAll();

//get all orders
if ($cust == true) {
    $getOrders = $conn->prepare("SELECT * FROM cart_tbl WHERE userId=$userId");
    $getOrders->execute();
}
?>

<?php include("./user/menu/header.php") ?>
<?php include("./user/menu/nav.php") ?>

<!-- Section-->
<section class="py-5 mt-2 mb-5">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php
            if ($result) {
                foreach ($result as $data) {
                    $foodId = $data["id"];
                    $foodName = $data["foodName"];
                    $foodPrice = $data["foodPrice"];
                    $categoryName = $data["categoryName"];
                    $imageUrl = $data["image_url"];
            ?>

                    <div class="col mb-5">
                        <div class="card">
                            <!-- Product image -->
                            <img class="card-img-top" src="./includes/images/<?php echo $imageUrl; ?>" alt="..." />
                            <!-- Product details -->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Food name -->
                                    <h5 class="fw-bolder"><?php echo $foodName; ?></h5>
                                    <!-- Food price -->
                                    <?php echo "Tzs " . $foodPrice; ?>
                                    <!-- Category name -->
                                    <p><?php echo $categoryName; ?></p>
                                </div>
                            </div>
                            <!-- Product actions -->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <!-- <a class="btn btn-outline-primary mt-auto btn-sm" href="#">Add to Cart</a> -->
                                    <a class="btn btn-outline-danger mt-auto btn-sm" href="./food-detail.php?foodId=<?php echo $foodId; ?>">View</a>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo "No food items found.";
            }
            ?>

        </div>
    </div>
</section>

<?php include("./user/menu/footer.php") ?>
