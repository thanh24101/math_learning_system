<?php
include("database.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

 
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        
        $token = bin2hex(random_bytes(32));
        $expire = date("Y-m-d H:i:s", time() + 3600); 

        
        $conn->query("DELETE FROM password_resets WHERE email = '$email'");
      
        $insert = $conn->prepare("INSERT INTO password_resets (email, token, expire_at) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $email, $token, $expire);
        $insert->execute();

        
        $resetLink = "http://localhost/mls/reset_password.php?token=$token";
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thanh24101@gmail.com';
            $mail->Password = 'honp ktif mger cnmo'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('thanh24101@gmail.com', 'Math Learning System');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "Password reset";
            $mail->Body = "Nhấn vào link sau để đặt lại mật khẩu:<br><a href='$resetLink'>$resetLink</a>";

            $mail->send();
            echo "<p style='color:green;'>✅ Email khôi phục đã được gửi đến $email.</p>";
        } catch (Exception $e) {
            echo "<p style='color:red;'>❌ Không thể gửi email: {$mail->ErrorInfo}</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ Không tìm thấy email này trong hệ thống!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quên mật khẩu</title>
</head>
<body>
  <h2>Quên mật khẩu</h2>
  <form method="POST">
    <label>Nhập email đã đăng ký:</label><br>
    <input type="email" name="email" required><br><br>
    <button type="submit">Gửi yêu cầu</button>
  </form>

  <p><a href="login.php"><button type="sumbit">Quay lại đăng nhập</button></a></p>
</body>
</html>
<?php include("include/footer.html"); ?>