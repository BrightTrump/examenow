<?php 

include '../model/config.php';
include '../model/testcontroller.php';

$user_id = $_SESSION['id'];
$course_id = $_POST['course_id'];
$test_title = $_POST['test_title'];
$test_description = $_POST['test_description'];
$test_time = $_POST['test_time'];
$test_duration = $_POST['test_duration'];
$testcontroller = new TestController();

$testcontroller->scheduleTest($course_id, $test_title, $test_description, $test_time, $test_duration, $user_id);

