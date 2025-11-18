<?php
header('Content-Type: application/json');

// Load WordPress
require_once '../../../../../wp-load.php';

// Suppress errors from printing to output
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Start output buffering
ob_start();

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get JSON input from request body
    $input   = json_decode(file_get_contents('php://input'), true);

    if (is_null($input)) {
        $response['message'] = 'Invalid JSON input';
        echo json_encode($response);
        ob_end_flush();
        exit();
    }

    $classId = intval($input['class_id'] ?? 0);

    if ($classId <= 0) {
        $response['message'] = 'Invalid class ID';
        echo json_encode($response);
        ob_end_flush();
        exit();
    }

    try {
        global $wpdb;
        $table_name = $wpdb->prefix . 'classes';

        // Check if class exists
        $class = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d",
            $classId
        ), ARRAY_A);

        if (! $class) {
            $response['message'] = 'Class not found';
            echo json_encode($response);
            ob_end_flush();
            exit();
        }

        // Delete the class
        $deleted = $wpdb->delete(
            $table_name,
            ['id' => $classId],
            ['%d']
        );

        if ($deleted) {
            $response['success'] = true;
            $response['message'] = 'Class deleted successfully';
        } else {
            $response['message'] = 'Failed to delete class';
        }

    } catch (Exception $e) {
        $response['message'] = 'An error occurred: ' . $e->getMessage();
    }

} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
ob_end_flush();
exit();
