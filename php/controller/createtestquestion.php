<?php
include '../model/config.php';
include '../model/testcontroller.php';

$testcontroller = new TestController();

$course_id = $_GET['course_id'];
$questionText = trim($_POST['questionText']);
$questionType = trim($_POST['questionType']);
$correctAnswer = strtolower(trim($_POST['correctAnswer']));

if ($questionType === 'mcq') {
    $options = isset($_POST['option']) ? $_POST['option'] : [];

    // Ensure it's an array
    if (is_array($options)) {
        // Trim spaces and convert to lowercase if needed
        $options = array_map(function($opt) {
            return strtolower(trim($opt));
        }, $options);
    } else {
        $options = [];
    }
}
$testcontroller->createQuestion($course_id, $questionText, $questionType, $options, $correctAnswer);


