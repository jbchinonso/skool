<?php

$roles = [
'student' => [
    'role' => 'student',
    'display_name' => 'Student',
    'capabilities' => get_role('subscriber')->capabilities
],
'teacher' => [
    'role' => 'teacher',
    'display_name' => 'Teacher',
    'capabilities' => get_role('editor')->capabilities
],

'admin' => [
    'role' => 'admin',
    'display_name' => 'Admin',
    'capabilities' => get_role('administrator')->capabilities
],
];

foreach ($roles as $role) {
    add_role($role['role'], $role['display_name'], $role['capabilities']);
}
