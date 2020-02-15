<?php
date_default_timezone_set("Asia/Bangkok");

//Set config db local
$db_handle = mysqli_connect("localhost","root","","db_janjian_free_tarik");

if ($_SERVER['SERVER_NAME'] != 'localhost') {
  //Set config db production
  $db_handle = mysqli_connect("localhost", "jalanklu_root", "jalankluar2020", "jalanklu_janjian-free-tarik");
}

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}

?>