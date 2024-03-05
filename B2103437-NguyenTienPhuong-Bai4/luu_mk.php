<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbanhang";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Xử lý khi form được gửi đi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy giá trị từ form
    $oldPassword = $_POST['pass_cu'];
    $newPassword = $_POST['pass_moi'];
    $confirmPassword = $_POST['pass_moi2'];

    // Kiểm tra mật khẩu cũ
    session_start();
    $id = $_SESSION['id'];
    $sql = "SELECT password FROM customers WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        if (md5($oldPassword) !== $storedPassword) {
            echo "Mật khẩu cũ không khớp.";
            header('Refresh: 3;url=sua_mk.php');

        } else {
            // Kiểm tra mật khẩu mới và xác nhận mật khẩu mới
            if ($newPassword !== $confirmPassword) {
                echo "Mật khẩu mới và xác nhận mật khẩu không khớp.";
                header('Refresh: 3;url=sua_mk.php');
            } elseif ($newPassword === $oldPassword) {
                echo "Mật khẩu mới phải khác mật khẩu cũ.";
                header('Refresh: 3;url=sua_mk.php');
            } else {
                // Tiến hành băm mật khẩu mới
                $hashedPassword = md5($newPassword);

                // Lưu mật khẩu mới vào CSDL
                $updateSql = "UPDATE customers SET password = '$hashedPassword' WHERE id = '$id'";
                if ($conn->query($updateSql) === TRUE) {
                    echo "Mật khẩu đã được thay đổi thành công.";
                    echo '<a href="Login.php">Trang chu</a>';
                } else {
                    echo "Lỗi khi cập nhật mật khẩu: " . $conn->error;
                }
            }
        }
    } else {
        echo "Không tìm thấy người dùng.";
    }
}
?>