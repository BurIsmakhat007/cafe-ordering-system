<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit;
}

require_once("../includes/connection.php");

// Function to get the data for the report
function getReportData($month, $year, $conn) {
   //Prepare the query to fetch data for the selected month and year
    // $stmt = $conn->prepare('SELECT * FROM food_tbl WHERE MONTH(created_at) = :month AND YEAR(created_at) = :year');
    $stmt = $conn->prepare('SELECT * FROM order_tbl INNER JOIN customer_tbl ON order_tbl.userId = customer_tbl.customer_id WHERE MONTH(created_at) = :month AND YEAR(created_at) = :year GROUP BY order_tbl.orderId');
    $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchBtn'])) {
    $selectedMonth = $_POST['month'];
    $selectedYear = $_POST['year'];

    // Get the data for the report
    $reportData = getReportData($selectedMonth, $selectedYear, $conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- <title>Suza Cafe - Admin</title> -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../admin/assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400&display=swap" rel="stylesheet">
    <title>Generate Report</title>
    <!-- <style> -->
        <style>
    /* Your existing styles for the table */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    /* Hide the Print button when printing */
    @media print {
        button {
            display: none;
        }
    }
</style>

    <!-- </style> -->
</head>
<body>

    <!-- Your HTML form here -->

    <?php
    if (isset($reportData) && count($reportData) > 0) {
        echo '<table>';
        echo '<tr><th>Date</th><th>Customer</th><th>Payment Status</th></tr>';
        foreach ($reportData as $row) {
            $paymentStatus = $row["paymentStatus"];

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
            echo '<tr>';
            echo '<td>' . $row['created_at'] . '</td>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>' . $p_status . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No data found for the selected month and year.';
    }
    ?>

    <!-- Print button -->
    <button class="btn btn-primary" onclick="window.print()">Print Report</button>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../admin/assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../admin/assets/js/datatables-simple-demo.js"></script>
</body>
</html>
