<?php
require_once("../connection.php");
session_start();
// $userID = $_SESSION["userID"];

try {
   


        $categoryId = $_GET["categoryId"];

        $clearQuery = "DELETE FROM category_tbl WHERE category_id = ?";
        $clearStatement = $conn->prepare($clearQuery);
        $clearStatement->execute([$categoryId]);
       
    
        if ($clearStatement == true) {
?>
            <script>
                alert("Deleted Successfully");
                window.location.href = "../../admin/category.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Not Deleted Successfully");
            </script>
        <?php
        }
    
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
