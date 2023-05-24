<?php
require_once ('checkLogin.php');
require_once ('databaseConnection.php');

#Tar id på leaderboard som ör aktiv
$leaderboard = $_SESSION['leaderboard'];

#Tar bort den leaderboard som är aktiv
$sql = "DELETE FROM leaderboardInfo WHERE id = :id";
$stm = $pdo->prepare($sql);
$stm->execute(array(
    'id' => $leaderboard
));

#Tar bort results från aktiv leaderboard
$sql = "DELETE FROM Result WHERE leaderboard = :leaderboard";
$stm = $pdo->prepare($sql);
$stm->execute(array(
    'leaderboard' => $leaderboard
));

session_unset();
session_destroy();
header('location: index.php?mess=Leaderboard was removed');
?>
