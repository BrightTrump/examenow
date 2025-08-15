<?php
include '../model/config.php';
include '../model/coursecontroller.php';

$courses = new CourseController();

$course_id = $_GET['id'];
$user_id = $_SESSION['id'];

$courses->addcoursetouser($course_id, $user_id);
