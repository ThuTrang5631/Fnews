<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "dbfnews";
  session_start();
  
  if ($_SESSION["taikhoan"] =='#') {
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://".$_SERVER['HTTP_HOST']."/Project/Fnews.php\">";
  }
  else{
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
    
    $sql = "select MaBT, HoTenTG, date_format(NgayDang, '%d/%m/%Y') as NgayDang, TenBT, SoLuotXem, TenLT
    from bangtin, tktacgia, loaitin
    where bangtin.MaTG = tktacgia.MaTG and upper(Email) = UPPER('".$_SESSION["taikhoan"]."') and bangtin.MaLT=loaitin.MaLT";
    $result2 = $conn->query($sql);

    if (!isset($_GET["remove"]))
      {$_GET["remove"] = '';}
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
      header("Location: DanhSachBaiViet.php");
    }
    $MaBT = " ";
    $TenBT = " ";
    if (!isset($_GET["edit"])) {
      $_GET["edit"] = ' ';
    }
    else {
      $MaBT = $_GET["edit"];
      $sql = "select TenBT
      from bangtin
      where MaBT='$MaBT'";
      $resultTenBT = $conn->query($sql);
      $row = $resultTenBT->fetch_assoc(); 
      $TenBT = $row["TenBT"];
    }
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
	
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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
                    </div>'
                ?>
            </div>
            <!-- /menu profile quick info -->
            <br />
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a href="ThongTinCaNhan.php"><i class="fa fa-home"></i> Thông tin cá nhân </a> 
                  </li>
                  <li><a><i class="fa fa-edit"></i>Quản lý bài viết <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="DanhSachBaiViet.php">Danh sách bài viết</a></li>
                        <li><a href="TuongTacBaiViet.php">Tương tác</a></li>
                      </ul>
                  </li>
                  <li><a href="TaoBaiViet.php"><i class="fa fa-clone"></i> Tạo bài viết </a> 
                  </li>
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
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3> Danh sách bài viết </h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_content">
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>
                            <th class="column-title">Tên Bài Viết </th>
                            <th class="column-title">Ngày Đăng </th>
                            <th class="column-title">Chủ Đề </th>
                            <!-- <th class="column-title">Trạng Thái </th> -->
                            <th class="column-title">Lượt Xem </th>
                            <th class="column-title no-link last"><span class="nobr">Hành Động</span></th>                           
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Chọn tất cả ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                              for ($i = 0; $i < mysqli_num_rows($result2); $i++){
                              $tam2=$result2->fetch_assoc();
                              echo ' 
                                    <tr class="even pointer">
                                    <td class="a-center ">
                                    <input type="checkbox" class="flat" name="table_records">
                                    </td>
                                    <td class=" ">'.$tam2["TenBT"].'</td>
                                    <td class=" ">'.$tam2["NgayDang"].'</td>
                                    <td class=" ">'.$tam2["TenLT"].'</td>                                   
                                    <td class=" ">'.$tam2["SoLuotXem"].'</td>
                                    <td class=" last">
                                      <form method="GET" action="DanhSachBaiViet.php">
                                        <button class = "btn btn-secondary btn-sm" type="submit" id="btn-delete'.$i.'" name="remove" value="'.$tam2["MaBT"].'">Xóa</button>
                                        <button class = "btn btn-secondary btn-sm" type="submit" id="btn-edit'.$i.'" name="edit" value="'.$tam2["MaBT"].'">Sửa</button>
                                      </form>
                                      
                                    </td>
                                  </tr>';
                              };
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="" >
            <div class="EditPage" style="display: <?php if($MaBT == " ") echo "none"; else echo "block"; ?>;">
              <div class="page-title">
                <div class="title_left">
                  <h3> Chỉnh sửa bài viết </h3>
            
                  <h5> <i> <?php echo $TenBT; ?></i></h5>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="row" style="display: block;">
                <div class="col-md-12 col-sm-12  ">
                  <div class="x_panel">
                    <div class="x_content">
                      <form action="./EditBaiViet.php" method="POST">
                        <div class="table-responsive">
                          <table class="table table-striped jambo_table bulk_action">
                            <thead>
                              <tr class="headings">
                                <th class="column-title" width="8%">STT</th>
                                <th class="column-title" width="8%">Loại</th>
                                <th class="column-title" width="50%">Mục 1 ( Nội dung - Nội dung ) - ( Hình ảnh - Link ảnh )</th>
                                <th class="column-title" width="20%">Mục 2 ( Hình ảnh - Mô tả ảnh )</th>
                                <!-- <th class="column-title">Trạng Thái </th> -->
                                <th class="column-title no-link last"><span class="nobr">Hành Động</span></th>                           
                              </tr>
                            </thead>
                            <tbody id="list-compo-edit">
                            </tbody>
                          </table>
                          <Button class ="btn btn-secondary btn-lg" onclick="addlist()" type="button">Thêm mục</Button>
                          <Button class ="btn btn-secondary btn-lg" onclick="" type="submit" name="info" value="" id="info-list">Update</Button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
        

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
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <script>
    var maEdit = "<?php echo $MaBT; ?>"
    console.log(maEdit);
    var item = [ {
      loai : ' ',
      muc1 : 'asdfsda\nsadasdasd'
    }]
    if (maEdit != " ") {
      item = [ 
        <?php         
            // $MaBT = 'BT02';
            $sqlND = "SELECT STT, DuLieu FROM `noidung` WHERE MaBT = '$MaBT'";
            $resultND = $conn->query($sqlND);
            $sqlHA = "SELECT STT, HinhAnh, MoTaAnh FROM `hinhanh` WHERE MaBT = '$MaBT';";
            $resultHA = $conn->query($sqlHA);
            $lengthBT = $resultND->num_rows + $resultHA->num_rows;
            if ($resultND->num_rows > 0)
              $indexND = $resultND->fetch_assoc();
            if ($resultHA->num_rows > 0)
              $indexHA = $resultHA->fetch_assoc();
            $i = 1;
            while ($i <= $lengthBT) {
                if (isset($indexND["STT"]))
                  if ($indexND["STT"] == "$i") {
                      echo "{ loai:'noidung', muc1: `".$indexND["DuLieu"]."`, muc2: ''},";
                      $indexND = $resultND->fetch_assoc();
                      $i++;
                  }
                if (isset($indexHA["STT"]))
                  if ($indexHA["STT"] == "$i") {
                      echo "{ loai:'hinhanh', muc1: `".addslashes($indexHA["HinhAnh"])."`, muc2: `".addslashes($indexHA["MoTaAnh"])."`},";
                      $indexHA = $resultHA->fetch_assoc();
                      $i++;
                  } 
            }
        ?>
      ]
      console.log(item)
      buildEdit(item)
    }
    function listDelete(index) {
      item.splice(index-1,1);
      buildEdit(item);
    }
    function listChange(index) {
      var loaichange = item[index-1]["loai"];
      if (loaichange == 'noidung')
        item[index-1]["loai"] = 'hinhanh'
      else
        item[index-1]["loai"] = 'noidung'
      item[index-1]["muc1"] = "";
      item[index-1]["muc2"] = "";
      buildEdit(item);
    }
    function addlist() {
      updateList()
      item.push({loai : "noidung", muc1 : "", muc2 : "", }) 
      console.log(item)
      buildEdit(item)
    }
    function updateList() {
      for(var i=0; i <item.length;i++) {
        var index = i+1;
        item[i]["loai"] = $("#list-type-"+index).val();
        item[i]["muc1"] = $("#list-"+index+"-muc-1").val();
        item[i]["muc2"] = $("#list-"+index+"-muc-2").val();
      }
    }
    function buildEdit(items) {
      var i = 0
      var htmlCompo = ''
      $("#info-list").val(item.length+"-"+maEdit)
      for (i=0;i<items.length;i++) {
        var index = i+1
        var selected = (items[i]["loai"]=="hinhanh")?"selected":" " 
        var disabled = (items[i]["loai"]=="noidung")?"disabled":" " 
        htmlCompo += '  <tr class="even pointer" id="list-edit-'+index+'">'+
                          '<td class="a-center"> '+index+' </td>'+
                          '<td class="a-center">'+
                            '<select id="list-type-'+index+'" onchange="listChange('+index+')" name="listChange-'+index+'">'+
                              '<option value="noidung">Bài viết</option>'+
                              '<option value="hinhanh" '+selected+'>Hình ảnh</option>'+
                            '</select>'+
                          '</td>'+
                            '<td>'+
                              '<div>'+
                                '<input id="list-'+index+'-muc-1" name="list-'+index+'-muc-1" type="text" value="'+items[i]["muc1"]+'" size="80">'+
                              '</div>'+
                            '</td>'+
                            '<td class="a-center">'+
                              '<input id="list-'+index+'-muc-2" name="list-'+index+'-muc-2" type="text" size="40" value="'+items[i]["muc2"]+'" '+disabled+'>'+
                            '</td>'+
                          '<td class="a-center">'+
                            '<button class = "btn btn-secondary btn-sm" type="button" onclick="listDelete('+index+')">Xóa</button>'+
                          '</td>'+
                        '</tr>';
      }
      document.getElementById("list-compo-edit").innerHTML = htmlCompo;
    }
  </script>
  </body>
  
</html>
<?php
  //Close connection to database
  $conn->close();
?>