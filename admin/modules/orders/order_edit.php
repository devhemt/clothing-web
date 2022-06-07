<?php 
    session_start();
    if(isset($_SESSION['user_login'])) {
        define("ISLOGGED",true);
        include_once "../../../config/connectDB.php";
        if (isset($_GET['prd_id'])&&isset($_GET['case'])) {
            switch ($_GET['case']) {
                case '12':
                    $prd_id = $_GET['prd_id'];
                    $sqlget = "SELECT status FROM status
                        WHERE invoiceid = $prd_id
                    ";
                    $resultget = mysqli_query($conn, $sqlget);
                    if ($resultget == 0) {
                        $prd_id = $_GET['prd_id'];
                        $sql_delete1 = "DELETE FROM status WHERE invoiceid=$prd_id";
                        $sql_delete2 = "DELETE FROM detailed_invoice WHERE invoiceid=$prd_id";
                        $sql_delete3 = "DELETE FROM invoice WHERE invoiceid=$prd_id";
                        mysqli_query($conn, $sql_delete1);
                        mysqli_query($conn, $sql_delete2);
                        mysqli_query($conn, $sql_delete3);
                        header("location: /assignments1/admin/index.php?page=order_new&&error");
                    } else {
                        $sql = "UPDATE status SET
                        status = 2
                        WHERE invoiceid = $prd_id
                    ";
                    mysqli_query($conn, $sql);
                    header("location: /assignments1/admin/index.php?page=processed_order");
                    }
                    break;
                case '23':
                    $prd_id = $_GET['prd_id'];
                    $sql = "UPDATE status SET
                        status = 3
                        WHERE invoiceid = $prd_id
                    ";
                    mysqli_query($conn, $sql);
                    header("location: /assignments1/admin/index.php?page=order_shiping");
                    break;
                case '34':
                    $prd_id = $_GET['prd_id'];
                    $sql = "UPDATE status SET
                        status = 4
                        WHERE invoiceid = $prd_id
                    ";
                    mysqli_query($conn, $sql);
                    header("location: /assignments1/admin/index.php?page=order_new");
                    break;
            }
        } else {
            header("location: /assignments1/admin/index.php?page=order_new");
        }
        
    }
?>