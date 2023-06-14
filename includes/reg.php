<?php
require_once("connection.php");
session_start();
// $userID = $_SESSION["userID"];

try {
    if (isset($_POST['RegBtn'])) {


        $fullName = $_POST["fullName"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $encryptedPassword = md5($password);



        $postSqlQuery = "INSERT INTO customer_tbl VALUES (?,?,?,?,?)";
        $statement = $conn->prepare($postSqlQuery);
        $result = $statement->execute(array(null, $fullName, $username, $password, $encryptedPassword));

        if ($result == true) {
?>
            <script>
                alert("Registered Successfully");
                window.location.href = "../login.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Not Added Successfully");
            </script>
<?php
        }
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
