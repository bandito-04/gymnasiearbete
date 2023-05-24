<?php
require_once ('checkLogin.php');
require_once ('databaseConnection.php');

#Tar id från result som man klickar på
$id = trim($_GET['id']);

#Tar bort från databasen
$sql = "DELETE FROM Result WHERE id = :id;";
$stm = $pdo->prepare($sql);
$stm->execute(array(
    'id' => $id
));

header('location: admin.php?mess=User with id:' . $id . 'is removed');
?>
