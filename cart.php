<?php
session_start();
$userId = $_SESSION['customer_id'];
require_once("includes/connection.php");
//get all orders
$getOrders = $conn->prepare("SELECT * FROM cart_tbl WHERE userId=$userId");
$getOrders->execute();

include("./user/menu/header.php");
include("./user/menu/nav.php");

// Assuming you have the user ID stored in a variable called $userId
// Fetch cart data based on user ID
$cartQuery = "SELECT p.foodName, p.foodPrice, p.image_url, c.quantity, (p.foodPrice * c.quantity) AS total
              FROM cart_tbl AS c
              INNER JOIN food_tbl AS p ON c.foodId = p.id
              WHERE c.userId = $userId";
$cartStatement = $conn->prepare($cartQuery);
$cartStatement->execute();
$cartItems = $cartStatement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h1 class="text-center">Shopping Cart</h1>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-primary">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Food</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($cartItems) {
                                foreach ($cartItems as $cartItem) {
                                    $productName = $cartItem['foodName'];
                                    $price = $cartItem['foodPrice'];
                                    $quantity = $cartItem['quantity'];
                                    $image = $cartItem['image_url'];
                                    $total = $cartItem['total'];
                            ?>
                                    <tr>
                                        <td><img class="card-img-top mb-5 mb-md-0" src="./includes/images/<?php echo $image; ?>" alt="Food Image" width="50" height="50" /></td>
                                        <td><?php echo $productName; ?></td>
                                        <td><?php echo "Tzs " . $price; ?></td>
                                        <td><?php echo $quantity; ?></td>
                                        <td><?php echo "Tzs " . $total; ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='4'>No items in the cart.</td></tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <?php
                            if ($cartItems) {
                                $totalAmount = 0;
                                foreach ($cartItems as $cartItem) {
                                    $totalAmount += $cartItem['total'];
                                }
                            ?>
                                <tr>
                                    <td colspan="4">Total:</td>
                                    <td><?php echo "Tzs " . $totalAmount; ?></td>
                                </tr>
                                <?php if ($totalAmount > 0) { ?>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php
                            }
                            ?>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pay through TigoPesa</h5>
                        <ol class="list-group">
                            <li class="list-group-item">Step 1: Call <b>*150*01#</b></li>
                            <li class="list-group-item">Step 2: Choose <b>5 "Lipia Kwa Simu"</b></li>
                            <li class="list-group-item">Step 3: Choose <b>1 "Kwenda Tigo Pesa"</b></li>
                            <li class="list-group-item">Step 4: Enter <b>account number (5545444) "Suza Cafe"</b></li>
                            <li class="list-group-item">Step 5: Enter <b>amount</b></li>
                            <li class="list-group-item">Step 6: Enter <b>Pin</b> to Confirm</li>
                        </ol>
                    </div>
                </div>

                <form action="./includes/Order.php" method="post">
                    <div class="mb-3">
                        <label for="refNumber" class="form-label">Reference Number (8 digits):</label>
                        <input type="text" class="form-control" id="refNumber" placeholder="Enter Reference No" name="refNumber" maxlength="8">
                        <input type="text" class="form-control" id="totalPrice" name="totalPrice" value="<?php echo $totalAmount ?>" hidden >
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="confirmButton" name="addOrder">Confirm</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Additional CSS -->
<style>
    .card-img-top {
        max-height: 100px;
        object-fit: cover;
    }
</style>

<!-- Additional JavaScript -->
<script>
    $(document).ready(function() {
        $('#confirmButton').hide();

        $('#refNumber').on('input', function() {
            var refNumber = $(this).val();
            if (refNumber.length === 8) {
                $('#confirmButton').show();
            } else {
                $('#confirmButton').hide();
            }
        });
    });
</script>

<?php include("./user/menu/footer.php"); ?>
