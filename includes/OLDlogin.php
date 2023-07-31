<?php
session_start();
require_once("connection.php");

// Check if the user is already logged in
if (isset($_SESSION['customer_id'])) {
    // User is already logged in, redirect to dashboard or any other page
    header('Location: ../index.php');
    exit();
}

// Login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['loginBtn'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare('SELECT * FROM customer_tbl WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && md5($password) === $user['password']) {
            $_SESSION['customer_id'] = $user['customer_id'];
            $_SESSION['username'] = $user['username']; // Store the username in the session
            header('Location: ../index.php');
        }
        else {
            echo 'Invalid username or password';
        }
    }
    if (isset($_POST['adminLoginBtn'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare('SELECT * FROM user_tbl WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && md5($password) === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullName'] = $user['fullName']; // Store the username in the session
            header('Location: ../admin/dashboard.php');

        }
        else {
            echo 'Invalid username or password';
        }
    }
}


?>