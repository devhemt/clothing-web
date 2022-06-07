<?php 
        include_once "../../../config/connectDB.php";
        if(isset($_GET['prd_id'])) {
            $prd_id = $_GET['prd_id'];
            $sql = "UPDATE status SET
                        status = 0
                        WHERE invoiceid = $prd_id
                    ";
            mysqli_query($conn, $sql);
            header("location: /assignments1/index.php?page_layou=order");
        }
?>