<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Suza Cafe - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../admin/assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400&display=swap" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
            font-family: 'Roboto Mono', monospace;
        }
        .heading {
            padding-top: 50px;
            text-shadow: 6px;
            text-align: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .row {
            width: 100%;
            /*border-top: 1px solid cadetblue;*/
            position: absolute;
            /*display: inline-block;*/
            bottom: 0;
            text-align: center;
            background-color: red;
            padding-left: 7%
        } 
        .footer {
            /*position: absolute;*/
            bottom: 0;
            /*padding: 20px;*/
            /*display: flex;*/


        } 
        .row p #me {
            display: inline;
        }  
        .row p #me:hover{
            
        }

        .logo{
            text-align: center;
            display: flex;
            margin: 10px 0 0 10px;
            padding-bottom: 3rem;
        }

        .logo img{
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }
        .logo span{
            font-weight: bold;
            padding-left: 15px;
            font-size: 18px;
            text-transform: uppercase;
        }
        nav .fas{
            position: relative;
            width: 70px;
            height: 40px;
            top: 20px;
            font-size: 20px;
            text-align: center;
        }
        .nav-item{
            position: relative;
            top: 12px;
            margin-left: 10px;
        }
        .container{
            display: flex;
        } 
    




        
        #myBtn {
            background-color: whitesmoke;
            color: black;
            border: 1px solid cadetblue;
            cursor: pointer;
            /*width: 120px;*/
            /*height: 30px;*/
            display: inline-block;
            outline: none;
            /*padding: 2% 1%;*/
            font-size: 16px;
            padding: 6px 14px;
            border-radius: 10px;
            /*box-shadow: 0 8px 16px rgba(0, 0, 0, .3);*/
            text-align: center;
            /*font-stretch: condensed;*/
            transition: .3s;
        }
        #myBtn:hover {
            opacity: .7;
            background-color: cadetblue;
            color: whitesmoke;
            transition: ease-in all 0.1s;
        }  
        .b4t {
            padding-left: 20px;
            display: flex;
        }
        
            
        .b4 {
            width: 96%;
            display: block;
            margin: 20px;
        }
        #btnLinks {
            text-decoration: none;
        }
        #btnDelete {
           background-color: red;
           color: whitesmoke;
           /*font-weight: bolder;*/
        }
        #mBtn {
            background-color: green;
           color: whitesmoke;
           /*font-weight: bolder;*/
        }


        /*Item List serction  */
        .item{
            margin-top: 120px;
            text-transform: capitalize;
            clear: both;

        }
        .item-list{
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
        }
        .table{
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 15px;
            min-width: 100%;
            overflow: hidden;
            border-radius: 5px 5px 0 0;
        }
        table thead tr{
            color: #fff;
            background: cadetblue;
            text-align: left;
            font-weight: bold;
        }
        .table th,
        .table td{
            padding: 10px 13px;
        }
        .table tbody tr{
            border-bottom: 1px solid #ddd;
        }
        .table tbody tr:nth-of-type(odd){
            background: #f3f3f3;
        }
        .table tbody tr:last-of-type{
            border-bottom: 2px solid cadetblue;
        }
        .table button{
            padding: 6px 14px;
            border-radius: 10px;
            cursor: pointer;
            /*background: transparent;*/
            border: none;
            /*border: 1px solid black;*/
        }
        .table button:hover{
            /*transition: 0.5rem;*/
        }
        form input {
            padding: 10px;
        }
        form select {
            padding: 10px;
        }
        
        form legend {
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="sb-nav-fixed">


    <?php include("nav.php"); ?>
    <!-- <div class="container"> -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
    <!-- <section class="main"> -->
    <h1 class="mt-4">Report</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Report</li>
                </ol>

        <div class="card mb-4" style="width: 60%;float: left; background: whitesmoke; border-radius: 20px; padding:20px; margin: 10px;box-shadow: 0 6px 10px rgba(0, 0, 0, .3);">
            <!-- <form method="GET">
                <fieldset>
                    <legend>Search by Date:</legend>
                    <label>From:</label>
                    <input type="Date" name="fromDate">
                    <label>To:</label>
                    <input type="Date" name="toDate">
                    <button type="submit" name="sDate">Search</button>
                </fieldset>
            </form> -->
            <form method="POST" action="generate_report.php">
                <label for="month">Select Month:</label>
                <select name="month" id="month">
                    <!-- Add options for all months here -->
                    <option value="">-Choose Month-</option>
                    <?php
                    $months = array("January", "February", "March", "April", "May", "June", "July", "August",
                        "September", "October", "November", "December");
                    $arrlength = count($months);

                    for($x = 0; $x < $arrlength; $x++) { ?>
                    <option value="<?php echo $x+1; ?>"><?php echo $months[$x]; ?></option> 
                    <?php } ?>
                </select>

                <label for="year">Select Year:</label>
                <select name="year" id="year">
                    <!-- Add options for all years here -->
                    <option value="">-Choose Year-</option>
                    <?php
                    for($x = 2020; $x < 2026; $x++) { ?>
                    <option value="<?php echo $x; ?>"><?php echo $x; ?></option> 
                    <?php } ?>
                </select>

                <button type="submit" class="btn btn-primary" name="searchBtn">Search</button>
            </form>

        </div>

        <!-- <div class="col-6" style="width: 45%;float: left;background: whitesmoke; border-radius: 20px; padding:20px; margin: 10px;box-shadow: 0 6px 10px rgba(0, 0, 0, .3);">
            <form method="GET">
                <fieldset>
                    <legend>Search by Month:</legend>
                    <label>To:</label>
                    <select name="month">
                        <option value="">-Choose Month-</option>
                    <?php
                    $months = array("January", "February", "March", "April", "May", "June", "July", "August",
                        "September", "October", "November", "December");
                    $arrlength = count($months);

                    for($x = 0; $x < $arrlength; $x++) { ?>
                    <option value="<?php echo $x+1; ?>"><?php echo $months[$x]; ?></option> 
                    <?php } ?>
                    </select>
                    <button type="submit" name="sMonth">Search</button>
                  
                </fieldset>
            </form>
        </div> -->







            <!-- load products -->
        <!-- <section class="item">
        <div class="item-list">
        <h2>Report</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Orders Type</th>
                    <th>Order Quantity</th>
                    <th>Product</th>
                    <th>Gender</th>
                    <th>Month/Date</th>
                    <th>Address</th>
                </tr>
            </thead>

            <tbody>
                <?php 

                    if(isset($_GET['sMonth'])) {
                        $month = $_GET['month'];
                        $sql ="SELECT * FROM Customer,oorder,order_item,product WHERE customer.custId=oorder.Cust_Id AND oorder.Order_Id=order_item.Order_Id AND product.Prod_Id=order_item.Prod_Id and month(oorder.Time_Date) =  '$month' order by oorder.Order_Id desc";
                        $rpt_monthly=$conn->prepare($sql);
                        $rpt_monthly->execute();
                        $infos = $rpt_monthly->fetchAll(PDO::FETCH_ASSOC);

                        $deliverytotal=$conn->prepare("SELECT * FROM Customer,oorder,order_item,product WHERE customer.custId=oorder.Cust_Id AND oorder.Order_Id=order_item.Order_Id AND product.Prod_Id=order_item.Prod_Id and month(oorder.Time_Date) =  '$month' AND type='Delivery' order by oorder.Order_Id desc");
                        $deliverytotal->execute();

                        $takeawaytotal=$conn->prepare("SELECT * FROM Customer,oorder,order_item,product WHERE customer.custId=oorder.Cust_Id AND oorder.Order_Id=order_item.Order_Id AND product.Prod_Id=order_item.Prod_Id and month(oorder.Time_Date) =  '$month' AND type='Takeaway' order by oorder.Order_Id desc");
                        $takeawaytotal->execute();

                        $maletotal=$conn->prepare("SELECT * FROM Customer,oorder,order_item,product WHERE customer.custId=oorder.Cust_Id AND oorder.Order_Id=order_item.Order_Id AND product.Prod_Id=order_item.Prod_Id and month(oorder.Time_Date) =  '$month' AND gender='M' GROUP BY Customer.custId order by oorder.Order_Id desc");
                        $maletotal->execute();

                        $femaletotal=$conn->prepare("SELECT * FROM Customer,oorder,order_item,product WHERE customer.custId=oorder.Cust_Id AND oorder.Order_Id=order_item.Order_Id AND product.Prod_Id=order_item.Prod_Id and month(oorder.Time_Date) =  '$month' AND gender='F' GROUP BY Customer.custId order by oorder.Order_Id desc");
                        $femaletotal->execute();


                        $sn=1;
                    foreach($infos as $info) {
                 ?>
                <tr>
                    <td><?php echo $sn ?></td>
                    <td><?php echo $info['type'] ?></td>
                    <td><?php echo $info['oQuantity'] ?></td>
                    <td><?php echo $info['Prod_Name'] ?></td>
                    <td><?php echo $info['gender'] ?></td>
                    <td><?php echo $month ?></td>
                    <td><?php echo $info['addr'] ?></td>
                </tr>
            <?php 
                $sn++;
                }
            } ?>



            <?php 

                    if(isset($_GET['sDate'])) {
                        $from = $_GET['fromDate'];
                        $to = $_GET['toDate'];
                        $sqlm ="SELECT * FROM Customer,oorder,order_item,product WHERE customer.custId=oorder.Cust_Id AND oorder.Order_Id=order_item.Order_Id AND product.Prod_Id=order_item.Prod_Id AND Time_Date BETWEEN '$from' AND '$to' order by oorder.Order_Id desc";
                        $rpt_monthl=$conn->prepare($sqlm);
                        $rpt_monthl->execute();
                        $infs = $rpt_monthl->fetchAll(PDO::FETCH_ASSOC);
// $rpt=$rpt_monthly->rowCount();

                        $sn=1;
                    foreach($infs as $inf) {
                        
                 ?>
                <tr>
                    <td><?php echo $sn ?></td>
                    <td><?php echo $inf['type'] ?></td>
                    <td><?php echo $inf['oQuantity'] ?></td>
                    <td><?php echo $inf['Prod_Name'] ?></td>
                    <td><?php echo $inf['gender'] ?></td>
                    <td><?php echo "$from to $to" ?></td>
                    <td><?php echo $inf['addr'] ?></td>
                </tr>
            <?php 
                $sn++;
                }
            } ?>
            </tbody>
          </table>

          

        </div>
        <table class="table" style="padding-top: 20px;">
              <tr>
                  <th>Month</th>
                  <th>Male</th>
                  <th>Female</th>
                  <th>Total Order</th>
                  <th>Takeaway Order</th>
                  <th>Delivery Order</th>
                  <th>Action</th>
              </tr>
              <tr style="text-align: center;">
               <?php if(isset($_GET['sMonth'])) { ?>
                  <td><?php echo $month ?></td>
                  <td><?php echo $maletotal->rowCount(); ?></td>
                  <td><?php echo $femaletotal->rowCount(); ?></td>
                  <td><?php echo $rpt_monthly->rowCount(); ?></td>
                  <td><?php echo $takeawaytotal->rowCount(); ?></td>
                  <td><?php echo $deliverytotal->rowCount(); ?></td>
                  <td><form method="POST"><button class="btn" name="btnrep" style="background-color:blue;color: whitesmoke;">Add to report</button></form></td>
                  <?php
                    if(isset($_POST['btnrep'])) {
        $mwezi = $month;
        $male =  $maletotal->rowCount();
        $female = $femaletotal->rowCount();
        $total = $rpt_monthly->rowCount();
        $delivery = $deliverytotal->rowCount();
        $takeaway = $takeawaytotal->rowCount();

        $insetRep = "INSERT INTO report (repID, mwezi, male, female, total, delivery, takeaway) VALUES ('','$mwezi', '$male', '$female', '$total', '$delivery', '$takeaway')";
        $insert_stmt=$conn->prepare($insetRep);
        $insert_stmt->execute();
    
    } 

                  ?>
              <?php } ?>
              </tr>
          </table>
       </section> -->

   </div>
    </main>
    <!-- </section> -->
<!-- </div> -->
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../admin/assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../admin/assets/js/datatables-simple-demo.js"></script>
</body>
</html>

<?php
    

    ?>
