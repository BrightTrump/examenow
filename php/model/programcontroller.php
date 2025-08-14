<?php

class ProgramController
{
    public $connection;
    public $url = "http://localhost/examnow/examenow/";

    public function __construct()
    {
        $conn = new config();
        $this->connection = $conn->getConnection();
    }
    public function createprogram($departmentName, $departmentOption, $departmentLevel)
    {
        if ($departmentName == "") {
            $_SESSION['program_error'] = "Department name is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } elseif (empty($departmentOption)) {
            $_SESSION['program_error'] = "Department option is required";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } elseif (empty($departmentLevel)) {
            $_SESSION['program_error'] = "Department level is required";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $createdAt = date('Y-m-d');
            $prepared = "INSERT INTO `program`(`department_name`, `department_option`, `department_level`, `createdAt`, `updatedAt`) VALUES ('$departmentName','$departmentOption','$departmentLevel','$createdAt','$createdAt')";
            $sql = $this->connection->query($prepared);
            if ($sql == TRUE) {
                $_SESSION['program_success'] = "Program created successful!";
                header("Location: " . $this->url . "php/view/admin/program.php");
                exit();
            }
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
    public function allprogram()
    {
        $prepared = "SELECT * FROM `program` order by id desc";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                echo '  <tr>
                            <th>'.$i++.'</th>
                            <th>'.$this->departmentname($value['department_name']).'</th>
                            <th>'.$value['department_option'].'</th>
                            <th class="text-uppercase">'.$value['department_level'].'</th>
                            <th>'.$value['createdAt'].'</th>
                            <th><a href="../../controller/deleteprogram.php?id='.$value['id'].'" class="text-danger">Delete</a></th>
                        </tr>';
            }
        }else {
            echo '<tr>
                    <td colspan="5" class="text-center">No departments found</td>
                  </tr>';
        }
    }
    public function deleteprogram($department_id){
        $prepared = "DELETE FROM `program` WHERE id = '$department_id'";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
                $_SESSION['program_success'] = "Program deleted successful!";
                header("Location: " . $this->url . "php/view/admin/program.php");
                exit();
            }
    }
    public function programasoption(){
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