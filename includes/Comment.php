<?php
require_once("connection.php");
session_start();
// $userID = $_SESSION["userID"];

try {
    if (isset($_POST['addComment'])) {


        $fullName = $_POST["fullName"];
        $comment = $_POST["comment"];
        $foodId = $_POST["foodId"];
    

        $postSqlQuery = "INSERT INTO comment_tbl VALUES (?,?,?,?,?,?)";
        $statement = $conn->prepare($postSqlQuery);
        $result = $statement->execute(array(null, $foodId, $fullName, $comment, null, null));

        if ($result == true) {
?>
            <script>
                alert("Comment added Successfully");
                window.location.href = "../index.php";
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
