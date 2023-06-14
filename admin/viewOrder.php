<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit;
}
?>

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto Mono', monospace;
        }
    </style>
    <style>
        body {
            padding: 20px;
            background-image: url('data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ8NDQ0NFREWFhURFRUYHSggGBolGxUVITEhJSkrLi4uFx8zODMsNygtLisBCgoKDQ0NDg0NDisZFRkrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrK//AABEIAK4BIgMBIgACEQEDEQH/xAAZAAEBAQEBAQAAAAAAAAAAAAACAQADBAf/xAAfEAEBAQEBAQADAAMAAAAAAAAAARESAhMDIWEiMVH/xAAVAQEBAAAAAAAAAAAAAAAAAAAAAf/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/APpjMyoysoMrRQaQpGkKQExcVZATFxZCkAcXCxcFHFwsXAGRsLGwAxsdMTADEx0xMAMTDxMAMTDxMEc7EsOxLACxMKxLABDo0BQq2ALMwMzMDM0WAqxIUBoUSFAXFkSFAaQpGkKQEkKRpCkFSQsWRZATGwsXAHGw8bADGw8bADEw8TACxLDxLAc7EsdLBsBzsSw7BsECxLDo0Ao062AGDSqUBRUBmZgYkiwFixosBYUSFAWFEhQGhSJDgrSFI0KQGkWRoUgJhY0hYA4uLi4A4mHjYAYmHYlgOdiWHYlBzsSw7BoBYNOjQCjTo0QKNOjQGjSqUBRalBGZgWFEhT9AuLEhQFhRIUBYsSFBVhRIUAoUGFAWFEhQFixosBsXFUBxsJAHBp0aA0aVSgFGnRoBRpVKAUaVGgNGlRog0aVGglEqmALFzUA/9NEhQFhRIcBpCkaQpBWjLi4DQoKwDhQYUAoQQoBxYMWUDUNWUCRNbQajVEEqVaNBKNWjQGjSo0Bo0qNAaNKjRBo0qNBKijQXqojA6QpEhQCkKRIcgLIUjSHIKOLhY2AFjRbEAosCFKBwpQlWUDlXQ1dA10NXQLW0dTQLUtTU0GtS1NS0Go1rUtBKNW0bQSjVo0RKNKpYAVKViWANEsTARC5YDhwIfkDhwIcA4cCFBSZmBKFOhQRZRrSg6SrKEKAWrosB62hraB62hraBamjraC6lqagNalrJQSjSo0EXGkOQA5Xl0kbAcb5G+Xe+QsBwvlpHT1EkEHlnTGBxhQIUB1hxzhwHSFK5ylBT1hbQWjWtG0EqwSgFDgeTgKzMCUaVCg2to1gJkUFZmBKNIaCUSqQC8w5E8x0kBMXDkbAcrA9R2sD1AcPUGR09QfMEXGLFByniHPETVFKeYUkBgdP02wcXAXqJqyFIDn+24dZFkBy+az8bti4DlPC8V1xQcuK3DsoOHzb5PQ36B5/k3yej9MDzfJvk9CA8/wA24d8TAcOBvh6LEsB574G+HpsGwHDmt/l/12xLAcu/TfX0diWAP1o38tK+UvkBv5P4F9/w+U5ETr+IvLAaoopKOtoGoaugerrnq6Dpq6562g662uetoOvS9OXTdA69L049L0Dr03Tl03QOvTdOXTdA69J059J0Dr0nTn03QOmpodJoHqaGtoFqUdbQVKmpoLUramg1RtQGZmETW0dYD1tHWA9bRjaB62hraKeroa2getoa2g6a2hrAet0GtoHraGtoHraGtoHrdBraB63Qa2gWto6mgetoa2gWto6gFraOtoLraOtoi6yJoLrIgP/Z');
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-size: cover;
            background-repeat: no-repeat;
            background-color: rgba(0, 0, 0, 0.5);
            /* Adjust the alpha value (0.5) as per your preference */
        }

        .card {
            border: 1px solid #ccc;
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
    <div class="container justify-content-center mt-5">

        <div class="row">
            <div class="col-md-6">
                <h1 class="text-center">Order Details</h1>
                <div class="card">
                    <div class="card-body">
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
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-5">
                <h3 class="text-center">Order Items</h3>

                <div class="card">
                    <div class="card-body">
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


                    </div>
                </div>


            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mt-5">
                <form action="../includes/ConfirmOrder.php" method="post" class="text-center">
                    <input type="hidden" name="orderId" value="<?php echo $orderId; ?>">
                    <button type="submit" class="btn btn-outline-primary btn-sm" name="confirmOrder">Confirm Order</button>
                </form>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>