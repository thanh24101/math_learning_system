<?php
session_start();
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Truy vấn kiểm tra tài khoản
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu đúng không
        if (password_verify($password, $user["password"])) {

            // ✅ Gán thông tin vào session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];

            echo "<p style='color:green;'>✅ Đăng nhập thành công!</p>";

            // Chuyển hướng sau 1 giây
            echo "<script>
                    setTimeout(function(){
                      window.location.href = 'home.php';
                    }, 1000);
                  </script>";
        } else {
            echo "<p style='color:red;'>❌ Sai mật khẩu!</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ Không tìm thấy tài khoản!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
</head>
<body>
  <h2>Đăng nhập</h2>
  <form method="POST">
    <input type="text" name="username" placeholder="Tên đăng nhập" required><br><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br><br>
    <button type="submit">Đăng nhập</button>
  </form>

  <p>Chưa có tài khoản?</p>
  <a href="register.php"><button>Đăng ký ngay</button></a>

  <p>Quên mật khẩu?</p>
  <a href="forgot_password.php"><button>Quên mật khẩu</button></a>
</body>
</html>
<?php include("include/footer.html"); ?>