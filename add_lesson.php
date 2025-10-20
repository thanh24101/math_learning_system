<?php
session_start();
include("database.php");

if (!isset($_SESSION["role"]) || !in_array($_SESSION["role"], ["giaovien", "admin"])) {
  die("<p style='color:red;'>⛔ Bạn không có quyền truy cập trang này.</p>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST["title"];
  $description = $_POST["description"];
  $subject = $_POST["subject"];
  $media_type = $_POST["media_type"];
  $content = $_POST["content"];
  $created_by = $_SESSION["user_id"];
  $media_url = NULL;

  
  if (isset($_FILES["media_file"]) && $_FILES["media_file"]["error"] == 0) {
    $upload_dir = "uploads/lessons/";
    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
    $filename = time() . "_" . basename($_FILES["media_file"]["name"]);
    $target = $upload_dir . $filename;
    if (move_uploaded_file($_FILES["media_file"]["tmp_name"], $target)) {
      $media_url = $target;
    }
  }

  if ($media_type == "video" && !empty($_POST["video_link"])) {
    $media_url = $_POST["video_link"];
  }


  $stmt = $conn->prepare("
    INSERT INTO lessons (title, description, media_type, media_url, subject, content, created_by)
    VALUES (?, ?, ?, ?, ?, ?, ?)
  ");
  $stmt->bind_param("ssssssi", $title, $description, $media_type, $media_url, $subject, $content, $created_by);
  $stmt->execute();

  echo "<script>alert('✅ Thêm bài giảng thành công!'); window.location='study.php';</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>➕ Thêm bài giảng</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f8f8f8; margin: 40px; }
    form {
      background: #fff; padding: 25px; border-radius: 12px;
      max-width: 700px; margin: auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 { color: purple; text-align: center; margin-bottom: 20px; }
    label { font-weight: bold; display: block; margin-top: 10px; }
    input[type="text"], textarea, select {
      width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px; margin-top: 5px;
    }
    button {
      margin-top: 20px; padding: 10px 20px; background: purple; color: white;
      border: none; border-radius: 6px; cursor: pointer; font-size: 15px;
    }
    button:hover { background: #5e2b97; }
    .back { background: gray; margin-left: 10px; }
    .back:hover { background: #333; }
  </style>
</head>
<body>

<h2>📘 Thêm bài giảng mới</h2>

<form method="POST" enctype="multipart/form-data">
  <label>Tiêu đề bài giảng:</label>
  <input type="text" name="title" placeholder="Nhập tiêu đề..." required>

  <label>Mô tả ngắn:</label>
  <textarea name="description" rows="3" placeholder="Giới thiệu ngắn về bài học..."></textarea>

  <label>Môn học:</label>
  <input type="text" name="subject" placeholder="Ví dụ: Toán, Văn, Tiếng Anh..." required>

  <label>Hình thức nội dung:</label>
  <select name="media_type" id="media_type" onchange="toggleUploadType()">
    <option value="text">📝 Văn bản</option>
    <option value="video">🎬 Video</option>
    <option value="file">📄 Tài liệu / Hình ảnh</option>
  </select>

  
  <div id="videoInput" style="display:none;">
    <label>Nhập link video (YouTube hoặc MP4):</label>
    <input type="text" name="video_link" placeholder="https://www.youtube.com/... hoặc link mp4">
  </div>


  <div id="fileInput" style="display:none;">
    <label>Tải tệp lên (pdf, docx, jpg, png, mp4...):</label>
    <input type="file" name="media_file" accept=".pdf,.docx,.jpg,.jpeg,.png,.mp4">
  </div>

  
  <div id="textInput">
    <label>Nội dung bài giảng (text):</label>
    <textarea name="content" rows="6" placeholder="Nhập nội dung bài học tại đây..."></textarea>
  </div>

  <button type="submit">💾 Lưu bài giảng</button>
  <a href="study.php"><button type="button" class="back">⬅ Quay lại</button></a>
</form>

<script>
function toggleUploadType() {
  const type = document.getElementById('media_type').value;
  document.getElementById('videoInput').style.display = (type === 'video') ? 'block' : 'none';
  document.getElementById('fileInput').style.display = (type === 'file') ? 'block' : 'none';
  document.getElementById('textInput').style.display = (type === 'text') ? 'block' : 'none';
}
</script>

</body>
</html>
