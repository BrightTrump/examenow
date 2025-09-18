<?php
include '../../model/config.php';
include '../../model/testcontroller.php';



$test_id = $_GET['id'] ?? null;

if (!$test_id) {
    die("Invalid Test ID");
}

$test = new TestController();

// Fetch results
$test_results = $test->getTestResults($test_id);

// Send CSV headers
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="test_scores_' . $test_id . '.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Add column headers
fputcsv($output, ['S/N', 'Matric No', 'Score']);

// Fill rows
$i = 1;
foreach ($test_results as $row) {
    fputcsv($output, [$i++, $row['matno'], $row['performance']]);
}

fclose($output);
exit;
