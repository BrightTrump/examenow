<?php

class DepartmentController
{
    public $connection;
    public $url = "http://localhost/examnow/examenow/";

    public function __construct()
    {
        $conn = new config();
        $this->connection = $conn->getConnection();
    }
    public function createdepartment($departmentName, $departmentCode)
    {
        if (strlen($departmentName) < 3) {
            $_SESSION['department_error'] = "Department name must be at least 3 characters long.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } elseif (empty($departmentCode)) {
            $_SESSION['department_error'] = "Department code is required";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $createdAt = date('Y-m-d');
            $prepared = "INSERT INTO `department`(`department_name`, `department_code`, `createdAt`, `updatedAt`) VALUES ('$departmentName','$departmentCode','$createdAt','$createdAt')";
            $sql = $this->connection->query($prepared);
            if ($sql == TRUE) {
                $_SESSION['department_success'] = "Department created successful!";
                header("Location: " . $this->url . "php/view/admin/department.php");
                exit();
            }
        }
    }
    public function alldepartments()
    {
        $prepared = "SELECT * FROM `department` order by id desc";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                echo '  <tr>
                            <th>'.$i++.'</th>
                            <th>'.$value['department_name'].'</th>
                            <th>'.$value['department_code'].'</th>
                            <th>'.$value['createdAt'].'</th>
                            <th><a href="../../controller/deletedepartment.php?id='.$value['id'].'" class="text-danger">Delete</a></th>
                        </tr>';
            }
        }else {
            echo '<tr>
                    <td colspan="5" class="text-center">No departments found</td>
                  </tr>';
        }
    }
    public function deletedepartment($department_id){
        $prepared = "DELETE FROM `department` WHERE id = '$department_id'";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
                $_SESSION['department_success'] = "Department deleted successful!";
                header("Location: " . $this->url . "php/view/admin/department.php");
                exit();
            }
    }
    public function departmentasoption(){
        $prepared = "SELECT * FROM `department` order by id desc";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                echo '<option value="'.$value['id'].'">'.$value['department_name'].'</option>';
            }
        }
    }
}