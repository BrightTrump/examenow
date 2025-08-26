<?php
include 'php/model/config.php';
include 'php/model/testcontroller.php';
$testController = new TestController();
$schedule_id = $_SESSION['schedule_id'];

$course_id = $testController->getcoursefromschedule($schedule_id);



$questions = [];
if ($course_id) {
    $questions = $testController->getQuestionsByCourse($course_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExameNow - Start Test</title>
    <link rel="stylesheet" href="assets/bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f6f8; }
        .question-list {
            max-height: 80vh;
            overflow-y: auto;
            background: white;
            padding: 10px;
            border-radius: 5px;
        }
        .question-list button {
            width: 100%;
            margin-bottom: 5px;
        }
        .question-card {
            background: white;
            padding: 20px;
            border-radius: 5px;
        }
        .submit-btn { margin-top: 20px; }
    </style>
</head>
<body>
<div class="container-fluid mt-4">
    <div class="row">
        <!-- LEFT: Question display -->
        <div class="col-md-9">
            <div class="question-card" id="questionDisplay">
                <h4>Select a question to start</h4>
            </div>

            <!-- Hidden form to store all answers -->
            <form id="testForm" method="post" action="php/controller/submit-test.php?course_id=<?=$course_id;?>">
                <?php foreach ($questions as $q): ?>
                    <input type="hidden" name="answers[<?php echo $q['id']; ?>]" id="answer_<?php echo $q['id']; ?>">
                <?php endforeach; ?>
                <button type="submit" class="btn btn-success btn-lg submit-btn">Submit Test</button>
            </form>
        </div>

        <!-- RIGHT: Question numbers -->
        <div class="col-md-3">
            <div class="question-list">
                <h5>Questions</h5>
                <?php if (!empty($questions)): ?>
                    <?php foreach ($questions as $index => $q): ?>
                        <button class="btn btn-outline-primary" onclick="loadQuestion(<?php echo $index; ?>)">
                            Question <?php echo $index + 1; ?>
                        </button>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No questions found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    let questions = <?php echo json_encode($questions); ?>;
    let savedAnswers = {}; // Store answers temporarily

    function loadQuestion(index) {
        let q = questions[index];
        let currentValue = savedAnswers[q.id] || ''; // Get saved value if any
        let html = `<h4>Question ${index + 1}</h4><p>${q.question_text}</p>`;

        if (q.question_type === 'mcq' && q.options) {
            let opts = JSON.parse(q.options);
            opts.forEach(opt => {
                let checked = (currentValue === opt) ? 'checked' : '';
                html += `<div>
                            <input type="radio" name="temp_answer" value="${opt}" ${checked}
                                onchange="saveAnswer(${q.id}, '${opt}')">
                            <label>${opt}</label>
                         </div>`;
            });
        } else if (q.question_type === 'true_false') {
            html += `<div>
                        <input type="radio" name="temp_answer" value="True" ${(currentValue === 'True') ? 'checked' : ''}
                            onchange="saveAnswer(${q.id}, 'True')"> True
                     </div>
                     <div>
                        <input type="radio" name="temp_answer" value="False" ${(currentValue === 'False') ? 'checked' : ''}
                            onchange="saveAnswer(${q.id}, 'False')"> False
                     </div>`;
        } else if (q.question_type === 'fill_blank') {
            html += `<input type="text" name="temp_answer" value="${currentValue}" 
                        oninput="saveAnswer(${q.id}, this.value)" 
                        class="form-control" placeholder="Your answer">`;
        }

        document.getElementById('questionDisplay').innerHTML = html;
    }

    function saveAnswer(qid, value) {
        savedAnswers[qid] = value;
        document.getElementById('answer_' + qid).value = value;
    }
</script>

<script src="assets/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
</body>
</html>
