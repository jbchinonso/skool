<?php
// Set response header FIRST before any output
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
    'classes' => [],
];

try {
    global $wpdb;
    $table_name = $wpdb->prefix . 'classes';

    // Check if table exists
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;

    if (! $table_exists) {
        $response['success'] = true;
        $response['message'] = 'No classes found';
        echo json_encode($response);
        ob_end_flush();
        exit();
    }

    // Get all classes
    $classes = $wpdb->get_results(
        "SELECT * FROM $table_name ORDER BY class_level ASC, class_name ASC",
        ARRAY_A
    );

    if ($classes) {
        // Get student count for each class
        foreach ($classes as &$class) {
            $studentCount = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->usermeta}
                WHERE meta_key = 'class' AND meta_value = %s",
                $class['class_level']
            ));

            $class['student_count'] = $studentCount;
        }

        $response['success'] = true;
        $response['message'] = 'Classes retrieved successfully';
        $response['classes'] = $classes;
    } else {
        $response['success'] = true;
        $response['message'] = 'No classes found';
    }

} catch (Exception $e) {
    $response['message'] = 'An error occurred: ' . $e->getMessage();
}

echo json_encode($response);
ob_end_flush();
exit();
