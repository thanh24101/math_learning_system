<?php
session_start();
include("database.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
$stmt = $conn->prepare("SELECT username, email, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<?php include("include/header.php"); ?>

<h2>Thông tin tài khoản</h2>
<table border="1" cellpadding="10" cellspacing="0">
  <tr><th>Tên đăng nhập</th><td><?php echo $user["username"]; ?></td></tr>
  <tr><th>Email</th><td><?php echo $user["email"]; ?></td></tr>
  <tr><th>Vai trò</th><td><?php echo ucfirst($user["role"]); ?></td></tr>
</table>



<?php include("include/footer.html"); ?>
