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

    $className    = sanitize_text_field($_POST['className'] ?? '');
    $classLevel   = sanitize_text_field($_POST['classLevel'] ?? '');
    $classTeacher = sanitize_text_field($_POST['classTeacher'] ?? '');
    $capacity     = intval($_POST['capacity'] ?? 0);
    $description  = sanitize_textarea_field($_POST['classDescription'] ?? '');

    if (empty($className) || empty($classLevel)) {
        $response['message'] = 'Class name and level are required';
        echo json_encode($response);
        ob_end_flush();
        exit();
    }

    try {
        global $wpdb;
        $table_name = $wpdb->prefix . 'classes';

        // Check if table exists, create if not
        createClassesTable();

        // Check if class already exists
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table_name WHERE class_name = %s AND class_level = %s",
            $className,
            $classLevel
        ));

        if ($existing) {
            $response['message'] = 'A class with this name and level already exists';
            echo json_encode($response);
            ob_end_flush();
            exit();
        }

        // Insert new class
        $inserted = $wpdb->insert(
            $table_name,
            [
                'class_name'    => $className,
                'class_level'   => $classLevel,
                'class_teacher' => $classTeacher,
                'capacity'      => $capacity > 0 ? $capacity : null,
                'description'   => $description,
                'created_date'  => current_time('mysql'),
                'created_by'    => get_current_user_id(),
            ],
            ['%s', '%s', '%s', '%d', '%s', '%s', '%d']
        );

        if ($inserted) {
            $response['success']  = true;
            $response['message']  = 'Class created successfully';
            $response['class_id'] = $wpdb->insert_id;
        } else {
            $response['message'] = 'Failed to create class: ' . $wpdb->last_error;
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

/**
 * Create classes table if it doesn't exist
 */
function createClassesTable()
{
    global $wpdb;
    $table_name      = $wpdb->prefix . 'classes';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        class_name varchar(100) NOT NULL,
        class_level varchar(20) NOT NULL,
        class_teacher varchar(200) DEFAULT NULL,
        capacity int(11) DEFAULT NULL,
        description text DEFAULT NULL,
        created_date datetime DEFAULT CURRENT_TIMESTAMP,
        created_by bigint(20) UNSIGNED DEFAULT NULL,
        updated_date datetime DEFAULT NULL,
        PRIMARY KEY (id),
        KEY class_level (class_level)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
