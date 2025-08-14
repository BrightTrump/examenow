<?php
include_once '../model/config.php';
include_once '../model/departmentcontroller.php';


$department_id = $_GET['id'];


$department = new DepartmentController();
$department->deletedepartment($department_id);