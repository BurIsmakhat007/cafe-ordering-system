<?php
require_once("../connection.php");
session_start();
// $userID = $_SESSION["userID"];

try {
   


        $user_id = $_GET["userId"];

        $clearQuery = "DELETE FROM user_tbl WHERE id = ?";
        $clearStatement = $conn->prepare($clearQuery);
        $clearStatement->execute([$user_id]);
       
    
        if ($clearStatement == true) {
?>
            <script>
                alert("Deleted Successfully");
                window.location.href = "../../admin/user.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Not Deleted Successfully");
            </script>
        <?php
        }
    
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
