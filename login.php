<?php
  require_once 'php/model/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExameNow - Online CBT Exam App</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    header,
    section {
      padding: 60px 20px;
    }

    header {
      background: #2563eb;
      color: white;
      text-align: center;
    }

    header h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
    }

    header p {
      max-width: 600px;
      margin: auto;
    }

    .btn {
      display: inline-block;
      padding: 12px 24px;
      background: white;
      color: #2563eb;
      text-decoration: none;
      border-radius: 5px;
      margin-top: 20px;
    }

    .section-title {
      text-align: center;
      margin-bottom: 40px;
    }

    .features,
    .how-it-works,
    .testimonials {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .card {
      background: #f9f9f9;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
    }

    footer {
      background: #111;
      color: #ccc;
      text-align: center;
      padding: 20px;
    }
  </style>
  <link rel="stylesheet" href="assets/bootstrap-4.0.0-dist/css/bootstrap.css">
  <link rel="stylesheet" href="assets/bootstrap-4.0.0-dist/css/bootstrap.min.css">
</head>

<body>

  <!-- 1. HERO SECTION -->
  <header>
    <h1>Welcome to ExamNow</h1>
    <p>The smart way to prepare, practice, and excel in your Computer-Based Tests.</p>
  </header>


  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-4 offset-md-4">
          <h2 class="text-center">Login</h2>
          <!-- <form action="http://localhost/examnow/examenow/php/controller/login.php" method="POST"> -->
          <form action="http://examenow/php/controller/login.php" method="POST">
            <p class="text-danger">
              <?php
              if (isset($_SESSION['login_error'])) {
                echo $_SESSION['login_error'];
                unset($_SESSION['login_error']);
              }
              ?>
            </p>
            
            <div class="form-group">
              <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            
            <div class="form-group mx-auto">
              <button type="submit" class="btn btn-primary w-100">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>


  <!-- 7. FOOTER -->
  <footer>
    <p>© <?php echo date("Y"); ?> ExamPro. All rights reserved.</p>
  </footer>
  <!-- 7. FOOTER -->

  <script src="assets/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
  <script src="assets/bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>