<?php

function skool_users_scripts() {
    wp_enqueue_style( 'skool-users-style', get_template_directory_uri() . '/modules/users/style.css', [], _S_VERSION );
}
add_action( 'admin_enqueue_scripts', 'skool_users_scripts' );