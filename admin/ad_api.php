<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow cross-origin requests

include "./config.php";

$obj = new Database();
$obj->select('advertise');

// Fetch the result as an associative array
$result = $obj->getResult();

if (is_array($result) && count($result) > 0) {
    echo json_encode($result);
} else {
    echo json_encode(array('message' => 'No Record Found.', 'status' => false));
}

?>
