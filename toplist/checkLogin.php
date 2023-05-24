<?php
session_start();

if (!isset($_SESSION['username']))
{
    header('location: leaderboard.php?mess=Your not logged in');
} ?>
