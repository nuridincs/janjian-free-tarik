<?php
	date_default_timezone_set("Asia/Bangkok");
	$db_handle = mysqli_connect("localhost","root","");
  mysqli_select_db($db_handle, "db_janjian_free_tarik");

  $json = file_get_contents('php://input');
  $data = json_decode($json);
  $rowData = $data->data;

  $name = $rowData->name;
  $dateLabel = $rowData->date;
  $time = $rowData->time;
  $datetime = new DateTime('tomorrow');

  if ($dateLabel === 'today') {
    $date = date('Y-m-d');
  } else {
    $date = $datetime->format('Y-m-d');;
  }

  $sqlInsert = "INSERT INTO app_tarik(id_time, name_line, date_label, date) VALUES('".$time."', '".$name."', '".$dateLabel."', '".$date."')";
  // echo "sql =>". $sqlInsert;die;
  mysqli_query($db_handle, $sqlInsert);
  // header("Location.index.php");