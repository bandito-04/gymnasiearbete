<?php
require_once ('databaseConnection.php');

#Tar emot datan som finns i länken
$score = trim($_POST['score']);
$leaderboard = trim($_POST['leaderboard']);
$auth = trim($_POST['auth']);

if ($auth == pow($score, 2))
{
    $sql = "INSERT INTO Result (leaderboard, score) VALUES (:leaderboard ,:score)";
    $stm = $pdo->prepare($sql);
    $stm->bindParam(':leaderboard', $leaderboard);
    $stm->bindParam(':score', $score);
    $stm->execute(array(
        'leaderboard' => $leaderboard,
        'score' => $score,
    ));
}
?>
