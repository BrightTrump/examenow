<?php
  include '../model/config.php';
  include '../model/usercontroller.php';

  $schedule_id = $_POST['schedule_id'];
  $matno = $_POST['matno'];



$user = new UserController();
$user->startTest($schedule_id, $matno);

  