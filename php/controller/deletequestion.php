<?php
include '../model/config.php';
include '../model/testcontroller.php';

$testcontroller = new TestController();

if (isset($_GET['id'])) {
    $questionId = $_GET['id'];
    $testcontroller->deleteQuestion($questionId);
}