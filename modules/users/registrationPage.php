<?php

function school_add_admin_menu()
{
    add_menu_page(
        'Student Registration',             // Page title
        'Student Registration',             // Menu title
        'manage_options',                   // Capability (admins only)
        'student-registration',             // Slug
        'school_student_registration_page', // Callback function
        'dashicons-welcome-learn-more',                     // Icon
        6                                   // Position
    );
}
add_action('admin_menu', 'school_add_admin_menu');

function school_student_registration_page()
{
    require_once __DIR__ . '/templates/studentRegistration.php';
}
