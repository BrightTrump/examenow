<?php

include '../model/config.php';
include '../model/coursecontroller.php';




$courseName = $_POST['courseName'];
$courseCode = $_POST['courseCode'];
$departmentName = $_POST['departmentName'];
$level = $_POST['level'];
$subLevel = $_POST['subLevel'];
$semester = $_POST['semester'];
$program = implode(',', $_POST['programs']);



$course = new CourseController();
$course->createCourse($courseName, $courseCode, $departmentName, $level, $subLevel, $semester, $program);
