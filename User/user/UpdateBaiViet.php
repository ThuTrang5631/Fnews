<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbfnews";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn -> set_charset("utf8");
    

    function OUT($num)
    {
        if ($num >= 10)
            return "$num";
        else 
            return "0$num";
    }

    $sql = 'SELECT * FROM bangtin;';
    $result = $conn->query($sql);
    $i = 1;
    for ($i=1; $i <= $result->num_rows; $i++) {
        $row = $result->fetch_assoc();
        if ($row["MaBT"] != "BT".OUT($i)) {
            break;
        } 
    }
    $MaBT = "BT".OUT($i);

    $sql = "SELECT Logo FROM bangtin WHERE Nguon = '".$_GET["Nguon"]."'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $Logo = $row['Logo'];

    $sqlUpdate = "
    INSERT INTO `bangtin` (`MaBT`, `TenBT`, `MaTG`, `SoLuotXem`, `NgayDang`, `MaLT`, `Nguon`, `Logo`) VALUES
    ('$MaBT', '".$_GET["TieuDe"]."', '".$_GET["info"]."', 0, '".$_GET["NgayDang"]."', '".$_GET["TheLoai"]."', '".$_GET["Nguon"]."', '$Logo');
    ";
    $result = $conn->query($sqlUpdate);

    echo "<meta http-equiv=\"refresh\" content=\"0;URL=DanhSachBaiViet.php?edit=$MaBT\">"; 
    $conn->close();
?>