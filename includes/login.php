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
            exit();
        } else {
            echo 'Invalid username or password';
        }
    }
}


