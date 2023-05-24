<?php
require_once ('checkLogin.php');
require_once ('databaseConnection.php');

#Tar emot data
$leaderboard = $_SESSION['leaderboard'];
$label = trim($_POST['label']);

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

# Om input innehåller dåliga karaktärer skickas man tillbaka till admin...
if (containsIllegalChars($label))
{
    header("location: admin.php?mess=Input contains illegal characters");
}
else
{

    #... annars uppdaterar man posten i databasen
    $sql = "UPDATE leaderboardInfo SET label = :label WHERE id = :id";
    $stm = $pdo->prepare($sql);
    $stm->bindParam(':label', $label);
    $stm->execute(array(
        'label' => $label,
        'id' => $leaderboard
    ));

    header("location: admin.php?mess=Label has been updated");
}
?>
