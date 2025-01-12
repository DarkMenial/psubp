<?php
require_once 'db_connect.php';

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and decode the JSON data
    $requestData = json_decode(file_get_contents("php://input"));

    // Check if the required fields are set in the JSON data
    if (isset($requestData->type, $requestData->item, $requestData->account_id, $requestData->table_name)) {
        $type = mysqli_real_escape_string($conn, $requestData->type);
        $item = mysqli_real_escape_string($conn, $requestData->item);
        $account_id = mysqli_real_escape_string($conn, $requestData->account_id);
        $table_name = mysqli_real_escape_string($conn, $requestData->table_name);

        // The rest of your code to archive the item

        // Return a response
        echo "Item archived successfully.";
    } else {
        echo "Missing required fields in the JSON data.";
    }
} else {
    echo "Invalid request method.";
}



?>
