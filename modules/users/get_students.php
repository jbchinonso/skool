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
    'students' => []
];

try {
    // Query all users with subscriber role (students)
    $args = array(
        'role' => 'student',
        'orderby' => 'registered',
        'order' => 'DESC',
        'number' => -1 // Get all students
    );
    
    $user_query = new WP_User_Query($args);
    $users = $user_query->get_results();
    
    if (!empty($users)) {
        foreach ($users as $user) {
            // Get user meta data
            $studentData = array(
                'user_id' => $user->ID,
                'username' => $user->user_login,
                'email' => $user->user_email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'display_name' => $user->display_name,
                'registered_date' => $user->user_registered,
                'gender' => get_user_meta($user->ID, 'gender', true),
                'date_of_birth' => get_user_meta($user->ID, 'date_of_birth', true),
                'phone' => get_user_meta($user->ID, 'phone', true),
                'emergency_phone' => get_user_meta($user->ID, 'emergency_phone', true),
                'address' => get_user_meta($user->ID, 'address', true),
                'class' => get_user_meta($user->ID, 'class', true),
                'jamb_registration' => get_user_meta($user->ID, 'jamb_registration', true),
                'parent_name' => get_user_meta($user->ID, 'parent_name', true),
                'parent_phone' => get_user_meta($user->ID, 'parent_phone', true),
                'parent_email' => get_user_meta($user->ID, 'parent_email', true),
                'parent_occupation' => get_user_meta($user->ID, 'parent_occupation', true),
                'registration_date' => get_user_meta($user->ID, 'registration_date', true)
            );
            
            $response['students'][] = $studentData;
        }
        
        $response['success'] = true;
        $response['message'] = 'Students retrieved successfully';
    } else {
        $response['success'] = true;
        $response['message'] = 'No students found';
    }
    
} catch (Exception $e) {
    $response['message'] = 'An error occurred: ' . $e->getMessage();
}

echo json_encode($response);
ob_end_flush();
exit();
?>