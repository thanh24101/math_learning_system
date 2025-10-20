<?php
session_start();
include("database.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// ✅ Chỉ giáo viên được phép
if ($_SESSION["role"] != "giaovien") {
    echo "<p style='color:red;'>🚫 Chỉ giáo viên mới được gửi thông báo!</p>";
    exit();
}

$user_id = $_SESSION["user_id"];
$role = $_SESSION["role"];
$message = "";


$receivers = $conn->query("SELECT id, username, role FROM users WHERE role IN ('tre','phuhuynh')");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $msg = $_POST["message"];
    $receiver_id = $_POST["receiver_id"];

    
    if ($receiver_id == "all") {
        $sql = "SELECT id FROM users WHERE role IN ('tre','phuhuynh')";
        $res = $conn->query($sql);
        while ($r = $res->fetch_assoc()) {
            $insert = $conn->prepare("INSERT INTO notifications (user_id, receiver_id, title, message, type) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("iisss", $user_id, $r['id'], $title, $msg, $role);
            $insert->execute();
        }
        $message = "<p style='color:green;'>✅ Đã gửi thông báo cho toàn bộ phụ huynh và học sinh!</p>";
    } else {
       
        $stmt = $conn->prepare("INSERT INTO notifications (user_id, receiver_id, title, message, type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $user_id, $receiver_id, $title, $msg, $role);
        $stmt->execute();
        $message = "<p style='color:green;'>✅ Đã gửi thông báo thành công!</p>";
    }
}
?>

<?php include("include/header.php"); ?>

<h2>📢 Gửi thông báo</h2>

<?php echo $message; ?>

<form method="POST">
  <label>Tiêu đề:</label><br>
  <input type="text" name="title" required style="width:300px;"><br><br>

  <label>Nội dung:</label><br>
  <textarea name="message" rows="6" cols="50" required></textarea><br><br>

  <label>Gửi đến:</label><br>
  <select name="receiver_id" required>
    <option value="all">📬 Toàn bộ phụ huynh và học sinh</option>
    <?php while($r = $receivers->fetch_assoc()): ?>
      <option value="<?php echo $r['id']; ?>">
        <?php echo htmlspecialchars($r['username']); ?> (<?php echo $r['role']; ?>)
      </option>
    <?php endwhile; ?>
  </select><br><br>

  <button type="submit">Gửi thông báo</button>
</form>

<hr>
<a href="notification.php">⬅ Quay lại danh sách thông báo</a>

<?php include("include/footer.html"); ?>