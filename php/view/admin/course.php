<?php
include '../../model/config.php';
include '../../model/departmentcontroller.php';
include '../../model/programcontroller.php';
include_once 'includes/text.php';
include '../../model/coursecontroller.php';

$department = new DepartmentController();
$program = new ProgramController();
$courses = new CourseController();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    <?php echo $page_title; ?>
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper">
    <?php include_once 'includes/sidebar.php'; ?>
    <div class="main-panel">
      <!-- Navbar -->

      <?php include_once 'includes/navbar.php'; ?>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-12">
            <div class="card card-chart">
              <div class="card-header ">
                <div class="row">
                  <div class="col-sm-6 text-left">
                    <h5 class="card-category">Courses</h5>
                    <h2 class="card-title">Manage courses.</h2>
                  </div>
                  <div>
                    <a href="alldepartments.php" class="btn btn-primary">All Departments</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4 offset-md-4">
                    <form method="post" action="../../controller/createcourse.php">
                      <span class="text-danger">
                        <?php
                        if (isset($_SESSION['course_error'])) {
                          echo $_SESSION['course_error'];
                          unset($_SESSION['course_error']);
                        }
                        ?>
                      </span>
                      <span class="text-success">
                        <?php
                        if (isset($_SESSION['course_success'])) {
                          echo $_SESSION['course_success'];
                          unset($_SESSION['course_success']);
                        }
                        ?>
                      </span>
                      <div class="form-group">
                        <label for="courseName">Course Name</label>
                        <input type="text" class="form-control" name="courseName" placeholder="Enter course name">
                      </div>
                      <div>
                        <label for="courseCode">Course Code</label>
                        <input type="text" class="form-control" name="courseCode" placeholder="Enter course code">
                      </div>
                      <div class="form-group">
                        <label for="departmentName">Department</label>
                        <select name="departmentName" id="department"  class="form-control bg-dark" onchange="departmentprograms()">
                          <option value="">Select department</option>
                          <option value="10000">General Studies</option>
                          <?= $department->departmentasoption() ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="departmentName">Programs</label>
                        <div id="programs">

                        </div>
                          
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="semester">Semester</label>
                        <select name="semester" class="form-control bg-dark">
                          <option value="">Select semester</option>
                          <option value="1">First Semester</option>
                          <option value="2">Second Semester</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="level">Level</label>
                        <select name="level" class="form-control bg-dark">
                          <option value="">Select level</option>
                          <option value="nd">ND</option>
                          <option value="hnd">HND</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="subLevel">Sub Level</label>
                        <select name="subLevel" class="form-control bg-dark">
                          <option value="">Select sub level</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>
                      </div>


                      <button type="submit" class="btn btn-primary">Add Course</button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-body">
                        <h5 class="card-title">All General Courses</h5>
                        <div>
                          <table class="table">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Course Code</th>
                                <th>Level</th>
                                <th>Sub Level</th>
                                <th>Semester</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $courses->allgeneralcourses()
                              ?>
                            </tbody>
                          </table>
                        </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!-- Place this tag in your head or just before your close body tag. -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/black-dashboard.min.js?v=1.0.0"></script>
  <!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function () {
      $().ready(function () {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        $('.fixed-plugin a').click(function (event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .background-color span').click(function () {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data', new_color);
          }

          if ($main_panel.length != 0) {
            $main_panel.attr('data', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data', new_color);
          }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function () {
          var $btn = $(this);

          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function () {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function () {
            clearInterval(simulateWindowResize);
          }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function () {
          var $btn = $(this);

          if (white_color == true) {

            $('body').addClass('change-background');
            setTimeout(function () {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {

            $('body').addClass('change-background');
            setTimeout(function () {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);

            white_color = true;
          }


        });

        $('.light-badge').click(function () {
          $('body').addClass('white-content');
        });

        $('.dark-badge').click(function () {
          $('body').removeClass('white-content');
        });
      });
    });
  </script>
  <script>
    $(document).ready(function () {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

    });
  </script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "black-dashboard-free"
      });
  </script>
  <script>
      function departmentprograms() {
        $department = document.getElementById('department').value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("programs").innerHTML = this.responseText;
          }
        };
        xhttp.open("GET", "../../controller/get_programs.php?department=" + $department, true);
        xhttp.send();
      }
  </script>
</body>

</html>