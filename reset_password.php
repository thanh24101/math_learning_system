<?php
include("database.php");
$time = date_default_timezone_set('Asia/Ho_Chi_Minh');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ? AND expire_at > $time");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reset = $result->fetch_assoc();
        $email = $reset['email'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newPass = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update->bind_param("ss", $newPass, $email);
            $update->execute();

         
            $conn->query("DELETE FROM password_resets WHERE email = '$email'");

            echo "<p style='color:green;'>✅ Mật khẩu đã được cập nhật thành công! Bạn có thể đăng nhập.</p>";
            echo "<a href='login.php'>Đăng nhập</a>";
            exit;
        }
    } else {
        echo "<p style='color:red;'>❌ Link không hợp lệ hoặc đã hết hạn!</p>";
        exit;
    }
} else {
    echo "<p style='color:red;'>❌ Thiếu mã token!</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đặt lại mật khẩu</title>
</head>
<body>
  <h2>Đặt lại mật khẩu mới</h2>
  <form method="POST">
    <input type="password" name="new_password" placeholder="Mật khẩu mới" required><br><br>
    <button type="submit">Cập nhật mật khẩu</button>
  </form>
</body>
</html>
<?php include("include/footer.html"); ?>