<?php
$servername = "localhost";
$username = "root";
// server
//$password = "dbf76fb8c7e45fe1";
// localhost pas
 $password = "";
$dbname = "fableous";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$pname = $_POST["pname"];
$user = $_POST["user"];
$data = $_POST["data"];

$sql = "INSERT INTO library (pname, user, data)
VALUES ('$pname', '$user', '$data')";

if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('保存成功');history.back();</script>";

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>