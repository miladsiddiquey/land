<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow cross-origin requests

// Get the student_id from query parameters
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

include "./config.php";

$obj = new Database();
$sql = "SELECT * FROM post_data WHERE id = {$student_id}";
$obj->sql($sql);
$result = $obj->getResult();

if (is_array($result) && count($result) > 0) {
    echo json_encode($result);
} else {
    echo json_encode(array('message' => 'No Record Found.', 'status' => false));
}

?>
