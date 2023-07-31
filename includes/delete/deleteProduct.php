<?php
require_once("../connection.php");
session_start();
// $userID = $_SESSION["userID"];

try {
   


        $foodId = $_GET["foodId"];

        $clearQuery = "DELETE FROM food_tbl WHERE id = ?";
        $clearStatement = $conn->prepare($clearQuery);
        $clearStatement->execute([$foodId]);
       
    
        if ($clearStatement == true) {
?>
            <script>
                alert("Deleted Successfully");
                window.location.href = "../../admin/product.php";
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
