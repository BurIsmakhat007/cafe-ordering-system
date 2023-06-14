<?php
include("./user/menu/header.php");
include("./user/menu/nav.php");
?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Order Table</h1>
                <table id="orderTable" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">Order ID</th>
                            <th class="text-center">Payment Status</th>
                            <th class="text-center">Order Status </th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>

<?php
require_once("includes/connection.php");
// session_start();
$customerId = $_SESSION['customer_id'];


$sqlQuery = "SELECT * FROM order_tbl INNER JOIN customer_tbl ON order_tbl.userId = customer_tbl.customer_id WHERE customer_tbl.customer_id = $customerId  GROUP BY order_tbl.orderId";
$statement = $conn->prepare($sqlQuery);
$statement->execute();
$result = $statement->fetchAll();

if ($result == true) {


    foreach ($result as $data) {
        $id = $data["orderId"];
        $fullName = $data["fullname"];
        $orderId = $data["orderId"];
        $paymentStatus = $data["paymentStatus"];
        $orderStatus = $data["orderStatus"];

        switch($orderStatus) {
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

        switch($paymentStatus) {
            case 0:
                $p_status = "UnaPaid";
                break;
            case 1:
                $p_status = "Paid";
                break;
            default:
                $p_status = "Unknown";
                break;
        }
?>
        <tr>
           
            <td><?php echo $orderId; ?></td>
            <td><?php echo $p_status; ?></td>
            <td><?php echo $status; ?></td>
            
            <td>
               
                <a href="viewOrder.php?id=<?php echo $id; ?>" type="button" class="btn btn-outline-danger btn-sm">View Order </a>
                
            </td>
        </tr>
       
<?php }
} ?>

</tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#orderTable').DataTable();
        });
    </script>
</body>
</html>
