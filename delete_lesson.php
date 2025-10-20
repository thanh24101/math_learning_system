<?php
session_start();
include("database.php");

if (!isset($_SESSION["role"]) || !in_array($_SESSION["role"], ["giaovien", "admin"])) {
  die("<p style='color:red;'>⛔ Bạn không có quyền xoá bài giảng!</p>");
}


if (!isset($_GET["id"])) {
  die("<p style='color:red;'>❌ Thiếu ID bài giảng!</p>");
}

$id = intval($_GET["id"]);


$stmt = $conn->prepare("DELETE FROM lessons WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  echo "<script>alert('✅ Đã xoá bài giảng thành công!'); window.location='study.php';</script>";
} else {
  echo "<p style='color:red;'>⚠️ Lỗi khi xoá bài giảng: " . $conn->error . "</p>";
}
?>
