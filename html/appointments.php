<?php
session_start();
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error){
    echo "ERROR CONNECTING TO DATABASE";
    die($conn->connect_error);
  }
  // If login, set session and cookie
	if (isset($_POST['docname']) && isset($_POST['reason'])){

  	$reason = get_post($conn, 'reason');
    $reasonString = 'General Consultation';
    if ($reason == 'option1'){
      $reasonString = 'General Consultation';
    } elseif ($reason == 'option2'){
      $reasonString = 'Abdominal Pain';
    } elseif ($reason == 'option3'){
      $reasonString = 'Fever or Cold';
    } elseif ($reason == 'option4'){
      $reasonString = 'Cut or Gash';
    } elseif ($reason == 'option5'){
      $reasonString = 'Joint Pain';
    } elseif ($reason == 'option6'){
      $reasonString = 'Migraine or Headache';
    } elseif ($reason == 'option7'){
      $reasonString = 'Muscular Pain';
    }

    $docname = get_post($conn, 'docname');
    $bookingdate = get_post($conn, 'bookingdate');
    $bookingtime = get_post($conn, 'bookingtime');
    $details = get_post($conn, 'details');
    $email = $_SESSION["username"];
    $id = rand(11111, 99999);

    $insert_query = "INSERT INTO appointments (email, cdate, time, details, doctor, id, reason) VALUES (?, ?, ?, ?, ?, ?, ?);";

    $stmt = $conn->prepare($insert_query);

    $stmt->bind_param("sssssis", $email, $bookingdate, $bookingtime, $details, $docname, $id, $reasonString);

    if($stmt->execute()) {
      echo "Successfully booked appointment.";
      header('Location:dashboard_patient.php?submitted=true');
    } else {
      echo "INSERT failed: $insert_query<br />" . $conn->error;
      //header('Location:dashboard_patient.php');
    }
  }

  $conn->close();
  function get_post($conn, $var){
    return mysql_fix_string($conn, $_POST[$var]);
  }
  function mysql_entities_fix_string($conn, $string){
    return htmlentities(mysql_fix_string($conn, $string));
  }	
  function mysql_fix_string($conn, $string){
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn->real_escape_string($string);
  }
?>