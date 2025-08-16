<?php
    include '../model/config.php';
    include '../model/testcontroller.php';

    $testController = new TestController();
    $takecourseid = $_GET['course_id'];
    $matno = $_SESSION['usermatno'] ?? null;
    $schedule_id = $_SESSION['schedule_id'] ?? null;
    

    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
      
        $answers = $_POST['answers'] ?? [];
        $testController->submitTest($answers, $takecourseid, $matno, $schedule_id);
    }