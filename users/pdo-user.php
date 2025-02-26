<?php
require_once('../daiski/pdo_connect.php');

if (!isset($_GET["id"])) {
	echo "參數缺失";
	exit;
}

$id = $_GET["id"];

$sql = "SELECT * FROM users WHERE id=? AND valid=1";
$stmt = $db_host->prepare($sql);

try {
	$stmt->execute([$id]);
	$row = $stmt->fetch();
	// echo "<pre>";
	// print_r($row);
	// echo "</pre>";

} catch (PDOException $e) {
	echo "預處理陳述式執行失敗！ <br/>";
	echo "Error: " . $e->getMessage() . "<br/>";
	$db_host = NULL;
	exit;
}

?>
<!doctype html>
<html lang="zh-TW">

<head>
	<title>Users</title>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<?php include("../daiski/css.php") ?>
</head>

<body>
	<div class="container">
		<div class="py-2">
			<a class="btn btn-primary" href="pdo-users.php"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
		</div>
		<?php if (isset($_GET["id"])): ?>
			<div class="row">
				<div class="col-lg-4 col-md-9">
					<table class="table table-bordered">
						<tr>
							<th>id</th>
							<td><?= $row["id"] ?></td>
						</tr>
						<tr>
							<th>name</th>
							<td><?= $row["name"] ?></td>
						</tr>
						<tr>
							<th>account</th>
							<td><?= $row["account"] ?></td>
						</tr>
						<tr>
							<th>phone</th>
							<td><?= $row["phone"] ?></td>
						</tr>
						<tr>
							<th>birthday</th>
							<td><?= $row["birthday"] ?></td>
						</tr>
						<tr>
							<th>createdtime</th>
							<td><?= $row["createdtime"] ?></td>
						</tr>
						<tr>
							<th>isCoach</th>
							<td>
								<?php if ($row["isCoach"] == 0): ?>
									否
								<?php else: ?>
									是
								<?php endif; ?>
							</td>
						</tr>
					</table>
					<div class="">
						<a class="btn btn-primary" href="user-edit.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-pen-to-square fa-fw"></i></a>
					</div>
				</div>
			</div>
		<?php else: ?>
			<h2>使用者不存在</h2>
		<?php endif; ?>
	</div>
</body>

</html>