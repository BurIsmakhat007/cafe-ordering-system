<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['customer_id']);
// session_unset();
session_destroy();

header('Location: index.php');
exit();
?>

session_start();
unset($_SESSION['loggedIn']);
session_destroy();
header('location: login_form.php');