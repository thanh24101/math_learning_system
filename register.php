<?php
include("database.php");


function checkUserExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['username'] === $username) {
            return "username"; 
        } elseif ($user['email'] === $email) {
            return "email"; 
        }
    }
    return false; 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST["role"];

 
    $check = checkUserExists($conn, $username, $email);

    if ($check === "username") {
        echo "<p style='color:red;'>❌ Tên đăng nhập này đã tồn tại, vui lòng chọn tên khác.</p>";
    } elseif ($check === "email") {
        echo "<p style='color:red;'>❌ Email này đã được sử dụng, vui lòng nhập email khác.</p>";
    } else {
       
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $password, $role);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>✅ Đăng ký thành công! Bạn có thể đăng nhập ngay.</p>";
   
            echo "<script>
                    setTimeout(function(){
                      window.location.href = 'login.php';
                    }, 1000);
                  </script>";
        } else {
            echo "<p style='color:red;'>❌ Lỗi: " . $stmt->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký</title>
  
</head>
<body>
  <h2>Đăng ký tài khoản</h2>
  <form method="POST">
    <input type="text" name="username" placeholder="Tên đăng nhập" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br><br>

    Vai trò:<br>
    <input type="radio" name="role" value="tre" required> Trẻ<br>
    <input type="radio" name="role" value="giaovien"> Giáo viên<br>
    <input type="radio" name="role" value="phuhuynh"> Phụ huynh<br><br>

    <button type="submit">Đăng ký</button>
  </form>

  <p>Đã có tài khoản?</p>
  <a href="login.php"><button>Đăng nhập</button></a>
</body>
</html>
<?php include("include/footer.html"); ?>