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
      $sql ="select * 
      from tktacgia
      where upper(Email) = UPPER('".$_SESSION["taikhoan"]."')"; 
      $result = $conn->query($sql);
      
      $sql = "select count(*) as SoBaiViet, Sum(SoLuotXem) as TongSoLuotXem
      from bangtin, tktacgia
      where bangtin.MaTG = tktacgia.MaTG and upper(Email) = UPPER('".$_SESSION["taikhoan"]."')";
      $result2 = $conn->query($sql);
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
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Thông tin cá nhân</h3>
              </div>           
            </div>           
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3  profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img class="img-responsive avatar-view" src="images/user.png" alt="Avatar" title="Change the avatar">
                        </div>
                      </div>
                      <br />                  
                    </div>
                    <div class="col-md-9 col-sm-9 ">
                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Giới thiệu</a>
                          </li>
                          <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Liên lạc</a>
                          </li>
                          <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Bài viết</a>
                          </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane active " id="tab_content1" aria-labelledby="home-tab">
                            <ul>
                              <?php
                                echo '
                                  <li>
                                    <p>Họ và tên:'.$tam["HoTenTG"].'</p>
                                  </li>
                                  <li>
                                    <i class="fa fa-birthday-cake"></i> Ngày sinh:'.$tam["NgaySinh"].'
                                  </li> 
                                '
                              ?>     
                            </ul>
                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                            <?php
                              echo ' <ul>
                              <li><i class="fa fa-map-marker user-profile-icon"></i> Địa chỉ: '.$tam["DiaChi"].'</li>
                              <li><i class=" fa fa-envelope-o"></i> Email: '.$tam["Email"].' </li>
                              <li><i class=" fa fa-mobile"></i> Số điện thoại: '.$tam["SDT"].' </li>
                            </ul>'
                            ?>
                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                            <?php
                              $tam2 = $result2->fetch_assoc();
                              echo '
                                <ul>
                                  <li>Tổng số bài viết: '.$tam2["SoBaiViet"].'</li>
                                  <li>Tổng số lượt xem: '.$tam2["TongSoLuotXem"].'</li>
                                </ul>';
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

  </body>
</html>