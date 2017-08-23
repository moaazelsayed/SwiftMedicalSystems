<?php
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error){
    echo "ERROR CONNECTING TO DATABASE";
    die($conn->connect_error);
  }
  // If login, set session and cookie
	if (isset($_POST['email']) && isset($_POST['password1'])){
  	$fname = get_post($conn, 'firstname');
    $lname = get_post($conn, 'lastname');
    $ucodename = get_post($conn, 'ucode');
    $email = get_post($conn, 'email');
    $password = get_post($conn, 'password1');

    $usercode = 4;
    if ($ucodename == 'Admin'){
    	$usercode = 1;
    } elseif ($ucodename == 'Doctor'){
    	$usercode = 2;
    } elseif ($ucodename == 'Nurse'){
    	$usercode = 3;
    } elseif ($ucodename == 'Patient'){
    	$usercode = 4;
    } elseif ($ucodename == 'Physician'){
    	$usercode = 5;
    } elseif ($ucodename == 'Receptionist'){
    	$usercode = 6;
    }

    $insert_query = "INSERT INTO user_profiles (fname, lname, usercode, email, token_password) VALUES (?, ?, ?, ?, ?);";
    $stmt = $conn->prepare($insert_query);

    $salt1 = "qm&h*";
    $salt2 = "ig!@i";
    $token = hash('ripemd128', "$salt1$password$salt2");
    $stmt->bind_param("ssiss", $fname, $lname, $usercode, $email, $token);
    
    // if ($ucodename == 'Doctor'){
    //   $dept = get_post($conn, 'deptid');
    //   $insert_query2 = "INSERT INTO doctors (department, email) VALUES (?, ?);";
    //   $stmt2 = $conn->prepare($insert_query2);
    //   $stmt2->bind_param("is", $dept, $email);

    //    if($stmt2->execute()) {
    //     echo "Successfully added $fname department $dept";
    //   } else {
    //       echo "INSERT failed: $insert_query<br />" . $conn->error . " tried insert -> $dept";
    //       //header('Location:login_signup.html');
    //   }
    // }

    if($stmt->execute()) {
        echo "Successfully added $ucodename: $fname $lname<br />Email: $email<br /><br />";
        session_start();
        $_SESSION['username'] = $email;
        $_SESSION['token'] = $token;
        $_SESSION['fname'] = $fname;
        $_SESSION['lname']  = $lname;
        $_SESSION['ucode'] = $ucodename;

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
        echo "INSERT failed: $insert_query<br />" . $conn->error . "<br /><br /> Attempted insert -> ($fname, $lname, $usercode, $email, $token) $ucodename";
        header('Location:login_signup.html');
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