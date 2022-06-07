<?php 
    session_start();
    $role = $_SESSION['user_login']['type'];
    if ($role == '1') {
        if(isset($_SESSION['user_login'])) {
            define("ISLOGGED",true);
            include_once "../../../config/connectDB.php";
            if(isset($_GET['prd_id'])) {
                $prd_id = $_GET['prd_id'];
                $sql_delete = "DELETE FROM account WHERE id=$prd_id";
                mysqli_query($conn, $sql_delete);
                header("location: /assignments1/admin/index.php?page=user");
            }
        }
    } else {
	    header("location: /assignments1/admin/index.php?page=user&err=1");
    }

?>