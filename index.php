<?php
	$db_handle = mysqli_connect("localhost","root","");
	mysqli_select_db($db_handle, "db_janjian_free_tarik");

	$sql = "SELECT * FROM app_time";
	$query = mysqli_query($db_handle, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Janjian Free Tarik</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h1 align="center">Janjian Free Tarik</h1>
		<hr>
		<form id="formJanjian" action="" method="POST">
			<div class="form-group">
				<label for="lineName">Nama Line</label>
				<input type="lineName" class="form-control" required placeholder="Masukan Nama Line" name="lineName" id="lineName" id="lineName">
			</div>
			<div class="form-group">
				<?php $datetime = new DateTime('tomorrow'); ?>
				<label for="tanggal">Tanggal:</label>
				<div class="form-check">
					<label class="form-check-label">
						<input type="radio" class="form-check-input" required name="date" value="today"> Hari ini (<?= date('d/m/Y') ?>)
					</label>
				</div>
				<div class="form-check">
					<label class="form-check-label">
						<input type="radio" class="form-check-input" required name="date" id="tomorrow" value="tomorrow"> Besok (<?= $datetime->format('d/m/Y'); ?>)
					</label>
				</div>
			</div>
			<div class="form-group">
				<label for="jam">Jam:</label>
				<div class="row">
				<?php while ($row = mysqli_fetch_object($query)) { ?>
					<div class="col">
						<div class="form-check">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" required name="time" value="<?= $row->id ?>"> <?= $row->label ?>
							</label>
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
			<button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
		</form>
		<hr>
		<h1 align="center">List Tarik</h1>
		<div class="row" align="center">
				<div class="col">
					<h4>Hari ini</h4>
					<hr>
					<?php 
						$sql = "SELECT * FROM app_time";
						$sqlCurdate = "SELECT *, 
													CASE 
													WHEN app_time.id = app_tarik.id_time THEN 'available' ELSE app_tarik.name_line 
													END AS label
													FROM app_time
													LEFT JOIN app_tarik ON app_tarik.id_time=app_time.id
													WHERE app_tarik.date = CURDATE() OR app_tarik.date = CURDATE() + INTERVAL 1 DAY 
													AND app_tarik.date_label = 'today'";

						$query = mysqli_query($db_handle, $sql); 
						$queryCurdate = mysqli_query($db_handle, $sqlCurdate); 
						while ($rowData = mysqli_fetch_object($query)) { 
							while ($dataCurdate = mysqli_fetch_object($queryCurdate)) {
								if ($rowData->id = $dataCurdate->id_time) {
									$label = "Available";
								} else {
									$label = $dataCurdate->name_line;
								}
							}
							
					?>
							<div class="row">
								<div class="col">
									<?= $rowData->label ?>
								</div>
								<div class="col">
									<span class="badge badge-success"><?= $label ?></span>
								</div>
							</div>
					<?php 
						} 
					?>
				</div>
				<div class="col">
					<h4>Besok</h4>
					<hr>
					<?php 
						$sql = "SELECT * FROM app_time";
						$query = mysqli_query($db_handle, $sql); 
						while ($rowData = mysqli_fetch_object($query)) { ?>
							<div class="row">
								<div class="col">
									<?= $rowData->label ?>
								</div>
								<div class="col">
									<span class="badge badge-danger">Book</span>
								</div>
							</div>
					<?php } ?>
		</div>
	</div>
</body>
</html>

<?php
	if (isset($_POST['submit'])) {
		$name = $_POST['lineName'];
		$dateLabel = $_POST['date'];
		$time = $_POST['time'];

		if ($dateLabel === 'today') {
			$date = date('Y-m-d');
		} else {
			$date = $datetime->format('Y-m-d');;
		}

		$sqlInsert = "INSERT INTO app_tarik(id_time, name_line, date_label, date) VALUES('".$time."', '".$name."', '".$dateLabel."', '".$date."')";
		// echo "sql =>". $sqlInsert;
		mysqli_query($db_handle, $sqlInsert);
		// header("Refresh:0");
	}
?>