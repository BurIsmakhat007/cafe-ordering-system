<!-- Navigation-->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <h1><a class="navbar-brand text-dark" href="index.php">Suza Cafe</a></h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent"> <!-- Added justify-content-between class -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0"> <!-- Added mx-auto class for center alignment -->
                <li class="nav-item" style="margin-right: 20px;"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                <li class="nav-item" style="margin-right: 20px;"><a class="nav-link active" aria-current="page" href="menu.php">Our Menu</a></li>
                <?php if (isset($_SESSION['customer_id'])) : ?>
                    <li class="nav-item"><a class="nav-link text-dark" href="orders.php">My Orders</a></li>
                    <!-- <li class="nav-item"><a class="nav-link text-dark" href="logout.php">Logout</a></li> -->
                <?php else : ?>
                    <!-- <li class="nav-item"><a class="nav-link text-dark" href="login.php">Login</a></li> -->
                <?php endif; ?>
            </ul>

            <?php if (isset($_SESSION['customer_id'])) : ?>
                <form class="d-flex">
                    <a href="cart.php" class="btn btn-outline-dark btn-sm" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $getOrders->rowCount(); ?></span>
                    </a>
                    <a href="#" class="btn btn-outline-dark btn-sm" style="margin-left: 10px;">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="nav-link">Welcome, <?php echo $_SESSION['username']; ?></span>

                    </a>

                    <a href="logout.php" class="btn btn-outline-danger btn-sm" style="margin-left: 10px;">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="nav-link">Logout</span>

                    </a>
                </form>
                <?php else : ?>
                    <a href="login.php" class="btn btn-outline-success btn-sm" style="margin-left: 10px;">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="nav-link">Login</span>

                    </a>
                <?php endif; ?>
                <!-- <a href="index.php" class="btn btn-outline-secondary btn-sm" style="margin-left: 10px;">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="nav-link">Home</span>

                    </a> -->
        </div>
    </div>
</nav>
<!-- Header-->
<header class=" py-5" style="background-image: url('https://as2.ftcdn.net/v2/jpg/05/53/15/53/1000_F_553155350_Oy6YtiH5ovW3SyInD94Pr3gKqI7YaL3V.jpg'); background-size: cover;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder text-dark">Welcome to suza Cafeteria</h1>
            <p class="lead fw-normal text-dark mb-0">For the love of delicious food.</p>
        </div>
    </div>
</header>
