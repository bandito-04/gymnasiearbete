<?php 
$score = trim($_POST['score']);
$signature = trim(strtoupper($_POST['sign']));
$leaderboard = trim($_POST['leaderboard']);
$auth = trim($_POST['auth']);

$data = $score." - ".$signature." - ".$leaderboard." - ".$auth;

file_put_contents($data, 'result.txt');
 ?>