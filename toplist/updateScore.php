<?php
require_once ('checkLogin.php');
require_once ('databaseConnection.php');

#Tar emot data
$score = trim($_POST['score']);
$id = trim($_POST['id']);

$sql = "UPDATE Result SET score = :score WHERE id = :id";
$stm = $pdo->prepare($sql);
$stm->bindParam(':score', $score);
$stm->bindParam(':id', $id);
$stm->execute(array(
    'score' => $score,
    'id' => $id
));

header("location: admin.php?mess=Result with id: $id has been updated");
?>
