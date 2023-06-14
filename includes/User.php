<?php
require_once("connection.php");
session_start();
// $userID = $_SESSION["userID"];

try {
    if (isset($_POST['addUserBtn'])) {


        $fullName = $_POST["fullName"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $encryptedPassword = md5($password);



        $postSqlQuery = "INSERT INTO user_tbl VALUES (?,?,?,?,?,?,?)";
        $statement = $conn->prepare($postSqlQuery);
        $result = $statement->execute(array(null, $fullName, $email, $password, $encryptedPassword, null, null));

        if ($result == true) {
?>
            <script>
                alert("User added Successfully");
                window.location.href = "../admin/user.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Not Added Successfully");
            </script>
        <?php
        }
    } elseif (isset($_POST['editUserBtn'])) {

        $id = $_POST["id"];
        $fullName = $_POST["fullName"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $encryptedPassword = md5($password);
        
        $postSqlQuery = "UPDATE user_tbl SET fullName = ?, email = ?,  plain_password = ? , password = ? WHERE id = ?";
        $statement = $conn->prepare($postSqlQuery);
        $statement->execute([$fullName, $email,  $password, $encryptedPassword, $id]);
        

        if ($statement == true) {
        ?>
            <script>
                alert("User edited Successfully");
                window.location.href = "../admin/user.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Not Edited Successfully");
            </script>
<?php
        }
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
