<?php
session_start();
include("database.php");
include("include/header.php");

$role = $_SESSION["role"];
$user_id = $_SESSION["user_id"];
?>

<h2>📚 Học tập</h2>

<div class="tabs">
  <button onclick="openTab('baihoc')" class="tab-btn active">📘 Bài học</button>
  <button onclick="openTab('baitap')" class="tab-btn">🧮 Bài tập</button>
  <button onclick="openTab('trochoi')" class="tab-btn">🎮 Trò chơi</button>
</div>
<hr>


<div id="baihoc" class="tab-content" style="display:block;">
  <?php if ($role == 'giaovien' || $role == 'admin'): ?>
  <div class="action-bar">
    <a href="add_lesson.php"><button>➕ Thêm bài giảng</button></a>
  </div>
  <?php endif; ?>

  <?php
  
  if ($role == 'tre') {
      $sql = "
          SELECT l.*, s.status, s.progress
          FROM lessons l
          LEFT JOIN studies s ON s.lesson_id = l.id AND s.user_id = $user_id
          ORDER BY l.id DESC
      ";
  } else {
      $sql = "SELECT * FROM lessons ORDER BY id DESC";
  }

  $lessons = $conn->query($sql);
  if ($lessons->num_rows > 0):
    while ($l = $lessons->fetch_assoc()):
      $lesson_id = $l['id'];
  ?>
    <div class="card">
      <h3>📘 <?php echo htmlspecialchars($l['title']); ?></h3>
      <p><?php echo htmlspecialchars($l['description']); ?></p>
      <small>👩‍🏫 Người tạo: <?php echo $l['created_by']; ?> | 📅 <?php echo $l['created_at']; ?></small><br>

      <?php if ($role == 'tre'): ?>
        <?php
          $status = $l['status'] ?? 'chua_hoc';
          $progress = $l['progress'] ?? 0;

        
          $avg_q = $conn->query("
            SELECT AVG(es.score) AS avg_score
            FROM exercise_submissions es
            JOIN exercises e ON es.exercise_id = e.id
            WHERE es.user_id = $user_id AND e.lesson_id = $lesson_id
          ");
          $avg_score = $avg_q->fetch_assoc()["avg_score"] ?? 0;
        ?>

        <div class="progress-info">
          <p>📊 <b>Trạng thái:</b>
            <?php
              if ($status == 'chua_hoc') echo "<span style='color:gray;'>Chưa học</span>";
              elseif ($status == 'dang_hoc') echo "<span style='color:orange;'>Đang học</span>";
              elseif ($status == 'hoan_thanh') echo "<span style='color:green;'>Hoàn thành</span>";
            ?>
          </p>

          <p>📈 Tiến độ: <?php echo $progress; ?>%  
             | ⭐ <b>Điểm trung bình:</b> <?php echo round($avg_score * 10, 1); ?>/10
          </p>

          <?php if ($status == 'chua_hoc'): ?>
            <a href="join_study.php?lesson_id=<?php echo $lesson_id; ?>">
              <button class="join-btn">🚀 Tham gia bài học</button>
            </a>
          <?php elseif ($status == 'dang_hoc'): ?>
            <a href="view_lesson.php?id=<?php echo $lesson_id; ?>"><button>▶️ Vào bài học</button></a>
            <a href="complete_study.php?lesson_id=<?php echo $lesson_id; ?>">
              <button class="done-btn">✅ Hoàn thành</button>
            </a>
          <?php elseif ($status == 'hoan_thanh'): ?>
            <a href="view_lesson.php?id=<?php echo $lesson_id; ?>"><button>📖 Xem lại bài</button></a>
          <?php endif; ?>
        </div>

      <?php else: ?>
        <a href="view_lesson.php?id=<?php echo $lesson_id; ?>"><button>▶️ Xem bài giảng</button></a>
        <a href="delete_lesson.php?id=<?php echo $lesson_id; ?>" 
           onclick="return confirm('Xóa bài giảng này và toàn bộ dữ liệu liên quan?')">
          <button class="delete-btn">❌ Xóa</button>
        </a>
      <?php endif; ?>
    </div>
  <?php endwhile; else: ?>
    <p>📭 Chưa có bài học nào.</p>
  <?php endif; ?>
</div>


<div id="baitap" class="tab-content" style="display:none;">
  <?php if ($role == 'giaovien' || $role == 'admin'): ?>
  <div class="action-bar">
    <a href="add_exercise.php"><button>➕ Thêm bài tập</button></a>
  </div>
  <?php endif; ?>

  <?php
  $exs = $conn->query("
    SELECT e.*, l.title AS lesson_title 
    FROM exercises e 
    LEFT JOIN lessons l ON e.lesson_id = l.id 
    ORDER BY e.id DESC
  ");
  if ($exs->num_rows > 0):
    while ($ex = $exs->fetch_assoc()):
  ?>
    <div class="card">
      <h3>🧮 <?php echo htmlspecialchars($ex['question']); ?></h3>
      <small>📘 Bài giảng: <?php echo htmlspecialchars($ex['lesson_title']); ?></small><br>
      <a href="view_exercise.php?id=<?php echo $ex['id']; ?>"><button>✏️ Làm bài</button></a>

      <?php if ($role == 'giaovien' || $role == 'admin'): ?>
        <a href="delete_exercise.php?id=<?php echo $ex['id']; ?>" onclick="return confirm('Xóa bài tập này?')">
          <button class="delete-btn">❌ Xóa</button>
        </a>
      <?php endif; ?>
    </div>
  <?php endwhile; else: ?>
    <p>📭 Chưa có bài tập nào.</p>
  <?php endif; ?>
</div>


<div id="trochoi" class="tab-content" style="display:none;">
  <?php if ($role == 'giaovien' || $role == 'admin'): ?>
  <div class="action-bar">
    <a href="add_game.php"><button>➕ Thêm trò chơi</button></a>
  </div>
  <?php endif; ?>

  <?php
  $games = $conn->query("
    SELECT g.*, l.title AS lesson_title 
    FROM game_links g
    LEFT JOIN lessons l ON g.lesson_id = l.id
    ORDER BY g.id DESC
  ");
  if ($games->num_rows > 0):
    while ($g = $games->fetch_assoc()): ?>
    <div class="card">
      <h3>🎮 <?php echo htmlspecialchars($g['lesson_title'] ?: 'Trò chơi'); ?></h3>
      <p><?php echo htmlspecialchars($g['description']); ?></p>
      <a href="<?php echo htmlspecialchars($g['game_url']); ?>" target="_blank"><button>▶️ Chơi ngay</button></a>
    </div>
  <?php endwhile; else: ?>
    <p>📭 Chưa có trò chơi nào.</p>
  <?php endif; ?>
</div>

<style>
  .tabs { margin-top: 15px; }
  .tab-btn { background: #eee; border: none; padding: 8px 16px; cursor: pointer;
             border-radius: 8px; margin-right: 5px; font-weight: bold; }
  .tab-btn.active { background: purple; color: white; }

  .card { border: 1px solid #ccc; padding: 15px; margin: 10px 0;
          border-radius: 8px; background: #fafafa; }
  .progress-info { background: #fff; padding: 10px; border-radius: 6px; margin-top: 8px; }
  .join-btn { background: dodgerblue; color: white; border: none; padding: 6px 12px;
              border-radius: 6px; cursor: pointer; }
  .done-btn { background: green; color: white; border: none; padding: 6px 12px;
              border-radius: 6px; cursor: pointer; }
  .delete-btn { background: crimson; color: white; border: none; padding: 4px 10px;
                border-radius: 5px; cursor: pointer; }
  .delete-btn:hover { background: darkred; }
</style>

<script>
function openTab(tabName) {
  document.querySelectorAll('.tab-content').forEach(div => div.style.display = 'none');
  document.getElementById(tabName).style.display = 'block';
  document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
  event.target.classList.add('active');
}
</script>

<?php include("include/footer.html"); ?>
