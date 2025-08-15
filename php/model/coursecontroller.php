<?php 

class CourseController {
    public $connection;
    public $url = "http://localhost/examnow/examenow/";

    public function __construct() {
        $conn = new config();
        $this->connection = $conn->getConnection();
    }
    public function createCourse($courseName, $courseCode, $departmentName, $level, $subLevel, $semester, $program) {

        if (strlen($courseName) < 3) {
            $_SESSION['course_error'] = "Course name must be at least 3 characters.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        if (empty($courseCode)) {
            $_SESSION['course_error'] = "Course code is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        if (empty($departmentName)) {
            $_SESSION['course_error'] = "Department name is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        if (empty($subLevel)) {
            $_SESSION['course_error'] = "Sub level is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        if (empty($semester)) {
            $_SESSION['course_error'] = "Semester is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }else {
            $createdAt = date('Y-m-d');
            $prepared = "INSERT INTO `course`(`course_name`, `course_code`, `department`, `program`, `school_level`, `sub_level`, `semester`, `createdAt`, `updatedAt`) VALUES ('$courseName','$courseCode','$departmentName','$program','$level','$subLevel','$semester','$createdAt','$createdAt')";
            $sql = $this->connection->query($prepared);
            if ($sql == TRUE ) {
                $_SESSION['course_success'] = "Course added successful!";
                header("Location: " . $this->url . "php/view/admin/course.php");
                exit();
            } else {
                $_SESSION['course_error'] = "Course addition failed. Please try again.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }
    public function allgeneralcourses(){
        $query = "SELECT * FROM `course` WHERE `department` = '10000'";
        $result = $this->connection->query($query);
        if ($result->num_rows > 0) {
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $i++ . "</td>";
                echo "<td>" . $row['course_name'] . "</td>";
                echo "<td>" . $row['course_code'] . "</td>";
                echo "<td class='text-uppercase'>" . $row['school_level'] . "</td>";
                echo "<td>" . $row['sub_level'] . "</td>";
                echo "<td>" . $row['semester'] . "</td>";
                echo "<td>
                        <a href='../../controller/deletecourse.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No courses found</td></tr>";
        }
    }
    public function deletecourse($course_id){
        $prepared = "DELETE FROM `course` WHERE id = '$course_id'";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
                $_SESSION['course_success'] = "Course deleted successful!";
                header("Location: " . $this->url . "php/view/admin/course.php");
                exit();
            }
    }

    public function courseperdepartment($department_id){
        $prepared = "SELECT * FROM `course` WHERE `department` = '$department_id'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                echo '  <tr>
                            <th>'.$i++.'</th>
                            <th>'.$value['course_name'].'</th>
                            <th>'.$value['course_code'].'</th>
                            <th class="text-uppercase">'.$value['school_level'].'</th>
                            <th>'.$value['sub_level'].'</th>
                            <th>'.$value['semester'].'</th>
                            <th><a href="../../controller/deletecourse.php?id='.$value['id'].'" class="text-danger">Delete</a></th>
                        </tr>';
            }
        }else {
            echo '<tr>
                    <td colspan="7" class="text-center">No courses found for this department</td>
                  </tr>';
        }
    }
    public function countofcourses(){
        $prepared = "SELECT COUNT(*) as total FROM `course`";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $details = $sql->fetch_assoc();
            return $details['total'];
        }
        return 0;
    }
    
}
