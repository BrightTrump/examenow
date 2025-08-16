<?php
$performance = $_GET['performance'] ?? '0';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExameNow - Online CBT Exam App</title>
  <style>
    * {box-sizing: border-box;}
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
  <h1>Thanks for taking this test</h1>
  <p>The smart way to prepare, practice, and excel in your Computer-Based Tests.</p>
  <a href="login.php" class="btn">Get Started</a>
  
</header>

<!-- 2. ABOUT SECTION -->
<section>
  <div class="section-title" >
   <h2 style="">Performance: <?=$performance?>%</h2>
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
  <p>© <?php echo date("Y"); ?> ExameNow. All rights reserved.</p>
</footer>

</body>
</html>
