<?php
    include_once "../../config/connectDB.php";
    $prdid = $_GET['prdid'];
    $color = $_GET['color'];
    $size = $_GET['size'];
    $sql = "SELECT * FROM nature WHERE itemsid = '$prdid' AND color = '$color' AND size = '$size'";
    $result = mysqli_fetch_assoc(mysqli_query($conn,$sql));
    $sql1 = "SELECT * FROM detailed_invoice WHERE itemsid = '$prdid' AND color = '$color' AND size = '$size'";
    $resultc1 = mysqli_query($conn,$sql1);
    $resultc2 = mysqli_num_rows($resultc1);
    if ($resultc2>0) {
        $result1 = mysqli_fetch_assoc($resultc1);
    }
    if ($resultc2==0 || $result['amount']>$result1['amount']) {
        echo "Con hang";
    } else {
        echo "Het hang";
    }
    


?>