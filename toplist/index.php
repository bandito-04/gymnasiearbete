<?php
require_once ('databaseConnection.php');

$mess = isset($_GET['mess']) ? "<h4 class='text-light'>" . $_GET['mess'] . "</h4>" : "";

#Tar name och id på leaderboard från databas...
$sql = "SELECT id, name FROM leaderboardInfo ORDER BY id";
$stm = $pdo->prepare($sql);
$stm->execute();
$res = $stm->fetchAll(PDO::FETCH_ASSOC);

$buttons = "";
#...och skapar en ny button för varje leaderboard
foreach ($res as $row)
{
    $buttons .= "\n<button type='button' class='btn btn-light m-3'>";
    $buttons .= "\n<a href='leaderboard.php?leaderboard=" . $row['id'] . "&date=today' class='nohigh fs-5 text-dark nav-link'>" . $row['name'] . "</a>";
    $buttons .= "\n</button>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home Page</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="main.css">
</head>
<body>
	<main>
		<button>
			<a href="source.php">CSource</a>
		</button>
		<div class="container">
			            <?php echo $mess; ?>
			<div class="row">

				<div class="col-md-6">
					<h1 class="text-light">Create Leaderboard</h1>
				</div>
				<div class="col-md-6">
					<h1 class="text-light">All Leaderboards</h1>
				</div>
			</div>
			<hr class="text-light">	
			<div class="row">
				<div class="col-md-6">
					<button type="button" class="btn btn-light m-3">
						<a data-bs-toggle="modal" data-bs-target="#modal" class="nav-link nohigh text-dark fs-5">Create Leaderboard</a>
					</button>
				</div>
				<div class="col-md-6">
					<?php
# Skriver ut knappar för leaderboards
echo $buttons;
?>
				</div>
			</div>
		</div>
	</main>

	<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="modalLabel">Create Leaderboard</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form method="post" action="createLeaderboard.php" id="createModal">
	        	<div class="mb-3">
	        		<label for="name" class="form-label">Name of Leaderboard</label>
	        		<input type="text" name="name" id="name" class="form-control" maxlength="20" required>
	        	</div>
	        	<div class="mb-3">
		        	<label for="text" class="form-label">Leaderboard Label</label>
		        	<input type="text" name="label" id="label" class="form-control" required>        		
	        	</div>
	        	<div class="mb-3">
		        	<label for="username" class="form-label">Admin Username</label>
		        	<input type="text" name="username" id="username" class="form-control" required>
	        	</div>		
	        	<div>
		        	<label for="password" class="form-label">Admin Password</label>
		        	<input type="password" name="password" id="password" class="form-control" required>        		
	        	</div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        <button form="createModal" type="button; submit" class="btn btn-purple">Create Ledaerboard</button>
	      </div>
	    </div>
	  </div>
	</div>

</body>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</html>
