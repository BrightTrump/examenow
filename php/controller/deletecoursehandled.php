<?php
    include '../model/config.php';
    include '../model/coursecontroller.php';

    
    $course_id = $_GET['id'];
    $user_id = $_SESSION['id'];


    
    
    $courses = new CourseController();
    $courses->deletecoursehandled($course_id, $user_id);
