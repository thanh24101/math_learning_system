<?php
session_start();
include("database.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION["username"];
    $current = $_POST["current_password"];
    $new = $_POST["new_password"];
    $confirm = $_POST["confirm_password"];

   
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!password_verify($current, $user["password"])) {
        $message = "<p style='color:red;'>❌ Mật khẩu hiện tại không đúng!</p>";
    } elseif ($new !== $confirm) {
        $message = "<p style='color:red;'>❌ Mật khẩu mới và xác nhận không trùng khớp!</p>";
    } else {
      
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $update->bind_param("ss", $hash, $username);
        $update->execute();

        $message = "<p style='color:green;'>✅ Đổi mật khẩu thành công!</p>";
    }
}
?>

<?php include("include/header.php"); ?>

<h2>Đổi mật khẩu</h2>

<?php echo $message; ?>

<form method="POST">
  <label>Mật khẩu hiện tại:</label><br>
  <input type="password" name="current_password" required><br><br>

  <label>Mật khẩu mới:</label><br>
  <input type="password" name="new_password" required><br><br>

  <label>Nhập lại mật khẩu mới:</label><br>
  <input type="password" name="confirm_password" required><br><br>

  <button type="submit">Cập nhật mật khẩu</button>
</form>



<?php include("include/footer.html"); ?>