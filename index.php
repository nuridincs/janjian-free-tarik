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
		<h1>Janjian Free Tarik</h1>
		<form id="formJanjian">
			<div class="form-group">
				<label for="lineName">Nama Line</label>
				<input type="lineName" class="form-control" placeholder="Masukan Nama Line" id="lineName" id="lineName">
			</div>
			<div class="form-group">
				<?php $datetime = new DateTime('tomorrow'); ?>
				<label for="tanggal">Tanggal:</label>
				<div class="form-check">
					<label class="form-check-label">
						<input type="radio" class="form-check-input" id="today"> Hari ini <?= date('d/m/Y') ?>
					</label>
				</div>
				<div class="form-check">
					<label class="form-check-label">
						<input type="radio" class="form-check-input" id="tomorrow"> Besok <?= $datetime->format('d/m/Y'); ?>
					</label>
				</div>
			</div>
			<div class="form-group">
				<?php $datetime = new DateTime('tomorrow'); ?>
				<label for="jam">Jam:</label>
				<div class="row">
					<div class="col">
						<div class="form-check">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" id="today"> 00:00
							</label>
						</div>
					</div>
					<div class="col">
						<div class="form-check">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" id="today"> 00:00
							</label>
						</div>
					</div>
					<div class="col">
						<div class="form-check">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" id="today"> 00:00
							</label>
						</div>
					</div>
					<div class="col">
						<div class="form-check">
							<label class="form-check-label">
								<input type="radio" class="form-check-input" id="today"> 00:00
							</label>
						</div>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</body>
</html>