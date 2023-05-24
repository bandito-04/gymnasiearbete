<?php
require_once ('databaseConnection.php');
session_start();
$mess = isset($_GET['mess']) ? "<p class='text-light'>" . $_GET['mess'] . "</p>" : "";

#Kollar om leaderboarden med ett visst id finns och lägger det id i session
if (!isset($_GET['leaderboard'])) header('location: index.php?mess=Leaderboard does not exist');
else
{
    $leaderboard = $_GET['leaderboard'];
}

$_SESSION['leaderboard'] = $leaderboard;

#Tar label från databas
$sql = "SELECT label FROM leaderboardInfo WHERE id = $leaderboard";
$stm = $pdo->prepare($sql);
$stm->execute();
$res = $stm->fetchAll(PDO::FETCH_ASSOC);

$table = "\n<table id='leaderboard' class='table table-striped table-hover display'>";
$table .= "\n\t<thead>\n\t\t<tr>\n\t\t\t<th>ID</th>\n\t\t\t<th>" . $res[0]['label'] . "</th>\n\t\t\t<th>DateTime</th>\n\t\t</tr>\n\t</thead>\n\t<tbody>";

#Tar results från databas...
if (isset($_GET['date']) == "today")
{
    $currentDate = date('Y-m-d');
    $sql = "SELECT * FROM Result WHERE leaderboard = $leaderboard AND timecreate > ('$currentDate') ORDER BY id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $res = $stm->fetchAll(PDO::FETCH_ASSOC);
}
else
{
    $sql = "SELECT * FROM Result WHERE leaderboard = $leaderboard ORDER BY id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $res = $stm->fetchAll(PDO::FETCH_ASSOC);
}

#... och skapar ett table med den datan
foreach ($res as $row)
{
    $table .= "\n\t\t<tr>";
    $table .= "\n\t\t<td>" . $row['id'] . "</td>";
    $table .= "\n\t\t<td>" . $row['score'] . "</td>";
    $table .= "\n\t\t<td>" . $row['timecreate'] . "</td>";
    $table .= "\n\t\t</tr>";
}
$table .= "\n\t</tbody>\n</table>";
?>

<!DOCTYPE html>
<html lang="sv">
   <head>
      <meta charset="utf-8">
      <title>Leaderboard</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="main.css">
          <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
    $('#leaderboard').DataTable();
});
    </script>
   </head>
   <body>
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <h1 class="modal-title fs-5" id="modalLabel">Log In</h1>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
           <form method="post" action="login.php" id="loginModal">
            <div class="mb-3">
               <label for="username" class="form-label">Username</label>
               <input type="text" name="username" id="username" class="form-control" required>
            </div>   
            <div>
               <label for="password" class="form-label">Password</label>
               <input type="password" name="password" id="password" class="form-control" required>             
            </div>
           </form>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
           <button form="loginModal" type="button; submit" class="btn btn-purple">Log In</button>
         </div>
       </div>
     </div>
   </div>
      <main>
         <div class="container">
            <?php echo $mess; ?>
            <button type="button" class="btn btn-light mb-3">
               <a href="index.php" class="nav-link nohigh text-dark fs-5">Back</a>
            </button>
            <button type="button" class="btn btn-light mb-3">
               <a data-bs-toggle="modal" data-bs-target="#modal" class="nav-link nohigh text-dark fs-5">Log In</a>
            </button>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-3">
                    <button type="button" class="btn btn-light mb-3 fs-5" onclick="myFunction1()">Today's scores</button>
                </div>
                <div class="col-2"></div>
                <div class="col-3">
                    <button type="button" class="btn btn-light mb-3 fs-5" onclick="myFunction()">All-time scores</button>
                </div>
                <div class="col-2"></div>
            </div>

            <div class="col-md">
               <div class="toplist p-3 Lato">

                  <?php
#Skriver ut table
echo $table;
?>
               </div>
            </div>
         </div>
      </main>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
      <script type="text/javascript">
          function myFunction(){
            var url = "https://bandito.online/toplist/leaderboard.php?leaderboard=<?php echo ($leaderboard) ?>"
            location.replace(url)
          }
            function myFunction1(){
            var url = "https://bandito.online/toplist/leaderboard.php?leaderboard=<?php echo ($leaderboard) ?>&date=today"
            location.replace(url)
          }
      </script>
   </body>
</html>