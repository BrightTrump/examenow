<?php
include_once '../model/config.php';
include_once '../model/departmentcontroller.php';


$departmentName = $_POST['departmentName'];
$departmentCode = $_POST['departmentCode'];


$department = new DepartmentController();
$department->createdepartment($departmentName, $departmentCode);