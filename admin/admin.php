<?php 
// session_start();
if(!defined("ISLOGGED")) {
	header("location: index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Elegant - Administrator</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/bootstrap-table.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<!--Icons-->
<script src="js/lumino.glyphs.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"><span>Ele</span>gant</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Admin <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Hồ sơ</a></li>
							<li><a href="logout.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Đăng xuất</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
	<!--sidebar-->	
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<?php if (!isset($_GET['keyword'])&&isset($_GET['page'])) { ?>
		<form role="search" action="index.php" method="GET">
			<div class="form-group">
				<input type="hidden" name="page" value="search_<?php echo $_GET['page']?>">
				<input type="text" name="keyword" class="form-control" placeholder="Search">
			</div>
		</form>
		<?php
		}
		?>
		<ul class="nav menu">
			<li <?php if (!isset($_GET['page'])){ echo 'class="active"';}   ?>><a href="index.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
			<li <?php if (isset($_GET['page'])){ if($_GET['page']=='user'||$_GET['page']=='add_user'||$_GET['page']=='edit_user'){ echo 'class="active"';} }  ?>><a href="index.php?page=user"><svg class="glyph stroked male user "><use xlink:href="#stroked-male-user"/></svg>Quản lý thành viên</a></li>
			<li <?php if (isset($_GET['page'])){ if($_GET['page']=='product'||$_GET['page']=='add_product'||$_GET['page']=='edit_product'){ echo 'class="active"';} }  ?>><a href="index.php?page=product"><svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg>Quản lý sản phẩm</a></li>
			<li <?php if (isset($_GET['page'])){ if($_GET['page']=='order_new'||$_GET['page']=='order_detail'||$_GET['page']=='order_shiping'||$_GET['page']=='processed_order'){ echo 'class="active"';} }  ?>><a href="index.php?page=order_new"><svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg>Quản lý đơn hàng</a></li>
			<li <?php if (isset($_GET['page'])&&$_GET['page']=='comment'){  echo 'class="active"';} ?>><a href="index.php?page=comment"><svg class="glyph stroked two messages"><use xlink:href="#stroked-two-messages"/></svg> Quản lý bình luận</a></li>
			<li <?php if (isset($_GET['page'])&&$_GET['page']=='settings'){  echo 'class="active"';} ?>><a href="index.php?page=settings"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg> Cấu hình</a></li>
		</ul>

	</div>
	<!--/.sidebar-->
	
	<!-- Main Content -->
	<?php 
	// switch-case
	
	if(isset($_GET['page'])) {
		switch ($_GET['page']) {
			// search module
			case 'search_product':
				require_once "modules/search/search_product.php";
				break;
			case 'search_add_product':
				require_once "modules/search/search_product.php";
				break;
			case 'search_edit_product':
				require_once "modules/search/search_product.php";
				break;
			case 'search_user':
				require_once "modules/search/search_user.php";
				break;
			case 'search_add_user':
				require_once "modules/search/search_user.php";
				break;
			case 'search_edit_user':
				require_once "modules/search/search_user.php";
				break;
			case 'search_order_new':
				require_once "modules/search/search_order.php";
				break;
			case 'search_processed_order':
				require_once "modules/search/search_order.php";
				break;
			case 'search_order_shiping':
				require_once "modules/search/search_order.php";
				break;
			case 'search_order_detail':
				require_once "modules/search/search_order.php";
				break;
			// product module
			case 'product':
				require_once "modules/product/product.php";
				break;
			case 'add_product':
				require_once "modules/product/add_product.php";
				break;
			case 'edit_product':
				require_once "modules/product/edit_product.php";
				break;
			// user module
			case 'user':
				require_once "modules/user/user.php";
				break;
			case 'add_user':
				require_once "modules/user/add_user.php";
				break;
			case 'edit_user':
				require_once "modules/user/edit_user.php";
				break;
			//order module
			case 'order_new':
				require_once "modules/orders/order_new.php";
				break;
			case 'processed_order':
				require_once "modules/orders/processed_order.php";
				break;
			case 'order_detail':
				require_once "modules/orders/order_detail.php";
				break;
			case 'order_shiping':
				require_once "modules/orders/order_shiping.php";
				break;
		}
	}else{
		require_once "static.php";
	}
	?>
	<!-- ./Main Content -->
</body>


<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-table.js"></script>
</html>
