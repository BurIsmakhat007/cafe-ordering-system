<!DOCTYPE html>
<html lang="en">

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

$sqlQuery = "SELECT * FROM category_tbl";
$statement = $conn->prepare($sqlQuery);
$statement->execute();
$result = $statement->fetchAll();

//get all orders
if ($cust == false) {
    $getOrders = $conn->prepare("SELECT * FROM cart_tbl");
    $getOrders->execute();
}
elseif ($cust == true) {
    $getOrders = $conn->prepare("SELECT * FROM cart_tbl WHERE userId=$userId");
    $getOrders->execute();
}
?>

<?php
include("./user/menu/header.php");
include("./user/menu/nav.php");
?>

<body>
    <section class="py-5">
        <div class="container px-4 px-lg-6">
            <div class="card border border-danger">
                <div class="card-body">
                    <h2 class="mb-5 text-center">Our Menu</h2>
                    <div class="row justify-content-center">
                        <?php if ($result) : ?>
                            <?php foreach ($result as $category) : ?>
                                <div class="col-3">
                                    <div class="card mb-4">
                                        <div class="card-body btn btn-outline-secondary">
                                            <!-- <?php //echo $category['fileUrl']; ?> -->
                                            <!-- <h5 class="card-title"><?php //echo $category['categoryName']; ?></h5> -->
                                            <a class="card-title" style="text-decoration: none; color: black; margin-left: 15px;" href="./category.php?id=<?php echo $category['category_id']; ?>"><?php echo $category['categoryName']; ?></a>
                                            <!-- <a href="index.php" class="btn btn-outline-secondary btn-sm" style="margin-left: 10px;">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="nav-link">Home</span>

                    </a> -->
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No categories found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    include("./user/menu/footer.php");

    ?>