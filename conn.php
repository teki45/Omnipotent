<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "omnipotent";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) { die("Connection failed " . $conn->connect_error); }