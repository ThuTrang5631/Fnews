<?php 
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "dbfnews";
	session_start();

	if ($_SESSION["taikhoan"] =='#') {
    
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://".$_SERVER['HTTP_HOST']."/Project/Fnews.php\">";
	  } 
	else {
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		$conn -> set_charset("utf8");
		
		$sql ="select HoTenTG,MaTG
		from tktacgia
		where upper(Email) = UPPER('".$_SESSION["taikhoan"]."')";
		$result = $conn->query($sql);
		$InfoTG = $result->fetch_assoc(); 
		$TenTG = $InfoTG["HoTenTG"];
		$MaTG = $InfoTG["MaTG"];
	}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>FNEWS USER </title>
	<link rel="shortcut icon" type="image/png" href="/Project/image/Fnews3.png"/>

	<!-- Bootstrap -->
	<link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-wysiwyg -->
	<link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<!-- Switchery -->
	<link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
	<!-- starrr -->
	<link href="../vendors/starrr/dist/starrr.css" rel="stylesheet">
	<!-- bootstrap-daterangepicker -->
	<link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="../build/css/custom.min.css" rel="stylesheet">
</head>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">					
					<div class="clearfix"></div>
					<!-- menu profile quick info -->
					<div class="profile clearfix">
						<div class="profile_pic">
						  <img src="images/user.png" alt="..." class="img-circle profile_img">
						</div>
						<div class="profile_info">
						  <span>Chào mừng bạn!</span>
						  <h2> <?php echo $TenTG ?></h2>
						</div>
					  </div>
					<!-- /menu profile quick info -->
					<br />
					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<div class="menu_section">
						  <ul class="nav side-menu">
							<li><a href="ThongTinCaNhan.php"><i class="fa fa-home"></i> Thông tin cá nhân </a> </li>
							<li><a><i class="fa fa-edit"></i>Quản lý bài viết <span class="fa fa-chevron-down"></span></a>
							  <ul class="nav child_menu">
								<li><a href="DanhSachBaiViet.php">Danh sách bài viết</a></li>
								<li><a href="TuongTacBaiViet.php">Tương tác</a></li>
							  </ul>
							</li>
							<li><a href="TaoBaiViet.php"><i class="fa fa-clone"></i> Tạo bài viết </a> </li>
							<!--Thêm-->
							</ul>
						</div>
					</div>
					<!-- /sidebar menu -->					
				</div>
			</div>

			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
					</div>
					<nav class="nav navbar-nav">
						<ul class=" navbar-right">
							<li class="nav-item dropdown open" style="padding-left: 15px;">
								<a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
									<img src="images/user.png" alt=""><?php echo $TenTG ?>
								</a>
								<div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/Project/DangXuat.php'; ?>"><i class="fa fa-sign-out pull-right"></i> Đăng xuất</a>
								</div>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Tạo Bài Viết</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Thông tin bài đăng </h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form action="./UpdateBaiViet.php" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="GET">

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tiêu Đề <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" name="TieuDe" required="required" class="form-control ">
											</div>
										</div>
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Thể Loại <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<select name="TheLoai" id="cars" class="form-control">
													<?php 
														$sql = "SELECT MaLT, TenLT FROM loaitin;";
														$result = $conn->query($sql);
														if ($result->num_rows > 0) {
															while ($tam = $result->fetch_assoc()) {
																echo '<option value="'.$tam["MaLT"].'">'.$tam["TenLT"].'</option>';
															}
														}
													?>
												</select>
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nguồn <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<select name="Nguon" id="cars" class="form-control">
													<?php 
														$sql = "SELECT DISTINCT Nguon,Logo FROM bangtin;";
														$result = $conn->query($sql);
														if ($result->num_rows > 0) {
															while ($tam = $result->fetch_assoc()) {
																echo '<option value="'.$tam["Nguon"].'">'.$tam["Nguon"].'</option>';
															}
														}
													?>
												</select>
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align">Ngày đăng bài <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input id="birthday" name="NgayDang" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
												<script>
													function timeFunctionLong(input) {
														setTimeout(function() {
															input.type = 'text';
														}, 60000);
													}
												</script>
											</div>
											
										</div>
										<br>
										<div class="item form-group">
											<div class="col-9"></div>
											<div class="col-md-3" style="margin-left: -50%; margin-top: 10px;">
												<Button class="btn btn-secondary btn-sm" name="info" value="<?php echo $MaTG; ?>"> Đăng bài</Button>
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>					
			</div>
			<!-- /page content -->
		</div>
	</div>
	<!-- script xóa ảnh -->
	<!-- footer content -->
	<footer>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

	<!-- jQuery -->
	<script src="../vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- FastClick -->
	<script src="../vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="../vendors/nprogress/nprogress.js"></script>
	<!-- bootstrap-progressbar -->
	<script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	<!-- iCheck -->
	<script src="../vendors/iCheck/icheck.min.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="../vendors/moment/min/moment.min.js"></script>
	<script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap-wysiwyg -->
	<script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
	<script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
	<script src="../vendors/google-code-prettify/src/prettify.js"></script>
	<!-- jQuery Tags Input -->
	<script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
	<!-- Switchery -->
	<script src="../vendors/switchery/dist/switchery.min.js"></script>
	<!-- Select2 -->
	<script src="../vendors/select2/dist/js/select2.full.min.js"></script>
	<!-- Parsley -->
	<script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
	<!-- Autosize -->
	<script src="../vendors/autosize/dist/autosize.min.js"></script>
	<!-- jQuery autocomplete -->
	<script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
	<!-- starrr -->
	<script src="../vendors/starrr/dist/starrr.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="../build/js/custom.min.js"></script>

</body>
</html>