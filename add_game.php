<?php
session_start();
include("database.php");

if (!isset($_SESSION["role"]) || !in_array($_SESSION["role"], ["giaovien", "admin"])) {
  die("<p style='color:red;'>⛔ Bạn không có quyền truy cập trang này.</p>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $lesson_id = $_POST["lesson_id"];
  $game_url = $_POST["game_url"];
  $description = $_POST["description"];

  $stmt = $conn->prepare("INSERT INTO game_links (lesson_id, game_url, description) VALUES (?, ?, ?)");
  $stmt->bind_param("iss", $lesson_id, $game_url, $description);
  $stmt->execute();

  echo "<script>alert('🎮 Thêm trò chơi thành công!'); window.location='study.php';</script>";
  exit;
}

$lessons = $conn->query("SELECT id, title FROM lessons ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>➕ Thêm trò chơi</title>
  <style>
    body { font-family: Arial; background: #f8f8f8; margin: 40px; }
    form { background: #fff; padding: 25px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    input, textarea, select { width: 100%; padding: 8px; margin-top: 8px; border: 1px solid #ccc; border-radius: 6px; }
    button { background: purple; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; margin-top: 15px; }
    button:hover { background: #5e2b97; }
    .back { background: gray; margin-left: 10px; }
    .back:hover { background: #333; }
  </style>
</head>
<body>

<form method="POST">
  <h2>🎮 Thêm trò chơi mới</h2>

  <label>Thuộc bài học:</label>
  <select name="lesson_id" required>
    <option value="">-- Chọn bài học --</option>
    <?php while ($l = $lessons->fetch_assoc()): ?>
      <option value="<?php echo $l['id']; ?>"><?php echo htmlspecialchars($l['title']); ?></option>
    <?php endwhile; ?>
  </select>

  <label>Link trò chơi (URL):</label>
  <input type="text" name="game_url" placeholder="https://..." required>

  <label>Mô tả:</label>
  <textarea name="description" rows="3"></textarea>

  <button type="submit">💾 Lưu trò chơi</button>
  <a href="study.php"><button type="button" class="back">⬅ Quay lại</button></a>
</form>

</body>
</html>
