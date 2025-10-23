<?php

class Skool_Registration_Page{

    public function __construct() {
        $this->init();
    }

    public function init(){
        add_action('admin_menu', [$this, 'skool_add_admin_menu'], 10);

        add_action('admin_menu', [$this,'skool_view_all_students_page'], 10,);
    }

    function skool_add_admin_menu()
{
    add_menu_page(
        'Student Registration',             // Page title
        'Register Student',             // Menu title
        'manage_options',                   // Capability (admins only)
        'student-registration',             // Slug
        [$this,'school_student_registration_page'], // Callback function
        'dashicons-welcome-learn-more',                     // Icon
        6                                   // Position
    );
}

public function skool_view_all_students_page()
{
    add_submenu_page(
        'student-registration', 
        'View All Students', 
        'View All Students', 
        'manage_options', 
        'view-all-students', 
        [$this,'school_view_all_students_page'],
    );
}

public function school_student_registration_page()
{
    require_once __DIR__ . '/templates/studentRegistration.php';
}


public function school_view_all_students_page(){
    require_once __DIR__ . '/templates/viewAllStudents.php';
}
}



new Skool_Registration_Page();