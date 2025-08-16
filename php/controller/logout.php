<?php
include '../model/config.php';
include '../model/usercontroller.php';
$user = new UserController();
$user->logout();