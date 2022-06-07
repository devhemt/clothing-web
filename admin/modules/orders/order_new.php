<?php
	if (isset($_GET['error'])) {
		echo "
		<script>
		$(document).ready(function(){
			alert(\"đơn hàng vừa bị hủy\");
		});
		</script>
		";
	}
?>
<?php
	$rowPerPage = 5; //Số order trên 1 trang.
    $sql_product = "SELECT * 
	FROM 
	invoice
	INNER JOIN customers ON invoice.cusid = customers.cusid
	INNER JOIN status ON invoice.invoiceid = status.invoiceid
	WHERE status.status = 1 ORDER BY invoice.invoiceid DESC
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
    $sql_pagination = "SELECT * 
	FROM 
	invoice
	INNER JOIN customers ON invoice.cusid = customers.cusid
	INNER JOIN status ON invoice.invoiceid = status.invoiceid
	WHERE status.status = 1
	ORDER BY invoice.invoiceid DESC LIMIT $start,$rowPerPage";
    $resultPagination = mysqli_query($conn, $sql_pagination);

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
			<h3> Bạn có <?php echo $totalRecords; ?> đơn hàng chưa xử lý</h3>
		</div>
	</div><!--/.row-->
	<div id="toolbar" class="btn-group">
		<a href="index.php?page=order_new" class="btn btn-success" style="background:#1f7223;">
			<i class="glyphicon glyphicon-plus"></i> Đơn chưa xử lý
		</a>
		<a href="index.php?page=processed_order" class="btn btn-success">
			<i class="glyphicon glyphicon-plus"></i> Đơn đã xử lý
		</a>
		<a href="index.php?page=order_shiping" class="btn btn-success">
			<i class="glyphicon glyphicon-plus"></i> Đơn đang giao
		</a>
		
	</div>
	<div class="row">
		<div class="col-md-12">
				<div class="panel panel-default">
						<div class="panel-body">
							<table 
								data-toolbar="#toolbar"
								data-toggle="table">
	
								<thead>
								<tr>
									<th data-field="id" data-sortable="true">ID</th>
									<th>Tên khách hàng</th>
									<th>Email</th>
									<th>Số điện thoại</th>
									<th>Địa chỉ</th>
									<th>Tổng tiền</th>
									<th>Hành động</th>
								</tr>
								</thead>
								<tbody>
								<?php  if(mysqli_num_rows($resultPagination) > 0) {
                                        while ($row = mysqli_fetch_assoc($resultPagination)) {
                            	?> 
									<tr>
										<td style=""><?php echo $row['invoiceid'] ?></td>
										<td style=""><?php echo $row['cusname'] ?></td>
										<td style=""><?php echo $row['email'] ?></td>
										<td style=""><?php echo $row['phone'] ?></td>
										<td style=""><?php echo $row['address'] ?></td>
										<td style=""><?php echo $row['pay'] ?> VNĐ</td>
										<td class="form-group">
											<a href="index.php?page=order_detail&prd_id=<?php echo $row['invoiceid']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i></a>
											<a href="modules/orders/order_edit.php?prd_id=<?php echo $row['invoiceid']; ?>&case=12" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
											<a href="modules/orders/order_del.php?prd_id=<?php echo $row['invoiceid']; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
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

