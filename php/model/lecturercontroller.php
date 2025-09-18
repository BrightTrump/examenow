<?php 

class LecturerController {
     public $connection;
    public $url =  "http://localhost/work/examenow/";

    public function __construct() {
        $conn = new config();
        $this->connection = $conn->getConnection();
    }
    public function createLecturer($name, $email, $department) {
        if (strlen($name) < 3) {
            $_SESSION['lecturer_error'] = "Lecturer name must be at least 3 characters long.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } elseif (empty($email)) {
            $_SESSION['lecturer_error'] = "Email is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } elseif (empty($department)) {
            $_SESSION['lecturer_error'] = "Department is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $password = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $createdAt = date('Y-m-d');
            $prepared = "INSERT INTO `users`(`fullname`, `email`, `password`, `role`, `department`, `level`, `program`, `createdAt`, `updatedAt`, `status`) VALUES ('$name','$email','$password','lecturer','$department','','','$createdAt','$createdAt',1)";
            $sql = $this->connection->query($prepared);
            if ($sql == TRUE) {
                $_SESSION['lecturer_success'] = "Lecturer created successfully!";
                header("Location: " . $this->url . "php/view/admin/lecturer.php");
                exit();
            }
        }
    }
    public function alllecturers()
    {
        $prepared = "SELECT * FROM `users` where id != '1' and role = 'lecturer' order by department desc";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                if ($value['status'] == 1) {
                    $status = '<span class="badge badge-success">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger">Inactive</span>';
                }
                $department_name = $this->departmentname($value['department']);
                echo '  <tr>
                            <th>'.$i++.'</th>
                            <th>'.$value['fullname'].'</th>
                            <th>'.$value['email'].'</th>
                            <th class="text-capitalize">'.$department_name.'</th>
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
    public function departmentname($department_id){
        $prepared = "SELECT * FROM `department` where id = '$department_id'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $details = $sql->fetch_assoc();
            return $details['department_name'];
        }
    }
    public function countoflecturers()
    {
        $prepared = "SELECT COUNT(*) as total FROM `users` WHERE role = 'lecturer'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $details = $sql->fetch_assoc();
            return $details['total'];
        }
        return 0;
    }
}