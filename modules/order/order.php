<?php
if (isset($_POST['find'])) {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = "SELECT * FROM customers INNER JOIN invoice ON customers.cusid = invoice.cusid
            WHERE customers.email = '$email' AND customers.phone = '$phone'";
    $result = mysqli_query($conn, $sql);
}

?>


<section class="order-cus">
<section class="customer" id="customer">

    <div class="row">

        <form method="post" role="form" action="index.php?page_layout=order">
            <h1 class="heading">
                Customer Information
            </h1>
            <div id="divider"></div>
            <div class="inputBox">
                <input type="email" placeholder="email" name="email" id="email">
                <input type="number" placeholder="number" name="phone" id="phone">
            </div>
            <input type="submit" name="find" class="btn" value="Tìm kiếm">
        </form>
    </div>
    
</section>

</section>

<section class="order" id="order">

<table border="1px">
	<thead>
		<tr>
            <th>Mã đơn hàng</th>
            <th>Thời gian tạo</th>
            <th>Thanh toán</th>
            <th>Trạng thái</th>
			<th>Hành động</th>
		</tr>
	</thead>
	<tbody>
        <?php
            if(isset($result)) {
            if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $ll=$row['invoiceid'];
                $sql1 = "SELECT * FROM status WHERE invoiceid='$ll'";
                $result1 = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
        ?>
		<tr>
			<td style=""><?php echo $row['invoiceid'] ?></td>
            <td style=""><?php echo $row['date_created'] ?></td>
            <td style=""><?php echo number_format($row['pay'],0,',','.') ?> VND</td>
            <td style=""><?php 
            switch ($result1['status']) {
                case 0:
                    echo "đã hủy";
                    break;
                case 1:
                    echo "chưa xử lý";
                    break;
                case 2:
                    echo "đã xử lý";
                    break;
                case 3:
                    echo "đang giao hàng";
                    break;
                case 4:
                    echo "đã thành công";
                    break;    
            }
            ?></td>
			<td class="form-group">
				<a href="#" class="btn">chi tiết</a>
                
                <?php 
                switch ($result1['status']) {
                    case 1:
                        echo "<a href=\"modules/order/order_del.php?prd_id=" . $row['invoiceid'] . "\"class=\"btn\">hủy đơn</a>";
                        break;
                }
                ?>
			</td>
		</tr>
        <?php         
            }
        }else{
            echo "<div style=\"color:red\">Có 0 hóa đơn được tìm thấy!</div>";
        }}else{
            echo "<div style=\"color:red\">Nhập thông tin để tìm hóa đơn!</div>";
        }
        ?>
	</tbody>
</table>


</section>
