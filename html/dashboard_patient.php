<?php
session_start();
if (isset($_SESSION["username"])){

  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error){
    echo "ERROR CONNECTING TO DATABASE";
    die($conn->connect_error);
  } else {
    $query = "SELECT * FROM user_profiles WHERE usercode = 2";
    $result = $conn->query($query);
    if (!$result) {
      die($result->error);
    } elseif ($result->num_rows) {
      $rows = $result->num_rows;
      echo <<< _END
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>SMS</title>

    <!-- JavaScript -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.easing.min.js"></script>
    <script src="../js/chart.min.js"></script>
    <script src="../js/jquery.dataTables.js"></script>
    <script src="../js/dataTables.bootstrap4.js"></script>
    <script src="../js/sb-admin.js"></script>

    <!-- Css -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="../css/sb-admin.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">

  </head>

  <body class="fixed-nav" id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <a class="navbar-brand" href="#">Patient Dashboard</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav">
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
            <div class="nav-link">
              <i class="fa fa-fw fa-user"></i>
              <span class="nav-link-text">
_END;

                echo "Welcome " . $_SESSION['fname'];
                echo <<< _END
              </span>
            </div>
          </li>
          <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Dashboard">
            <a class="nav-link" href="#">
              <i class="fa fa-fw fa-calendar"></i>
              <span class="nav-link-text">
                Bookings
              </span>
            </a>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
            <a class="nav-link" href="#">
              <i class="fa fa-fw fa-cogs"></i>
              <span class="nav-link-text">
                Settings
              </span>
            </a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="fa fa-fw fa-sign-out"></i>
              Logout
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="content-wrapper py-3">
      <div class="container-fluid"> 
_END;
        if (isset($_REQUEST['submitted'])){
          echo "<h3>Successfully Submitted Appointment</h3>";
        }

        echo <<< _END
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Book an Appointment
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <form action="appointments.php" id="appt_form" method="post" role="form">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="reasonmenu">Reason:</label>
                      <div id="reasonmenu" >
                        <input type="radio" name="reason" value="option1" id="option1" checked><b>&nbsp; General Consultation</b><br>
                        <input type="radio" name="reason" value="option2" id="option2">&nbsp; Abdominal Pain<br>
                        <input type="radio" name="reason" value="option3" id="option3">&nbsp; Fever or Cold<br>
                        <input type="radio" name="reason" value="option4" id="option4">&nbsp; Cut or Gash<br>
                        <input type="radio" name="reason" value="option5" id="option5">&nbsp; Joint Pain<br>
                        <input type="radio" name="reason" value="option6" id="option6">&nbsp; Migraine or Headache<br>
                        <input type="radio" name="reason" value="option7" id="option7">&nbsp; Muscular Pain<br>
                      </div>
                    </div>
                    </br>
                    <div class="form-group">
                      <label for="bookingdate">Date:</label>
                      <input name="bookingdate" id="bookingdate" type="date" class="form-control" required>
                    </div>
                    </br>
                    <div class="form-group">
                      <label for="bookingtime">Time:</label>
                      <input name="bookingtime" id="bookingtime" type="time" class="form-control" required>
                    </div>
                    </br>
                    <div class="form-group">
                      <label for="doctor">Doctor:</label>
                      <div id="doctor">
_END;

  for ($j = 0 ; $j < $rows ; ++$j){
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
      <input type="radio" name="docname" value="$row[4]" id="$row[4]"> $row[0] $row[1] <br>
_END;
    }


                        echo <<< _END
                      </div>
                    </div>
                    </br>
                  </div>

                  <div class="col-md-6">

                    <div class="form-group">
                      <label for="details">Details (500 Character Limit):</label>
                      <textarea name="details" id="details" class="form-control" rows="5" maxlength="500" required></textarea>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-default" style="border: 1px solid rgba(0,0,0,.15);">Book Appointment</button>
                    </div>

                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="card-footer small text-muted">
          </div>
        </div>

      </div>
    </div>

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

  </body>
</html>
_END;
    }
  }
} else {
  echo "No user info found. Please login!";
  header('Location:login_signup.html');
}
?>

