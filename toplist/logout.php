<?php

session_start();
$leaderboard = $_SESSION['leaderboard'];
session_unset();
session_destroy();

header("location: leaderboard.php?leaderboard=$leaderboard&date=today");
?>
