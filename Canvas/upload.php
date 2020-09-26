<?php
$servername = "localhost";
$username = "root";
// server
$password = "dbf76fb8c7e45fe1";
// localhost pas
//  $password = "";
$dbname = "fableous";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$pname = $_POST["pname"];
$user = $_POST["user"];
$data = $_POST["data"];
$pdata1 = null;
//echo $data."\n";
$pages = explode("data:image/png;base64,", $data);
$number = count($pages);
foreach($pages as $key => $pdata) {
    if (!$pdata=="") {
        $pdata1 = "data:image/png;base64,". str_replace(",","",$pdata);

        $sql = "INSERT INTO library (pname, user, data)
        VALUES ('$pname', '$user', '$pdata1')";

        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return;
        }
    }
    if ($key == $number - 1) {
        echo "<script> alert('save succeed');history.back();</script>";
    }
}

//echo "data:image/png;base64," . str_replace(",","",$pages[1]);
//$json = json_decode('$data', true);
//echo "\n";
//echo $json;
//foreach ($data as $key => $value) {
//    echo $value;
//    echo "\n";
//}






$conn->close();
?>