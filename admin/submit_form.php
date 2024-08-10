<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Adjust as necessary

// Include the Database class
include './config.php'; // Adjust the path as necessary

// Create a new instance of the Database class
$db = new Database();

// Get the JSON data from the request body
$data = json_decode(file_get_contents("php://input"), true);

// Check if the data is valid
if ($data && isset($data['apn_id']) && isset($data['name']) && isset($data['email']) && isset($data['phone']) && isset($data['message'])) {
    // Escape and prepare the data
    $apn_id = $db->escapeString($data['apn_id']);
    $name = $db->escapeString($data['name']);
    $email = $db->escapeString($data['email']);
    $phone = $db->escapeString($data['phone']);
    $message = $db->escapeString($data['message']);

    // Prepare the data array
    $params = array(
        'apn_id' => $apn_id,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'message' => $message
    );

    // Insert data into the user_info table
    if ($db->insert('user_info', $params)) {
        echo json_encode(['status' => 'success', 'message' => 'Form submitted successfully']);
    } else {
        $errors = $db->getResult();
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . implode(', ', $errors)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
