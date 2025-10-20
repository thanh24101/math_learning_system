<?php
session_start();
include("database.php");


if (!isset($_SESSION["role"]) || !in_array($_SESSION["role"], ["giaovien", "admin"])) {
  die("<p style='color:red;'>⛔ Bạn không có quyền truy cập trang này.</p>");
}


$lessons = $conn->query("SELECT id, title FROM lessons ORDER BY id DESC");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $lesson_id = $_POST["lesson_id"];
  $question = $_POST["question"];
  $correct_answer = $_POST["correct_answer"];
  $answer = NULL;
  $type = "hinh_anh";

  
  if (isset($_FILES["answer_file"]) && $_FILES["answer_file"]["error"] == 0) {
    $upload_dir = "uploads/exercises/";
    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

    $filename = time() . "_" . basename($_FILES["answer_file"]["name"]);
    $target_file = $upload_dir . $filename;

    if (move_uploaded_file($_FILES["answer_file"]["tmp_name"], $target_file)) {
      $answer = $target_file;
    } else {
      die("<p style='color:red;'>❌ Lỗi khi tải ảnh lên!</p>");
    }
  }

  
  $stmt = $conn->prepare("
    INSERT INTO exercises (lesson_id, question, answer, correct_answer, created_at)
    VALUES (?, ?, ?, ?, NOW())
  ");
  $stmt->bind_param("isss", $lesson_id, $question, $answer, $correct_answer);
  $stmt->execute();

  echo "<script>alert('✅ Thêm bài tập hình ảnh thành công!'); window.location='study.php';</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>🖼 Thêm bài tập hình ảnh</title>
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: #f8f8f8; 
      margin: 40px;
    }
    form {
      background: #fff; 
      padding: 25px; 
      border-radius: 12px;
      max-width: 600px; 
      margin: auto; 
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 { 
      color: purple; 
      text-align: center; 
      margin-bottom: 20px; 
    }
    label { 
      font-weight: bold; 
      display: block; 
      margin-top: 10px; 
    }
    select, input[type="text"], textarea {
      width: 100%; 
      padding: 8px; 
      border: 1px solid #ccc; 
      border-radius: 6px; 
      margin-top: 5px;
    }
    input[type="file"] {
      margin-top: 8px;
    }
    button {
      margin-top: 20px; 
      padding: 10px 20px; 
      background: purple; 
      color: white;
      border: none; 
      border-radius: 6px; 
      cursor: pointer; 
      font-size: 15px;
    }
    button:hover { background: #5e2b97; }
    .back { background: gray; margin-left: 10px; }
    .back:hover { background: #333; }
    .preview {
      margin-top: 15px;
      text-align: center;
    }
    .preview img {
      max-width: 100%;
      border-radius: 10px;
      border: 1px solid #ddd;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<h2>🖼 Thêm bài tập hình ảnh</h2>

<form method="POST" enctype="multipart/form-data">
  <label>📘 Chọn bài giảng:</label>
  <select name="lesson_id" required>
    <option value="">-- Chọn bài giảng liên quan --</option>
    <?php while($l = $lessons->fetch_assoc()): ?>
      <option value="<?php echo $l['id']; ?>"><?php echo htmlspecialchars($l['title']); ?></option>
    <?php endwhile; ?>
  </select>

  <label>📝 Câu hỏi hoặc yêu cầu bài tập:</label>
  <textarea name="question" rows="3" placeholder="Nhập nội dung câu hỏi, ví dụ: Hãy đếm số vật trong hình..." required></textarea>

  <label>🖼 Ảnh bài tập:</label>
  <input type="file" name="answer_file" accept=".jpg,.jpeg,.png,.gif" required onchange="previewImage(event)">

  <div class="preview" id="preview"></div>

  <label>✏️ Đáp án đúng:</label>
  <input type="text" name="correct_answer" placeholder="Nhập đáp án chính xác (ví dụ: 5, con mèo, màu đỏ...)" required>

  <button type="submit">💾 Lưu bài tập</button>
  <a href="study.php"><button type="button" class="back">⬅ Quay lại</button></a>
</form>

<script>
function previewImage(event) {
  const preview = document.getElementById('preview');
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
    }
    reader.readAsDataURL(file);
  }
}
</script>

</body>
</html>
