<?php
require_once("connection.php");
session_start();
// $userID = $_SESSION["userID"];

try {
    if (isset($_POST['confirmOrder'])) {


       
        $orderId = $_POST["orderId"];
        $paymentStatus = 1;
        $orderStatus = 3;

    

        $postSqlQuery = "UPDATE order_tbl SET paymentStatus = ?, orderStatus = ? WHERE orderId = ?";
        $statement = $conn->prepare($postSqlQuery);
        $statement->execute([$paymentStatus, $orderStatus, $orderId]);

        if ($statement == true) {
?>
            <script>
                alert("Recorded Successfully");
                window.location.href = "../admin/order.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Not Added Successfully");
            </script>
        <?php
        }
    } 
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
