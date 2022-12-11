<?php

function generate_random_string($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function get_user_info($uid, $conn) {
    if ($conn->query("SELECT * FROM users WHERE uid = '$uid'")->num_rows != 1) {
        exit('Could not find this user.');
    }

    if (!$result = $conn->query("SELECT username, bio FROM users WHERE uid = '$uid'")) {
        exit('Failed to execute query');
    }

    return $result->fetch_assoc();
}