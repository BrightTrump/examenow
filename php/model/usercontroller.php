<?php 

class UserController {
    public $connection;
    public $url = "http://localhost/examnow/examenow/";

    public function __construct() {
        $conn = new config();
        $this->connection = $conn->getConnection();
    }

    public function register($fullname, $email, $password, $cpassword) {
        if (strlen($fullname) < 3) {
            $_SESSION['register_error'] = "Full name must be at least 3 characters long.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }elseif (strpos($fullname, ' ') == false) {
            $_SESSION['register_error'] = "Surname and firstname is required";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }elseif (empty($email)) {
            $_SESSION['register_error'] = "Email is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }elseif (strlen($password) < 6) {
            $_SESSION['register_error'] = "Password must be at least 6 characters long.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }elseif ($cpassword !== $password) {
            $_SESSION['register_error'] = "Passwords do not match.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }else {
            $createdAt = date('Y-m-d');
            $prepared = "INSERT INTO `users`(`fullname`, `email`, `password`, `role`, `department`, `level`, `program`, `createdAt`, `updatedAt`, `status`) VALUES ('$fullname','$email','$password','student','','','','$createdAt','$createdAt',1)";
            $sql = $this->connection->query($prepared);
            if ($sql == TRUE ) {
                $_SESSION['register_success'] = "Registration successful!";
                header("Location: " . $this->url . "login.php");
                exit();
            } else {
                $_SESSION['register_error'] = "Registration failed. Please try again.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }

    public function login($email, $password) {
        if (empty($email)) {
            $_SESSION['login_error'] = "Email is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } elseif (empty($password)) {
            $_SESSION['login_error'] = "Password is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $prepared = "SELECT * FROM `users` WHERE email='$email' AND password='$password'";
            $sql = $this->connection->query($prepared);
            if ($sql->num_rows > 0) {
                $user = $sql->fetch_assoc();
                $_SESSION['id'] = $user['id'];
                if ($user['role'] == 'admin') {
                    header("Location: " . $this->url . "php/view/admin/");
                    exit();
                }elseif($user['role'] == 'student'){
                    header("Location: " . $this->url . "php/view/dashboard/");
                    exit();
                }elseif ($user['role'] == 'lecturer') {
                    header("Location: " . $this->url . "php/view/lecturer/");
                    exit();
                }else{
                    $_SESSION['login_error'] = "Invalid user";
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                }
            } else {
                $_SESSION['login_error'] = "Invalid email or password.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }
}
