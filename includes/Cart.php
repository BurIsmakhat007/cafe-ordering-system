<?php
require_once("connection.php");
session_start();
// $userID = $_SESSION["userID"];

try {
    if (isset($_POST['addToCart'])) {


        $foodId = $_POST["foodId"];
        $quantity = $_POST["quantity"];
        $customerID = $_SESSION['customer_id'];
    

        $postSqlQuery = "INSERT INTO cart_tbl VALUES (?,?,?,?)";
        $statement = $conn->prepare($postSqlQuery);
        $result = $statement->execute(array(null, $foodId, $quantity, $customerID));

        if ($result == true) {
?>
            <script>
                alert("added Successfully");
                window.location.href = "../index.php";
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
