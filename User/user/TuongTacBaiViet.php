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

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql ="select HoTenTG
        from tktacgia
        where upper(Email) = UPPER('".$_SESSION["taikhoan"]."')";
        $result = $conn->query($sql);
        
        // Binh luan //
        $sql = "select bangtin.MaBT,TenBT, NoiDungCmt, TenND, date_format(NgayCmt, '%d/%m/%Y') as NgayCmt
        from bangtin, comment, tknguoidung, tktacgia
        where bangtin.MaBT = comment.MaBT and comment.MaTKND = tknguoidung.MaTKND and tktacgia.MaTG = bangtin.MaTG
        and upper(tktacgia.Email) = UPPER('".$_SESSION["taikhoan"]."')
        order by NgayCmt DESC";
        
        
        $result1 = $conn->query($sql);

        $sql = "select Sum(SoLuotXem) as TongSoLuotXem
        from bangtin, tktacgia
        where bangtin.MaTG = tktacgia.MaTG and upper(Email) = UPPER('".$_SESSION["taikhoan"]."')";
        $result2 = $conn->query($sql);

        $sql = "select  sum(SoLuotLike) as TongSoLuotLike, count(MaCMT) as SoLuotCMT
        from bangtin, comment, tktacgia
        where bangtin.MaBT = comment.MaBT and tktacgia.MaTG = bangtin.MaTG
        and upper(Email) = UPPER('".$_SESSION["taikhoan"]."')";
        $result3 = $conn->query($sql);
    }
    //Close connection to database
    $conn->close();


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
	
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
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
                <?php
                  $tam = $result->fetch_assoc(); 
                  echo'
                    <div class="profile_info">
                      <span>Chào mừng bạn!</span>
                      <h2>'.$tam["HoTenTG"].' </h2>
                    </div>';
                ?>
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
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
           
            <!-- /menu footer buttons -->
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
                    <img src="images/user.png" alt="">
                      <?php
                        echo $tam["HoTenTG"];
                      ?>
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">                        
                    <a class="dropdown-item"  href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/Project/DangXuat.php'; ?>"><i class="fa fa-sign-out pull-right"></i> Đăng xuất</a>
                  </div>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- top navigation -->
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3> Tương tác bài viết </h3>
              </div>
            </div>
            <!-- page content -->
            <!-- top tiles -->
            <div class="clearfix"></div>
            <div class="row" style="display: block;">
              <div class="x_panel">
                <div class="x_content">
                  <?php
                    $tam2 = $result2->fetch_assoc();
                    echo '
                          <div class="col-md-3 col-sm-4  tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Tổng Số Lượt Xem <strong>'.$tam2["TongSoLuotXem"].' </strong> </span>
                          </div>';
                    $tam3 = $result3->fetch_assoc();
                    echo '
                        <div class="col-md-3 col-sm-4  tile_stats_count">
                          <span class="count_top"><i class="fa fa-user"></i> Số lượt tương tác '.$tam3["TongSoLuotLike"] + $tam3["SoLuotCMT"].'  </span>
                        </div>
                        <div class="col-md-3 col-sm-4  tile_stats_count">
                          <span class="count_top"><i class="fa fa-user"></i> Số lượt thích  <strong>'.$tam3["TongSoLuotLike"].' </strong></span>
                        </div>
                        <div class="col-md-3 col-sm-4  tile_stats_count">
                          <span class="count_top"><i class="fa fa-user"></i> Số lượt bình luận  <strong>'.$tam3["SoLuotCMT"].' </strong> </span>             
                        </div>';
                    ?>
                </div>
              </div>
            </div>
            <!-- /top tiles -->
            <div class="clearfix"></div>
            <div>
              <h4>Bình luận gần đây</h4>
            </div>
            <div class="x_panel">
              <div class="x_content">
                <ul class="messages">
                  <?php
                    if($result1->num_rows > 0)
                    {
                      while($tam1 = $result1->fetch_assoc())
                      {
                        echo '
                        <li>
                          <img src="images/user.png" class="avatar" alt="Avatar">
                          <div class="message_date">                          
                            <p class="month">'.$tam1["NgayCmt"].'</p>
                          </div>
                          <div class="message_wrapper">
                            <h4 class="heading">'.$tam1["TenND"].'</h4>
                            <blockquote class="message">'.$tam1["NoiDungCmt"].'</blockquote>
                            <br />
                            <p class="url">
                              <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                              <a href="http://'.$_SERVER['HTTP_HOST'].'/Project/Fnews.php?page=BangTin&Ma='.$tam1["MaBT"].'"><i class="fa fa-paperclip"></i> '.$tam1["TenBT"].' </a>
                            </p>
                          </div>
                        </li> ';
                      }
                    }
                  ?>                                            
                </ul>
              </div>
            </div>
          </div>
        </div>   
        <!-- footer content -->
        <footer>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- morris.js -->
    <script src="../vendors/raphael/raphael.min.js"></script>
    <script src="../vendors/morris.js/morris.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

  </body>
</html>