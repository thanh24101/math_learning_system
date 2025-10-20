<?php
include("database.php");
$id = $_GET['id'];
$conn->query("DELETE FROM game_links WHERE id=$id");
header("Location: study.php");
exit;
?>
