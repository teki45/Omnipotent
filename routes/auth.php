<?php

function validate_input($username, $password) {
    if (count($_POST) <= 0) {
        die('No data was found in post request');
    }

    if (empty($username) || empty($password)) {
        die('Username or password was empty');
    }

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        die('Username can only contain alphanumerics (A-Z, 0-9) and underscores');
    }
}

function user_exists($conn, $username) {
    $query = 'SELECT id FROM users WHERE username = ?';

    if (!$statement = $conn->prepare($query)) {
        die('Couldn\'t prepare query');
    }

    $statement->bind_param('s', $username);

    if (!$statement->execute()) {
        die('Couldn\'t execute query');
    }

    $statement->store_result();

    if ($statement->num_rows == 1) {
        return true;
    }

    $statement->close();

    return false;
}

$router->get('/signup', function() use($twig) {
    echo $twig->render('auth/signup.twig.html');
});
$router->post('/signup', function() use($twig, $conn) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    validate_input($username, $password);

    if (user_exists($conn, $username)) {
        die('User already exists');
    }

    $query = "INSERT INTO users (username, password) VALUES (?, ?)";

    if (!$statement = $conn->prepare($query)) {
        die('Couldn\'t prepare query');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $statement->bind_param('ss', $username, $hashed_password);

    if (!$statement->execute()) {
        die('Couldn\'t execute query');
    }

    $statement->close();
    $conn->close();

    header('Location: /');
});

$router->get('/signin', function() use($twig) {
    echo $twig->render('auth/signin.twig.html');
});
$router->post('/signin', function() use($twig, $conn) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    validate_input($username, $password);

    if (!user_exists($conn, $username)) {
        die('Username or password is incorrect');
    }

    $query

    $conn->close();

    header('Location: /');
});