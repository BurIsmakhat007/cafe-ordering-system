<?php
require_once("connection.php");
session_start();

try {
    if (isset($_POST['addFood'])) {
        $foodName = $_POST['foodName'];
        $foodPrice = $_POST['foodPrice'];
        $foodCategory = $_POST['foodCategory'];

        // Check if the 'images' array key is set and there are no upload errors
        if (isset($_FILES['images']) && $_FILES['images']['error'] === 0) {
            $folder = "images/";
            $image = $_FILES['images']['name'];
            $path = $folder . $image;
            $target_file = $folder . basename($_FILES["images"]["name"]);
            move_uploaded_file($_FILES['images']['tmp_name'], $path);
        } else {
            // Handle the case when the image upload is not successful
?>
            <script>
                alert("Error uploading image");
            </script>
        <?php
            exit;
        }

        $postSqlQuery = "INSERT INTO food_tbl VALUES (?,?,?,?,?,?,?)";
        $statement = $conn->prepare($postSqlQuery);
        $result = $statement->execute(array(null, $foodName, $foodPrice, $foodCategory, $image, null, null));

        if ($result == true) {
        ?>
            <script>
                alert("Food Added Successfully");
                window.location.href = "../admin/product.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Food not Added Successfully");
            </script>
        <?php
        }
    } elseif (isset($_POST['editFood'])) {


        $foodId = $_POST['foodId'];
        $foodName = $_POST['foodName'];
        $foodPrice = $_POST['foodPrice'];
        $foodCategory = $_POST['foodCategory'];

        $postSqlQuery = "UPDATE food_tbl SET foodName = ?, foodCategory = ?,  foodPrice = ?  WHERE id = ?";
        $statement = $conn->prepare($postSqlQuery);
        $statement->execute([$foodName, $foodCategory,  $foodPrice, $foodId]);


        if ($statement == true) {
        ?>
            <script>
                alert("Food edited Successfully");
                window.location.href = "../admin/product.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Not Edited Successfully");
            </script>
<?php
        }
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>