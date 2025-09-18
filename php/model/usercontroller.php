<?php 

class UserController {
    public $connection;
    public $url = "http://localhost/work/examenow/";

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
    public function allusers()
    {
        $prepared = "SELECT * FROM `users` where id != '1' and role = 'student' order by id desc";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                if ($value['status'] == 1) {
                    $status = '<span class="badge badge-success">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger">Inactive</span>';
                }
                echo '  <tr>
                            <th>'.$i++.'</th>
                            <th>'.$value['fullname'].'</th>
                            <th>'.$value['email'].'</th>
                            <th class="text-uppercase">'.$value['role'].'</th>
                            <th>'.$value['createdAt'].'</th>
                            <th><a href="../../controller/changeuserstatus.php?id='.$value['id'].'" class="text-danger">'.$status.'</a></th>
                        </tr>';
            }
        }else {
            echo '<tr>
                    <td colspan="5" class="text-center">No departments found</td>
                  </tr>';
        }
    }
    public function changeuserstatus($user_id) {
        $prepared = "SELECT * FROM `users` WHERE id = '$user_id'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $user = $sql->fetch_assoc();
            $new_status = ($user['status'] == 1) ? 0 : 1;
            $update_query = "UPDATE `users` SET status = '$new_status' WHERE id = '$user_id'";
            if ($this->connection->query($update_query) === TRUE) {
                $_SESSION['status_change_success'] = "User status updated successfully!";
            } else {
                $_SESSION['status_change_error'] = "Failed to update user status.";
            }
        } else {
            $_SESSION['status_change_error'] = "User not found.";
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
    public function countofusers(){
        $prepared = "SELECT COUNT(*) as total FROM `users` WHERE role = 'student'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $details = $sql->fetch_assoc();
            return $details['total'];
        }
        return 0;
    }
    public function userdetails($user_id) {
        $prepared = "SELECT * FROM `users` WHERE id = '$user_id'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            return $sql->fetch_assoc();
        } else {
            return null;
        }

    }
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: " . $this->url . "login.php");
        exit();
    }
    

    public function startTest($schedule_id, $matno) {
        

        if ($schedule_id == '' || $matno == '') {
            $_SESSION['test_error'] = "All fields are required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        $_SESSION['schedule_id'] = $schedule_id;
        $_SESSION['usermatno'] = $matno;

        

        header("Location: " . $this->url . "start-test.php");
        exit();
    }
}
