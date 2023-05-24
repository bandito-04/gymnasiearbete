<?php 
require_once('databaseConnection.php');
$leaderboard = $_SESSION['leaderboard'];


$sql = "SELECT CONCAT(JSON_OBJECT('id', id, 'score', score, 'timecreate', timecreate)) FROM Result WHERE leaderboard = $leaderboard";
$stm = $pdo->prepare($sql);
$stm->execute();
$res = $stm->fetchAll(PDO::FETCH_ASSOC);

echo $res
 ?>