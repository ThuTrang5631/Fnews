<?php

    $email =$_POST["Email"];
    $pass = $_POST["MatKhau"];
    $Ma =(isset($_POST["Ma"])) ? $_POST["Ma"] :"#";
    $link = (isset($_POST["Link"])) ? $_POST["Link"] :"#";
   
    session_start();
    
    if (empty($email)) {
        echo ("Bạn chưa nhập email. Mời bạn đăng nhập lại!");
    }
    else if (empty($pass)) {
        echo ("Bạn chưa nhập password. Mời bạn đăng nhập lại!");
    }
    else {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dbfnews";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn -> set_charset("utf8");

        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        // $sql = "SELECT * FROM tknguoidung WHERE Email= '$email' AND MatKhau= MD5('$pass')";
        // echo $sql;
        //die();

        // $result = $conn->query($sql);
        // echo $result->num_rows;
        // echo $result->fetch_assoc()["TaiKhoan"];

        
        $sql1 = "SELECT Email,MatKhau from tknguoidung  where Upper(Email)= Upper('$email') AND MatKhau= MD5('$pass')";
        $result1 = mysqli_query($conn,$sql1);
        $sql2 = "SELECT Email,MatKhau from tktacgia  where Upper(Email)= Upper('$email') AND MatKhau= MD5('$pass')";
        $result2 = mysqli_query($conn,$sql2);
        $sql3 = "SELECT Email,MatKhau from tkadmin where Upper(Email)= Upper('$email') AND MatKhau= MD5('$pass')";
        $result3 = mysqli_query($conn,$sql3);

        if (mysqli_num_rows($result1) + mysqli_num_rows($result2) + mysqli_num_rows($result3) === 1) {
            echo ("Bạn đã đăng nhập thành công!");
            $_SESSION["taikhoan"] = $email;
            if (mysqli_num_rows($result1)=== 1) {
                if ($Ma == "#")
                    echo "<meta http-equiv=\"refresh\" content=\"0;URL=Fnews.php?".$link."\">";
                else 
                    echo "<meta http-equiv=\"refresh\" content=\"0;URL=Fnews.php?".$link."&Ma=".$Ma."\">";
            }
            else if (mysqli_num_rows($result3)=== 1) {
                echo "<meta http-equiv=\"refresh\" content=\"0;URL=Admin/Admin.php\">";
            }

            else {
                echo "<meta http-equiv=\"refresh\" content=\"0;URL=User/user/ThongTinCaNhan.php\">";
            }

        }else {
            echo ("Bạn đã nhập sai email hoặc mật khẩu!");    
        }
        
       //Close connection to database
        $conn->close();
    }
?>
    