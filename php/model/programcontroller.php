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
    public function departmentname($department_id)
    {
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
                            <th>' . $i++ . '</th>
                            <th>' . $this->departmentname($value['department_name']) . '</th>
                            <th>' . $value['department_option'] . '</th>
                            <th class="text-uppercase">' . $value['department_level'] . '</th>
                            <th>' . $value['createdAt'] . '</th>
                            <th><a href="../../controller/deleteprogram.php?id=' . $value['id'] . '" class="text-danger">Delete</a></th>
                        </tr>';
            }
        } else {
            echo '<tr>
                    <td colspan="5" class="text-center">No departments found</td>
                  </tr>';
        }
    }
    public function deleteprogram($department_id)
    {
        $prepared = "DELETE FROM `program` WHERE id = '$department_id'";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
            $_SESSION['program_success'] = "Program deleted successful!";
            header("Location: " . $this->url . "php/view/admin/program.php");
            exit();
        }
    }
    public function programasoption()
    {
        $prepared = "SELECT * FROM `department` order by id desc";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                echo '<option value="' . $value['id'] . '">' . $value['department_name'] . '</option>';
            }
        }
    }
    public function getProgramsByDepartment($department_id)
    {
        $prepared = "SELECT * FROM `program` WHERE department_name = '$department_id' order by department_name desc";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            foreach ($sql as $value) {
                echo '<input type="checkbox" name="programs[]" value="' . $value['id'] . '"> ' . $value['department_option'] . ' (' . $value['department_level'] . ')<br>';
            }
        } else {
            echo '<input type="checkbox" name="programs[]" value=""> No programs available</input>';
        }
    }
    // public function programs($department_id){
    //     $prepared = "SELECT * FROM `program` where department_name = '$department_id' order by id desc";
    //     $sql = $this->connection->query($prepared);
    //     if ($sql->num_rows > 0) {
    //         foreach ($sql as $value) {
    //             $program_id = $value['id'];
    //             $prepared = "SELECT * FROM `course` where FIND_IN_SET('$program_id', program) or program = ''";
    //             $sql = $this->connection->query($prepared);
    //             if ($sql->num_rows > 0) {
    //                 foreach ($sql as $course) {
    //                     echo '<div class="ml-4">'.$course['course_name'].'</div>';
    //                 }
    //             }else{
    //                 echo '<div class="ml-4">No courses available</div>';
    //             }
    //             echo '<div>'.$value['department_option'].' ('.$value['department_level'].')</div>';
    //         }
    //     }else{
    //         echo '<div>No programs available</div>';
    //     }
    // }
    public function programs($department_id)
{
    // Get programs for this department
    $prepared = "SELECT * FROM `program` WHERE department_name = '$department_id' ORDER BY department_level DESC";
    $programs = $this->connection->query($prepared);

    if ($programs->num_rows > 0) {
        foreach ($programs as $program) {
            $program_id       = $program['id'];
            $department_level = $program['department_level'];
            $levelName        = strtoupper($department_level); // ND / HND

            echo '<div><strong class="text-primary">' . $program['department_option'] . ' (' . $levelName . ')</strong></div>';

            // Get program-specific courses
            $programCourses = $this->connection->query("
                SELECT course_name, school_level, sub_level, semester, id
                FROM course
                WHERE FIND_IN_SET('$program_id', program)
            ");

            // Get general courses for this level
            $generalCourses = $this->connection->query("
                SELECT course_name, school_level, sub_level, semester, id
                FROM course
                WHERE program = '' AND school_level = '$department_level'
            ");

            // Merge without duplicates
            $allCourses = [];
            $seen = [];

            foreach ([$programCourses, $generalCourses] as $resultSet) {
                if ($resultSet && $resultSet->num_rows > 0) {
                    foreach ($resultSet as $course) {
                        $key = $course['course_name'] . '|' . $course['sub_level'] . '|' . $course['semester'];
                        if (!isset($seen[$key])) {
                            $allCourses[] = $course;
                            $seen[$key] = true;
                        }
                    }
                }
            }

            if (!empty($allCourses)) {
                // Group by sublevel and semester
                $grouped = [];
                foreach ($allCourses as $course) {
                    $subLvl = $course['sub_level'];
                    $sem    = $course['semester'];
                    $grouped[$subLvl][$sem][] = $course;
                }

                // Sort sublevels (1, 2) and semesters (1, 2)
                ksort($grouped);
                foreach ($grouped as &$semesters) {
                    ksort($semesters);
                }

                // Display in ND1/ND2 order
                foreach ($grouped as $subLvl => $semesters) {
                    echo "<h4>{$levelName}{$subLvl}</h4>";
                    foreach ($semesters as $sem => $courses) {
                        echo "<h5>Semester {$sem}</h5>";
                        foreach ($courses as $course) {
                            echo '<div class="ml-4">'
                               . $course['course_name']
                               . ' <a href="../../controller/deletecourse.php?id=' . $course['id'] . '">Delete</a>'
                               . '</div>';
                        }
                    }
                }
            } else {
                echo '<div class="ml-4">No courses available</div>';
            }
        }
    } else {
        echo '<div>No programs available</div>';
    }
}




}