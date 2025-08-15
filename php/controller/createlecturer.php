<?php
include '../model/config.php';
include '../model/lecturercontroller.php';




    $name = $_POST['lecturerName'];
    $email = $_POST['lecturerEmail'];
    $department = $_POST['departmentName'];
    $lecturer = new LecturerController();
    $lecturer->createLecturer($name, $email, $department);

?>