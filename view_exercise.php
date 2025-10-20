<?php
session_start();
include("database.php");
include("include/header.php");

if (!isset($_GET["id"])) die("<p style='color:red;'>❌ Thiếu ID bài tập!</p>");
$exercise_id = intval($_GET["id"]);

$exercise = $conn->query("
  SELECT e.*, l.title AS lesson_title
  FROM exercises e
  LEFT JOIN lessons l ON e.lesson_id = l.id
  WHERE e.id = $exercise_id
")->fetch_assoc();

if (!$exercise) die("<p style='color:red;'>❌ Không tìm thấy bài tập!</p>");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Bài tập - <?php echo htmlspecialchars($exercise['lesson_title']); ?></title>
  <style>
    body { font-family: Arial, sans-serif; background: #f8f8f8; margin: 30px; }
    .container {
      background: #fff; border-radius: 10px; padding: 25px;
      max-width: 750px; margin: auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 { color: purple; }
    h3 { color: #444; margin-top: 25px; }
    img {
      max-width: 100%; border-radius: 10px; margin-top: 10px;
      border: 1px solid #ddd; display: block; margin-bottom: 20px;
    }
    .question {
      background: #f4f4f4; padding: 12px; border-radius: 8px;
      margin-top: 10px; font-size: 16px; line-height: 1.6;
    }
    input[type="text"] {
      width: 100%; padding: 8px; margin-top: 10px;
      border-radius: 6px; border: 1px solid #ccc;
    }
    button {
      background: purple; color: white; border: none; padding: 10px 18px;
      border-radius: 6px; cursor: pointer; margin-top: 15px;
      font-weight: bold;
    }
    button:hover { background: #5e2b97; }
    .back { background: gray; }
    .back:hover { background: #333; }
    hr { margin: 20px 0; }
  </style>
</head>
<body>

<div class="container">
  <h2>🧮 Bài tập từ bài giảng: <?php echo htmlspecialchars($exercise["lesson_title"]); ?></h2>
  <hr>

  <h3>❓ Câu hỏi:</h3>
  <div class="question">
    <?php echo nl2br(htmlspecialchars($exercise["question"])); ?>
  </div>

  <?php if (!empty($exercise["answer"]) ): ?>
    <h3>🖼 Hình ảnh bài tập:</h3>
    <img src="<?php echo htmlspecialchars($exercise["answer"]); ?>" alt="Hình bài tập">
  <?php endif; ?>

  <form method="POST" action="submit_exercise.php">
    <input type="hidden" name="exercise_id" value="<?php echo $exercise_id; ?>">
    <label>✏️ Nhập đáp án của bạn:</label>
    <input type="text" name="answer_text" placeholder="Nhập câu trả lời..." required>
    <button type="submit">📤 Nộp bài</button>
    <a href="study.php"><button type="button" class="back">⬅ Quay lại</button></a>
  </form>

</div>
</body>
</html>
