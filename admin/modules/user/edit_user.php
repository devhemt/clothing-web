<?php
    //Lấy các thông tin của user cần sửa
    if(isset($_GET['prd_id'])) {
		$prd_id = $_GET['prd_id'];
		$sqluser = "SELECT * FROM account WHERE id = $prd_id";
		$resultuser = mysqli_query($conn, $sqluser);
		$userEdit = mysqli_fetch_assoc($resultuser);
		
		$role = $_SESSION['user_login']['type'];
		if ($role == '1') {
			if(isset($_POST['sbm'])) {
				//kiểm email đã được nhập hay chưa
				if(!empty($_POST['email'])) {
					$email = trim($_POST['email']);
				}else{
					$error['email'] = "Bạn chưa nhập email";
				}
				//Kiểm tra password đã được nhập hay chưa
				if(!empty($_POST['pass'])) {
					$pass = $_POST['pass'];
				}else{
					$error['pass'] = "Bạn chưa nhập mật khẩu";
				}
				//Kiểm tra tên đã được nhập hay chưa
				if(!empty($_POST['name'])) {
					$name = $_POST['name'];
				}else{
					$error['name'] = "Bạn chưa nhập tên";
				}
				//Kiểm tra re_pass
				if(!empty($_POST['re_pass'])) {
					$re_pass = $_POST['re_pass'];
				}else{
					$error['re_pass'] = "Bạn chưa nhập lại mật khẩu";
				}
				if ($pass!=$re_pass) {
					$error['re_pass'] = "Bạn nhập lại mật khẩu chưa chính xác";
				}
				$type = $_POST['type'];
				
				if ($email != $userEdit['username']) {
					$sql_email = "SELECT * FROM account WHERE username = '$email'";
					$resultcheck = mysqli_query($conn, $sql_email);
					$check = mysqli_num_rows($resultcheck);
					if ($check>0) {
						$error['email'] = "Email đã tồn tại";
					}
				}

			
				//Khi không có lỗi xảy ra
				if(!isset($error['email']) &&  !isset($error['pass']) &&  !isset($error['name']) &&  !isset($error['re_pass'])) {
					//trường hợp thỏa mãn tài khoản đăng nhập
					$sql = "UPDATE account SET
							name = '$name',
							username = '$email',
							password = '$pass',
							type = '$type'
							WHERE id = $prd_id
							";
					if(mysqli_query($conn, $sql)) {
						header("location: index.php?page=user");
					}else{
						$error['invalid'] = '<div class="alert alert-danger">Tài khoản không hợp lệ !</div>';
					}
				}
			}
		} else {
			$error['invalid'] = '<div class="alert alert-danger">Đây là quyền hạn của Admin !</div>';
		}

	}else{
		header('location: index.php?page=user');
	} 

?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
			<li><a href="">Quản lý thành viên</a></li>
			<li class="active"><?php echo $userEdit['name'] ?></li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Thành viên: <?php echo $userEdit['name'] ?></h1>
		</div>
	</div><!--/.row-->
	<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="col-md-8">
						<?php if(isset($error['invalid'])) echo $error['invalid']; ?>
						<form role="form" method="post">
							<div class="form-group">
								<label>Họ & Tên</label>
								<input type="text" name="name" value="<?php echo $userEdit['name'] ?>" required class="form-control" placeholder="">
								<span style="color: red"><?php if(isset($error['name'])) echo $error['name']; ?></span>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input name="email" required type="text" value="<?php echo $userEdit['username'] ?>" class="form-control">
								<span style="color: red"><?php if(isset($error['email'])) echo $error['email']; ?></span>
							</div>                       
							<div class="form-group">
								<label>Mật khẩu</label>
								<input name="pass" required type="password" value="<?php echo $userEdit['password'] ?>" class="form-control">
								<span style="color: red"><?php if(isset($error['pass'])) echo $error['pass']; ?></span>
							</div>
							<div class="form-group">
								<label>Nhập lại mật khẩu</label>
								<input name="re_pass" required type="password"  class="form-control">
								<span style="color: red"><?php if(isset($error['re_pass'])) echo $error['re_pass']; ?></span>
							</div>
							<div class="form-group">
								<label>Quyền</label>
								<select name="type" class="form-control">
									<?php
										if ($userEdit['type'] == '1') {
											echo "<option selected value=1>Admin</option>";
											echo "<option value=2>Staff</option>";
										} else {
											echo "<option value=1>Admin</option>";
											echo "<option selected value=2>Staff</option>";
										}
										
									?>
								</select>
							</div>
							<button name="sbm" type="submit" class="btn btn-success">Cập nhật</button>
							<button type="reset" class="btn btn-default">Làm mới</button>
						</div>
					</form>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
	
</div>	<!--/.main-->	