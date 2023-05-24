<?php
require_once ('checkLogin.php');
require_once ('databaseConnection.php');

$mess = isset($_GET['mess']) ? "<p class='text-error'>" . $_GET['mess'] . "</p>" : "";
$leaderboard = $_SESSION['leaderboard'];

#Tar label från databas
$sql = "SELECT label FROM leaderboardInfo WHERE id = $leaderboard";
$stm = $pdo->prepare($sql);
$stm->execute();
$res = $stm->fetchAll(PDO::FETCH_ASSOC);

$label = $res[0]['label'];

$table = "\n<table class='table text-light'>";
$table .= "\n\t<thead>\n\t\t<tr>\n\t\t\t<th class='text-light'>Id</th>\n\t\t\t<th class='text-light'>" . $label . "</th>\n\t\t\t<th class='text-light'>Signature</th>\n\t\t\t<th class='text-light'>DateTime</th>\n\t\t\t<th class='text-light'>Action</th>\n\t\t</tr>\n\t</thead>\n\t<tbody>";

#Tar results från databas...
$sql = "SELECT * FROM Result WHERE leaderboard = $leaderboard ORDER BY id";
$stm = $pdo->prepare($sql);
$stm->execute();
$res = $stm->fetchAll(PDO::FETCH_ASSOC);

#...och skapar ett table med de
foreach ($res as $row)
{
    $table .= "\n\t\t<tr>";
    $table .= "\n\t\t<td>" . $row['id'] . "</td>";
    $table .= "\n\t\t<td>" . $row['score'] . "</td>";
    $table .= "\n\t\t<td>" . $row['signature'] . "</td>";
    $table .= "\n\t\t<td>" . $row['timecreate'] . "</td>";
    $table .= "\n\t\t<td>[<a href='removeScore.php?id=" . $row['id'] . "'>remove</a>] [<a href='editScore.php?id=" . $row['id'] . "'>edit</a>]</td>";
    $table .= "\n\t\t</tr>";
}
$table .= "\n\t</tbody>\n</table>"
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="container text-light">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <h1>Admin</h1>
            <?php echo $mess; ?>
            <p>You logged in on leaderboard: <?php echo $_SESSION['name']; ?></p>
            <button type="button" class="btn btn-primary mb-3">
                <a href="logout.php" class="text-light nav-link nohigh">Logout</a>
            </button>
            <h2>Link to add externally</h2>
            <button type="button" class="btn btn-warning mb-3" onclick="copyText()">
                <a class="text-dark nav-link nohigh">Copy</a>
            </button>

            <h2>Delete Leaderboard</h2>
            <button type="button" class="btn btn-danger mb-3" onclick="confirmDelete()">
                <a href="deleteLeaderboard.php" class="text-light nav-link nohigh" onclick="return confirm('Are you sure to delete?')">Delete Leaderboard</a>
            </button>
            <h2>Edit Label</h2>
            <button type="button" class="btn btn-info mb-3">
                <a href="editLabel.php" class="text-light nav-link nohigh">Edit Label</a>
            </button>
            <h2>Users</h2>
            <button type="button" class="btn btn-success mb-3">
                <a data-bs-toggle="modal" data-bs-target="#modal" class="text-light nav-link nohigh">Add Score</a>
            </button>


            <?php
#Skriver ut table
echo $table;
?>
            
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalLabel">Add Score</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" action="insertScore.php" id="loginModal">
                <div class="mb-3">
                    <label for="score" class="form-label">Score</label>
                    <input type="number" name="score" id="score" class="form-control" min="1" required>
                </div>  
                <div>
                    <label for="signature" class="form-label">Signature (max 10 chars)</label>
                    <input type="text" name="signature" id="signature" class="form-control" maxlength="10" required>             
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button form="loginModal" type="button; submit" class="btn btn-success">Add Score</button>
          </div>
        </div>
      </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function copyText() {
    alert("Copied!");
<?php
# Skapar länk för att lägga till post externt
echo "navigator.clipboard.writeText('https://bandito.online/toplist/outsideAdd.php?score=<" . $label . " variable>&sign=<signature varible>&auth=<sha1(sign variable)>&leaderboard=" . $leaderboard . "');";

?>
}
</script>
</html>
