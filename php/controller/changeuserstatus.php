<?php
include_once '../model/config.php';
include_once '../model/usercontroller.php';

$user_id = $_GET['id'];

$user = new UserController();
$user->changeuserstatus($user_id);