<?php
require_once("../includes/connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve order details from order_tbl, order_details_tbl, transaction_tbl, and food_tbl
    $sqlQuery = "SELECT *
                 FROM order_tbl
                 INNER JOIN order_details_tbl ON order_tbl.orderId = order_details_tbl.orderId
                 INNER JOIN transaction_tbl ON order_tbl.orderId = transaction_tbl.orderId
                 INNER JOIN food_tbl ON order_details_tbl.foodId = food_tbl.id
                 WHERE order_tbl.orderId = ?";
    $statement = $conn->prepare($sqlQuery);
    $statement->execute([$id]);
    $result = $statement->fetchAll();

    // Check if order exists
    if ($result) {
        $orderData = $result[0];
        $orderId = $orderData["orderId"];
        // $fullName = $orderData["fullName"];
        $orderStatus = $orderData["orderStatus"];
        $paymentStatus = $orderData["paymentStatus"];
        $foodName = $orderData["foodName"];
        $quantity = $orderData["quantity"];
        $price = $orderData["price"];

        // Determine order status label
        switch ($orderStatus) {
            case 0:
                $status = "Pending";
                break;
            case 1:
                $status = "Shipped";
                break;
            case 2:
                $status = "Cancelled";
                break;
            case 3:
                $status = "Complete";
                break;
            default:
                $status = "Unknown";
                break;
        }

        // Determine payment status label
        switch ($paymentStatus) {
            case 0:
                $p_status = "Unpaid";
                break;
            case 1:
                $p_status = "Paid";
                break;
            default:
                $p_status = "Unknown";
                break;
        }
    } else {
        // Order not found, handle error or redirect
        // ...
    }
} else {
    // Invalid or missing order ID, handle error or redirect
    // ...
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        h1 {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            max-width: 600px;
        }
        th {
            width: 30%;
            background-color: #f8f9fa;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Details</h1>
        <table class="table">
            <tr>
                <th>Order ID:</th>
                <td><?php echo $orderId; ?></td>
            </tr>
            
            <tr>
                <th>Order Status:</th>
                <td><?php echo $status; ?></td>
            </tr>
            <tr>
                <th>Payment Status:</th>
                <td><?php echo $p_status; ?></td>
            </tr>
        </table>

        <h3>Order Items</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Food Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $item) { ?>
                <tr>
                    <td><?php echo $item["foodName"]; ?></td>
                    <td><?php echo $item["quantity"]; ?></td>
                    <td><?php echo $item["foodPrice"]; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <form action="../includes/ConfirmOrder.php" method="post">
            <input type="hidden" name="orderId" value="<?php echo $orderId; ?>">
            <button type="submit" class="btn btn-primary" name="confirmOrder">Confirm Order</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
