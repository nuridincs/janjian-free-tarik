<?php
  include "../config/database.php";

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
  mysqli_query($db_handle, $sqlInsert);