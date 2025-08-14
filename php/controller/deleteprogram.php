<?php
include_once '../model/config.php';
include_once '../model/programcontroller.php';


$program_id = $_GET['id'];


$program = new ProgramController();
$program->deleteprogram($program_id);