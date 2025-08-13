<?php
  require_once 'php/model/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExamPro - Online CBT Exam App</title>
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
    <h1>Welcome to ExamPro</h1>
    <p>The smart way to prepare, practice, and excel in your Computer-Based Tests.</p>
  </header>


  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-4 offset-md-4">
          <h2 class="text-center">Login</h2>
          <form action="http://localhost/examnow/examenow/php/controller/login.php" method="POST">
            <p class="text-danger">
              <?php
              if (isset($_SESSION['login_error'])) {
                echo $_SESSION['login_error'];
                unset($_SESSION['login_error']);
              }
              ?>
            </p>
            
            <div class="form-group">
              <input type="email" name="email" class="form-control" placeholder="Email" required>
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

  <!-- 3. FEATURES SECTION -->
  <section style="background: #f1f5f9;">
    <div class="section-title">
      <h2>Features</h2>
    </div>
    <div class="features">
      <div class="card">
        <h3>⏳ Timed Exams</h3>
        <p>Simulate real exam conditions with an automatic countdown timer.</p>
      </div>
      <div class="card">
        <h3>📊 Instant Results</h3>
        <p>Get your score immediately after you submit your answers.</p>
      </div>
      <div class="card">
        <h3>📈 Performance Analytics</h3>
        <p>Track your progress with detailed reports and charts.</p>
      </div>
    </div>
  </section>

  <!-- 4. HOW IT WORKS -->
  <section>
    <div class="section-title">
      <h2>How It Works</h2>
    </div>
    <div class="how-it-works">
      <div class="card">
        <h3>1. Sign Up</h3>
        <p>Create your free account in minutes.</p>
      </div>
      <div class="card">
        <h3>2. Take Exams</h3>
        <p>Attempt multiple-choice tests with a real-time timer.</p>
      </div>
      <div class="card">
        <h3>3. View Results</h3>
        <p>Get instant feedback and review your answers.</p>
      </div>
    </div>
  </section>

  <!-- 5. TESTIMONIALS -->
  <section style="background: #f1f5f9;">
    <div class="section-title">
      <h2>What Students Say</h2>
    </div>
    <div class="testimonials">
      <div class="card">
        <p>"ExamPro helped me pass my exams with confidence!"</p>
        <strong>- Jane Doe</strong>
      </div>
      <div class="card">
        <p>"I love the instant results feature. It’s so motivating."</p>
        <strong>- John Smith</strong>
      </div>
    </div>
  </section>

  <!-- 6. CALL TO ACTION -->
  <section style="text-align: center; background: #2563eb; color: white;">
    <h2>Ready to Get Started?</h2>
    <p>Join thousands of students improving their scores today.</p>
    <a href="register.php" class="btn" style="background:white; color:#2563eb;">Sign Up Now</a>
  </section>

  <!-- 7. FOOTER -->
  <footer>
    <p>© <?php echo date("Y"); ?> ExamPro. All rights reserved.</p>
  </footer>
  <script src="assets/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
  <script src="assets/bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>