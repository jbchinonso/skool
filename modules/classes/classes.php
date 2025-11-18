<?php
class Skool_classes{
    public function __construct() {
        $this->init();
    }

    public function init(){
        // Initialization code here
        add_action('admin_menu', [$this, 'skool_add_admin_menu'], 10);

    }


    function skool_add_admin_menu(){
        add_menu_page(
            'Class Management',                      // Page title
            'Manage Classes',                          // Menu title
            'manage_options',                            // Capability (admins only)
            'manage-classes',                      // Slug
            [$this, 'school_class_management_page'], // Callback function
            'dashicons-open-folder',              // Icon
            6                                            // Position
        );
}

function school_class_management_page(){
    require_once __DIR__ . '/templates/manage-classes.php';
}

}

new Skool_classes();