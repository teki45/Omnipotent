<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '\includes\functions.php';

session_start();

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'omnipotent';

$conn = new mysqli($hostname, $username, $password, $database) or die('Connection to database failed');

$user_info = null;
if (isset($_SESSION['uid'])) {
    $user_info = get_user_info($_SESSION['uid'], $conn);
}