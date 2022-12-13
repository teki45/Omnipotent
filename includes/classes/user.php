<?php

namespace helpers;

class user
{
    public $db_conn;

    public function __construct($conn) {
        $this->db_conn = $conn;
    }

    function create($username, $email, $password) {
        if ($this->exists($username) || $this->exists_email($email)) { return 2; }

        $uid = generate_random_string(20);

        $stmt = $this->db_conn->prepare("INSERT INTO users (uid, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $uid, $username, $email, password_hash($password, PASSWORD_DEFAULT));

        if(!$stmt->execute()) {
            return 0;
        }

        return $uid;
    }

    function sign_in($username, $password) {
        // Username incorrect
        if ($this->db_conn->query("SELECT * FROM users WHERE username = '$username'")->num_rows != 1) {
            return 0;
        }

        // Failed to execute query
        if (!$result = $this->db_conn->query("SELECT password, uid FROM users WHERE username = '$username'")) {
            return 2;
        }

        $data = $result->fetch_assoc();

        if (!password_verify($password, $data['password'])) {
            return 0;
        }

        $_SESSION['uid'] = $data['uid'];
    }

    function update_sensitive($uid, $username = '', $email = '', $password = '') {

    }

    function update($bio = '') {

    }


    function exists($username) { return $this->db_conn->query("SELECT * FROM users WHERE username = '$username'")->num_rows == 1; }
    function exists_uid($uid) { return $this->db_conn->query("SELECT * FROM users WHERE uid = '$uid'")->num_rows == 1; }
    function exists_email($email) { return $this->db_conn->query("SELECT * FROM users WHERE email = '$email'")->num_rows == 1; }

}