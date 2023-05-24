<?php
session_start();
require_once ('databaseConnection.php');

#Tar emot data
$leaderboard = $_SESSION['leaderboard'];
$username = trim($_POST['username']);
$password = sha1(trim($_POST['password']));

#Kollar om den kan hitta data i databasen med den datan man anledde
$sql = "SELECT * FROM leaderboardInfo WHERE username = :username AND password = :password AND id = $leaderboard";
$stm = $pdo->prepare($sql);
$stm->execute(array(
    'username' => $username,
    'password' => $password
));
$result = $stm->fetch(PDO::FETCH_ASSOC);

#Om det fanns data så loggas man in data sätts in i sessions
if (isset($result['name']))
{
    $_SESSION['username'] = $username;
    $_SESSION['name'] = $result['name'];
    header('location: admin.php');
}
else
{
    header("location: leaderboard.php?leaderboard=$leaderboard&mess=Wrong username or password");
}

