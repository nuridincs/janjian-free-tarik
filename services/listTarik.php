<?php
  include "../config/database.php";

  $json = file_get_contents('php://input');
  $data = json_decode($json);

  if ($data->date === 'today') {
    $condition = "Curdate()";
  } else {
    $condition = "Curdate() + interval 1 day";
  }

	$sql = "SELECT app_time.id, app_time.label, app_tarik.id_time, app_tarik.name_line, app_tarik.date_label, app_tarik.date,
            CASE
              WHEN app_time.id = app_tarik.id_time THEN app_tarik.name_line
              ELSE 'available'
            END AS status
          FROM app_time
            LEFT JOIN app_tarik
              ON app_tarik.id_time = app_time.id
                AND app_tarik.date = $condition
          GROUP BY  app_time.id
          ORDER BY  app_time.id ASC";

  $query = mysqli_query($db_handle, $sql);

  $data = [];
  while ($dataTime = mysqli_fetch_object($query)) {
    $data[] = $dataTime;
  }

  echo json_encode($data);
?>