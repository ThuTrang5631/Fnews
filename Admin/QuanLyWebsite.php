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
        //Tong So Bai Viet
        $post= "select count(*) as SoLuong from bangtin;";
        $sumpost= $conn->query($post);
        //Tong So Luot Xem
        $seen= "select sum(SoLuotXem) as SoLuong from bangtin;";
        $sumseen = $conn->query($seen);
        //Tong So Tuong Tac
        $cmt = "select count(*) as SoLuong from comment;";
        $sumcmt = $conn->query($cmt);
        //Tong So Tac Gia
        $author = "select count(*) as SoLuong from tktacgia;";
        $sumauthor = $conn->query($author);
        //Bai Viet Xem Nhieu Nhat
        $sqlBT = "select distinct bangtin.MaBT,SUBSTRING( bangtin.TenBT, 1, 69) as TenBT, HinhAnh.HinhAnh,bangtin.Nguon,bangtin.Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai
                from BANGTIN,HINHANH
                where BANGTIN.MaBT= HINHANH.MaBT AND  HinhAnh.MaHA = 'HA01' 
                order by SoLuotXem DESC;";
        $BT = $conn->query($sqlBT);
        //Tac Gia Nhieu Bai Viet Nhat
        $sqlTG = "select *
                from bangtin,tktacgia
                where bangtin.MaTG= tktacgia.MaTG
                group by bangtin.MaTG
                order by count(MaBT)desc,SoLuotXem desc limit 1;";
        $TG = $conn->query($sqlTG);
        // Bai viet nieu luot tuong tac nhat
        $sqlTT = " select distinct bangtin.MaBT,SUBSTRING( bangtin.TenBT, 1, 69) as TenBT, HinhAnh.HinhAnh,bangtin.Nguon,bangtin.Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai, count(MaCMT)
                    from BANGTIN,HINHANH,comment
                    where BANGTIN.MaBT= HINHANH.MaBT AND  HinhAnh.MaHA = 'HA01' and comment.MaBT=bangtin.MaBT
                    group by bangtin.MaBT,SoLuotXem
                    order by count(MaCMT) desc, SoLuotXem desc limit 1";
        $TT = $conn->query($sqlTT);
        // Cmt nhieu like nhat
        $cmt= "select bangtin.MaBT,TenBT,NgayCmt,SoLuotLike,NoiDungCmt,TenND
        from tknguoidung,comment,bangtin
        where tknguoidung.MaTKND= comment.MaTKND and bangtin.MaBT=comment.MaBT and SoLuotLike IN (select max(SoLuotLike)
        from comment)";
        $result=$conn->query($cmt);
    }
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title> FNEWS ADMIN</title>
        <link rel="shortcut icon" type="image/png" href="/Project/image/Fnews3.png"/>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="admin.html">Admin</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/Project/DangXuat.php'; ?>">Đăng Xuất</a>
                    </div>
                </li>
            </ul>
        </nav>
        
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="Admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Trang Chủ
                            </a>
                            <a class="nav-link" href="QuanLyWebsite.php" >
                                <div class="sb-nav-link-icon"></div>
                                Quản lý website
                            </a>
                            <a class="nav-link" href="XoaBaiViet.php" >
                                <div class="sb-nav-link-icon"></div>
                                Xóa Bài Viết
                            </a>
                            <a class="nav-link" href="QuanLyTacGia.php" >
                                <div class="sb-nav-link-icon"></div>
                                Quản lý tác giả
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Đăng nhập bởi</div>
                        Admin
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Quản Lý Website</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row" style="margin: auto;text-align: center;">
                                    <div class="col-md-3" >
                                        <p ><i class="fa fa-edit"></i> Tổng Số Bài Viết  </p>
                                         <?php
                                            $TongBT= $sumpost->fetch_assoc();
                                            echo'<p ><strong> '.$TongBT["SoLuong"].'</strong> </span>';
                                         ?>      
                                    </div>
                                    <div class="col-md-3" >
                                        <p ><i class="fa fa-user"></i> Tổng Số Tác Giả  </p>
                                        <?php
                                            $TongTG= $sumauthor->fetch_assoc();
                                            echo'<p ><strong> '.$TongTG["SoLuong"].'</strong> </span>';
                                         ?>
                                    </div>
                                    <div class="col-md-3" >
                                        <p ><i class="fa fa-user"></i> Tổng Số Lượt Xem  </p>
                                        <?php
                                            $TongLX= $sumseen->fetch_assoc();
                                            echo'<p ><strong> '.$TongLX["SoLuong"].'</strong> </span>';
                                         ?> 
                                    </div>
                                    <div class="col-md-3" >
                                        <p ><i class="fa fa-comments"></i> Tổng Số Lượt Tương Tác  </p>
                                        <?php
                                            $TongTT= $sumcmt->fetch_assoc();
                                            echo'<p ><strong> '.$TongTT["SoLuong"].'</strong> </span>';
                                         ?>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                    <i class="fa fa-edit"></i>
                                         Bài Viết Nhiều Lượt Xem Nhất
                                    </div>
                                    <br>
                                    <div class="_card row col-lg-12 col-md-6">
                                        <?php
                                            $bestpost=  $BT->fetch_assoc();
                                            echo '
                                            <div class="col-5 img_card">
                                                <a href="http://'.$_SERVER['HTTP_HOST'].'/Project/Fnews.php?page=BangTin&Ma='.$bestpost["MaBT"].'">
                                                    <img class="w-100 d-block" src="'.$bestpost["HinhAnh"].'" alt="" height=200px, width= 300px>
                                                </a>
                                            </div>
                                            <div class="col-7 ml-0 text_card">
                                                <a href="http://'.$_SERVER['HTTP_HOST'].'/Project/Fnews.php?page=BangTin&Ma='.$bestpost["MaBT"].'">
                                                    <p class="p_card">'.$bestpost["TenBT"].'</p>
                                                </a>
                                                <div class="d-flex">
                                                    <a href="'.$bestpost["Nguon"].'">
                                                        <img class="w-50 d-inline" src="'.$bestpost["Logo"].'" alt="" >
                                                    </a>
                                                    <div class="d-flex w-100 flex-column-reverse">
                                                        <p class="date_card w-100">
                                                        '.$bestpost["NgayDangBai"].'
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>';
                                        ?>
                                    </div>
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                    <i class="fa fa-user"></i>
                                        Tác Giả Nhiều Bài Viết Nhất
                                    </div>
                                    <br>
                                    <div class="_card row col-lg-12 col-md-6">
                                        <div class="col-5 img_card">
                                            <a href="">
                                                <img class="w-100 d-block" src="https://static2.yan.vn/YanNews/2167221/202102/facebook-cap-nhat-avatar-doi-voi-tai-khoan-khong-su-dung-anh-dai-dien-e4abd14d.jpg" alt=""  height=200px, width= 300px >
                                            </a>
                                        </div>
                                        <div class="col-7 ml-0 text_card">
                                            <?php
                                                $bestauthor = $TG->fetch_assoc();
                                                echo '
                                                    <p> Họ và Tên: '.$bestauthor["HoTenTG"].'</p>
                                                    <p> Ngày Sinh: '.$bestauthor["NgaySinh"].'</p>
                                                    <p> Email: '.$bestauthor["Email"].'</p>
                                                    <p> Số điện thoại: '.$bestauthor["SDT"].'</p>';       
                                            ?>    
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                    <i class="fa fa-edit"></i>
                                        Bài Viết Nhiều Lượt Tương Tác Nhất
                                    </div>
                                    <br>
                                    <div class="_card row col-lg-12 col-md-6">
                                    <?php
                                            $bestinteract=  $TT->fetch_assoc();
                                            echo '
                                            <div class="col-5 img_card">
                                                <a href="http://'.$_SERVER['HTTP_HOST'].'/Project/Fnews.php?page=BangTin&Ma='.$bestinteract["MaBT"].'"">
                                                    <img class="w-100 d-block" src="'.$bestinteract["HinhAnh"].'" alt=""  height=200px, width= 300px>
                                                </a>
                                            </div>
                                            <div class="col-7 ml-0 text_card">
                                                <a href="http://'.$_SERVER['HTTP_HOST'].'/Project/Fnews.php?page=BangTin&Ma='.$bestinteract["MaBT"].'"">
                                                    <p class="p_card">'.$bestinteract["TenBT"].'</p>
                                                </a>
                                                <div class="d-flex">
                                                    <a href="'.$bestinteract["Nguon"].'">
                                                        <img class="w-50 d-inline" src="'.$bestinteract["Logo"].'" alt="">
                                                    </a>
                                                    <div class="d-flex w-100 flex-column-reverse">
                                                        <p class="date_card w-100">
                                                        '.$bestinteract["NgayDangBai"].'
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>';
                                        ?>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                    <i class="fa fa-comments"></i>
                                        Bình Luận Nhiều Lượt Tương Tác Nhất
                                    </div>
                                    <br>
                                    <div class="_card row col-lg-12 col-md-6">
                                    <?php
                                            $bestcmt=  $result->fetch_assoc();
                                            echo '
                                            <div class="col-5 img_card">
                                                    <img class="w-100 d-block" src="https://static2.yan.vn/YanNews/2167221/202102/facebook-cap-nhat-avatar-doi-voi-tai-khoan-khong-su-dung-anh-dai-dien-e4abd14d.jpg" alt="" height=200px, width= 300px>
                                            </div>
                                            <div class="col-7 ml-0 text_card">
                                                <a href="http://'.$_SERVER['HTTP_HOST'].'/Project/Fnews.php?page=BangTin&Ma='.$bestcmt["MaBT"].'"">
                                                    '.$bestcmt["TenBT"].'
                                                </a>
                                                <p class="p_card">'.$bestcmt["TenND"].'</p>
                                                <p class="p_card">'.$bestcmt["NoiDungCmt"].'</p>
                                                <p><i class="fas fa-thumbs-up"></i> '.$bestcmt["SoLuotLike"].'</p>
                                                <div class="d-flex">
                                                    <div class="d-flex w-100 flex-column-reverse">
                                                        <p class="date_card w-100" style="margin-right 10px;">
                                                        '.$bestcmt["NgayCmt"].'
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>';
                                        ?>
                                    </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/demo/chart-pie-demo.js"></script>
    </body>
</html>
