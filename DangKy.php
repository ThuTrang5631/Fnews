<?php
    header("Content-type: text/html; charset=utf-8");
    header("Access-Control-Allow-Origin: *");

    $Email = $_POST["Email"];
    $MatKhau = $_POST["Matkhau"];

    //Connect to database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "dbfnews";

    // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
 
// //   Check connection
//   if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error) . "<br>";
//   }
//   echo "Connected successfully. <br>";

  $row = "SELECT * FROM tknguoidung";
  $check_email = "SELECT * FROM tknguoidung WHERE Email='$Email'";
  $result_email = $conn->query($check_email);
  if ($result_email->num_rows > 0){
    echo("Tài khoản đã tồn tại");
    $conn->close();
  }
  else{
    $result = $conn->query($row);
    $stt = $result->num_rows+1;
    //Insert
    $sql = "INSERT INTO tknguoidung (MaTKND, Email, MatKhau)
    VALUES ('TK$stt','$Email',MD5('$MatKhau'))";

   if ($conn->query($sql) == TRUE) {
       echo "Success";
     } 
   else 
       echo "Error";
     $conn->close();}
?>