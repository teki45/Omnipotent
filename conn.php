<?php

ob_start();

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'omnipotent';

$conn = mysqli_connect($hostname, $username, $password, $database) or die('Connection to database failed');

