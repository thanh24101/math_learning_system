<?php
session_start();
include("database.php");
include("include/header.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$role = $_SESSION["role"];


if ($role == "giaovien") {
    $stmt = $conn->prepare("
        SELECT n.*, u.username AS receiver_name 
        FROM notifications n
        LEFT JOIN users u ON n.receiver_id = u.id
        WHERE n.user_id = ?
        ORDER BY n.created_at DESC
    ");
    $stmt->bind_param("i", $user_id);
}

else {
    $stmt = $conn->prepare("
        SELECT n.*, u.username AS sender_name 
        FROM notifications n
        JOIN users u ON n.user_id = u.id
        WHERE n.receiver_id = ?
        ORDER BY n.created_at DESC
    ");
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<h2>📬 Thông báo</h2>

<?php if ($role == "giaovien"): ?>
  <a href="create_notification.php"><button>➕ Gửi thông báo mới</button></a>
<?php endif; ?>

<hr>

<?php
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px; border-radius:8px; background:#fafafa'>";
    echo "<h3><a href='view_notification.php?id=" . $row['id'] . "' style='text-decoration:none; color:#4b0082;'>" 
        . htmlspecialchars($row['title']) . "</a></h3>";

    if ($role == "giaovien") {
        echo "<p>👥 Gửi đến: " . htmlspecialchars($row['receiver_name'] ?? 'Toàn bộ') . "</p>";
    } else {
        echo "<p>👤 Gửi bởi: " . htmlspecialchars($row['sender_name']) . "</p>";
    }
    echo "<p><small>📅 " . $row["created_at"] . "</small></p>";
    echo "</div>";
  }
} else {
  echo "<p>Không có thông báo nào.</p>";
}
?>


<?php include("include/footer.html"); ?>