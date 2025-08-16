<?php
include_once '../model/config.php';
include_once '../model/programcontroller.php';


$departmentName = $_POST['departmentName'];
$departmentOption = $_POST['departmentOption'];
$departmentLevel = $_POST['departmentLevel'];




$program = new ProgramController();
$program->createprogram($departmentName, $departmentOption, $departmentLevel);