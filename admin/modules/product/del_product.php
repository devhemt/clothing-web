<?php 
    session_start();
    if(isset($_SESSION['user_login'])) {
        define("ISLOGGED",true);
        include_once "../../../config/connectDB.php";
        if(isset($_GET['prd_id'])) {
            $prd_id = $_GET['prd_id'];
            $sql_select1 = "SELECT * FROM detailed_invoice WHERE itemsid = $prd_id";
            $result = mysqli_query($conn, $sql_select1);
            $dem = mysqli_num_rows($result);
            $sql_delete1 = "DELETE FROM category WHERE itemsid=$prd_id";
            $sql_delete2 = "DELETE FROM nature1 WHERE itemsid=$prd_id";
            $sql_delete3 = "DELETE FROM nature WHERE itemsid=$prd_id";
            $sql_delete4 = "DELETE FROM product WHERE prdid=$prd_id";
        }
        if ($dem>0) {
            echo "<script>alert('Xóa sản phẩm không thành công vì tồn tại đơn hàng');</script>";
            header("location: /assignments1/admin/index.php?page=product");
        }else{
            mysqli_query($conn, $sql_delete1);
            mysqli_query($conn, $sql_delete2);
            mysqli_query($conn, $sql_delete3);
            mysqli_query($conn, $sql_delete4);
            header("location: /assignments1/admin/index.php?page=product");
        }
        
    }
?>