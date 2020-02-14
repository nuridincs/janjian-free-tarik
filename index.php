<?php
	date_default_timezone_set("Asia/Bangkok");
	$db_handle = mysqli_connect("localhost","root","");
	mysqli_select_db($db_handle, "db_janjian_free_tarik");

	$sql = "SELECT app_time.id, app_time.label, app_tarik.id_time, app_tarik.name_line, app_tarik.date_label, app_tarik.date,
						CASE
							WHEN app_time.id = app_tarik.id_time THEN app_tarik.name_line
							ELSE 'available'
						END AS status
					FROM app_time
						LEFT JOIN app_tarik
							ON app_tarik.id_time = app_time.id
								AND app_tarik.date = Curdate()
					GROUP BY  app_time.id
					ORDER BY  app_time.id ASC";
	$query = mysqli_query($db_handle, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Janjian Free Tarik</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<script src="assets/js/jquery.js"></script>
</head>
<body>
	<div class="container">
		<h1 align="center">Janjian Free Tarik</h1>
		<hr>
		<div class="form-group">
			<label for="lineName">Nama Line</label>
			<input type="lineName" class="form-control" required placeholder="Masukan Nama Line" name="lineName" id="lineName" id="lineName">
		</div>
		<div class="form-group">
			<?php $datetime = new DateTime('tomorrow'); ?>
			<label for="tanggal">Tanggal:</label>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" required name="date" value="today" checked> Hari ini (<?php echo date('d/m/Y') ?>)
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" required name="date" id="tomorrow" value="tomorrow"> Besok (<?php echo $datetime->format('d/m/Y'); ?>)
				</label>
			</div>
		</div>
		<div class="form-group">
			<label for="jam">Jam:</label>
			<div class="row" id='post-result'>
			<?php 
				while ($row = mysqli_fetch_object($query)) {
					$disabled = 'disabled';
					if ($row->status === 'available') {
						$disabled = '';
					}
			?>
				<div class="col" id="firstShow">
					<div class="form-check">
						<label class="form-check-label">
							<input type="radio" class="form-check-input" required name="time" value="<?= $row->id ?>" <?= $disabled ?>> <?= $row->label ?>
						</label>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
		<button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Submit</button>
		<hr>
		<h1 align="center">List Tarik</h1>
		<div class="row" align="center">
				<div class="col">
					<h4>Hari ini</h4>
					<hr>
					<?php
						$sqlCurdate = "SELECT *,
														CASE
															WHEN app_time.id = app_tarik.id_time THEN app_tarik.name_line
															ELSE 'available'
														END AS status
													FROM app_time
														LEFT JOIN app_tarik
															ON app_tarik.id_time = app_time.id AND app_tarik.date = curdate()
															GROUP BY app_time.id
													ORDER BY app_time.id ASC";
						$queryCurdate = mysqli_query($db_handle, $sqlCurdate);
						while ($rowData = mysqli_fetch_object($queryCurdate)) {
							if ($rowData->status === 'available') {
								$badge = "success";
							} else {
								$badge = "danger";
							}
					?>
							<div class="row">
								<div class="col">
									<?= $rowData->label ?>
								</div>
								<div class="col">
									<span class="badge badge-<?php echo $badge ?>"><?= ucwords($rowData->status) ?></span>
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
						$sqlTomorrow = "SELECT *,
														CASE
															WHEN app_time.id = app_tarik.id_time THEN app_tarik.name_line
															ELSE 'available'
														END AS status
														FROM app_time
															LEFT JOIN app_tarik
																ON app_tarik.id_time = app_time.id AND app_tarik.date = curdate() + interval 1 day
																GROUP BY app_time.id
														ORDER BY app_time.id ASC";
						$queryTomorrow = mysqli_query($db_handle, $sqlTomorrow);
						while ($rowData = mysqli_fetch_object($queryTomorrow)) {
							if ($rowData->status === 'available') {
								$badge = "success";
							} else {
								$badge = "danger";
							}
					?>
							<div class="row">
								<div class="col">
									<?= $rowData->label ?>
								</div>
								<div class="col">
									<span class="badge badge-<?php echo $badge ?>"><?= ucwords($rowData->status) ?></span>
								</div>
							</div>
					<?php } ?>
		</div>
	</div>
</body>
</html>

<script>
	$(document).ready(function () {
		setTimeout(() => {
			location.reload();
		}, 60000);
		$('[name=date]').click(function () {
			const date = this.value;

			fetch('services/listTarik.php', {
				headers: {
					'Accept': 'application/json',
					'Content-Type': 'application/json'
				},
				method: 'POST',
				body: JSON.stringify({date:date})
			})
			.then((response) => {
				return response.json();
			})
			.then((data) => {
				let view = '';
				$.each (data, function (i, obj) {
						let disabled = 'disabled'

						if (obj.status === 'available') {
							disabled = '';
						}

						view += '<div class="col">'+
						'<div class="form-check">'+
							'<label class="form-check-label">'+
								'<input type="radio" class="form-check-input" required name="time" value="'+ obj.id +'" '+disabled+'>'+ obj.label +
							'</label>'+
						'</div>'+
					'</div>'
				});
				$('#firstShow').hide();
				$('#post-result').html(view);
			});
		});

		$('#submit').click(function () {
			const data = {
				name: $('input[name=lineName]').val(),
				date: $('input[name=date]:checked').val(),
				time: $('input[name=time]:checked').val(),
			}

			if (data.name === '' || data.date === '' || typeof data.time === 'undefined') {
				alert('Lengkapi semua isian');

				return false;
			}

			fetch('services/insert.php', {
				headers: {
					'Accept': 'application/json',
					'Content-Type': 'application/json'
				},
				method: 'POST',
				body: JSON.stringify({data})
			})
			.then((response) => {
				location.reload();
			})
			.then((data) => {
				location.reload();;
			});
		});
	});
</script>