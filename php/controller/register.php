<?php
require_once '../model/config.php';
require_once '../model/usercontroller.php';

$fullname = htmlspecialchars($_POST['fullname']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$cpassword = htmlspecialchars($_POST['cpassword']);

$userController = new UserController();
$userController->register($fullname, $email, $password, $cpassword);


