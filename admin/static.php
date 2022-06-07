<?php 
    $sql_prd = "SELECT * FROM product";
    $resultprd = mysqli_query($conn, $sql_prd);
    $totalprd = mysqli_num_rows($resultprd); //số bản ghi lấy được.

	$sql_cmt = "SELECT * FROM comments";
    $resultcmt = mysqli_query($conn, $sql_cmt);
    $totalpcmt = mysqli_num_rows($resultcmt); //số bản ghi lấy được.

	$sql_user = "SELECT * FROM account";
    $resultuser = mysqli_query($conn, $sql_user);
    $totalpuser = mysqli_num_rows($resultuser); //số bản ghi lấy được.

	$sql_successOrder = "SELECT * FROM invoice INNER JOIN status ON invoice.invoiceid = status.invoiceid
	WHERE status.status = 4";
	$resultsuccessOrder = mysqli_query($conn, $sql_successOrder);
    $totalpsuccessOrder = mysqli_num_rows($resultsuccessOrder); //số bản ghi lấy được.
    
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Trang chủ quản trị</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Trang chủ quản trị</h1>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo $totalprd ?></div>
							<div class="text-muted">Sản Phẩm</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked empty-message"><use xlink:href="#stroked-empty-message"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo $totalpcmt ?></div>
							<div class="text-muted">Bình Luận</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo $totalpuser ?></div>
							<div class="text-muted">Thành Viên</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked app-window-with-content"><use xlink:href="#stroked-app-window-with-content"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo $totalpsuccessOrder ?></div>
							<div class="text-muted">SuccessfulOrder</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->
	<div id="container-min">
    	<canvas id="myChart"></canvas>
	</div>
<script>
	<?php
	$date = getdate();
	$sql1 = "SELECT SUM(pay) FROM invoice INNER JOIN status ON invoice.invoiceid = status.invoiceid
	WHERE status.status = 4 AND date_created >=".$date['year']."-".$date['mon']."-1";
	$result1 = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
	$sql2 = "SELECT SUM(pay) FROM invoice INNER JOIN status ON invoice.invoiceid = status.invoiceid
		WHERE status.status = 4 AND date_created >=".$date['year']."-".($date['mon']-1)."-1
		AND date_created < ".$date['year']."-".$date['mon']."-1"
	;
	$result2 = mysqli_fetch_assoc(mysqli_query($conn, $sql2));
	$sql3 = "SELECT SUM(pay) FROM invoice INNER JOIN status ON invoice.invoiceid = status.invoiceid
		WHERE status.status = 4 AND date_created >=". $date['year']."-".($date['mon']-2)."-1
		AND date_created < ".$date['year']."-".($date['mon']-1)."-1"
	;
	$result3 = mysqli_fetch_assoc(mysqli_query($conn, $sql3));
	$sql4 = "SELECT SUM(pay) FROM invoice INNER JOIN status ON invoice.invoiceid = status.invoiceid
		WHERE status.status = 4 AND date_created >=". $date['year']."-".($date['mon']-3)."-1
		AND date_created < ".$date['year']."-".($date['mon']-2)."-1"
	;
	$result4 = mysqli_fetch_assoc(mysqli_query($conn, $sql4));
	$sql5 = "SELECT SUM(pay) FROM invoice INNER JOIN status ON invoice.invoiceid = status.invoiceid
		WHERE status.status = 4 AND date_created >=". $date['year']."-".($date['mon']-4)."-1
		AND date_created < ".$date['year']."-".($date['mon']-3)."-1"
	;
	$result5 = mysqli_fetch_assoc(mysqli_query($conn, $sql5));
	$average = ((int)$result1['SUM(pay)']+(int)$result2['SUM(pay)']+(int)$result3['SUM(pay)']+(int)$result4['SUM(pay)']+(int)$result5['SUM(pay)'])/5;
	?>

    let myChart = document.getElementById('myChart').getContext('2d');
    // Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 18;
    Chart.defaults.global.defaultFontColor = '#777';

    let massPopChart = new Chart(myChart, {
      type:'bar',
      data:{
        labels:['Tháng <?php echo $date['mon'] ?>', 'Tháng <?php echo $date['mon']-1 ?>', 'Tháng <?php echo $date['mon']-2 ?>', 'Tháng <?php echo $date['mon']-3 ?>', 'Tháng <?php echo $date['mon']-4 ?>', 'Trung bình'],
        datasets:[{
          label:'Tổng doanh thu',
          data:[
            <?php echo $result1['SUM(pay)'] ?>,
            <?php echo $result2['SUM(pay)'] ?>,
            <?php echo $result3['SUM(pay)'] ?>,
            <?php echo $result4['SUM(pay)'] ?>,
            <?php echo $result5['SUM(pay)'] ?>,
            <?php echo $average ?>
          ],
          backgroundColor:[
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)'
          ],
          borderWidth:1,
          borderColor:'#777',
          hoverBorderWidth:3,
          hoverBorderColor:'#000'
        }]
      },
      options:{
        title:{
          display:true,
          text:'Biểu đồ doanh thu',
          fontSize:25
        },
        legend:{
          display:false,
        },
        layout:{
          padding:{
            left:50,
            right:0,
            bottom:0,
            top:0
          }
        },
        tooltips:{
          enabled:true
        }
      }
    });
</script>


