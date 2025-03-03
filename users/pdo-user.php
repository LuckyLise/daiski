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
	<style>
		body {
			color: white !important;
			background-color: #07192F;

			table {
				color: white !important;
			}
		}
	</style>
</head>

<body>
	<!-- Loading 畫面 -->
	<div id="loadingOverlay">
    <div class="spinner"></div>
  </div>
	<div class="d-flex flex-column" id="mainContent">
		<?php include("./new_head_mod.php"); ?>
		<div class="d-flex flex-row w-100 myPage">
			<?php include("./new_side_mod.php"); ?>
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
		</div>
	</div>
	<?php include("../daiski/js.php") ?>
	<script>
		VANTA.BIRDS({
			el: ".sidebar", // 指定作用的 HTML 元素 ID
			mouseControls: true, // 啟用滑鼠控制，使動畫會跟隨滑鼠移動
			touchControls: true, // 啟用觸控控制，使動畫可以隨觸控移動
			gyroControls: false, // 禁用陀螺儀控制（手機旋轉時不影響動畫）
			minHeight: 50.00, // 設定最小高度，確保畫面不會小於 200px
			minWidth: 50.00, // 設定最小寬度，確保畫面不會小於 200px
			scale: 1.00, // 設定一般裝置上的縮放比例
			scaleMobile: 2.0, // 在手機上放大 2 倍，以提升可視度
			separation: 100.00, // 調整鳥群之間的間隔，數值越大，距離越大
			color1: 0xffffff,
			birdSize: 0.20,
			speedLimit:2,
			// backgroundColor:0x4e73df
		});

		VANTA.BIRDS({
			el: ".myPage", // 指定作用的 HTML 元素 ID
			mouseControls: true, // 啟用滑鼠控制，使動畫會跟隨滑鼠移動
			touchControls: true, // 啟用觸控控制，使動畫可以隨觸控移動
			gyroControls: false, // 禁用陀螺儀控制（手機旋轉時不影響動畫）
			minHeight: 50.00, // 設定最小高度，確保畫面不會小於 200px
			minWidth: 50.00, // 設定最小寬度，確保畫面不會小於 200px
			scale: 1.00, // 設定一般裝置上的縮放比例
			scaleMobile: 2.0, // 在手機上放大 2 倍，以提升可視度
			separation: 100.00, // 調整鳥群之間的間隔，數值越大，距離越大
			color1: 0xffffff,
			birdSize: 0.20,
			speedLimit:2,
			// backgroundColor:0x4e73df
		});

		VANTA.BIRDS({
			el: ".head", // 指定作用的 HTML 元素 ID
			mouseControls: true, // 啟用滑鼠控制，使動畫會跟隨滑鼠移動
			touchControls: true, // 啟用觸控控制，使動畫可以隨觸控移動
			gyroControls: false, // 禁用陀螺儀控制（手機旋轉時不影響動畫）
			minHeight: 50.00, // 設定最小高度，確保畫面不會小於 200px
			minWidth: 50.00, // 設定最小寬度，確保畫面不會小於 200px
			scale: 1.00, // 設定一般裝置上的縮放比例
			scaleMobile: 2.0, // 在手機上放大 2 倍，以提升可視度
			separation: 100.00, // 調整鳥群之間的間隔，數值越大，距離越大
			color1: 0xffffff,
			birdSize: 0.2,
			speedLimit:2,
			// backgroundColor:0x4e73df
		});
		//VANTA.WAVES({ //目前註解掉
		//  el: "body", //綁在body上會使該網頁的modal跳出來時有問題 最好綁在你需要的class上
		//  mouseControls: true,
		//  touchControls: true,
		//  gyroControls: false,
		//  minHeight: 200.00,
		//  minWidth: 200.00,
		//  scale: 1.00,
		//  scaleMobile: 1.00,
		//  color:0xb2e2ff
		// })
	</script>
</body>

</html>