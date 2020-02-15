<?php
	include "config/database.php";

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
		<script src="assets/js/bootstrap.min.js"></script>
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
		<button type="submit" name="submit" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">Submit</button>
		<hr>
		<h1 align="center">List Tarik</h1>
		<div class="row" align="center">
				<div class="col">
					<h4>Hari ini</h4>
					<div><?= date('d/m/Y') ?></div>
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
					<div><?= $datetime->format('d/m/Y') ?></div>
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
		<div class="container text-justify">
			<hr>
			<h1 align="center">Rules</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed elit non est euismod vehicula. Ut egestas, tellus nec hendrerit accumsan, turpis nulla rhoncus augue, ut pretium arcu urna in lectus. Curabitur a imperdiet justo, vitae aliquet lectus. Integer vitae massa suscipit, malesuada erat laoreet, sollicitudin odio. Nulla facilisi. Proin nibh tellus, vestibulum et nunc sed, iaculis ultricies turpis. Nullam in libero tellus. Morbi sagittis justo accumsan, pulvinar arcu ac, fermentum urna.</p>
		</div>
		<div class="modal" id="myModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Submit Data</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<!-- Modal body -->
					<div class="modal-body">
						<p class="text-justify"> Apakah Anda yakin untuk book di tanggal & jam tersebut? Tanggal & Jam yang sudah dipilih tidak dapat diubah,kecuali ada persetujuan untuk tukeran jam</p>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="submit" data-dismiss="modal">Submit</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- The Modal -->
		<div class="modal fade" id="modalPassword">
			<div class="modal-dialog">
				<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Masukan Password</h4>
						<!-- <button type="button" class="close" data-dismiss="modal">×</button> -->
					</div>
					<!-- Modal body -->
					<div class="modal-body">
						<input type="password" class="form-control" required name="password" id="password">
					</div>

					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="submitPassword" data-dismiss="modal">Submit</button>
						<!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
					</div>

				</div>
			</div>
		</div>
</body>
</html>

<script>
	$(document).ready(function () {
		setTimeout(() => {
			location.reload();
		}, 60000);

		const user = window.localStorage.getItem('user');

		if (!user) {
			$("#modalPassword").modal({
        backdrop: 'static',
				keyboard: false
			});
		}

		$('#submitPassword').click(function () {
			const data = {
				password: $('input[name=password]').val()
			}

			if (data.password === '') {
				alert('Password wajib diisi!');

				return false;
			}

			fetch('services/getUser.php', {
				headers: {
					'Accept': 'application/json',
					'Content-Type': 'application/json'
				},
				method: 'POST',
				body: JSON.stringify({password:data.password})
			})
			.then((response) => {
				return response.json();
			})
			.then((data) => {
				if (data.status) {
					window.localStorage.setItem('user', true);
					$('#modalPassword').modal('hide');
				} else {
					alert('Password tidak sesuai');

					location.reload();
				}
			});
		});

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