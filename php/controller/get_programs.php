<?php
include '../model/config.php';
include '../model/programcontroller.php';

$department_id = $_GET['department'];
$program = new ProgramController();
$programs = $program->getProgramsByDepartment($department_id);
