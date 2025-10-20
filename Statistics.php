<?php
session_start();
include("database.php");
include("include/header.php");


if (!isset($_SESSION["role"])) {
  die("<p style='color:red;'>⛔ Bạn chưa đăng nhập.</p>");
}

$role = $_SESSION["role"];
$user_id = $_SESSION["user_id"];
?>

<h2>📊 Thống kê học tập</h2>
<hr>

<?php

if ($role == 'giaovien' || $role == 'admin') {
    $sql = "SELECT * FROM study_statistics ORDER BY avg_progress DESC";
} 

elseif ($role == 'tre') {
    $sql = "SELECT * FROM study_statistics WHERE user_id = $user_id";
} 

elseif ($role == 'phuhuynh') {
    echo "<p>👨‍👩‍👧 Chức năng thống kê cho phụ huynh đang được phát triển...</p>";
    exit;
}
else {
    die("<p style='color:red;'>Không xác định được vai trò người dùng.</p>");
}

$result = $conn->query($sql);
?>

<div class="stats-container">
  <table>
    <thead>
      <tr>
        <th>👤 Học sinh</th>
        <th>📚 Tổng số bài học</th>
        <th>✅ Đã hoàn thành</th>
        <th>📈 Tiến độ trung bình (%)</th>
        <th>⭐ Điểm trung bình (/10)</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
      ?>
        <tr>
          <td><?php echo htmlspecialchars($row['student_name']); ?></td>
          <td><?php echo $row['total_lessons']; ?></td>
          <td><?php echo $row['lessons_completed']; ?></td>
          <td><?php echo number_format($row['avg_progress'], 2); ?>%</td>
          <td><?php echo number_format($row['avg_score'], 2); ?></td>
        </tr>
      <?php
        endwhile;
      else:
        echo "<tr><td colspan='5'><i>Không có dữ liệu thống kê.</i></td></tr>";
      endif;
      ?>
    </tbody>
  </table>
</div>

<style>
  body { font-family: Arial, sans-serif; margin: 30px; background: #f8f8f8; }
  h2 { color: purple; }
  .stats-container {
    margin-top: 20px;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  th, td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #ddd;
  }
  th {
    background-color: purple;
    color: white;
  }
  tr:hover {
    background-color: #f1f1f1;
  }
</style>

<?php include("include/footer.html"); ?>
