<?php
require_once 'init.php';
if (Session::exists('enter')) {
     echo "<p style='color: lightgreen'>" . Session::flash('enter') . "</p>";
}

$user = new User;

if ($user->isLoggedIn()) {
    echo Session::flash('change_password');
    echo '<a href="logout.php">Logout</a><br>';
    echo '<a href="update.php">Update user name</a><br>';
    echo '<a href="update_password.php">Update user password</a><br>';

    if ($user->hasPermission('admin')) {
        echo 'You are administrator';
    }
} else {
    echo '<a href="login.php">Login</a>';
}