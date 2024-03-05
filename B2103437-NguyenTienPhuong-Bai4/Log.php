<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbanhang";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }


$sql = "select id, fullname, email from customers where email = '".$_POST["email"]."' and password = '".md5($_POST["pass"])."'";

$result = $conn->query($sql);

if ($result->num_rows != 0) {
 
  $row = $result->fetch_assoc();
  //
  session_start();
  $session_name = "user";
  $session_value = $row['email'] ;
  $_SESSION['fullname'] = $row['fullname'];
  $_SESSION['id'] = $row['id'];
  $_SESSION['$session_name'] = $row['$session_value'];        
  
  //
  header('Location: homepage.php');
  
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  //Tro ve trang dang nhap sau 3 giay
  // header('Refresh: 5;url=login.php');

}

$conn->close();
?>