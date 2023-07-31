<?php
require_once("../connection.php");
session_start();
// $userID = $_SESSION["userID"];

try {
   


        $commentId = $_GET["commentId"];

        $clearQuery = "DELETE FROM comment_tbl WHERE comment_id = ?";
        $clearStatement = $conn->prepare($clearQuery);
        $clearStatement->execute([$commentId]);
       
    
        if ($clearStatement == true) {
?>
            <script>
                alert("Deleted Successfully");
                window.location.href = "../../admin/comments.php";
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
