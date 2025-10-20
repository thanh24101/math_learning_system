<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
  die("<p style='color:red;'>❌ Bạn cần đăng nhập để nộp bài.</p>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_id = $_SESSION["user_id"];
  $exercise_id = intval($_POST["exercise_id"]);
  $answer_text = trim($_POST["answer_text"]);

  
  $stmt = $conn->prepare("SELECT correct_answer, lesson_id FROM exercises WHERE id=?");
  $stmt->bind_param("i", $exercise_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $exercise = $result->fetch_assoc();

  if (!$exercise) {
    die("<p style='color:red;'>❌ Không tìm thấy bài tập.</p>");
  }

  $correct_answer = strtolower(trim($exercise["correct_answer"]));
  $lesson_id = intval($exercise["lesson_id"]);

 
  $is_correct = (strtolower($answer_text) == $correct_answer) ? 1 : 0;
  $score = $is_correct ? 1 : 0; 


  $stmt = $conn->prepare("
    INSERT INTO exercise_submissions (exercise_id, user_id, answer_text, is_correct, score, submitted_at)
    VALUES (?, ?, ?, ?, ?, NOW())
  ");
  $stmt->bind_param("iisii", $exercise_id, $user_id, $answer_text, $is_correct, $score);
  $stmt->execute();

  $sql_avg = "
    SELECT AVG(es.score) AS avg_score
    FROM exercise_submissions es
    JOIN exercises e ON es.exercise_id = e.id
    WHERE es.user_id = ? AND e.lesson_id = ?
  ";
  $stmt_avg = $conn->prepare($sql_avg);
  $stmt_avg->bind_param("ii", $user_id, $lesson_id);
  $stmt_avg->execute();
  $avg_result = $stmt_avg->get_result()->fetch_assoc();
  $avg_score = $avg_result["avg_score"] ?? 0;


  $progress = round($avg_score * 100);

 
  $check = $conn->query("SELECT * FROM studies WHERE user_id=$user_id AND lesson_id=$lesson_id");
  if ($check->num_rows > 0) {
    $conn->query("
      UPDATE studies 
      SET progress=$progress, status=IF($progress>=100,'hoan_thanh','dang_hoc')
      WHERE user_id=$user_id AND lesson_id=$lesson_id
    ");
  } else {
    $status = ($progress >= 100) ? 'hoan_thanh' : 'dang_hoc';
    $stmt2 = $conn->prepare("
      INSERT INTO studies (user_id, lesson_id, progress, status, start_time)
      VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt2->bind_param("iiis", $user_id, $lesson_id, $progress, $status);
    $stmt2->execute();
  }

  // ✅ Thông báo kết quả
  if ($is_correct) {
    echo "<script>alert('🎉 Chính xác! Bạn đã được +1 điểm.\\nĐiểm trung bình hiện tại: " . round($avg_score * 10, 1) . "/10'); window.location='study.php';</script>";
  } else {
    echo "<script>alert('❌ Sai rồi, hãy thử lại nhé!\\nĐiểm trung bình hiện tại: " . round($avg_score * 10, 1) . "/10'); window.location='study.php';</script>";
  }
}
?>
