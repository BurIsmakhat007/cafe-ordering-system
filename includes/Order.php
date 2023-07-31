<?php
require_once("connection.php");
session_start();
// $userID = $_SESSION["userID"];
$userId = $_SESSION['customer_id'];

try {


    // Function to generate a random order ID
    function generateRandomOrderId()
    {
        $min = 100; // Minimum value for the order ID
        $max = 999; // Maximum value for the order ID

        // Generate a random number within the specified range
        $orderId = mt_rand($min, $max);

        return $orderId;
    }

    // Check if the form is submitted
    if (isset($_POST['addOrder'])) {
        // Assuming you have the necessary variables
        // $userId = $_SESSION["userID"];
        
        $refNumber = $_POST["refNumber"];
        $totalPrice = $_POST["totalPrice"];
        $paymentStatus = 0;
        $orderStatus = 0;

        // Generate a random order ID
        $orderId = generateRandomOrderId();

        // Insert the order data into the order_tbl
        $orderQuery = "INSERT INTO order_tbl VALUES (?, ?, ?, ?, ?, ?, ?)";
        $orderStatement = $conn->prepare($orderQuery);
        $orderStatement->execute([null, $orderId, $userId, 0, 0, null, null]);


        // Insert the order details into the order_details table
        if ($orderStatement) {

            $cartQuery = "SELECT p.id, p.foodName, p.foodPrice, p.image_url, c.quantity, (p.foodPrice * c.quantity) AS total
            FROM cart_tbl AS c
            INNER JOIN food_tbl AS p ON c.cart_id = p.id
            WHERE c.userId = $userId";


            $cartStatement = $conn->prepare($cartQuery);
            $cartStatement->execute();
            $cartItems = $cartStatement->fetchAll(PDO::FETCH_ASSOC);

            if ($cartItems) {
                foreach ($cartItems as $cartItem) {
                    $foodId = $cartItem['id'];
                    $price = $cartItem['foodPrice'];
                    $quantity = $cartItem['quantity'];
                    $total = $cartItem['total'];

                    $sql = "INSERT INTO order_details_tbl VALUES (?,?,?,?,?,?,?)";
                    $statement = $conn->prepare($sql);
                    $statement->execute([
                        null,
                        $orderId,
                        $foodId,
                        $price,
                        $quantity,
                        $total,
                        null
                    ]);
                }
            }
        }

        // Insert the order ID and reference number into the transaction_tbl
        $transactionQuery = "INSERT INTO transaction_tbl VALUES (?, ?, ?, ?)";
        $transactionStatement = $conn->prepare($transactionQuery);
        $transactionStatement->execute([null, $orderId, $totalPrice, $refNumber]);

        if ($transactionStatement) {
            // Clear the cart (assuming you have a separate table to store the cart items)
            $clearCartQuery = "DELETE FROM cart_tbl WHERE userId = ?";
            $clearCartStatement = $conn->prepare($clearCartQuery);
            $clearCartStatement->execute([$userId]);
        }

        // Redirect or display success message
        if ($clearCartStatement == true) {
?>
            <script>
                alert("Order added Successfully");
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
