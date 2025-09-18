<?php

class TestController
{
    public $connection;
    public $url = "http://localhost/work/examenow/";

    public function __construct()
    {
        $conn = new config();
        $this->connection = $conn->getConnection();
    }

    public function createQuestion($course_id, $questionText, $questionType, $options, $correctAnswer)
    {
        if ($course_id == '') {
            $_SESSION['question_error'] = "Course ID is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        if (strlen($questionText) < 5) {
            $_SESSION['question_error'] = "Question text must be at least 5 characters long.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        if (empty($questionType)) {
            $_SESSION['question_error'] = "Question type is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        if (empty($correctAnswer)) {
            $_SESSION['question_error'] = "Correct answer is required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        $createdAt = date('Y-m-d');
        $prepared = "INSERT INTO `questions`(`course_id`, `question_text`, `question_type`, `options`, `correct_answer`, `createdAt`, `updatedAt`) VALUES ('$course_id', '$questionText', '$questionType', '" . json_encode($options) . "', '$correctAnswer', '$createdAt', '$createdAt')";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
            $_SESSION['question_success'] = "Question created successfully!";
            header("Location: " . $this->url . "php/view/lecturer/testquestion.php?id=$course_id");
            exit();
        } else {
            $_SESSION['question_error'] = "Failed to create question. Please try again.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

    }

    public function getQuestions($testId)
    {
        $prepared = "SELECT * FROM `questions` WHERE course_id = '$testId'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                if ($value['question_type'] != 'mcq') {
                    $options = 'N/A';
                } else {
                    $options = implode(", ", json_decode($value['options']));
                }
                echo '<tr>';
                echo '<td>' . $i++ . '</td>';
                echo '<td>' . $value['question_text'] . '</td>';
                echo '<td>' . $value['question_type'] . '</td>';
                echo '<td>' . $options . '</td>';
                echo '<td>' . $value['correct_answer'] . '</td>';
                echo '<td>
                        <a href="edit.php?id=' . $value['id'] . '" class="btn btn-success btn-sm">Edit</a>
                        <a href="../../controller/deletequestion.php?id=' . $value['id'] . '" class="btn btn-danger btn-sm">Delete</a>
                      </td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6" class="text-center">No questions found.</td></tr>';
        }
    }

    public function updateQuestion($questionId, $data)
    {
        // Implementation for updating a question
    }

    public function deleteQuestion($questionId)
    {
        $prepared = "DELETE FROM `questions` WHERE id = '$questionId'";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
            $_SESSION['question_success'] = "Question deleted successfully!";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $_SESSION['question_error'] = "Failed to delete question. Please try again.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    public function scheduleTest($course_id, $test_title, $test_description, $test_time, $test_duration, $user_id)
    {
        if (empty($course_id) || empty($test_title) || empty($test_description) || empty($test_time) || empty($test_duration)) {
            $_SESSION['test_error'] = "All fields are required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        $createdAt = date('Y-m-d');
        $prepared = "INSERT INTO `testschedule`(`course_id`, `test_title`, `test_description`, `test_time`, `test_duration`, `createdAt`, `updatedAt`, `user_id`) VALUES ('$course_id', '$test_title', '$test_description', '$test_time', '$test_duration', '$createdAt', '$createdAt', '$user_id')";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
            $_SESSION['test_success'] = "Test scheduled successfully!";
            header("Location: " . $this->url . "php/view/lecturer/scheduletest.php");
            exit();
        } else {
            $_SESSION['test_error'] = "Failed to schedule test. Please try again.";
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
    public function getScheduledTests($user_id)
    {
        $prepared = "SELECT * FROM `testschedule` WHERE user_id = '$user_id' ORDER BY createdAt DESC";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
            $i = 1;
            foreach ($sql as $value) {
                echo '<tr>';
                echo '<td>' . $i++ . '</td>';
                echo '<td>' . $this->courseDetails($value['course_id'])['course_name'] . '</td>';
                echo '<td>' . $value['test_title'] . '</td>';
                echo '<td>' . $value['test_time'] . '</td>';
                echo '<td>' . $value['test_duration'] . ' minutes</td>';
                echo '<td>
                        <a href="edit.php?id=' . $value['id'] . '" class="btn btn-success btn-sm">Edit</a>
                        <a href="../../controller/deletescheduledtest.php?id=' . $value['id'] . '" class="btn btn-danger btn-sm">Delete</a>
                      </td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6" class="text-center">No scheduled tests found.</td></tr>';
        }
    }
    public function deleteScheduledTest($testId)
    {
        $prepared = "DELETE FROM `testschedule` WHERE id = '$testId'";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
            $_SESSION['test_success'] = "Test deleted successfully!";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $_SESSION['test_error'] = "Failed to delete test. Please try again.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    public function getScheduledTestForToday()
    {
        
        $today = date('Y-m-d');
       
        $prepared = "SELECT * FROM `testschedule` WHERE test_time = '$today' ";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
           
            foreach ($sql as $value) {
                echo '<option value="' . $value['id'] . '">' . $this->courseDetails($value['course_id'])['course_name'] . '</option>';
            }
        } else {
            echo '<option value="">No tests scheduled for today</option>';
        }
    }
    public function getQuestionsByCourse($course_id)
    {

        $sql = "SELECT * FROM questions WHERE course_id = '$course_id'";
        $result = $this->connection->query($sql);

        $questions = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $questions[] = $row;
            }
        }
        return $questions;
    }
    public function getcoursefromschedule($schedule_id){
        $sql = "SELECT * FROM testschedule WHERE id = '$schedule_id'";
        $result = $this->connection->query($sql);
        if ($result && $result->num_rows > 0) {
           $details = $result->fetch_assoc();
            return  $details['course_id'];
        }
        return null;
    }
    public function submitTest($answers, $course_id, $matno, $schedule_id)
    {
        $score = 0;
        $totalQuestions = count($answers);
        $today = date('Y-m-d'); // or however you're identifying the test

        foreach ($answers as $question_id => $user_answer) {
            // Query the correct answer for this question
            $prepared = "SELECT correct_answer FROM `questions` WHERE id = '$question_id'";
            $sql = $this->connection->query($prepared);

            if ($sql && $sql->num_rows > 0) {
                $row = $sql->fetch_assoc();
                $correct_answer = $row['correct_answer'];

                // Compare user's answer with the correct one
                if (trim(strtolower($user_answer)) === trim(strtolower($correct_answer))) {
                    $score++;
                }
            }
        }

        // Calculate percentage
        $percentage = ($totalQuestions > 0) ? ($score / $totalQuestions) * 100 : 0;
        $prepared = "INSERT INTO `performance`(`matno`, `course_id`, `dateoftest`, `test_id`, `performance`) VALUES ('$matno','$course_id','$today','$schedule_id','$percentage')";
        $sql = $this->connection->query($prepared);
        if ($sql == TRUE) {
             $_SESSION['sumit_success'] = "Test submitted successfully!";
            header("Location: " . $this->url . "score.php?performance=$percentage");
            exit();
        }
    //    var_dump( [
    //         'score' => $score,
    //         'total' => $totalQuestions,

    //         'percentage' => $percentage
    //     ]);
    }
    public function getTestScheduled($user_id){
        $prepared = "SELECT * FROM `testschedule` WHERE user_id = '$user_id'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
           return $sql->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    public function getTestResults($test_id){
        $prepared = "SELECT * FROM `performance` WHERE test_id = '$test_id'";
        $sql = $this->connection->query($prepared);
        if ($sql->num_rows > 0) {
           return $sql->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}