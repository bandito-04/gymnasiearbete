<?php
require_once ('checkLogin.php');
require_once ('databaseConnection.php');

#Tar emot data
$score = trim($_POST['score']);
$leaderboard = $_SESSION['leaderboard'];

$sql = "INSERT INTO Result (leaderboard, score) VALUES (:leaderboard, :score)";
$stm = $pdo->prepare($sql);
$stm->bindParam(':leaderboard', $leaderboard);
$stm->bindParam(':score', $score);
$stm->execute(array(
    'leaderboard' => $leaderboard,
    'score' => $score
));
$lastId = $pdo->lastInsertId();

header("location: admin.php?mess=Score with id: $lastId have been created");
?>
