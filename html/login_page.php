<?php
  // Login page
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error){
    echo "ERROR CONNECTING TO DATABASE";
    die($conn->connect_error);
  }
  // If login, set session and cookie
  if (isset($_POST['email']) && isset($_POST['password2'])) {
  	$rec_un = $_POST['email'];
  	$rec_pw = $_POST['password2'];
  	$un_temp = mysql_entities_fix_string($conn, $rec_un);
    $pw_temp = mysql_entities_fix_string($conn, $rec_pw);
    $query = "SELECT * FROM user_profiles WHERE email ='$un_temp'";
    $result = $conn->query($query);
    if (!$result) {
      die($result->error);
    } elseif ($result->num_rows) {
    	$row = $result->fetch_array(MYSQLI_NUM); 
    	$result->close();
    	$salt1 = "qm&h*";
    	$salt2 = "ig!@i";
      $token = hash('ripemd128', "$salt1$pw_temp$salt2");
      if ($token == $row[5]) {
    		session_start();
    		$_SESSION['username'] = $un_temp;
    		$_SESSION['token'] = $token;
    		$_SESSION['fname'] = $row[0];
    		$_SESSION['lname']  = $row[1];
        if ($row[2] == 1){
          $_SESSION['ucode']  = 'Admin';
        } elseif ($row[2] == 2){
          $_SESSION['ucode']  = 'Doctor';
        } elseif ($row[2] == 3){
          $_SESSION['ucode']  = 'Nurse';
        } elseif ($row[2] == 4){
          $_SESSION['ucode']  = 'Patient';
        } elseif ($row[2] == 5){
          $_SESSION['ucode']  = 'Physician';
        } elseif ($row[2] == 6){
          $_SESSION['ucode']  = 'Receptionist';
        }

    		echo "$row[0] $row[1] : Hi $row[0], you are now logged in as '$row[4]'";

        if ($_SESSION['ucode'] == 'Admin'){
          header('Location:dashboard.php');
        } elseif ($_SESSION['ucode']  == 'Doctor'){
          header('Location:dashboard_doctor.php');
        } elseif ($_SESSION['ucode']  == 'Nurse'){
          header('Location:dashboard_nurse.php');
        } elseif ($_SESSION['ucode']  == 'Patient'){
          header('Location:dashboard_patient.php');
        } elseif ($_SESSION['ucode']  == 'Receptionist'){
          echo "Receptionist page coming soon!";
          //header('Location:dashboard.php');
        }

    	} else {
        echo "Invalid username/password combination";
        header('Location:login_signup.html');
      }
  	} else die("Please set email and password to login");
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