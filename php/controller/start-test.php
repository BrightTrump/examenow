<?php
  include '../model/config.php';
  include '../model/usercontroller.php';

  $course_id = $_POST['course_id'];
  $matno = $_POST['matno'];

$user = new UserController();
$user->startTest($course_id, $matno);

  