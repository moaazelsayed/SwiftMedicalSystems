<?php
session_start();
if (isset($_SESSION['username'])){

	require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error){
    echo "ERROR CONNECTING TO DATABASE";
    die($conn->connect_error);
  } else {
    $query = "SELECT * FROM appointments";
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

    <!-- Css -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="../css/sb-admin.css" rel="stylesheet">

    <!-- JavaScript -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.easing.min.js"></script>
    <script src="../js/chart.min.js"></script>
    <script src="../js/jquery.dataTables.js"></script>
    <script src="../js/dataTables.bootstrap4.js"></script>
    <script src="../js/sb-admin.js"></script>

  </head>

  <body class="fixed-nav" id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <a class="navbar-brand" href="#">Nurse Dashboard</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav">
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
            <div class="nav-link">
              <i class="fa fa-fw fa-dashboard"></i>
              <span class="nav-link-text">
_END;

                echo "Welcome ". $_SESSION["fname"];
                echo <<< _END
              </span>
            </div>
          </li>
          <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Dashboard">
            <a class="nav-link" href="#">
              <i class="fa fa-fw fa-calendar"></i>
              <span class="nav-link-text">
                Appointments
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

        <!-- Area Chart Example -->
        <!--
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-area-chart"></i>
            User Types
          </div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div>
          <div class="card-footer small text-muted">
          </div>
        </div>
        -->
        <div class="row">

          <div class="col-lg-8">

            <!-- Example Bar Chart Card -->
            <!--
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-bar-chart"></i>
                Bar Chart Example
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-8 my-auto">
                    <canvas id="myBarChart" width="100" height="50"></canvas>
                  </div>
                  <div class="col-sm-4 text-center my-auto">
                    <div class="h4 mb-0 text-primary">$34,693</div>
                    <div class="small text-muted">YTD Revenue</div>
                    <hr>
                    <div class="h4 mb-0 text-warning">$18,474</div>
                    <div class="small text-muted">YTD Expenses</div>
                    <hr>
                    <div class="h4 mb-0 text-success">$16,219</div>
                    <div class="small text-muted">YTD Margin</div>
                  </div>
                </div>
              </div>
              <div class="card-footer small text-muted">
              </div>
            </div>
            -->
          </div>
        </div>

        <!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Appointment Table
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Email</th>
                    <th>Apptmnt Date</th>
                    <th>Apptmnt Time</th>
                    <th>Doctor Email</th>
                    <th>Reason</th>
                    <th>Apptmnt ID</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Email</th>
                    <th>Apptmnt Date</th>
                    <th>Apptmnt Time</th>
                    <th>Doctor Email</th>
                    <th>Reason</th>
                    <th>Apptmnt ID</th>
                  </tr>
                </tfoot>
                <tbody>
_END;

for ($j = 0 ; $j < $rows ; ++$j){
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
    <tr>
    <td>$row[0]</td>
    <td>$row[1]</td>
    <td>$row[2]</td>
    <td>$row[4]</td>
    <td>$row[6]</td>
    <td>$row[5]</td>
	</tr>
_END;
    }
				echo <<< _END
				</tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- /.content-wrapper -->

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