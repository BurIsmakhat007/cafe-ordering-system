<?php
require_once("connection.php");
session_start();


try {
    if (isset($_POST['addFoodCategory'])) {


        $categoryName = $_POST["foodCategoryName"];


        $postSqlQuery = "INSERT INTO category_tbl VALUES (?,?,?,?)";
        $statement = $conn->prepare($postSqlQuery);
        $result = $statement->execute(array(null, $categoryName, null, null));

        if ($result == true) {
?>
            <script>
                alert("Category Added Successfully");
                window.location.href = "../admin/category.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Category not Added Successfully");
            </script>
        <?php
        }
    } elseif (isset($_POST['editFoodCategory'])) {

        $id = $_POST["id"];
        $categoryName = $_POST["foodCategoryName"];


        $postSqlQuery = "UPDATE category_tbl SET categoryName = ? WHERE category_id = ?";
        $statement = $conn->prepare($postSqlQuery);
        $statement->execute([$categoryName, $id]);


        if ($statement == true) {
        ?>
            <script>
                alert("Category Edited Successfully");
                window.location.href = "../admin/category.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Category not Edited Successfully");
            </script>
<?php
        }
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
