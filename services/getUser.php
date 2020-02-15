<?php
  include "../config/database.php";

  $json = file_get_contents('php://input');
  $data = json_decode($json);

  $sql = "SELECT * FROM app_account WHERE password='".$data->password."'";
  $query = mysqli_query($db_handle, $sql);
  $result = mysqli_num_rows($query);

  if ($result >= 1) {
    $response = true;
  } else {
    $response = false;
  }

  $resultResponse = [
    'status' => $response
  ];

  echo json_encode($resultResponse);