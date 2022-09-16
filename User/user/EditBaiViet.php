<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbfnews";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn -> set_charset("utf8");

    $info = explode("-",$_POST["info"]);
    $Length = $info[0];
    $MaBT =  $info[1];
    echo "Length = $Length; MaBT = $MaBT <br>";
    $sql2="delete from noidung where MaBT='$MaBT' ";
    $sql3="delete from hinhanh where MaBT='$MaBT' ";
    $del2 = $conn->query($sql2);
    $del3 = $conn->query($sql3);
    $indexHA = 1;
    $indexND = 1;
    function OUT($num)
    {
        if ($num >= 10)
            return "$num";
        else 
            return "0$num";
    }
    for ($i = 1; $i <= $Length; $i++) {
        $sql ="";
        if ($_POST["listChange-$i"]=="noidung") {
            echo "Ma $i : ND".OUT($indexND)." Muc1 :".$_POST["list-$i-muc-1"]."<br>";
            $sql = "INSERT INTO `noidung` (`MaND`, `MaBT`, `STT`, `DuLieu`) VALUES ('ND".OUT($indexND)."', '$MaBT', $i, '".$_POST["list-$i-muc-1"]."')";
            $indexND++;
        }
        else {
            echo "Ma $i : HA".OUT($indexHA)." Muc1 :".$_POST["list-$i-muc-1"]." Muc2 :".$_POST["list-$i-muc-2"]."<br>";
            $sql = "INSERT INTO `hinhanh` (`MaHA`, `MaBT`, `STT`, `HinhAnh`, `MoTaAnh`) VALUES('HA".OUT($indexHA)."', '$MaBT', $i, '".$_POST["list-$i-muc-1"]."','".$_POST["list-$i-muc-2"]."')";
            $indexHA++;
        }
        $result = $conn->query($sql);
    }
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=DanhSachBaiViet.php?edit=$MaBT\">";
    $conn->close();
?>