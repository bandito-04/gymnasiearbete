<?php
require_once ('databaseConnection.php');

#Tar emot data
$username = trim($_POST['username']);
$password = sha1(trim($_POST['password']));
$label = trim($_POST['label']);
$name = trim($_POST['name']);

#Funktion som kollar om string har dåliga karaktärer
function containsIllegalChars($input)
{
    $illegalChars = array(
        "'",
        '"',
        "<",
        "|",
        ">",
        ",",
        ".",
        "=",
        "-"
    );

    foreach ($illegalChars as $key)
    {
        if (str_contains($input, $key))
        {
            return true;
        }
    }
    return false;
}

# Om input innehåller dåliga karaktärer skickas man tillbaka till index...
if (containsIllegalChars($label) or containsIllegalChars($name))
{
    header("location: index.php?mess=Input contains illegal characters");
}
else
{

    #... annars skapar man posten i databasen
    $sql = "INSERT INTO leaderboardInfo (name, label, username, password) VALUES (:name, :label, :username, :password)";
    $stm = $pdo->prepare($sql);
    $stm->bindParam(':name', $name);
    $stm->bindParam(':label', $label);
    $stm->bindParam(':username', $username);
    $stm->bindParam(':password', $password);
    $stm->execute(array(
        'name' => $name,
        'label' => $label,
        'username' => $username,
        'password' => $password
    ));
    $lastId = $pdo->lastInsertId();

    header("location: index.php?mess=A leaderboard has been created");
}

?>
