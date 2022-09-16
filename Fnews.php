<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbfnews";
    session_start();
    if (!isset($_SESSION['taikhoan']))
        $_SESSION['taikhoan'] = '#';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn -> set_charset("utf8");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_GET["Ma"]))
    {
        $sql= "update bangtin set SoLuotXem= SoLuotXem+1 where MaBT ='".$_GET["Ma"]."';";
        $result =  $conn->query($sql);
    }

    // build page button
    $sql = "SELECT TenLT,TenLTID FROM LOAITIN";
    $resultLT = $conn->query($sql);

    $page = isset($_GET['page']) ? $_GET['page'] : "TrangChu" ;
    echo "<style type='text/css'>
    #".$page."-btn {
        background-color: #17a2b8;
    }
    </style>" ;

    // build top 3 hot new

    $sql = "select distinct bangtin.MaBT,bangtin.TenBT, HinhAnh.HinhAnh
            from BANGTIN,HINHANH
            where BANGTIN.MaBT= HINHANH.MaBT AND  HinhAnh.MaHA = 'HA01'
            order by NgayDang DESC, SoLuotXem  DESC, MaBT DESC limit 3;";
    $top3 = $conn->query($sql);
    //build top 5 hot news
    $sql = "select distinct bangtin.MaBT,SUBSTRING( bangtin.TenBT, 1, 69) as TenBT, HinhAnh.HinhAnh,bangtin.Nguon,bangtin.Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai
            from BANGTIN,HINHANH
            where BANGTIN.MaBT= HINHANH.MaBT AND  HinhAnh.MaHA = 'HA01' 
            order by SoLuotXem DESC limit 5;";
    $top5 = $conn->query($sql);
    // build top thoisu news
    $sql = "select distinct bangtin.MaBT,SUBSTRING( TenBT, 1, 69) as TenBT, HinhAnh.HinhAnh,bangtin.Nguon,bangtin.Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai 
            from BANGTIN,HINHANH,LOAITIN 
            where BANGTIN.MaBT= HINHANH.MaBT AND HinhAnh.MaHA = 'HA01' AND LOAITIN.MaLT= bangtin.MaLT and loaitin.MaLT='LT05' 
            order by NgayDang DESC, SoLuotXem DESC limit 5;";
    $topthoisu= $conn->query($sql);
    // built top 5Chinh Tri

    $sql = "select distinct bangtin.MaBT, SUBSTRING( TenBT, 1, 48) as TenBT , `HinhAnh`, `Logo`, date_format(NgayDang,'%d/%m/%Y') as NgayDangBai, SUBSTRING(noidung.DuLieu, 1, 150) as DuLieu, Nguon

    from BANGTIN,HINHANH, loaitin, noidung

    where BANGTIN.MaBT= HINHANH.MaBT and bangtin.MaLT = loaitin.MaLT and TenLT='Chính Trị' and bangtin.MaBT = noidung.MaBT and MaND='ND01' 

    order by NgayDang DESC, SoLuotXem DESC limit 5;";

    $top5CT = $conn->query($sql);
    //Thethao
    $sql = "select distinct bangtin.MaBT,bangtin.TenBT, hinhanh.HinhAnh, bangtin.NgayDang, SUBSTRING(noidung.DuLieu, 1, 248) as DuLieu, date_format(NgayDang, '%d/%m/%Y') as NgayDangBai
        from bangtin, hinhanh, noidung 
        where bangtin.MaBT= hinhanh.MaBT and bangtin.MaBT = noidung.MaBT and bangtin.MaLT = 'LT04' and noidung.MaND ='ND01' and hinhanh.MaHA = 'HA01' 
        order by bangtin.NgayDang DESC, SoLuotXem DESC limit 2;";
    $TTtop2 = $conn->query($sql);
    // build top 3 Van hoa
    
    $sql = "select distinct bangtin.MaBT,SUBSTRING(bangtin.TenBT,1,65) as TenBT, bangtin.Logo, hinhanh.HinhAnh, SUBSTRING(noidung.DuLieu, 1, 100) as DuLieu, date_format(NgayDang, '%d/%m/%Y') as NgayDangBai,Nguon
            from bangtin, hinhanh, noidung where BANGTIN.MaBT= HINHANH.MaBT and BANGTIN.MaBT = NOIDUNG.MaBT and bangtin.MaLT = 'LT03'and noidung.MaND ='ND01' and hinhanh.MaHA = 'HA01'
            order by bangtin.NgayDang DESC limit 3;";
    $VHtop3 = $conn->query($sql); 

    // build top 3 Du Lich
    $sql = "select distinct bangtin.MaBT,SUBSTRING(bangtin.TenBT,1,60) as TenBT, bangtin.Logo, hinhanh.HinhAnh, SUBSTRING(noidung.DuLieu, 1, 100) as DuLieu, date_format(NgayDang, '%d/%m/%Y') as NgayDangBai, Nguon
            from bangtin, hinhanh, noidung
            where BANGTIN.MaBT= HINHANH.MaBT and BANGTIN.MaBT = NOIDUNG.MaBT and bangtin.MaLT = 'LT08'and noidung.MaND ='ND01' and hinhanh.MaHA = 'HA01'
            order by bangtin.NgayDang DESC limit 3;";
    $DLtop3 = $conn->query($sql);
    //build top 5 hot news
    $sql = "select distinct bangtin.MaBT,SUBSTRING( bangtin.TenBT, 1, 69) as TenBT, HinhAnh.HinhAnh,bangtin.Nguon,bangtin.Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai
            from BANGTIN,HINHANH
            where BANGTIN.MaBT= HINHANH.MaBT AND  HinhAnh.MaHA = 'HA01' 
            order by SoLuotXem DESC limit 5;";
    $top5 = $conn->query($sql);
    // build top thoisu news
    $sql = "select distinct bangtin.MaBT,SUBSTRING( TenBT, 1, 69) as TenBT, HinhAnh.HinhAnh,bangtin.Nguon,bangtin.Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai 
            from BANGTIN,HINHANH,LOAITIN 
            where BANGTIN.MaBT= HINHANH.MaBT AND HinhAnh.MaHA = 'HA01' AND LOAITIN.MaLT= bangtin.MaLT and loaitin.MaLT='LT05' 
            order by NgayDang DESC, SoLuotXem DESC limit 5;";
    $topthoisu= $conn->query($sql);
    //Demuc chinh tri
    $sqlCT = "select bangtin.MaBT, HinhAnh,TenBT, SUBSTRING( DuLieu, 1,143) as DuLieu, Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai, Nguon
            from bangtin, hinhanh, noidung
            where bangtin.MaBT = HinhAnh.MaBT and bangtin.MaBT = noidung.MaBT and bangtin.MaLT = 'LT01'and HinhAnh.MaHA = 'HA01'and noidung.MaND = 'ND01'
            order by NgayDang DESC;";
    $demucCT= $conn->query($sqlCT);
    //De muc xa hoi
    $sqlXH = "select bangtin.MaBT, HinhAnh,TenBT, SUBSTRING( DuLieu, 1,143) as DuLieu, Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai, Nguon
                from bangtin, hinhanh, noidung
                where bangtin.MaBT = HinhAnh.MaBT and bangtin.MaBT = noidung.MaBT and bangtin.MaLT = 'LT02'and HinhAnh.MaHA = 'HA01'and noidung.MaND = 'ND01'
                order by NgayDang DESC;";
    $demucXH= $conn->query($sqlXH);
    /* Van Hoa */
    $sql= "select bangtin.MaBT, HinhAnh,TenBT, DuLieu, Logo, date_format(NgayDang,'%d/%m/%Y') as NgayDangBai, Nguon, SUBSTRING(noidung.DuLieu, 1, 200) as DuLieu
            from bangtin, hinhanh, noidung
            where bangtin.MaBT = HinhAnh.MaBT and bangtin.MaBT = noidung.MaBT and HinhAnh.MaHA = 'HA01'and noidung.MaND = 'ND01' and MaLT='LT03'
            order by NgayDang DESC;";
    $listVanHoa = $conn->query($sql);
    /* The Thao */
    $sql = "select bangtin.MaBT, HinhAnh,TenBT, DuLieu, Logo,date_format(NgayDang,'%d/%m/%Y') as NgayDangBai, Nguon, SUBSTRING(noidung.DuLieu, 1, 210) as DuLieu
            from bangtin, hinhanh, noidung
            where bangtin.MaBT = HinhAnh.MaBT and bangtin.MaBT = noidung.MaBT and HinhAnh.MaHA = 'HA01'and noidung.MaND = 'ND01' and MaLT='LT04'
            order by NgayDang DESC;";
    $listTheThao = $conn->query($sql);
    /* Giai tri */
    $sql = "select bangtin.MaBT, HinhAnh,TenBT, DuLieu, Logo,date_format(NgayDang,'%d/%m/%Y') as NgayDangBai, Nguon, SUBSTRING(noidung.DuLieu, 1, 173) as DuLieu
            from bangtin, hinhanh, noidung
            where bangtin.MaBT = HinhAnh.MaBT and bangtin.MaBT = noidung.MaBT and HinhAnh.MaHA = 'HA01'and noidung.MaND = 'ND01' and MaLT='LT09'
            order by NgayDang DESC;";
    $listGiaiTri = $conn->query($sql);
    //build de muc thoisu
    $sql = "select bangtin.MaBT, HinhAnh, TenBT, SUBSTRING( DuLieu, 1, 150) as DuLieu, Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai , Nguon
    from bangtin, hinhanh, noidung
    where bangtin.MaBT = HinhAnh.MaBT and bangtin.MaBT = noidung.MaBT and bangtin.MaLT = 'LT05'and HinhAnh.MaHA = 'HA01'and noidung.MaND = 'ND01'
    order by NgayDang DESC;";
    $top5_TS = $conn->query($sql);
    //build de muc kinhdoanh
    $sql = "select bangtin.MaBT, HinhAnh, TenBT, SUBSTRING( DuLieu, 1, 150) as DuLieu, Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai , Nguon
    from bangtin, hinhanh, noidung
    where bangtin.MaBT = HinhAnh.MaBT and bangtin.MaBT = noidung.MaBT and bangtin.MaLT = 'LT06'and HinhAnh.MaHA = 'HA01'and noidung.MaND = 'ND01'
    order by NgayDang DESC;";
    $top5_KD = $conn->query($sql);
    /*  De muc Giao Duc */
    $sql= "select bangtin.MaBT, HinhAnh,TenBT,SUBSTRING(DuLieu,1,198) as DuLieu, Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai, Nguon
    from bangtin, hinhanh, noidung
    where bangtin.MaBT = HinhAnh.MaBT and bangtin.MaBT = noidung.MaBT and bangtin.MaLT = 'LT07'and HinhAnh.MaHA = 'HA01'and noidung.MaND = 'ND01'
    order by NgayDangBai DESC";
    $Giaoduc= $conn->query($sql);
   /* De muc Du Lich */
   $sql = "select bangtin.MaBT, HinhAnh,TenBT, SUBSTRING(DuLieu,1,198) as DuLieu, Logo, date_format(NgayDang, '%d/%m/%Y') as NgayDangBai, Nguon
   from bangtin, hinhanh, noidung
   where bangtin.MaBT = HinhAnh.MaBT and bangtin.MaBT = noidung.MaBT and bangtin.MaLT = 'LT08'and HinhAnh.MaHA = 'HA01'and noidung.MaND = 'ND01'
   order by NgayDangBai DESC";
   $Dulich= $conn->query($sql);

    // search
    if (!isset($_GET["key"])){$_GET["key"] = '';}
    $keyword=$_GET["key"];
    $sql="select bangtin.MaBT, HinhAnh,TenBT,SUBSTRING(DuLieu,1,198) as DuLieu, Logo,date_format(NgayDang, '%d/%m/%Y') as NgayDangBai, Nguon
    from bangtin, hinhanh, noidung
    where bangtin.MaBT = HinhAnh.MaBT and bangtin.MaBT = noidung.MaBT and HinhAnh.MaHA = 'HA01'and noidung.MaND = 'ND01' and TenBT like '%$keyword%'
    order by NgayDangBai DESC";
    $searchResult= $conn->query($sql);

    //Nội dung bản tin
    if (!isset($_GET["Ma"])){$_GET["Ma"] = '';}
    $MaBT = $_GET["Ma"];
    $sql = "SELECT bangtin.MaBT, TenBT, UPPER(TenLT) as TenLT, Nguon, TenTG, Logo, date_format(NgayDang, '%d/%m/%Y') as NgayDangBai FROM bangtin, tktacgia, loaitin WHERE bangtin.MaTG = tktacgia.MaTG and bangtin.MaLT = loaitin.MaLT and MaBT = '$MaBT'";
    $resultBT = $conn->query($sql);
    $sqlND = "SELECT STT, DuLieu FROM `noidung` WHERE MaBT = '$MaBT'";
    $resultND = $conn->query($sqlND);
    $sqlHA = "SELECT STT, HinhAnh, MoTaAnh FROM `hinhanh` WHERE MaBT = '$MaBT';";
    $resultHA = $conn->query($sqlHA);
    
    $lengthBT = $resultND->num_rows + $resultHA->num_rows;
    
    $indexND = $resultND->fetch_assoc();
    $indexHA = $resultHA->fetch_assoc();
    $sqlAdd="select * from bangtin where MaLT = (select MaLT from bangtin where MaBT='$MaBT') limit 3";
    $resultAdd = $conn->query($sqlAdd);

    //Comment
    $sql = "select NoiDungCmt,TenND, date_format(NgayCmt, '%d/%m/%Y') as NgayCMT, SoLuotLike, MaCMT, tknguoidung.MaTKND
    from comment, bangtin, tknguoidung
    where comment.MaBT = bangtin.MaBT and comment.MaTKND = tknguoidung.MaTKND and bangtin.MaBT = '$MaBT'
    order by NgayCmt DESC";
    $NDCmt = $conn->query($sql);

    // sent comment
    if (!isset($_GET["cmt"]) || $_GET["cmt"]=='' || !isset($_GET["ID"]) || $_GET["ID"]=='')
        {
            $_GET["cmt"] = '#';
            $_GET["ID"] = '#';
        }
    else {        
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date = date('Y-m-d');
        $ID = $_GET["ID"];
        $Noidung = $_GET["cmt"];
        $Email = $_SESSION['taikhoan'];
        $resultAcc = $conn->query("SELECT * FROM tknguoidung WHERE upper(Email)=upper('$Email');");
        $MaTK = $resultAcc->fetch_assoc(); 
        $MaTKcmt = $MaTK["MaTKND"];           
        $row = $conn->query("SELECT * FROM `comment`;");
        $number = $row->num_rows + 1;       
        $sql="INSERT INTO `comment` (`MaCMT`, `MaBT`, `MaTKND`,`NgayCmt`, `NoiDungCmt`, `SoLuotLike`) VALUES ('CM$number','$ID','$MaTKcmt','$date','$Noidung', 0);";      
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully. <br>";
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
            }            
        header("Location: Fnews.php?page=BangTin&Ma=$ID");
    }

   //cập nhật like
   if (!isset($_GET["MaCMT"]) || $_GET["MaCMT"]=='' || !isset($_GET["MaBT"]) || $_GET["MaBT"]=='')
   {
       $_GET["MaCMT"] = "#";
       $_GET["MaBT"] = "#";
   }

   $idCMT = $_GET["MaCMT"];
   $Ma = $_GET["MaBT"];
   $sql= "SELECT * from tknguoidung  where Upper(Email)= Upper('" .$_SESSION['taikhoan']."');";
   $resultidTK = $conn->query($sql);
   if ($resultidTK->num_rows > 0) {
       $idTKtam = $resultidTK->fetch_assoc(); 
       $idTK = $idTKtam["MaTKND"];
     } 
   else {
       $idTK = "#";
   }
   $sql= "SELECT * from luotlike where MaTKND='$idTK' and MaCMT='$idCMT'";
   $resultTK = $conn->query($sql);
   if ($resultTK->num_rows > 0) {
       $TKtam = $resultTK->fetch_assoc(); 
       $TK = $TKtam["MaTKND"];
     } 
   else {
       $TK = "#";
     }
   if($idCMT != "#")
   {   
       if($idTK != "#") {
            if($TK != "#"){
                $sql = "DELETE FROM luotlike WHERE MaCMT='$idCMT' AND MaTKND='$idTK';";
                if ($conn->query($sql) === TRUE) {
                    echo "delete successfully. <br>";
                    } else {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                    }   
                $sql="UPDATE `comment` SET SoLuotLike=SoLuotLike-1 WHERE MaCMT='$idCMT';";
                if ($conn->query($sql) === TRUE) {
                    echo "update successfully. <br>";
                    } else {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                    } 
            }        
            else {
                $sql="INSERT INTO `luotlike`(`MaCMT`, `MaTKND`) VALUES ('$idCMT','$idTK');";
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully. <br>";
                    } else {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                    }  
                $sql="UPDATE `comment` SET SoLuotLike=SoLuotLike+1 WHERE MaCMT='$idCMT';";
                if ($conn->query($sql) === TRUE) {
                    echo "successfully. <br>";
                    } else {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                    }   
            }
        }
       header("Location: Fnews.php?page=BangTin&Ma=$Ma");    
   }

  //Close connection to database
    $conn->close();
    
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/style.css">  
    <link rel="shortcut icon" type="image/png" href="/Project/image/Fnews3.png"/>
    <title>FNews</title>
    <!-- Bootstrap 4 -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Font awesome -->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" data-auto-replace-svg="nest"></script>
    <style type=”text/css”>
        #<?php echo $page ?>-btn {
            background-color: blue;
        }
    </style>
</head>
<script>
function DangNhap_DangKy(){
    if($('#title-form').text() == "Đăng ký"){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
          if(this.readyState == 4 && this.status == 200){
              if(this.responseText == "Tài khoản đã tồn tại" || this.responseText == "error")
                document.getElementById("text-form").innerHTML = this.responseText;
             else{
                    alert("Tạo tài khoản thành công. Hãy đăng nhập lại.");
                    startLogin();
                    }
          }
        };
        var Email = document.getElementById("exampleInputEmail1").value;
        var Password = document.getElementById("exampleInputPassword").value;
        var RePassword = document.getElementById("exampleInputRePassword").value;
        if(Password != RePassword)
            {
                document.getElementById("group-RePassword").innerHTML += "<p>Mật khẩu bạn nhập không giống nhau</p>";
            }
        else {
            var regExp = /^[A-Za-z][\w$.]+@[\w]+\.\w+$/;
            if (regExp.test(Email)){
                if (Password.length == 0)
                    document.getElementById("text-form").innerHTML = "Bạn chưa nhập mật khẩu.";
                else
                    {
                        var data = "Email="+ Email + "&Matkhau="+ Password;
                        var url = "./DangKy.php";
                        xhttp.open("POST", url, true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send(data);
                    }
                }
            else 
                document.getElementById("text-form").innerHTML = "Email không hợp lệ!";
            }
        }
        else if($('#title-form').text() == "Đăng nhập"){
            var xhttp = new XMLHttpRequest ();
            xhttp.onreadystatechange = function () {
              if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText != null)
                        document.getElementById("text-form").innerHTML = this.responseText;
                    else {
                        alert("Mời bạn hãy đăng nhập lại!")
                        location.reload();
                    }
              }
            };
        
            var email = document.getElementById("exampleInputEmail1").value;
            var password = document.getElementById("exampleInputPassword").value;
        
            var url = "./DangNhap.php";
            xhttp.open("POST", url, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var link = window.location.href;
            var n = link.search("php?")
            link = link.slice(n+4, link.length)
            xhttp.send("Email=" + email + "&MatKhau=" + password + "&Link=" + link);
     
    }
    
}
</script>
<body>
    <button class="scrollToTopButton btn btn-info" id="scrollToTopButton">
        <i class="fas fa-sort-up"></i>
    </button>
    <div class="login-container" id="login-container">
        <div class="opacty-background" id="opacty-background">
        </div>
        <div class="login" id="login">
            <div class="form-container" id="form-container">                
                <form class="form-login" id="form-login" action="" >
                    <center>
                        <h3 class="title-form" id="title-form">Đăng nhập</h3>
                        <hr>
                        <p class="text-form" id="text-form">Đăng nhập với email</p>
                        <div class="form-group">
                            <div class="input-group">
                                <input name="email" type="email" class="form-control text-info" 
                                id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập gmail">
                            </div>
                            <div class="input-group" id="group-Password">
                                <input name="password" type="password" class="form-control text-info input-password" 
                                    id="exampleInputPassword" placeholder="Mật khẩu">
                                <button class="btn hide-password" onclick="show_hide('password')" id="show-password">
                                    <i class="fas fa-eye" id="icon-password"></i>
                                </button>
                            </div>
                            <div class="input-group" id="group-RePassword">
                                <input name="repassword" type="password" class="form-control input-password" 
                                id="exampleInputRePassword" placeholder="Nhập lại mật khẩu">
                                <button class="btn hide-password" onclick="show_hide('repassword')" id="show-repassword">
                                    <i class="fas fa-eye" id="icon-repassword"></i>
                                </button>
                            </div>    
                            <div class="input-group">
                                <button type="submit" class="btn btn-info w-100" id="exampleSubmit" onclick="DangNhap_DangKy()">Đăng nhập</button>
                            </div>                            
                        </div>        
                        <div class="input-group">
                            <button style= "margin:auto" class="btn btn-info w-50 " id="register" href="" type="sumit">Đăng ký</nutton>
                        </div>                        
                        <div class="login-with d-flex">
                            <div class="btn-facebook w-25">
                                <button class="btn btn-info btn-outline-info">
                                    <i class="fab fa-facebook-f text-primary"></i>
                                </button>
                            </div>
                            <div class="btn-instagram w-25">
                                <button class="btn btn-info btn-outline-info">
                                    <i class="fab fa-instagram"></i>
                                </button>
                            </div>
                            <div class="btn-google w-25">
                                <button class="btn btn-info btn-outline-info">
                                    <i class="fab fa-google text-danger"></i>
                                </button>
                            </div>
                            <div class="btn-apple w-25">
                                <button class="btn btn-info btn-outline-info">
                                    <i class="fab fa-apple text-dark"></i>
                                </button>
                            </div>
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container">
        <header>
            <div class="row">
                <div class="header_top col-12 d-flex">
                    <div class="header_top_left">
                        <form class="bg-dark d-flex">
                            <button class="btn btn-outline-info text-light" type="submit">Home</button>
                            <a href = "Gioithieu.html" class="btn btn-outline-info text-light" type="submit">About</a>
                            <a href="#Contact" class="btn btn-outline-info text-light" type="submit">Contact</a>
                        </form>
                    </div>
                    <div class="bg-dark header_top_right w-100">
                        <p class="text-light" id="title-date">
                            Wednesday, April 28, 2021
                        </p>
                    </div>
                </div>
                
                <div class="col-12">
                    <nav class="navbar navbar-expand-sm">
                        <h1>
                            <strong>F</strong>NEWS
                        </h1>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span><i class="fas fa-search"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto"></ul>
                            <form class="form-inline my-2 my-lg-0" id="form-search" method="GET" action="Fnews.php?page=Search">
                                <input class="form-control mr-sm-2" name="key" type="search" placeholder="Search" aria-label="Search">
                                <input id="btn-search"class="btn btn-outline-info my-2 mx-2 my-sm-0" type="submit" name = "page"value="Search">
                                <style>
                                    #btn-search{
                                        background-color:white; 
                                        color: #17a2b8; 
                                        padding: 3px 8px; 
                                        border: solid 0.2px #17a2b8;
                                        border-radius: 4px;
                                     }
                                    #btn-search:hover{
                                        background-color:#17a2b8;
                                        color: white;
                                    }                                  
                                </style>
                                <?php
                                    if ($_SESSION["taikhoan"]!='#') {
                                        echo '<a class="btn btn-outline-info my-2 my-sm-0" type="button" href="./DangXuat.php"><i class="fas fa-sign-out-alt"></i></a>';
                                    }
                                    else {
                                        echo '<button class="btn btn-outline-info my-2 my-sm-0" type="button" onclick="startLogin()"><i class="fas fa-user"></i></button>';
                                    }
                                ?>        
                            </form>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <section class="toppic">
            <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
                <form method="GET" action="Fnews.php">
                    <button class="btn btn-dark" type="submit" name="page" value="TrangChu" id="TrangChu-btn"><i class="fas fa-home"></i></button>
                </form>            
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent1">
                    <form class="form-inline" method="GET" action="Fnews.php">
                        <?php 
                            if ($resultLT->num_rows > 0) {
                                // output data of each row
                                while ($row = $resultLT->fetch_assoc()) {
                                    echo '<button class="btn btn-outline-info" name="page" value="'.$row["TenLTID"].'" type="submit" id="'.$row["TenLTID"].'-btn">'.$row["TenLT"].'</button>';
                                }
                            } else {
                                echo "0 results";
                            }
                        ?>
                    </form>
                </div>
            </nav>
        </section>
        <div class="main row" id="main">
            <div class="top_news col-lg-8 col-md-12 
                <?php 
                    if (isset($_GET["page"])) {
                        if ($_GET["page"] == "TrangChu")
                            echo "d-block";
                        else echo "d-none";
                    }
                    else echo "d-block";
                ?>
                " id="top-news">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <?php 
                                $tam = $top3->fetch_assoc(); 
                                echo '  <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'">
                                            <img class="d-block w-100" src="'.$tam["HinhAnh"].'" alt="First slide">
                                        </a>
                                        <div class="carousel-caption d-none d-md-block">
                                            <div class="caroulsel-text"> 
                                                <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'" class="text-light">
                                                    <h3>'.$tam["TenBT"].'</h3>
                                                </a>
                                            </div>
                                        </div>';                             
                            ?>
                        </div>
                        <div class="carousel-item">
                            <?php 
                                $tam = $top3->fetch_assoc(); 
                                echo '  
                                    <a href = "Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'">
                                            <img class="d-block w-100" src="'.$tam["HinhAnh"].'" alt="Second slide">
                                        </a>
                                        <div class="carousel-caption d-none d-md-block">
                                            <div class="caroulsel-text"> 
                                                <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'" class="text-light">
                                                    <h3>'.$tam["TenBT"].'</h3>
                                                </a>
                                            </div>
                                        </div>';
                                
                            ?>
                        </div>
                        <div class="carousel-item">
                            <?php 
                                $tam = $top3->fetch_assoc(); 
                                echo '     
                                    <a href = "Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'">
                                        <img class="d-block w-100" src="'.$tam["HinhAnh"].'" alt="Third slide">
                                    </a>
                                    <div class="carousel-caption d-none d-md-block">
                                        <div class="caroulsel-text"> 
                                            <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'" class="text-light">
                                                <h3>'.$tam["TenBT"].'</h3>
                                            </a>
                                        </div>
                                    </div>';
                            ?>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" type="button">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="ChinhTri row">
                    <div class="title-list col-12" id="ChinhTri">
                        <h2 >
                            <Span>CHÍNH TRỊ</Span>
                        </h2>
                    </div>
                    <div class="_card1 _card1_1 col-lg-6 col-sm-12">
                        <?php
                            $tam =  $top5CT->fetch_assoc(); 
                            if(strlen($tam["TenBT"]) > 48)
                            $tam["TenBT"]=$tam["TenBT"]."...";
                            if(strlen($tam["DuLieu"]) > 90)
                            $tam["DuLieu"]=$tam["DuLieu"]."...";
                            echo ' 
                                <div class="img_card">
                                    <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'">
                                        <img class="w-100 d-block" src="'.$tam["HinhAnh"].'" alt="">
                                    </a>
                                </div>
                                <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'">
                                    <div class="text_card"> 
                                        <p class="title-p_card">'.$tam["TenBT"].'     
                                            <span class="date_card">'.$tam["NgayDangBai"].'
                                            </span>
                                        </p>
                                        <p class="p_card">         
                                            '.$tam["DuLieu"].'
                                        </p>
                                    </div>
                                </a>'; 
                        ?>
                        
                    </div>
                    <div class="row col-lg-6 col-sm-12">
                        <div class="_card row col-lg-12 col-md-6 col-sm-12">
                            <?php 
                                $tam = $top5CT->fetch_assoc();
                                if(strlen($tam["TenBT"]) > 48)
                                $tam["TenBT"]=$tam["TenBT"]."....."; 
                                echo '  
                                    <div class="col-5 img_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'">
                                            <img class="w-100 d-block" src="'.$tam["HinhAnh"].'" alt="">
                                        </a>
                                    </div>
                                    <div class="col-7 ml-0 text_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'" >
                                            <p class="p_card">'.$tam["TenBT"].'</p>
                                        </a>   
                                        <div class="d-flex">
                                            <a href="'.$tam["Nguon"].' ">
                                                <img class="w-50 d-inline" src="'.$tam["Logo"].'" alt="">
                                            </a>
                                            <div class="d-flex w-100 flex-column-reverse">
                                                <p class="date_card w-100">'.$tam["NgayDangBai"].' </p>
                                            </div>
                                        </div>
                                    </div>';
                            ?>
                        </div>
                        <div class="_card row col-lg-12 col-12 col-md-6 col-sm-12">
                            <?php 
                                $tam = $top5CT->fetch_assoc();
                                if(strlen($tam["TenBT"]) > 48)
                                $tam["TenBT"]=$tam["TenBT"]."....."; 
                                echo '  
                                    <div class="col-5 img_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'">
                                            <img class="w-100 d-block" src="'.$tam["HinhAnh"].'" alt="">
                                        </a>
                                    </div>
                                    <div class="col-7 ml-0 text_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'" >
                                            <p class="p_card">'.$tam["TenBT"].'</p>
                                        </a>   
                                        <div class="d-flex">
                                            <a href="'.$tam["Nguon"].' ">
                                                <img class="w-50 d-inline" src="'.$tam["Logo"].'" alt="">
                                            </a>
                                            <div class="d-flex w-100 flex-column-reverse">
                                                <p class="date_card w-100">'.$tam["NgayDangBai"].' </p>
                                            </div>
                                        </div>
                                    </div>';
                            ?>
                        </div>
                        <div class="_card row col-lg-12 col-md-6 col-sm-12">
                            <?php 
                                $tam = $top5CT->fetch_assoc();
                                if(strlen($tam["TenBT"]) > 48)
                                $tam["TenBT"]=$tam["TenBT"]."....."; 
                                echo '  
                                    <div class="col-5 img_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'">
                                            <img class="w-100 d-block" src="'.$tam["HinhAnh"].'" alt="">
                                        </a>
                                    </div>
                                    <div class="col-7 ml-0 text_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'" >
                                            <p class="p_card">'.$tam["TenBT"].'</p>
                                        </a>   
                                        <div class="d-flex">
                                            <a href="'.$tam["Nguon"].' ">
                                                <img class="w-50 d-inline" src="'.$tam["Logo"].'" alt="">
                                            </a>
                                            <div class="d-flex w-100 flex-column-reverse">
                                                <p class="date_card w-100">'.$tam["NgayDangBai"].' </p>
                                            </div>
                                        </div>
                                    </div>';
                            ?>
                        </div>
                        <div class="_card row col-lg-12 col-md-6 col-sm-12">
                            <?php 
                                $tam = $top5CT->fetch_assoc();
                                if(strlen($tam["TenBT"]) > 48)
                                $tam["TenBT"]=$tam["TenBT"]."....."; 
                                echo '  
                                    <div class="col-5 img_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'">
                                            <img class="w-100 d-block" src="'.$tam["HinhAnh"].'" alt="">
                                        </a>
                                    </div>
                                    <div class="col-7 ml-0 text_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tam["MaBT"].'" >
                                            <p class="p_card">'.$tam["TenBT"].'</p>
                                        </a>   
                                        <div class="d-flex">
                                            <a href="'.$tam["Nguon"].' ">
                                                <img class="w-50 d-inline" src="'.$tam["Logo"].'" alt="">
                                            </a>
                                            <div class="d-flex w-100 flex-column-reverse">
                                                <p class="date_card w-100">'.$tam["NgayDangBai"].' </p>
                                            </div>
                                        </div>
                                    </div>';
                            ?>
                        </div>
                    </div>     
                </div>
                <div class="TheThao row">
                    <div class="title-list col-12" id="TheThao">
                        <h2>
                            <Span>THỂ THAO</Span>
                        </h2>
                    </div>
                    <div class="_card1 _card1_1 col-lg-6 col-sm-12">
                        <?php
                            $tt = $TTtop2->fetch_assoc();
                            if(strlen($tt["DuLieu"])>248)
                                $tt["DuLieu"]=$tt["DuLieu"]."...";
                            echo '          
                                    <div class="img_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tt["MaBT"].'">
                                            <img class="w-100 d-block" src="'.$tt["HinhAnh"].'" alt="">
                                        </a>
                                    </div>
                                    <div class="text_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tt["MaBT"].'">
                                            <p class="title-p_card">'.$tt["TenBT"].'
                                                <span class="date_card">
                                                    ' .$tt["NgayDangBai"].'
                                                </span>
                                            </p>
                                            <p class="p_card">
                                                '.$tt["DuLieu"].'
                                            </p>
                                        </a>
                                    </div>';
                        ?>
                    </div>
                    <div class="_card1 col-lg-6 col-sm-12">
                        <?php
                            $tt = $TTtop2->fetch_assoc();
                            if(strlen($tt["DuLieu"])>248)
                                $tt["DuLieu"]=$tt["DuLieu"]."...";
                            echo '          
                                    <div class="img_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tt["MaBT"].'">
                                            <img class="w-100 d-block" src="'.$tt["HinhAnh"].'" alt="">
                                        </a>
                                    </div>
                                    <div class="text_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$tt["MaBT"].'">
                                            <p class="title-p_card">'.$tt["TenBT"].'
                                                <span class="date_card">
                                                    ' .$tt["NgayDangBai"].'
                                                </span>
                                            </p>
                                            <p class="p_card">
                                                '.$tt["DuLieu"].'
                                            </p>
                                        </a>
                                    </div>';
                            ?>
                    </div>
                </div>  
                <div class="VanHoaDuLich row">
                    <div class="VanHoa col-lg-6 col-sm-12">      
                        <div class="title-list" id="VanHoa">
                            <h2 >
                                <Span>VĂN HÓA</Span>
                            </h2>
                        </div>
                        <div class="row">
                            <div class="_card1 col-12">
                                <?php 
                                    $vh = $VHtop3->fetch_assoc(); 
                                    if(strlen($vh["TenBT"])>65)
                                         $vh["TenBT"]=$vh["TenBT"]."...";                          
                                    $vh["DuLieu"]=$vh["DuLieu"]."...";
                                    echo ' 
                                        <div class="img_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$vh["MaBT"].'">
                                                <img class="w-100 d-block" height=250px src="'.$vh["HinhAnh"].'" alt="">
                                            </a>
                                        </div>
                                        <div class="text_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$vh["MaBT"].'">
                                                <p class="title-p_card">'.$vh["TenBT"].'
                                                    <span class="date_card">
                                                        ' .$vh["NgayDangBai"].'
                                                    </span>
                                                </p>
                                                <p class="p_card">
                                                    '.$vh["DuLieu"].'
                                                </p>
                                            </a>
                                        </div>';    
                                ?>
                            </div>
                            <div class="_card2 row col-lg-12 col-md-6 col-sm-12">
                                <?php
                                    $vh = $VHtop3->fetch_assoc();
                                    if(strlen($vh["TenBT"])>65)
                                         $vh["TenBT"]=$vh["TenBT"]."...";                                   
                                    echo '
                                        <div class="col-4 img_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$vh["MaBT"].'">
                                                <img class="w-100 d-block" height=120px src="'.$vh["HinhAnh"].'" alt="">
                                            </a>
                                        </div>
                                        <div class="col-8 ml-0 text_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$vh["MaBT"].'">
                                                <p class="p_card">'.$vh["TenBT"].'
                                                </p>
                                                <div class="d-flex">
                                                    <a href="'.$vh["Nguon"].' ">
                                                        <img class="w-50 d-inline" height=40px src="'.$vh["Logo"].'" alt="">
                                                    </a>
                                                    <div class="d-flex w-100 flex-column-reverse">
                                                        <p class="date_card w-100">'.$vh["NgayDangBai"].' </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>';
                                ?>
                            </div>
                            <div class="_card2 row col-lg-12 col-md-6 col-sm-12">
                                <?php
                                    $vh = $VHtop3->fetch_assoc();
                                    if(strlen($vh["TenBT"])>65)
                                         $vh["TenBT"]=$vh["TenBT"]."...";                                   
                                    echo '
                                        <div class="col-4 img_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$vh["MaBT"].'">
                                                <img class="w-100 d-block" height=120px src="'.$vh["HinhAnh"].'" alt="">
                                            </a>
                                        </div>
                                        <div class="col-8 ml-0 text_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$vh["MaBT"].'">
                                                <p class="p_card">'.$vh["TenBT"].'
                                                </p>
                                            </a>
                                            <div class="d-flex">
                                                <a href="'.$vh["Nguon"].' ">
                                                    <img class="w-50 d-inline" height=40px src="'.$vh["Logo"].'" alt="">
                                                </a>
                                                <div class="d-flex w-100 flex-column-reverse">
                                                    <p class="date_card w-100">'.$vh["NgayDangBai"].' </p>
                                                </div>
                                            </div>
                                        </div>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="DuLich col-lg-6 col-sm-12">
                        <div class="title-list" id="XaHoi">
                            <h2 >
                                <Span>DU LỊCH</Span>
                            </h2>
                        </div>
                        <div class="row">
                            <div class="_card1 col-12">
                                <?php 
                                    $DL = $DLtop3->fetch_assoc();
                                    if(strlen($DL["TenBT"])>60)
                                         $DL["TenBT"]=$DL["TenBT"]."...";                                    
                                    $DL["DuLieu"]=$DL["DuLieu"]."...";
                                    echo ' 
                                        <div class="img_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$DL["MaBT"].'">
                                                <img class="w-100 d-block" height=250px src="'.$DL["HinhAnh"].'" alt="">
                                            </a>
                                        </div>
                                        <div class="text_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$DL["MaBT"].'">
                                            <p class="title-p_card">'.$DL["TenBT"].'
                                                <span class="date_card">
                                                    ' .$DL["NgayDangBai"].'
                                                </span>
                                            </p>
                                            <p class="p_card">
                                                '.$DL["DuLieu"].'
                                            </p>
                                        </a>
                                        </div>';                                    
                                ?>
                            </div>
                            <div class="_card2 row col-lg-12 col-md-6 col-sm-12">
                                <?php
                                    $DL = $DLtop3->fetch_assoc();
                                    if(strlen($DL["TenBT"])>60)
                                         $DL["TenBT"]=$DL["TenBT"]."...";                                    
                                    echo '
                                    <div class="col-4 img_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$DL["MaBT"].'">
                                            <img class="w-100 d-block" height=120px src="'.$DL["HinhAnh"].'" alt="">
                                        </a>
                                    </div>
                                    <div class="col-8 ml-0 text_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$DL["MaBT"].'">
                                            <p class="p_card">'.$DL["TenBT"].'
                                            </p>
                                        </a>
                                        <div class="d-flex">
                                            <a href="'.$DL["Nguon"].'">
                                                <img class="w-50 d-inline" height=40px src="'.$DL["Logo"].'" alt="">
                                            </a>
                                            <div class="d-flex w-100 flex-column-reverse">
                                                <p class="date_card w-100">'.$DL["NgayDangBai"].' </p>
                                            </div>
                                        </div>
                                    </div>';
                                ?>
                            </div>
                            <div class="_card2 row col-lg-12 col-md-6 col-sm-12">
                            <?php
                                    $DL = $DLtop3->fetch_assoc();
                                    if(strlen($DL["TenBT"])>60)
                                         $DL["TenBT"]=$DL["TenBT"]."...";                                    
                                    echo '
                                        <div class="col-4 img_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$DL["MaBT"].'">
                                                <img class="w-100 d-block" height=120px src="'.$DL["HinhAnh"].'" alt="">
                                            </a>
                                        </div>
                                        <div class="col-8 ml-0 text_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$DL["MaBT"].'">
                                                <p class="p_card">'.$DL["TenBT"].'
                                                </p>
                                            </a>
                                            <div class="d-flex">
                                                <a href="'.$DL["Nguon"].' ">
                                                    <img class="w-50 d-inline" height=40px src="'.$DL["Logo"].'" alt="">
                                                </a>
                                                <div class="d-flex w-100 flex-column-reverse">
                                                    <p class="date_card w-100">'.$DL["NgayDangBai"].' </p>
                                                </div>
                                            </div>
                                        </div>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- code De muc -->
            <!-- Chinh Tri -->
            <div class="top_search row col-lg-8 col-md-12 
                <?php 
                    if (isset($_GET["page"])) {
                        if ($_GET["page"] == "ChinhTri")
                            echo "d-block";
                        else echo "d-none";
                    }
                    else echo "d-none";
                ?>" id="de-muc">
                <div class="title-list">
                    <h2 >
                        <Span id="de_muc-title">CHÍNH TRỊ</Span>
                    </h2>
                </div>
                <?php                   
                    $i=1;  
                    while ($i<=$demucCT->num_rows)
                    {  
                        $postCT = $demucCT->fetch_assoc();
                        if(strlen($postCT["DuLieu"])>143)
                            $postCT["DuLieu"]=$postCT["DuLieu"]."...";
                         echo'
                        <div class="_card row col-12">
                        <div class="col-5 img_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$postCT["MaBT"].'">
                                <img class="w-100 d-block" src="'.$postCT["HinhAnh"].'" alt="">
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$postCT["MaBT"].'">
                                <p class="p_card"> '.$postCT["TenBT"].'
                                </p>
                                <p style=" font-weight: 500;">
                                '.$postCT["DuLieu"].'
                                </p>
                            </a>
                            <div class="d-flex">
                                <a href="'.$postCT["Nguon"].'.">
                                    <img class="w-25 d-inline" src="'.$postCT["Logo"].'" alt="">
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                    '.$postCT["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>   ';
                    $i++;       
                    }

                ?>
                </div>
                <!-- Xa Hoi -->
                <div class="top_search row col-lg-8 col-md-12 
                <?php 
                    if (isset($_GET["page"])) {
                        if ($_GET["page"] == "XaHoi")
                            echo "d-block";
                        else echo "d-none";
                    }
                    else echo "d-none";
                ?>" id="de-muc">
                <div class="title-list">
                    <h2 >
                        <Span id="de_muc-title">XÃ HỘI</Span>
                    </h2>
                </div>
                <?php 
                    $i=1;  
                    while ($i<=$demucXH->num_rows)
                    {  
                        $postXH = $demucXH->fetch_assoc();
                        if(strlen($postXH["DuLieu"])>143)
                            $postXH["DuLieu"]=$postXH["DuLieu"]."...";
                         echo'
                        <div class="_card row col-12">
                        <div class="col-5 img_card">
                            <a href= "Fnews.php?page=BangTin&Ma='.$postXH["MaBT"].'">
                                <img class="w-100 d-block" src="'.$postXH["HinhAnh"].'" alt="">
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$postXH["MaBT"].'">
                                <p class="p_card"> '.$postXH["TenBT"].'
                                </p>
                                <p style=" font-weight: 500;">
                                '.$postXH["DuLieu"].'
                                </p>
                            </a>
                            <div class="d-flex">
                                <a href="'.$postXH["Nguon"].'.">
                                    <img class="w-25 d-inline" src="'.$postXH["Logo"].'" alt="">
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                    '.$postXH["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>   ';
                    $i++;       
                    }

                ?>
                </div>
            <!-- code list Văn hóa -->
            <div class="top_search row col-lg-8 col-md-12 
                    <?php 
                        if (isset($_GET["page"])) {
                            if ($_GET["page"] == "VanHoa")
                                echo "d-block";
                            else echo "d-none";
                        }
                        else echo "d-none";
                    ?>" id="muc-van-hoa">
                <div class="title-list">
                    <h2 >
                        <Span id="de_muc-title">VĂN HÓA</Span>
                    </h2>
                </div>
                <?php                    
                    for($i=0; $i<mysqli_num_rows($listVanHoa); $i++){
                        $vhnews = $listVanHoa->fetch_assoc();
                        echo '
                            <div class="_card row col-12">
                                <div class="col-5 img_card">
                                    <a href = "Fnews.php?page=BangTin&Ma='.$vhnews["MaBT"].'">
                                        <img class="w-100 d-block" src="'.$vhnews["HinhAnh"].'" alt="">
                                    </a>
                                </div>
                                <div class="col-7 ml-0 text_card">
                                    <a href="Fnews.php?page=BangTin&Ma='.$vhnews["MaBT"].'">
                                        <p class="p_card">'.$vhnews["TenBT"].'</p>
                                        <p style=" font-weight: 500;">'.$vhnews["DuLieu"].' ...</p>
                                    </a>                            
                                        <div class="d-flex">
                                            <a href="'.$vhnews["Nguon"].'">
                                                <img class="w-25 d-inline" src="'.$vhnews["Logo"].'" alt="">
                                            </a>
                                            <div class="d-flex w-100 flex-column-reverse">
                                                <p class="date_card w-100">'.$vhnews["NgayDangBai"].'</p>
                                            </div>
                                        </div>                            
                                </div>
                            </div>';
                    }                     
                ?>
            </div>
              <!-- code list Thể thao -->
            <div class="top_search row col-lg-8 col-md-12 
                    <?php 
                        if (isset($_GET["page"])) {
                            if ($_GET["page"] == "TheThao")
                                echo "d-block";
                            else echo "d-none";
                        }
                        else echo "d-none";
                    ?>" id="muc-the-thao">
                <div class="title-list">
                    <h2 >
                        <Span id="de_muc-title">THỂ THAO</Span>
                    </h2>
                </div>
                <?php                    
                    for($i=0; $i<mysqli_num_rows($listTheThao); $i++){
                        $ttnews = $listTheThao->fetch_assoc();
                        echo '
                            <div class="_card row col-12">
                                <div class="col-5 img_card">
                                    <a href = "Fnews.php?page=BangTin&Ma='.$ttnews ["MaBT"].'">
                                        <img class="w-100 d-block" src="'.$ttnews["HinhAnh"].'" alt="">
                                    </a>
                                </div>
                                <div class="col-7 ml-0 text_card">
                                    <a href= "Fnews.php?page=BangTin&Ma='.$ttnews ["MaBT"].'">
                                        <p class="p_card">'.$ttnews["TenBT"].'</p>
                                        <p style=" font-weight: 500;">'.$ttnews["DuLieu"].' ...</p>
                                    </a>                            
                                        <div class="d-flex">
                                            <a href="'.$ttnews["Nguon"].'">
                                                <img class="w-25 d-inline" src="'.$ttnews["Logo"].'" alt="">
                                            </a>
                                            <div class="d-flex w-100 flex-column-reverse">
                                                <p class="date_card w-100">'.$ttnews["NgayDangBai"].'</p>
                                            </div>
                                        </div>                            
                                </div>
                            </div>';
                    }                     
                ?>
             </div>
            <!-- Thoi Su -->
                <div class="top_search row col-lg-8 col-md-12 
                    <?php 
                        if (isset($_GET["page"])) {
                            if ($_GET["page"] == "ThoiSu")
                                echo "d-block";
                            else echo "d-none";
                        }
                        else echo "d-none";
                    ?>" id="de-muc">
                    <div class="title-list">
                        <h2 >
                            <Span id="de_muc-title">THỜI SỰ</Span>
                        </h2>
                    </div>                                     
                        <?php
                            if ($top5_TS->num_rows > 0) {
                                while( $top5TS = $top5_TS->fetch_assoc())
                                {
                                     
                                    if(strlen($top5TS["DuLieu"]) > 150)
                                    $top5TS["DuLieu"]=$top5TS["DuLieu"]."..."; 
                                    echo '
                                    <div class="_card row col-12"> 
                                        <div class="col-5 img_card">
                                            <a href = "Fnews.php?page=BangTin&Ma='.$top5TS ["MaBT"].'">
                                               <img class="w-100 d-block"  src="'.$top5TS["HinhAnh"].'" alt="">
                                            </a>
                                        </div>
                                        <div class="col-7 ml-0 text_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$top5TS ["MaBT"].'">
                                                <p class="p_card"> '.$top5TS["TenBT"].'</p>
                                                <p style=" font-weight: 500;">'.$top5TS["DuLieu"].' </p>
                                            </a>
                                            <div class="d-flex">
                                                <a href = "'.$top5TS["Nguon"].'">
                                                    <img class="w-25 d-inline" src="'.$top5TS["Logo"].'" alt="">
                                                </a>
                                                <div class="d-flex w-100 flex-column-reverse">
                                                    <p class="date_card w-100">'.$top5TS["NgayDangBai"].' </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }                            
                        ?>                                                         
                </div>
                <!-- Kinh Doanh -->
                <div class="top_search row col-lg-8 col-md-12 
                    <?php 
                        if (isset($_GET["page"])) {
                            if ($_GET["page"] == "KinhDoanh")
                                echo "d-block";
                            else echo "d-none";
                        }
                        else echo "d-none";
                    ?>" id="de-muc">
                    <div class="title-list">
                        <h2 >
                            <Span id="de_muc-title">KINH DOANH</Span>
                        </h2>
                    </div>                                     
                        <?php
                            if ($top5_KD->num_rows > 0) {
                                while( $top5KD = $top5_KD->fetch_assoc())
                                {                                        
                                    if(strlen($top5KD["DuLieu"]) > 150)
                                    $top5KD["DuLieu"]=$top5KD["DuLieu"]."..."; 
                                    echo '
                                    <div class="_card row col-12"> 
                                        <div class="col-5 img_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$top5KD ["MaBT"].'">
                                                <img class="w-100 d-block" src="'.$top5KD["HinhAnh"].'" alt="">
                                            </a>
                                        </div>
                                        <div class="col-7 ml-0 text_card">
                                            <a href="Fnews.php?page=BangTin&Ma='.$top5KD ["MaBT"].'">
                                                <p class="p_card"> '.$top5KD["TenBT"].'</p>
                                                <p style=" font-weight: 500;">'.$top5KD["DuLieu"].' </p>
                                            </a>
                                            <div class="d-flex">
                                                <a href = "'.$top5KD["Nguon"].'">
                                                    <img class="w-25 d-inline" src="'.$top5KD["Logo"].'" alt="">
                                                </a>
                                                <div class="d-flex w-100 flex-column-reverse">
                                                    <p class="date_card w-100">'.$top5KD["NgayDangBai"].' </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }                            
                        ?>                                                         
                </div>
            <!-- code De muc GiaoDuc-->
            <div class="top_search row col-lg-8 col-md-12 
                <?php 
                    if (isset($_GET["page"])) {
                        if ($_GET["page"] == "GiaoDuc")
                            echo "d-block"; 
                        else echo "d-none";
                    }
                    else echo "d-none";
                ?>" id="de-muc">
                <div class="title-list">
                    <h2 >
                        <Span id="de_muc-title">GIÁO DỤC</Span>
                    </h2>
                </div>
                <?php
                    if ($Giaoduc->num_rows > 0) {                    
                        while ($gd = $Giaoduc->fetch_assoc()) {
                            if(strlen($gd["DuLieu"])>198)
                            $gd["DuLieu"]=$gd["DuLieu"]."...";  
                            echo '
                                <div class="_card row col-12">
                                    <div class="col-5 img_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$gd ["MaBT"].'">
                                            <img class="w-100 d-block" src="'.$gd["HinhAnh"].'" alt="">
                                        </a>
                                    </div>
                                    <div class="col-7 ml-0 text_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$gd ["MaBT"].'">
                                            <p class="p_card">'.$gd["TenBT"].'</p>
                                            <p style=" font-weight: 500;">'.$gd["DuLieu"].'</p>
                                        </a>
                                        <div class="d-flex">
                                            <a href = '.$gd["Nguon"].'>
                                                 <img class="w-25 d-inline" src="'.$gd["Logo"].'" alt="">
                                            </a>
                                            <div class="d-flex w-100 flex-column-reverse">
                                                <p class="date_card w-100">'.$gd["NgayDangBai"].'</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                    }
                ?>
            </div>
            <!-- end code De muc GiaoDuc -->
            <!-- code De muc DuLich-->
            <div class="top_search row col-lg-8 col-md-12 
                <?php 
                    if (isset($_GET["page"])) {
                        if ($_GET["page"] == "DuLich")
                            echo "d-block"; 
                        else echo "d-none";
                    }
                    else echo "d-none";
                ?>" id="de-muc">
                <div class="title-list">
                    <h2 >
                        <Span id="de_muc-title">DU LỊCH</Span>
                    </h2>
                </div>
                <?php
                    if ($Dulich->num_rows > 0) {                    
                        while ($dl = $Dulich->fetch_assoc()) {
                            if(strlen($dl["DuLieu"])>198)
                            $dl["DuLieu"]=$dl["DuLieu"]."...";  
                            echo '
                                <div class="_card row col-12">
                                    <div class="col-5 img_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$dl["MaBT"].'">
                                            <img class="w-100 d-block" src="'.$dl["HinhAnh"].'" alt="">
                                        </a>
                                    </div>
                                    <div class="col-7 ml-0 text_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$dl["MaBT"].'">
                                            <p class="p_card">'.$dl["TenBT"].'</p>
                                            <p style=" font-weight: 500;">'.$dl["DuLieu"].'</p>
                                        </a>
                                        <div class="d-flex">
                                            <a href = '.$dl["Nguon"].'>
                                                 <img class="w-25 d-inline" src="'.$dl["Logo"].'" alt="">
                                            </a>
                                            <div class="d-flex w-100 flex-column-reverse">
                                                <p class="date_card w-100">'.$dl["NgayDangBai"].'</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                    }
                ?>
            </div>
            <!-- end code De muc DuLich -->
            
             <!-- code list giải trí -->             
            <div class="top_search row col-lg-8 col-md-12 
                    <?php 
                        if (isset($_GET["page"])) {
                            if ($_GET["page"] == "GiaiTri")
                                echo "d-block";
                            else echo "d-none";
                        }
                        else echo "d-none";
                    ?>" id="muc-van-hoa">
                <div class="title-list">
                    <h2 >
                        <Span id="de_muc-title">GIẢI TRÍ</Span>
                    </h2>
                </div>
                <?php                    
                    for($i=0; $i<mysqli_num_rows($listGiaiTri); $i++){
                        $gtnews = $listGiaiTri->fetch_assoc();
                        echo '
                            <div class="_card row col-12">
                                <div class="col-5 img_card">
                                    <a href="Fnews.php?page=BangTin&Ma='.$gtnews["MaBT"].'">
                                        <img class="w-100 d-block" src="'.$gtnews["HinhAnh"].'" alt="">
                                    </a>
                                </div>
                                <div class="col-7 ml-0 text_card">
                                    <a href="Fnews.php?page=BangTin&Ma='.$gtnews["MaBT"].'">
                                        <p class="p_card">'.$gtnews["TenBT"].'</p>
                                        <p style=" font-weight: 500;">'.$gtnews["DuLieu"].' ...</p>
                                    </a>                            
                                        <div class="d-flex">
                                            <a href="'.$gtnews["Nguon"].'">
                                                <img class="w-25 d-inline" src="'.$gtnews["Logo"].'" alt="">
                                            </a>
                                            <div class="d-flex w-100 flex-column-reverse">
                                                <p class="date_card w-100">'.$gtnews["NgayDangBai"].'</p>
                                            </div>
                                        </div>                            
                                </div>
                            </div>';
                    }                     
                ?>
            </div>
            <!-- end code De muc -->
           
                 <!-- code Top-search -->
           <div class="top_search row col-lg-8 col-md-12 
                    <?php                         
                        if (isset($_GET["page"])) {
                            if ($_GET["page"] == "Search")
                                echo "d-block";
                            else echo "d-none";
                        }
                        else echo "d-none";
                    ?>" id="top">
                <div class="title-list">
                    <h2 >
                        <Span id="de_muc-title"> KẾT QUẢ TÌM KIẾM</Span>
                    </h2>
                </div>
                <?php                                    
                        for($i=0; $i<mysqli_num_rows($searchResult); $i++){                        
                            $news = $searchResult->fetch_assoc();                                          
                            echo '
                                <div class="_card row col-12">
                                    <div class="col-5 img_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$news["MaBT"].'">
                                            <img class="w-100 d-block" src="'.$news["HinhAnh"].'" alt="">
                                        </a>
                                    </div>
                                    <div class="col-7 ml-0 text_card">
                                        <a href="Fnews.php?page=BangTin&Ma='.$news["MaBT"].'">
                                            <p class="p_card">'.$news["TenBT"].'</p>
                                            <p style=" font-weight: 500;">'.$news["DuLieu"].' ...</p>
                                        </a>
                                        <div class="d-flex">
                                            <a href="'.$news["Nguon"].'">
                                                <img class="w-25 d-inline" src="'.$news["Logo"].'" alt="">
                                            </a>
                                            <div class="d-flex w-100 flex-column-reverse">
                                                <p class="date_card w-100">'.$news["NgayDangBai"].'</p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>';
                        }
                ?>                
            </div>
            <!-- end code Top Search -->

            <!-- Trang báo -->
            <div class="top_search row col-lg-8 col-md-12
                    <?php                         
                        if (isset($_GET["page"])) {
                            if ($_GET["page"] == "BangTin")
                                echo "d-block";
                            else echo "d-none";
                        }
                        else echo "d-none"; 
                    ?>" id="NoiDung_BangTin">
                <?php
                    $bangtin = $resultBT->fetch_assoc();
                    echo '
                        <div class="title-list">
                            <h2 >
                                <Span id="de_muc-title">'.$bangtin["TenLT"].'</Span>
                            </h2>
                        </div>                  
                        <div class="key-search col-12">
                            <h1 style="text-align: center; margin: 5%;">'.$bangtin["TenBT"].'</h1>
                        </div>
                        <div class="NoiDung-1"> <p>';            
                            $i = 1;
                            while ($i <= $lengthBT) {
                                if (isset($indexND))
                                {
                                    if ($indexND["STT"] == "$i") {
                                        echo $indexND["DuLieu"].'<br></p>';
                                        $indexND = $resultND->fetch_assoc();
                                    }
                                }
                                if (isset($indexHA)) {
                                    if($indexHA["STT"] == "$i")
                                    {
                                        echo '<div class="_card row col-12">
                                                <img class ="card text_card img" style="margin: auto" src="'.$indexHA["HinhAnh"].'">
                                                <p style=" font-weight: 500; margin:auto; font-style: italic" >'.$indexHA["MoTaAnh"].'</p>
                                            </div> </p>';
                                            
                                        $indexHA = $resultHA->fetch_assoc();                                        
                                    }
                                } 
                                $i++;
                            }
                            echo '<p style="padding-left:70%;"><b>'.$bangtin["TenTG"].'</b></p>
                            <br>
                            <div class="d-flex ">
                                    <img class="w-25 image" src="'.$bangtin["Logo"].'" alt="">
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p style="text-align: right;"class="date_card w-100">
                                        '.$bangtin["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>';
                    echo '<div class="AddPage">';
                    for($i=0; $i<3; $i++){
                        $Add = $resultAdd->fetch_assoc();
                        echo'<a class="card add " href="Fnews.php?page=BangTin&Ma='.$Add["MaBT"].'" ><b>'.$Add["TenBT"].'</b></a>';
                    }
                    echo '</div>            
                    </div>';
                ?>          
                <div class="comment col-lg-6 col-xl-12">
            <h5>BÌNH LUẬN</h5>
            <?php 
                if($_SESSION['taikhoan'] == '#')
                echo ' <button class= "btn- btn-info" type="button" onclick="startLogin()" > Vui lòng đăng nhập để bình luận! </button>';
                else {
                    echo '
                    <form id="form-cmt" method="GET" action="Fnews.php?">
                        <div class="row"> 
                            <input type="hidden" name="ID" value="'.$bangtin["MaBT"].'">                 
                            <textarea id="subject" name="cmt" placeholder="Ý kiến của bạn.." style="height:100px"></textarea>
                            <div class="card submit">
                                <input type="submit" value="Gửi bình luận">
                            </div>
                        </div>
                    </form>';
                }
            ?>      
        </div>                                  
        <?php
                if ($NDCmt->num_rows > 0) {  
                    echo ' 
                        <div class="comment col-lg-4 col-xl-12"> 
                        <h5>BÌNH LUẬN KHÁC</h5>';                  
                    while ($ND = $NDCmt->fetch_assoc()) {
                        echo '                                   
                            <div class="x_content">
                                <ul class="messages">
                                    <li>                                                   
                                        <div class="message_wrapper">                                                   
                                            <img src="https://statictuoitre.mediacdn.vn/zoom/50_50/web_images/Avatar.jpg" class="avatar" alt="Avatar">
                                            <span style="" >'.$ND["TenND"].'</span>
                                            <blockquote class="message">'.$ND["NoiDungCmt"].'</blockquote>                                                                                                               
                                            <div class = "row">
                                                <form method="GET" action="Fnews.php">
                                                    <input type="hidden" name="MaBT" value="'.$bangtin["MaBT"].'">                                                     
                                                    <p><button type="submit" id="btn-like" style="border: none;"name="MaCMT" value="'.$ND["MaCMT"].'"><i id="ilike"class="fa fa-thumbs-up" aria-hidden="true"></i></button> '.$ND["SoLuotLike"].'</p> 
                                                </form>                   
                                                <p style = "margin-left: 80%;"class="month">'.$ND["NgayCMT"].'</p>
                                            </div>                                               
                                        </div>
                                    </li>                                                
                                </ul>
                                <hr>    
                                                                                                
                            </div>';
                    }                                  
                        echo '</div>';
    
                }                          
            ?>  
            </div>
            <!-- end code -->
           
            <div class="hot_news col-lg-4 col-md-12">
                <div class="row">
                    <div class="title-list col-12">    
                        <h2>
                            <Span>HOT NEWS</Span>
                        </h2>
                    </div>
                    <!-- Bai1 -->
                    <div class="_card row col-lg-12 col-md-6">
                        <div class="col-5 img_card">
                        <?php
                        $tam2= $top5->fetch_assoc();
                        
                        if(strlen($tam2["TenBT"])>90) 
                        $tam2["TenBT"]=$tam2["TenBT"]."...";
                        echo '  <a href="Fnews.php?page=BangTin&Ma='.$tam2["MaBT"].'">
                            <img class="w-100 d-block" src="'.$tam2["HinhAnh"].'" alt="" height=100px, width= 300px">
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$tam2["MaBT"].'">
                                <p class="p_card">'.$tam2["TenBT"].'</p>
                            </a>
                            
                            <div class="d-flex">
                                <a href="'.$tam2["Nguon"].' ">
                                    <img class="w-50 d-inline" src="'.$tam2["Logo"].'" alt="">
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                        '.$tam2["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>';
                        ?>
                        </div>
                    </div>
                    <!-- Bai2 -->
                    <div class="_card row col-lg-12 col-md-6">
                        <div class="col-5 img_card">
                        <?php
                        $tam2= $top5->fetch_assoc();
                        if(strlen($tam2["TenBT"])>90)                        
                        $tam2["TenBT"]=$tam2["TenBT"]."..."; 
                        echo '  <a href="Fnews.php?page=BangTin&Ma='.$tam2["MaBT"].'">
                            <img class="w-100 d-block" src="'.$tam2["HinhAnh"].'" alt="" height=100px, width= 300px>
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$tam2["MaBT"].'">
                                <p class="p_card">'.$tam2["TenBT"].'</p>
                            </a>
                            
                            <div class="d-flex">
                                <a href="'.$tam2["Nguon"].' ">
                                    <img class="w-50 d-inline" src="'.$tam2["Logo"].'" alt="" >
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                        '.$tam2["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>';
                        ?>   
                        </div>
                    </div>
                    <!-- Bai3 -->
                    <div class="_card row col-lg-12 col-md-6">
                        <div class="col-5 img_card">
                        <?php
                        $tam2= $top5->fetch_assoc();
                        if(strlen($tam2["TenBT"])>90)
                        $tam2["TenBT"]=$tam2["TenBT"]."...";
                        echo '  <a href="Fnews.php?page=BangTin&Ma='.$tam2["MaBT"].'">
                            <img class="w-100 d-block" src="'.$tam2["HinhAnh"].'" alt="" height=100px, width= 300px>
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$tam2["MaBT"].'">
                                <p class="p_card">'.$tam2["TenBT"].'</p>
                            </a>
                            
                            <div class="d-flex">
                                <a href="'.$tam2["Nguon"].' ">
                                    <img class="w-50 d-inline" src="'.$tam2["Logo"].'" alt="" >
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                        '.$tam2["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>';
                        ?>   
                        </div>
                    </div>
                    <!-- Bai4 -->
                    <div class="_card row col-lg-12 col-md-6">
                        <div class="col-5 img_card">
                        <?php
                        $tam2= $top5->fetch_assoc();
                        if(strlen($tam2["TenBT"])>90)
                        $tam2["TenBT"]=$tam2["TenBT"]."..."; 
                        echo '  <a href="Fnews.php?page=BangTin&Ma='.$tam2["MaBT"].'">
                            <img class="w-100 d-block" src="'.$tam2["HinhAnh"].'" alt="" height=100px, width= 300px>
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$tam2["MaBT"].'">
                                <p class="p_card">'.$tam2["TenBT"].'</p>
                            </a>
                            
                            <div class="d-flex">
                                <a href="'.$tam2["Nguon"].' ">
                                    <img class="w-50 d-inline" src="'.$tam2["Logo"].'" alt="" >
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                        '.$tam2["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>';
                        ?>   
                        </div>
                    </div>
                    <!-- Bai5 -->
                    <div class="_card row col-lg-12 col-md-6">
                        <div class="col-5 img_card">
                        <?php
                        $tam2= $top5->fetch_assoc();
                        if(strlen($tam2["TenBT"])>90)
                        $tam2["TenBT"]=$tam2["TenBT"]."...";
                        echo '  <a href="Fnews.php?page=BangTin&Ma='.$tam2["MaBT"].'">
                            <img class="w-100 d-block" src="'.$tam2["HinhAnh"].'" alt="" height=100px, width= 300px>
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$tam2["MaBT"].'">
                                <p class="p_card">'.$tam2["TenBT"].'</p>
                            </a>
                            
                            <div class="d-flex">
                                <a href="'.$tam2["Nguon"].' ">
                                    <img class="w-50 d-inline" src="'.$tam2["Logo"].'" alt="">
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                        '.$tam2["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>';
                        ?> 
                    </div>
                </div>
                <div class="list-col_card">
                    <div class="title-list">    
                        <h2>
                            <Span>BẢN TIN THỜI SỰ</Span>
                        </h2>
                    </div>
                    <!-- Bai1 -->
                    <div class="_card row col-lg-12 col-md-6">
                        <div class="col-5 img_card">
                        <?php
                        $top5thoisu= $topthoisu->fetch_assoc();
                        if(strlen($top5thoisu["TenBT"])>90)
                        $top5thoisu["TenBT"]=$top5thoisu["TenBT"]."...";
                        echo '  <a href="Fnews.php?page=BangTin&Ma='.$top5thoisu["MaBT"].'">
                            <img class="w-100 d-block" src="'.$top5thoisu["HinhAnh"].'" alt="" height=100px, width= 300px">
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$top5thoisu["MaBT"].'">
                                <p class="p_card">'.$top5thoisu["TenBT"].'</p>
                            </a>
                            
                            <div class="d-flex">
                                <a href="'.$top5thoisu["Nguon"].' ">
                                    <img class="w-50 d-inline" src="'.$top5thoisu["Logo"].'" alt="">
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                        '.$top5thoisu["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>';
                        ?>
                        </div>
                    </div>
                    <!-- Bai2 -->
                    <div class="_card row col-lg-12 col-md-6">
                        <div class="col-5 img_card">
                        <?php
                        $top5thoisu= $topthoisu->fetch_assoc();
                        if(strlen($top5thoisu["TenBT"])>90)
                        $top5thoisu["TenBT"]=$top5thoisu["TenBT"]."..."; 
                        echo '  <a href="Fnews.php?page=BangTin&Ma='.$top5thoisu["MaBT"].'">
                            <img class="w-100 d-block" src="'.$top5thoisu["HinhAnh"].'" alt="" height=100px, width= 300px>
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$top5thoisu["MaBT"].'">
                                <p class="p_card">'.$top5thoisu["TenBT"].'</p>
                            </a>
                            
                            <div class="d-flex">
                                <a href="'.$top5thoisu["Nguon"].' ">
                                    <img class="w-50 d-inline" src="'.$top5thoisu["Logo"].'" alt="" >
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                        '.$top5thoisu["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>';
                        ?>   
                        </div>
                    </div>
                    <!-- Bai3 -->
                    <div class="_card row col-lg-12 col-md-6">
                        <div class="col-5 img_card">
                        <?php
                        $top5thoisu= $topthoisu->fetch_assoc(); 
                        if(strlen($top5thoisu["TenBT"])>90)
                        $top5thoisu["TenBT"]=$top5thoisu["TenBT"]."...";
                        echo '  <a href="Fnews.php?page=BangTin&Ma='.$top5thoisu["MaBT"].'">
                            <img class="w-100 d-block" src="'.$top5thoisu["HinhAnh"].'" alt="" height=100px, width= 300px>
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$top5thoisu["MaBT"].'">
                                <p class="p_card">'.$top5thoisu["TenBT"].'</p>
                            </a>
                            
                            <div class="d-flex">
                                <a href="'.$top5thoisu["Nguon"].' ">
                                    <img class="w-50 d-inline" src="'.$top5thoisu["Logo"].'" alt="" >
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                        '.$top5thoisu["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>';
                        ?>   
                        </div>
                    </div>
                    <!-- Bai4 -->
                    <div class="_card row col-lg-12 col-md-6">
                        <div class="col-5 img_card">
                        <?php
                        $top5thoisu= $topthoisu->fetch_assoc();
                        if(strlen($top5thoisu["TenBT"])>90)
                        $top5thoisu["TenBT"]=$top5thoisu["TenBT"]."..."; 
                        echo '  <a href="Fnews.php?page=BangTin&Ma='.$top5thoisu["MaBT"].'">
                            <img class="w-100 d-block" src="'.$top5thoisu["HinhAnh"].'" alt="" height=100px, width= 300px>
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$top5thoisu["MaBT"].'">
                                <p class="p_card">'.$top5thoisu["TenBT"].'</p>
                            </a>
                            
                            <div class="d-flex">
                                <a href="'.$top5thoisu["Nguon"].' ">
                                    <img class="w-50 d-inline" src="'.$top5thoisu["Logo"].'" alt="" >
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                        '.$top5thoisu["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>';
                        ?>   
                        </div>
                    </div>
                    <!-- Bai5 -->
                    <div class="_card row col-lg-12 col-md-6">
                        <div class="col-5 img_card">
                        <?php
                        $top5thoisu= $topthoisu->fetch_assoc();
                        if(strlen($top5thoisu["TenBT"])>90)
                        $top5thoisu["TenBT"]=$top5thoisu["TenBT"]."...";
                        echo '  <a href="Fnews.php?page=BangTin&Ma='.$top5thoisu["MaBT"].'">
                            <img class="w-100 d-block" src="'.$top5thoisu["HinhAnh"].'" alt="" height=100px, width= 300px>
                            </a>
                        </div>
                        <div class="col-7 ml-0 text_card">
                            <a href="Fnews.php?page=BangTin&Ma='.$top5thoisu["MaBT"].'">
                                <p class="p_card">'.$top5thoisu["TenBT"].'</p>
                            </a>
                            
                            <div class="d-flex">
                                <a href="'.$top5thoisu["Nguon"].' ">
                                    <img class="w-50 d-inline" src="'.$top5thoisu["Logo"].'" alt="">
                                </a>
                                <div class="d-flex w-100 flex-column-reverse">
                                    <p class="date_card w-100">
                                        '.$top5thoisu["NgayDangBai"].'
                                    </p>
                                </div>
                            </div>';
                        ?>   
                    </div>
                </div>
            </div>                
        </div>        
    </div>
    
    <footer class="bg-dark text-white w-100" id="Contact">
        <div class="footer_top row">
            <div class="col-lg-4 col-md-12 p-4">
                <h5>FLICKR IMAGES</h5>
                <hr class="bg-white">
            </div>
            <div class="col-lg-4 col-md-12 p-4">
                <h5>TAG</h5>
                <hr class="bg-white">
                <a href="#ChinhTri">Chính trị</a>
                <a href="#XaHoi">Xã hội</a>
                <a href="#VanHoa">Văn hóa</a>
                <a href="#TheThao">Thể thao</a>
            </div>
            <div class="col-lg-4 col-md-12 p-4">
                <h5>CONTACT</h5>                   
                <hr class="bg-white">
                <p>Mọi thắc mắc xin liện hệ theo địa chỉ sau đây.</p>
                <p>Email : 1952****@gm.uit.edu.vn</p>
                <p>Phone : 09866534**</p>
                <div class="contact-social">
                    <button class="btn btn-outline-light" onclick="location.href='https://www.facebook.com/Absorb.Eng';"><i class="fab fa-facebook-f"></i></button>
                    <button class="btn btn-outline-light" onclick="location.href='https://www.instagram.com/thungo0923/';"><i class="fab fa-instagram"></i></button>
                    <button class="btn btn-outline-light" onclick="location.href='https://github.com/GiaTran-1902/GiaTran-1902';"><i class="fab fa-github"></i></button>
                </div>
            </div>
        </div>
        <div class="footer_left">
            © 2021-2021. Toàn bộ bản quyền thuộc FNews
        </div>
    </footer>
    
    <!-- My Script -->
    <script src="./js/script.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
</body>

</html>