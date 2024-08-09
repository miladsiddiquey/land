<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow cross-origin requests

// Get the student_id from query parameters
$state = $data['state']

include "./config.php";

$obj = new Database();
$sql = "SELECT * FROM post_data WHERE state LIKE  '%{$state}%'";
$obj->sql($sql);
$result = $obj->getResult();

if (is_array($result) && count($result) > 0) {
    echo json_encode($result);
} else {
    echo json_encode(array('message' => 'No Search Found Found.', 'status' => false));
}

?>
