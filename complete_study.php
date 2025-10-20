<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
  die("<p style='color:red;'>❌ Bạn cần đăng nhập để hoàn thành bài học.</p>");
}

$user_id = $_SESSION["user_id"];
$lesson_id = intval($_GET["lesson_id"]);

$conn->query("
  UPDATE studies 
  SET status='hoan_thanh', end_time=NOW(), progress=100 
  WHERE user_id=$user_id AND lesson_id=$lesson_id
");


$lesson = $conn->query("SELECT title FROM lessons WHERE id=$lesson_id")->fetch_assoc();
$title = $lesson['title'] ?? 'Bài học';

$stmt = $conn->prepare("
  INSERT INTO notifications (user_id, receiver_id, title, message, type, created_at, is_read)
  VALUES (?, ?, ?, ?, 'he_thong', NOW(), 0)
");
$message = "🎉 Bạn đã hoàn thành bài học: $title!";
$stmt->bind_param("iiss", $user_id, $user_id, $title, $message);
$stmt->execute();

echo "<script>alert('✅ Bạn đã hoàn thành bài học!'); window.location='study.php';</script>";
exit;
?>
