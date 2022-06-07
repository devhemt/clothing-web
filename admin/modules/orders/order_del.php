<?php 
    session_start();
    if(isset($_SESSION['user_login'])) {
        define("ISLOGGED",true);
        include_once "../../../config/connectDB.php";
        if(isset($_GET['prd_id'])) {
            $prd_id = $_GET['prd_id'];
            $sql_delete1 = "DELETE FROM status WHERE invoiceid=$prd_id";
            $sql_delete2 = "DELETE FROM detailed_invoice WHERE invoiceid=$prd_id";
            $sql_delete3 = "DELETE FROM invoice WHERE invoiceid=$prd_id";
            mysqli_query($conn, $sql_delete1);
            mysqli_query($conn, $sql_delete2);
            mysqli_query($conn, $sql_delete3);
            header("location: /assignments1/admin/index.php?page=order_new");
        }
        
    }
?>