<?php
    if (isset($_GET['prd_id'])) {
        $prd_id = $_GET['prd_id'];
        $sql = "SELECT * 
        FROM 
        invoice
        INNER JOIN customers ON invoice.cusid = customers.cusid
        INNER JOIN detailed_invoice ON invoice.invoiceid = detailed_invoice.invoiceid
        INNER JOIN product ON detailed_invoice.itemsid = product.prdid
        WHERE invoice.invoiceid = $prd_id
        ";
        $result = mysqli_query($conn, $sql);
        $cusresult = mysqli_fetch_array($result);

    $rowPerPage = 5; //Số product trên 1 trang.
    $sql_product = "SELECT * 
    FROM 
    invoice
    INNER JOIN customers ON invoice.cusid = customers.cusid
    INNER JOIN detailed_invoice ON invoice.invoiceid = detailed_invoice.invoiceid
    INNER JOIN product ON detailed_invoice.itemsid = product.prdid
    WHERE invoice.invoiceid = $prd_id
	";
    $resultAll = mysqli_query($conn, $sql_product);
    $totalRecords = mysqli_num_rows($resultAll); //số bản ghi lấy được.
    //Tổng số trang
    $totalPage = ceil($totalRecords/$rowPerPage);

    //lấy trang hiện tại từ đường dẫn.
    if(isset($_GET['current_page'])) {
        $current_page = $_GET['current_page'];
    }else{
        $current_page = 1;
    }
    
    if($current_page < 1) {
        $current_page = 1;
    }

    if($current_page > $totalPage && $totalPage>0) {
        $current_page = $totalPage;
    }
    // SELECT * FROM table_name LIMIT $start,$rowPerPage;
    $start = ($current_page - 1)*$rowPerPage;
	var_dump($current_page);
    $sql_pagination = "SELECT * 
    FROM 
    invoice
    INNER JOIN detailed_invoice ON invoice.invoiceid = detailed_invoice.invoiceid
    INNER JOIN product ON detailed_invoice.itemsid = product.prdid
    WHERE invoice.invoiceid = $prd_id
	ORDER BY invoice.invoiceid DESC LIMIT $start,$rowPerPage";
    $resultPagination = mysqli_query($conn, $sql_pagination);



    } else {
        header("Location: index.php?page=order_new");
    }
    

?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li class="active">Quản lý đơn hàng</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Quản lý đơn hàng</h1>
		</div>
	</div><!--/.row-->
	<div class="row">
        <div class="col-12">
            <ul>
                <li>Tên khách hàng: <?php echo $cusresult['cusname']?></li>
                <li>Địa chỉ: <?php echo $cusresult['address']?></li>
                <li>Email: <?php echo $cusresult['email']?></li>
                <li>Điện thoại: <?php echo $cusresult['phone']?></li>
            </ul>
        </div>
		<div class="col-md-12">
				<div class="panel panel-default">
						<div class="panel-body">
							<table  data-toolbar="#toolbar"data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Hình ảnh</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                    </tr>
                                </thead>
								<tbody>
                                <?php  if(mysqli_num_rows($resultPagination) > 0) {
                                        while ($row = mysqli_fetch_assoc($resultPagination)) {
                            	?>
                                    <tr>
                                        <td style=""><?php echo $row['itemsid'] ?></td>
                                        <td style=""><?php echo $row['name'] ?></td>
                                        <td style="text-align: center"><img width="130" height="180" src="../images/<?php echo $row['image'] ?>" /></td>
                                        <td style=""><?php echo $row['price'] ?> vnd</td>
                                        <td>
                                        <?php echo $row['amount'] ?><br>
                                        COLOR:<br>
                                        <?php echo "<div class=\"colors\" style=\"background-color:".$row['color'].";\">" ?><br>
                                        SIZE:<br>
                                        <?php echo "<div class=\"sizes\">".$row['size'] ?>
                                        </td>
                                    </tr>
                                <?php         
                                    }
                                } 
                                ?>
								</tbody>
							</table>
						</div>
                        <div class="panel-footer">
							<nav aria-label="Page navigation example">
								<ul class="pagination">
									<!-- Hiển thị nút trở về trang trước -->
									<?php if($current_page > 1) { ?>
										<li class="page-item"><a class="page-link" href="index.php?page=product&current_page=<?php echo $current_page-1; ?>">&laquo;</a></li>
									<?php }else { ?>
										<li class="page-item disabled"><a class="page-link" href="">&laquo;</a></li>
								<?php } ?>
									<!-- Page menu item -->
									<?php for($i = 1; $i <= $totalPage; $i++) { 
											if($i > $current_page - 3 && $i < $current_page + 3) { 
												if($i == $current_page) {   
									?>
													<li class="page-item active"><a class="page-link" href="index.php?page=product&current_page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
												<?php }else { ?>
													<li class="page-item"><a class="page-link" href="index.php?page=product&current_page=<?php echo $i; ?>"><?php echo $i; ?></a></li>

									<?php 
											}
										}
									}
									?>
									<!-- Hiển thị nút next trang -->
									<?php if($current_page < $totalPage) { ?>
										<li class="page-item"><a class="page-link" href="index.php?page=product&current_page=<?php echo $current_page + 1; ?>">&raquo;</a></li>
									<?php }else {?>
										<li class="page-item disabled"><a class="page-link disabled" href="">&raquo;</a></li>
									<?php } ?>
								</ul>
							</nav>
						</div>
					</div>
		</div>
	</div><!--/.row-->
</div>	<!--/.main-->
