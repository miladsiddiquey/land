<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST'); 
header('Access-Control-Allow-Headers: Content-Type'); 

// Include the Database class
include './config.php'; // Adjust the path as necessary

// Create a new instance of the Database class
$db = new Database();

// Get the JSON data from the request body
$data = json_decode(file_get_contents("php://input"), true);

// Check if the data is valid
if ($data && isset($data['apnId']) && isset($data['name']) && isset($data['email']) && isset($data['phone']) && isset($data['message'])) {
    // Escape and prepare the data
    $apnId = $db->escapeString($data['apnId']);
    $name = $db->escapeString($data['name']);
    $email = $db->escapeString($data['email']);
    $phone = $db->escapeString($data['phone']);
    $message = $db->escapeString($data['message']);

    // Prepare the data array
    $params = array(
        'apnId' => $apnId,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'message' => $message
    );

    // Insert data into the user_info table
    if ($db->insert('user_info', $params)) {
        echo json_encode(['status' => 'success', 'message' => 'Form submitted successfully']);
    } else {
        // Log or display detailed errors
        $errors = $db->getResult();
        error_log('Database insert error: ' . implode(', ', $errors));
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . implode(', ', $errors)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
