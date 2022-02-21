<?php
  session_start();

  // // initialize all variables for database
  // $servername = "localhost";
  // $username = "root";
  // $password = "";
  // $dbname = "sekolah";

  // initialize all variables for database
	$servername = "localhost";
	$username = "id17301791_aaa";
	$password = "3!d6qb_}dR)d+!LT";
	$dbname = "id17301791_sekolah";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // tapis data yang diterima sebelum data tersebut digunakan dalam sistem ini
	// untuk mengelakkan penceroboh (hacker) drpd mengeksploitasi sistem ini
	// merupakan salah satu feature iaitu adanya security
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

  $nama_pelajar = $no_pelajar = $nama_penjaga = $no_tel_penjaga = $status = "";
  $message = "";
  $no_telefon = "";
  $recipient_phone_numbers = "";

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["nama_pelajar"]) && isset($_GET["nama_penjaga"]) && isset($_GET["no_tel_penjaga"]) && isset($_GET["no_pelajar"])) {
      $nama_pelajar = test_input($_GET["nama_pelajar"]);
      $no_pelajar = test_input($_GET["no_pelajar"]);
      $nama_penjaga = test_input($_GET["nama_penjaga"]);
      $no_tel_penjaga = test_input($_GET["no_tel_penjaga"]);
    }
    else if (isset($_GET["no_pelajar"]) && isset($_GET["no_tel_penjaga"]) && isset($_GET["status"])) {
      $no_pelajar = test_input($_GET["no_pelajar"]);
      $no_tel_penjaga = test_input($_GET["no_tel_penjaga"]);
      $status = test_input($_GET["status"]);

      $sql = "SELECT no_telefon FROM pelajar WHERE no_pelajar='$no_pelajar'";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $no_telefon = $row["no_telefon"];
    }
  }

  $service_plan_id = "d0e6c5292002479692af3eb420c91952";
  $bearer_token = "24b2e867e7444ae284b3dbbd91d22a4b";

  //Any phone number assigned to your API
  $send_from = "+447537454464";
  //May be several, separate with a comma ,
  
  if ($status == "1") {
    $recipient_phone_numbers = "+6$no_telefon";
    $message = "Permohonan anda diterima";
  }
  else if ($status == "2") {
    $recipient_phone_numbers = "+6$no_telefon";
    $message = "Permohonan anda ditolak.";
  }
  else {
    $recipient_phone_numbers = "+6$no_tel_penjaga"; 
    $message = "Makluman.. Anak anda $nama_pelajar telah memohon untuk pulang bermalam. Sila hubungi pihak pengurusan asrama di talian: 088xxxxxx untuk pengesahan";
  }

  // Check recipient_phone_numbers for multiple numbers and make it an array.
  if(stristr($recipient_phone_numbers, ',')){
    $recipient_phone_numbers = explode(',', $recipient_phone_numbers);
  }else{
    $recipient_phone_numbers = [$recipient_phone_numbers];
  }

  // Set necessary fields to be JSON encoded
  $content = [
    'to' => array_values($recipient_phone_numbers),
    'from' => $send_from,
    'body' => $message
  ];

  $data = json_encode($content);

  $ch = curl_init("https://us.sms.api.sinch.com/xms/v1/{$service_plan_id}/batches");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
  curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $bearer_token);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  $result = curl_exec($ch);

  if(curl_errno($ch)) {
      echo 'Curl error: ' . curl_error($ch);
  } else {
      echo $result;
  }
  curl_close($ch);

  if (isset($_GET["goto"])) {
    if ($_GET["goto"] == "back") {
      header("Location: semak_permohonan.php?no_pelajar=$no_pelajar&maklum=1");
    }
  }
  else {
    header("Location: semak_permohonan.php?no_pelajar=$no_pelajar&status=$status");
  }
?>
