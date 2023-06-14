<!DOCTYPE html>
<html lang="en">

<?php
require_once("./includes/connection.php");

$sqlQuery = "SELECT * FROM category_tbl";
$statement = $conn->prepare($sqlQuery);
$statement->execute();
$result = $statement->fetchAll();
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
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $category['categoryName']; ?></h5>
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