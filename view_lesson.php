<?php
session_start();
include("database.php");
include("include/header.php");

if (!isset($_GET["id"])) {
  die("<p style='color:red;'>❌ Thiếu ID bài giảng.</p>");
}

$id = intval($_GET["id"]);
$lesson = $conn->query("SELECT * FROM lessons WHERE id=$id")->fetch_assoc();

if (!$lesson) {
  die("<p style='color:red;'>❌ Không tìm thấy bài giảng.</p>");
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($lesson["title"]); ?></title>
  <style>
    body { font-family: Arial, sans-serif; background: #f8f8f8; margin: 30px; }
    .container {
      background: #fff; border-radius: 10px; padding: 25px;
      max-width: 900px; margin: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    h2 { color: purple; }
    video, iframe { width: 100%; border-radius: 8px; margin-top: 15px; }
    .desc { margin-top: 10px; font-size: 16px; line-height: 1.5; background:#f5f5f5; padding:10px; border-radius:8px; }
    button {
      background: gray; color: white; border: none; padding: 8px 14px;
      border-radius: 6px; cursor: pointer; font-weight: bold;
    }
    button:hover { background: #333; }
    hr { margin: 20px 0; }
    .complete-btn {
  background: green;
  color: white;
  border: none;
  padding: 8px 14px;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.2s;
}
.complete-btn:hover {
  background: darkgreen;
}

  </style>
</head>
<body>

<div class="container">
  <h2>📘 <?php echo htmlspecialchars($lesson["title"]); ?></h2>
  <small>👩‍🏫 Người tạo: ID <?php echo $lesson["created_by"]; ?> | 📅 <?php echo $lesson["created_at"]; ?></small>

  <hr>

  <h3>📖 Nội dung bài học</h3>
  <div class="desc">
    <?php
   
    if ($lesson["media_type"] == "video" && $lesson["media_url"]) {
      if (strpos($lesson["media_url"], "youtube") !== false || strpos($lesson["media_url"], "youtu.be") !== false) {
        $embed = preg_replace(["/watch\\?v=/", "/youtu\\.be\\//"], ["embed/", "embed/"], $lesson["media_url"]);
        echo "<iframe height='400' src='$embed' frameborder='0' allowfullscreen></iframe>";
      } else {
        echo "<video controls><source src='{$lesson["media_url"]}' type='video/mp4'></video>";
      }
    }
    elseif ($lesson["media_type"] == "file" && $lesson["media_url"]) {
      echo "<p>📄 <a href='{$lesson["media_url"]}' target='_blank'>Xem hoặc tải tài liệu tại đây</a></p>";
    }
    else {
      echo nl2br(htmlspecialchars($lesson["content"] ?: $lesson["description"] ?: "Không có nội dung hiển thị."));
    }
    ?>
   

  </div>

  <hr>

  <div style="text-align:center;">
    <a href="study.php"><button>⬅ Quay lại danh sách bài học</button></a>
  </div>
</div>

</body>
</html>
