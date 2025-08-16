<?php
include '../model/config.php';
include '../model/testcontroller.php';

$testcontroller = new TestController();

if (isset($_GET['id'])) {
    $testId = $_GET['id'];
    $testcontroller->deleteScheduledTest($testId);
}