<?php
require_once ('checkLogin.php');
require_once ('databaseConnection.php');

$leaderboard = $_SESSION['leaderboard'];

$sql = "SELECT label FROM leaderboardInfo WHERE id = :id";
$stm = $pdo->prepare($sql);
$stm->execute(array(
    'id' => $leaderboard
));
$res = $stm->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Update user</title>
</head>
<body>
	<div class="container">
		<div class="col-md-9">
			<form action="changeLabel.php" method="post">
				<div>
					<label for="label" class="control-label">Label</label>
					<?php echo '<input type="text" name="label" id="label" value="' . $res['label'] . '" required>'; ?>
				</div>
				<div>
					<button type="button; submit">Submit</button>
				</div>
			</form>
			
		</div>
	</div>
</body>
</html>
