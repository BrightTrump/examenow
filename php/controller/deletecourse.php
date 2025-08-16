<?php
    include '../model/config.php';
    include '../model/coursecontroller.php';
    $courses = new CourseController();

  
        $id = $_GET['id'];
        $courses->deletecourse($id);
