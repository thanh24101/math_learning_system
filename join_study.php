<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
  die("<p style='color:red;'>❌ Bạn cần đăng nhập để tham gia bài học.</p>");
}

$user_id = $_SESSION["user_id"];
$lesson_id = intval($_GET["lesson_id"]);

if (!$lesson_id) {
  die("<p style='color:red;'>❌ Thiếu ID bài học.</p>");
}

$check = $conn->query("SELECT * FROM studies WHERE user_id=$user_id AND lesson_id=$lesson_id");

if ($check->num_rows > 0) {

  $conn->query("
    UPDATE studies 
    SET status='dang_hoc', start_time=NOW()
    WHERE user_id=$user_id AND lesson_id=$lesson_id
  ");
} else {

  $stmt = $conn->prepare("
    INSERT INTO studies (user_id, lesson_id, start_time, status, progress)
    VALUES (?, ?, NOW(), 'dang_hoc', 0)
  ");
  $stmt->bind_param("ii", $user_id, $lesson_id);
  $stmt->execute();
}

echo "<script>alert('🚀 Bắt đầu học bài này!'); window.location='view_lesson.php?id=$lesson_id';</script>";
exit;
?>
