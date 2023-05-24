<?php
require_once ('checkLogin.php');
require_once ('databaseConnection.php');

$id = trim($_GET['id']);

$sql = "SELECT * FROM Result WHERE id = :id";
$stm = $pdo->prepare($sql);
$stm->execute(array(
    'id' => $id
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
			<form action="updateScore.php" method="post">
				<div>
					<label for="score" class="control-label">Score</label>
					<?php echo '<input type="score" name="score" id="score" value="' . $res['score'] . '" required>'; ?>
				</div>
				<input type="hidden" name="id" value="<?php echo $res['id'] ?>">
				<div>
					<button type="button; submit">Submit</button>
				</div>
			</form>
			
		</div>
	</div>
</body>
</html>
