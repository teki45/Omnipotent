<?php

session_start();

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'omnipotent';

$conn = new mysqli($hostname, $username, $password, $database) or die('Connection to database failed');