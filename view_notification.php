<?php
session_start();
include("database.php");
include("include/header.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$id = intval($_GET["id"]);
$user_id = $_SESSION["user_id"];
$role = $_SESSION["role"];

$stmt = $conn->prepare("
    SELECT n.*, u.username AS sender_name
    FROM notifications n
    JOIN users u ON n.user_id = u.id
    WHERE n.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$notif = $stmt->get_result()->fetch_assoc();

if (!$notif) {
    echo "<p style='color:red;'>❌ Không tìm thấy thông báo!</p>";
    exit();
}

if ($notif["user_id"] != $user_id && $notif["receiver_id"] != $user_id) {
    echo "<p style='color:red;'>🚫 Bạn không có quyền xem thông báo này!</p>";
    exit();
}

$conn->query("UPDATE notifications SET is_read = 1 WHERE id = $id");
?>

<h2><?php echo htmlspecialchars($notif["title"]); ?></h2>
<p><?php echo nl2br(htmlspecialchars($notif["message"])); ?></p>
<p><small>👤 Gửi bởi: <?php echo htmlspecialchars($notif["sender_name"]); ?> | 📅 <?php echo $notif["created_at"]; ?></small></p>

<hr>
<a href="notification.php">⬅ Quay lại danh sách</a>

<?php include("include/footer.html"); ?>
