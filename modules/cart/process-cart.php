<?php 
session_start();
$action = $_GET['action'];
switch ($action) {
    case 'add':
        if(isset($_GET['prd_id'])) {
            $prd_id = $_GET['prd_id'];
            $color = $_POST['color'];
            $size = $_POST['size'];
            $_SESSION['color'][$prd_id]=$color;
            $_SESSION['size'][$prd_id]=$size;
        }
        if(isset($_SESSION['cart'][$prd_id])) {
            $_SESSION['cart'][$prd_id]++;
        }else{
            $_SESSION['cart'][$prd_id] = 1;
        }
        header("location: ../../index.php?page_layout=cart");
        break;
    
    case 'increase':
        include_once "../../config/connectDB.php";
        if(isset($_GET['prd_id'])) {
            $prd_id = $_GET['prd_id'];
        }
        if(isset($_SESSION['cart'][$prd_id])) {
            $_SESSION['cart'][$prd_id]++;
            $kk = $_SESSION['cart'][$prd_id];

            $color = $_SESSION['color'][$prd_id];
            $size = $_SESSION['size'][$prd_id];
            $sql_prdcount = "SELECT * FROM product INNER JOIN nature ON product.prdid = nature.itemsid WHERE product.prdid=$prd_id AND nature.color='$color' AND nature.size='$size'";
            $sql_prdsold = "SELECT SUM(amount) FROM detailed_invoice WHERE itemsid=$prd_id";
            $prdcount = mysqli_fetch_assoc(mysqli_query($conn, $sql_prdcount));
            $prdsold = mysqli_fetch_assoc(mysqli_query($conn, $sql_prdsold));
            $prdsth = $prdcount["amount"]-$prdsold["SUM(amount)"];
            if ($_SESSION['cart'][$prd_id]>($prdsth-1)) {
                $_SESSION['cart'][$prd_id] = $prdsth;
                $kk = $prdsth;
                $mes = "đã đạt giới hạn đơn hàng";
            }


            $sum = 0;
            foreach($_SESSION['cart'] as $prd_id => $qty){
            $sql = "select * from product where prdid = '$prd_id'";
            $result = mysqli_query($conn,$sql);
            $each = mysqli_fetch_array($result);
            $sum += $each['price'] * $qty;
            }
        }
        $sum1=number_format($sum,0,',','.');
        $result = array();
        
        if (isset($mes)) {
            $result[] = array(
                'mes' => $mes,
                'amount' => $kk,
                'sum' => $sum1
            );
        }else{
            $result[] = array(
                'amount' => $kk,
                'sum' => $sum1
            );
        }


        die (json_encode($result));
        break;
    case 'reduction':
        include_once "../../config/connectDB.php";
        if(isset($_GET['prd_id'])) {
            $prd_id = $_GET['prd_id'];
        }
        if(isset($_SESSION['cart'][$prd_id])&&$_SESSION['cart'][$prd_id]>1) {
            $_SESSION['cart'][$prd_id]--;
            $kk = $_SESSION['cart'][$prd_id];
        }else {
            $_SESSION['cart'][$prd_id] = 1;
            $kk = 1;
        }
            $sum = 0;
            foreach($_SESSION['cart'] as $prd_id => $qty){
            $sql = "select * from product where prdid = '$prd_id'";
            $result = mysqli_query($conn,$sql);
            $each = mysqli_fetch_array($result);
            $sum += $each['price'] * $qty;
            }
            $sum1=number_format($sum,0,',','.');
            $result = array();
            $result[] = array(
                'amount' => $kk,
                'sum' => $sum1
            );
            die (json_encode($result));
            break;
    case 'del':
        if(isset($_SESSION['cart'][$_GET['prd_id']])) {
            unset($_SESSION['cart'][$_GET['prd_id']]);
        }

        if(empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }

        header("location: ../../index.php?page_layout=cart");
        break;
    case 'submit':
        if(isset($_POST['user_name'])&&isset($_POST['user_phone'])&&isset($_POST['user_email'])) {
            include_once "../../config/connectDB.php";
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $user_name = $_POST['user_name'];
            $user_phone = $_POST['user_phone'];
            $user_email = $_POST['user_email'];
            $address = $_POST['user_address'];
            $sqlUser = "INSERT INTO customers(cusname,phone,email,address) 
            VALUES('$user_name','$user_phone','$user_email','$address')";
            mysqli_query($conn, $sqlUser);
            $sqlCus = "SELECT * FROM customers WHERE phone=$user_phone";
            $resultCus = mysqli_query($conn, $sqlCus);
            $customer = mysqli_fetch_array($resultCus);
            $cusId = $customer['cusid'];



            $sum = 0;
            foreach($_SESSION['cart'] as $prd_id => $qty):
            $sqlsum = "select * from product where prdid = '$prd_id'";
            $resultsum = mysqli_query($conn,$sqlsum);
            $eachsum = mysqli_fetch_array($resultsum);
            $sum += $eachsum['price'] * $qty;
            endforeach;
            $sqlInvoice = "INSERT INTO invoice(cusid,pay) 
            VALUES('$cusId','$sum')";
            mysqli_query($conn, $sqlInvoice);
            $sqlinvoice = "SELECT * FROM invoice WHERE cusid = '$cusId'";
            $resultinvoice = mysqli_query($conn, $sqlinvoice);
            $invoice = mysqli_fetch_array($resultinvoice);
            $invoiceId = $invoice['invoiceid'];


            $sqlStatus = "INSERT INTO status(invoiceid,status) 
            VALUES('$invoiceId','1')";
            mysqli_query($conn, $sqlStatus);   
            


            foreach($_SESSION['cart'] as $prd_id => $qty):
            $color = $_SESSION['color'][$prd_id];
            $size = $_SESSION['size'][$prd_id];
            $sqlpr = "select * from product where prdid = '$prd_id'";
            $resultpr = mysqli_query($conn,$sqlpr);
            $eachpr = mysqli_fetch_array($resultpr);
            $dprice = $eachpr['price'];
            $sqlInvoiceDt = "INSERT INTO detailed_invoice(itemsid,invoiceid,amount,size,color,dprice) 
            VALUES('$prd_id','$invoiceId','$qty','$size','$color',$dprice)";
            mysqli_query($conn, $sqlInvoiceDt);
            endforeach;

            
            unset($_SESSION['cart']);
            header("location: ../../index.php?page_layout=success");
        }
        break;
}

?>



