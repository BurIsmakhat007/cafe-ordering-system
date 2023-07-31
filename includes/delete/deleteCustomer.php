<?php
require_once("../connection.php");
session_start();
// $userID = $_SESSION["userID"];

try {
   


        $customer_id = $_GET["customer_id"];

        $clearQuery = "DELETE FROM customer_tbl WHERE customer_id = ?";
        $clearStatement = $conn->prepare($clearQuery);
        $clearStatement->execute([$customer_id]);
       
    
        if ($clearStatement == true) {
?>
            <script>
                alert("Deleted Successfully");
                window.location.href = "../../admin/customer.php";
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
