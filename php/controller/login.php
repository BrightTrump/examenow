<?php
require_once '../model/config.php';
require_once '../model/usercontroller.php';


$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);


$userController = new UserController();
$userController->login($email, $password);


