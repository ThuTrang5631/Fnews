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
        $sql = "select bangtin.MaBT, TenBT,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai, TenLT, TenTG
        from bangtin, tktacgia,loaitin
        where bangtin.MaTG = tktacgia.MaTG and loaitin.MaLT = bangtin.MaLT";
        $result = $conn->query($sql);

        if (!isset($_GET["remove"])){$_GET["remove"] = '';}
        else{
            $id=$_GET["remove"];
            $sql= "select * from comment where MaBT='$id'";
            $result= $conn->query($sql);
            for($i=0; $i < $result->num_rows; $i++){
                $check = $result->fetch_assoc();
                $MaCmt=$check["MaCMT"];
                $sql5="delete from luotlike where MaCMT='$MaCmt' ";
                $del5 = $conn->query($sql5);
            }   
        $sql1="delete from comment where MaBT='$id' ";
        $sql2="delete from noidung where MaBT='$id' ";
        $sql3="delete from hinhanh where MaBT='$id' ";
        $sql4="delete from bangtin where MaBT='$id' ";  
        $del1 = $conn->query($sql1);
        $del2 = $conn->query($sql2);
        $del3 = $conn->query($sql3);
        $del4 = $conn->query($sql4);
        
        echo "Xóa thành công";
        header("Location: XoaBaiViet.php");}
    }
    //Close connection to database
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
            <a class="navbar-brand" href="Admin.php">Admin</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
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
                                Xóa bài viết
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
                        <h1 class="mt-4">Xóa bài viết</h1>
                        <div class="row">
                           
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Danh sách bài viết
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tên Bài Viết</th>
                                                <th>Tên Tác Giả</th>
                                                <th>Ngày Đăng</th>
                                                <th>Chủ Đề</th>
                                                <th>Hành Động</th>
                                            </tr>
                                        </thead>                            
                                        <tbody>
                                            <?php
                                                for ($i = 0; $i < mysqli_num_rows($result); $i++){
                                                    $tam=$result->fetch_assoc();
                                                    echo '
                                                        <tr>
                                                            <td>'.$tam["TenBT"].'</td>
                                                            <td>'.$tam["TenTG"].'</td>
                                                            <td>'.$tam["NgayDangBai"].'</td>
                                                            <td>'.$tam["TenLT"].'</td>
                                                            <th>
                                                                <form method="GET" action="XoaBaiViet.php">
                                                                    <button class="btn btn-primary" type="submit" id="btn-delete'.$i.'" name="remove" value="'.$tam["MaBT"].'">Xóa</button>
                                                                </form>
                                                            </th>
                                                        </tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
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
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>