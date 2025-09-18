<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExameNow - Online CBT Exam App</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; }
    header, section { padding: 60px 20px; }
    header { background: #2563eb; color: white; text-align: center; }
    header h1 { font-size: 2.5rem; margin-bottom: 10px; }
    header p { max-width: 600px; margin: auto; }
    .btn { display: inline-block; padding: 12px 24px; background: white; color: #2563eb; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    .section-title { text-align: center; margin-bottom: 40px; }
    .features, .how-it-works, .testimonials { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
    .card { background: #f9f9f9; padding: 20px; border-radius: 10px; text-align: center; }
    footer { background: #111; color: #ccc; text-align: center; padding: 20px; }
  </style>
</head>
<body>

<!-- 1. HERO SECTION -->
<header>
<?php include 'header.php'; ?>
<a href="login.php" class="btn">Get Started</a>
<a href="test.php" class="btn">Start Test</a>
</header>
<!-- 1. HERO SECTION -->



<!-- 2. ABOUT SECTION -->
<section>
  <div class="section-title" >
    <h2>About Us</h2>
    <p>ExameNow is a cutting-edge online Computer-Based Testing (CBT) platform designed to transform the way students and professionals take exams. With an intuitive interface, lightning-fast performance, and robust features, it makes the entire test-taking process easy, seamless, and highly efficient, ensuring a smooth experience from login to result analysis.</p>
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
      <p>"ExameNow helped me pass my exams with confidence!"</p>
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
<?php include 'footer.php'; ?>
<!-- 7. FOOTER -->

</body>
</html>
