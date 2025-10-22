<?php

// Set response header
header('Content-Type: application/json');

// Start output buffering to catch any stray output
ob_start();


// Load WordPress
require_once '../../../../../wp-load.php';

// Enable error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);



// Initialize response array
$response = [
    'success' => false,
    'message' => '',
];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Sanitize and validate input data
    $firstName        = sanitizeInput($_POST['firstName'] ?? '');
    $lastName         = sanitizeInput($_POST['lastName'] ?? '');
    $gender           = sanitizeInput($_POST['gender'] ?? '');
    $dob              = sanitizeInput($_POST['dob'] ?? '');
    $email            = sanitizeInput($_POST['email'] ?? '');
    $phone            = sanitizeInput($_POST['phone'] ?? '');
    $emergencyPhone   = sanitizeInput($_POST['emergencyPhone'] ?? '');
    $address          = sanitizeInput($_POST['address'] ?? '');
    $class            = sanitizeInput($_POST['class'] ?? '');
    $jamb             = sanitizeInput($_POST['jamb'] ?? '');
    $parentName       = sanitizeInput($_POST['parentName'] ?? '');
    $parentPhone      = sanitizeInput($_POST['parentPhone'] ?? '');
    $parentEmail      = sanitizeInput($_POST['parentEmail'] ?? '');
    $parentOccupation = sanitizeInput($_POST['parentOccupation'] ?? '');

    // Validate required fields
    $errors = [];

    if (empty($firstName)) {
        $errors[] = 'First name is required';
    }
    if (empty($lastName)) {
        $errors[] = 'Last name is required';
    }
    if (empty($gender)) {
        $errors[] = 'Gender is required';
    }
    if (empty($dob)) {
        $errors[] = 'Date of birth is required';
    }
    if (empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email address is required';
    }
    if (empty($phone)) {
        $errors[] = 'Phone number is required';
    }
    if (empty($address)) {
        $errors[] = 'Address is required';
    }
    if (empty($class)) {
        $errors[] = 'Class/Form is required';
    }
    if (empty($parentName)) {
        $errors[] = 'Parent/Guardian name is required';
    }
    if (empty($parentPhone)) {
        $errors[] = 'Parent/Guardian phone is required';
    }




    // If there are errors, return them
    if (!empty($errors)) {
        $response['message'] = implode(', ', $errors);
        echo json_encode($response);
        ob_end_flush();
        exit();
    }


    // Validate email format
    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email address';
        echo json_encode($response);
        ob_end_flush();
        exit();
    }


    // Validate parent email if provided
    if (! empty($parentEmail) && ! filter_var($parentEmail, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid parent/guardian email address';
        echo json_encode($response);
        ob_end_flush();
        exit();
    }


    try {

        // Check if email already exists
        $existingUser = get_user_by('email', $email);



        if ($existingUser) {
            $response['message'] = 'This email is already registered';
            echo json_encode($response);
            ob_end_flush();
            exit();
        }

        // Create username from first and last name
        $username = strtolower(str_replace(' ', '.', $firstName . '.' . $lastName));
        $username = preg_replace('/[^a-z0-9._-]/', '', $username);

        // Ensure username is unique
        $counter          = 1;
        $originalUsername = $username;
        while (username_exists($username)) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        // Generate a random password
        $randomPassword = wp_generate_password(12, true, true);

        // Prepare user data
        $userdata = [
            'user_login'   => $username,
            'user_email'   => $email,
            'user_pass'    => $randomPassword,
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'display_name' => $firstName . ' ' . $lastName,
            'role'         => 'student', // Default role for students
        ];



        // Insert user into WordPress
        $userId = wp_insert_user($userdata);

        if (is_wp_error($userId)) {
            throw new Exception('Failed to create user: ' . $userId->get_error_message());
        }

        // Save additional student information as user meta data
        update_user_meta($userId, 'gender', $gender);
        update_user_meta($userId, 'date_of_birth', $dob);
        update_user_meta($userId, 'phone', $phone);
        update_user_meta($userId, 'emergency_phone', $emergencyPhone);
        update_user_meta($userId, 'address', $address);
        update_user_meta($userId, 'class', $class);
        update_user_meta($userId, 'jamb_registration', $jamb);
        update_user_meta($userId, 'parent_name', $parentName);
        update_user_meta($userId, 'parent_phone', $parentPhone);
        update_user_meta($userId, 'parent_email', $parentEmail);
        update_user_meta($userId, 'parent_occupation', $parentOccupation);
        update_user_meta($userId, 'registration_date', current_time('mysql'));

        // Prepare data for logging/email
        $registrationData = [
            'user_id'          => $userId,
            'username'         => $username,
            'password'         => $randomPassword,
            'timestamp'        => current_time('mysql'),
            'firstName'        => $firstName,
            'lastName'         => $lastName,
            'gender'           => $gender,
            'dob'              => $dob,
            'email'            => $email,
            'phone'            => $phone,
            'emergencyPhone'   => $emergencyPhone,
            'address'          => $address,
            'class'            => $class,
            'jamb'             => $jamb,
            'parentName'       => $parentName,
            'parentPhone'      => $parentPhone,
            'parentEmail'      => $parentEmail,
            'parentOccupation' => $parentOccupation,
        ];

        // Send email notifications
        sendEmailNotification($registrationData);

        // Log registration
        logRegistration($registrationData);

        $response['success'] = true;
        $response['message'] = 'Registration submitted successfully! A confirmation email has been sent.';

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
 * Sanitize user input
 */
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Send email notification to school admin and parent
 */
function sendEmailNotification($data)
{
    $adminEmail   = get_option('admin_email'); // Gets WordPress admin email
    $parentEmail  = $data['parentEmail'];
    $studentEmail = $data['email'];

    // Email to admin
    $adminSubject = 'New Student Registration - ' . $data['firstName'] . ' ' . $data['lastName'];
    $adminBody    = "New Student Registration\n\n";
    $adminBody .= "Date: " . $data['timestamp'] . "\n";
    $adminBody .= "Student Name: " . $data['firstName'] . ' ' . $data['lastName'] . "\n";
    $adminBody .= "Username: " . $data['username'] . "\n";
    $adminBody .= "Class: " . $data['class'] . "\n";
    $adminBody .= "Email: " . $data['email'] . "\n";
    $adminBody .= "Phone: " . $data['phone'] . "\n";
    $adminBody .= "Parent/Guardian: " . $data['parentName'] . "\n";
    $adminBody .= "Parent Phone: " . $data['parentPhone'] . "\n\n";
    $adminBody .= "View student profile in WordPress admin panel.\n";

    // Email to parent with login credentials
    $parentSubject = 'Student Registration Confirmation - Login Credentials';
    $parentBody    = "Dear " . $data['parentName'] . ",\n\n";
    $parentBody .= "This is to confirm that " . $data['firstName'] . ' ' . $data['lastName'] . " has been successfully registered for " . $data['class'] . ".\n\n";
    $parentBody .= "Registration Details:\n";
    $parentBody .= "Date of Registration: " . $data['timestamp'] . "\n";
    $parentBody .= "Class: " . $data['class'] . "\n";
    $parentBody .= "School Portal Username: " . $data['username'] . "\n";
    $parentBody .= "Temporary Password: " . $data['password'] . "\n\n";
    $parentBody .= "IMPORTANT: Please log in and change your password immediately.\n";
    $parentBody .= "Login URL: " . home_url('/wp-login.php') . "\n\n";
    $parentBody .= "We look forward to welcoming your child to our school.\n\n";
    $parentBody .= "Best regards,\n";
    $parentBody .= get_bloginfo('name') . " Administration";

    // Set headers
    $headers = "From: " . get_option('admin_email') . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send emails using WordPress mail function
    if (! empty($adminEmail)) {
        wp_mail($adminEmail, $adminSubject, $adminBody, $headers);
    }

    if (! empty($parentEmail)) {
        wp_mail($parentEmail, $parentSubject, $parentBody, $headers);
    }
}

/**
 * Log registration to file for backup
 */
function logRegistration($data)
{
    $logFile = WP_CONTENT_DIR . '/student-registrations.log';

    $logEntry = date('Y-m-d H:i:s') . " | User ID: " . $data['user_id'] .
        " | " . $data['firstName'] . " " . $data['lastName'] .
        " | Email: " . $data['email'] .
        " | Class: " . $data['class'] . "\n";

    error_log($logEntry, 3, $logFile);
}
