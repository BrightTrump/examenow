<?php

class CourseController
{
    public $connection;
    public $url =  "http://localhost/work/examenow/";

    public function __construct()
    {
        $conn = new config();
        $this->connection = $conn->getConnection();
    }
    public function createCourse($courseName, $courseCode, $departmentName, $level, $subLevel, $semester, $program)
    {

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
        } else {
            $createdAt = date('Y-m-d');
            $prepared = "INSERT INTO `course`(`course_name`, `course_code`, `department`, `program`, `school_level`, `sub_level`, `semester`, `createdAt`, `updatedAt`) VALUES ('$courseName','$courseCode','$departmentName','$program','$level','$subLevel','$semester','$createdAt','$createdAt')";
            $sql = $this->connection->query($prepared);
            if ($sql == TRUE) {
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
    public function allgeneralcourses()
    {
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
    public function deletecourse($course_id)
    {
        $prepared = "DELETE FROM `course` WHERE id = '$course_id'";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
            $_SESSION['course_success'] = "Course deleted successful!";
            header("Location: " . $this->url . "php/view/admin/course.php");
            exit();
        }
    }

    public function courseperdepartment($department_id)
    {
        $prepared = "SELECT * FROM `course` WHERE `department` = '$department_id'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                echo '  <tr>
                            <th>' . $i++ . '</th>
                            <th>' . $value['course_name'] . '</th>
                            <th>' . $value['course_code'] . '</th>
                            <th class="text-uppercase">' . $value['school_level'] . '</th>
                            <th>' . $value['sub_level'] . '</th>
                            <th>' . $value['semester'] . '</th>
                            <th><a href="../../controller/deletecourse.php?id=' . $value['id'] . '" class="text-danger">Delete</a></th>
                        </tr>';
            }
        } else {
            echo '<tr>
                    <td colspan="7" class="text-center">No courses found for this department</td>
                  </tr>';
        }
    }
    public function countofcourses()
    {
        $prepared = "SELECT COUNT(*) as total FROM `course`";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $details = $sql->fetch_assoc();
            return $details['total'];
        }
        return 0;
    }

    public function listofallcourses($department_id)
    {
        $prepared = "SELECT * FROM `course` WHERE `department` = '$department_id' OR `department` = '10000' ORDER BY id DESC";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                echo '<div class="col-md-6 offset-md-3">
                    <div>
                        <form method="POST" action="../../controller/addcourse.php?id=' . $value['id'] . '" class="d-flex justify-content-between align-items-center">
                            <div class="form-group align-items-center mb-0">
                              <label for="">' . $value['course_name'] . ' (' . $value['course_code'] . ') (' . $value['school_level'] . ')</label>

                            </div>
                            <button type="submit" class="btn btn-primary py-2">Add</button>
                        </form>

                    </div>
                  </div>';
            }
        } else {
            echo '<tr>
                    <td colspan="7" class="text-center">No courses found</td>
                  </tr>';
        }
    }
    public function addcoursetouser($course_id, $user_id)
    {
        $prepared = "INSERT INTO `courseshandled` (`course_id`,`user_id`) VALUES ('$course_id', '$user_id')";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
            $_SESSION['course_success'] = "Course added to user successfully!";
            header("Location: " . $this->url . "php/view/lecturer/course.php");
            exit();
        } else {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    public function courseDetails($course_id)
    {
        $prepared = "SELECT * FROM `course` WHERE id = '$course_id'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            return $sql->fetch_assoc();
        } else {
            return null;
        }
    }
    public function coursehandled($user_id)
    {
        $prepared = "SELECT * FROM `courseshandled` WHERE `user_id` = '$user_id'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                $course_details = $this->courseDetails($value['course_id']);
                echo '  <tr>
                            <th>' . $i++ . '</th>
                            <th>' . $course_details['course_name'] . '</th>
                            <th>' . $course_details['course_code'] . '</th>
                            <th class="text-uppercase">' . $course_details['school_level'] . '</th>
                            <th>' . $course_details['sub_level'] . '</th>
                            <th>' . $course_details['semester'] . '</th>
                            <th><a href="../../controller/deletecoursehandled.php?id=' . $value['id'] . '" class="text-danger">Delete</a></th>
                        </tr>';
            }
        } else {
            echo '<tr>
                    <td colspan="6" class="text-center">No courses handled</td>
                  </tr>';
        }
    }
    public function deletecoursehandled($course_id, $user_id){
        $prepared = "DELETE FROM `courseshandled` WHERE course_id = '$course_id' AND user_id = '$user_id'";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
            $_SESSION['course_success'] = "Course removed from user successfully!";
            header("Location: " . $this->url . "php/view/lecturer/course.php");
            exit();
        } else {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    public function courseshandled($user_id){
        $prepared = "SELECT * FROM `courseshandled` WHERE `user_id` = '$user_id' order by id desc";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            foreach ($sql as $value) {
                echo '<div class="col-md-3">
                    <a href="testquestion.php?id='.$value['id'].'">
                      <div class="card">
                        <div class="card-body bg-primary">
                          <h5 class="card-title text-white text-center">'.$this->courseDetails($value['course_id'])['course_name'].'</h5>
                          <p class="card-text text-white text-center">'.$this->courseDetails($value['course_id'])['course_code'].'</p>
                        </div>
                      </div>
                    </a>
                </div>';
            }
        }
    }
    public function courseshandledoption($user_id){
        $prepared = "SELECT * FROM `courseshandled` WHERE user_id = '$user_id' order by id desc";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            foreach ($sql as $value) {
                echo '<option value="'.$value['course_id'].'">'.$this->courseDetails($value['course_id'])['course_name'].'</option>';
            }
        }else {
            echo '<option value="">No courses found</option>';
        }
    }
    
}
