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
    'student' => null,
];

try {
    // Get student ID from query parameter
    $studentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($studentId <= 0) {
        $response['message'] = 'Invalid student ID';
        echo json_encode($response);
        ob_end_flush();
        exit();
    }

    // Get user data
    $user = get_userdata($studentId);

    if (! $user) {
        $response['message'] = 'Student not found';
        echo json_encode($response);
        ob_end_flush();
        exit();
    }

    // Get user meta data
    $studentData = [
        'user_id'           => $user->ID,
        'username'          => $user->user_login,
        'email'             => $user->user_email,
        'first_name'        => $user->first_name,
        'last_name'         => $user->last_name,
        'display_name'      => $user->display_name,
        'registered_date'   => $user->user_registered,
        'gender'            => get_user_meta($user->ID, 'gender', true),
        'date_of_birth'     => get_user_meta($user->ID, 'date_of_birth', true),
        'phone'             => get_user_meta($user->ID, 'phone', true),
        'emergency_phone'   => get_user_meta($user->ID, 'emergency_phone', true),
        'address'           => get_user_meta($user->ID, 'address', true),
        'class'             => get_user_meta($user->ID, 'class', true),
        'jamb_registration' => get_user_meta($user->ID, 'jamb_registration', true),
        'parent_name'       => get_user_meta($user->ID, 'parent_name', true),
        'parent_phone'      => get_user_meta($user->ID, 'parent_phone', true),
        'parent_email'      => get_user_meta($user->ID, 'parent_email', true),
        'parent_occupation' => get_user_meta($user->ID, 'parent_occupation', true),
        'registration_date' => get_user_meta($user->ID, 'registration_date', true),
    ];

    $response['success'] = true;
    $response['message'] = 'Student retrieved successfully';
    $response['student'] = $studentData;

} catch (Exception $e) {
    $response['message'] = 'An error occurred: ' . $e->getMessage();
}

echo json_encode($response);
ob_end_flush();
exit();
