<?php
if (strcmp($_SERVER['SERVER_NAME'], "localhost") == 0)
{
    $host = "localhost";
    $user = "root";
    $pwd = "root";
    $db = "board";
}
else
{
    $host = "alstrom.hemsida.eu";
    $user = "alstromh_040320sh";
    $pwd = "rA5#9!SIiuCn";
    $db = "alstromh_040320sh";
}

$dsn = "mysql:host=" . $host . ";dbname=" . $db;

$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES,
    false
);

try
{
    $pdo = new PDO($dsn, $user, $pwd, $options);
}
catch(Exception $e)
{
    die('Could not connect to the database:<br/>' . $e);
}
?>
