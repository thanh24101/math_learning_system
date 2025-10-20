<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include("database.php");


if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}


$unreadCount = 0;
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM notifications WHERE receiver_id = ? AND is_read = 0");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $unreadCount = $stmt->get_result()->fetch_assoc()["total"];
}
?>

<style>
  body { font-family: Arial, sans-serif; margin: 30px; }
  nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .menu-left a {
    margin-right: 15px;
    text-decoration: none;
    color: purple;
    font-weight: bold;
    position: relative;
  }
  .menu-left a:hover {
    text-decoration: underline;
  }

 
  .badge {
    background: red;
    color: white;
    border-radius: 50%;
    padding: 3px 7px;
    font-size: 12px;
    position: absolute;
    top: -6px;
    right: -12px;
  }

  .account-menu {
    position: relative;
    display: inline-block;
    font-weight: bold;
  }

  .account-btn {
    background: none;
    border: none;
    color: purple;
    cursor: pointer;
    font-size: 15px;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #f9f9f9;
    min-width: 180px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    border-radius: 6px;
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
  }

  .dropdown-content a:hover {
    background-color: #f1f1f1;
  }

  .account-menu:hover .dropdown-content {
    display: block;
  }

  .logout {
    color: crimson;
    font-weight: bold;
  }

  hr { margin-top: 20px; }
</style>

<h1>Math Learning System</h1>

<nav>
  <div class="menu-left">
    <a href="home.php">Home</a>
    <a href="study.php">Study</a>

    
    <a href="notification.php">
      Notification
      <?php if ($unreadCount > 0): ?>
        <span class="badge"><?php echo $unreadCount; ?></span>
      <?php endif; ?>
    </a>

    <a href="statistics.php">Statistics</a>
  </div>

  <div class="account-menu">
    <button class="account-btn">
      👤 <?php echo $_SESSION["username"]; ?> ▼
    </button>
    <div class="dropdown-content">
      <a href="profile.php">Thông tin cá nhân</a>
      <a href="change_password.php">Đổi mật khẩu</a>
      <a href="logout.php" class="logout">Đăng xuất</a>
    </div>
  </div>
</nav>

<hr>
