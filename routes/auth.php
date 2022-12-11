<?php

$router->get('/signup', function() use($twig) {
    echo $twig->render('auth/signup.twig.html');
});
$router->post('/signup', function() use($twig, $conn) {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    $password_confirm = $conn->real_escape_string(trim($_POST['password_confirm']));

    if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
        exit('One or more values were empty.');
    }
    if ($password != $password_confirm) {
        exit('The passwords provided do not match.');
    }
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
        exit('Username can only contain alphanumerics and underscores.');
    }
    if ($conn->query("SELECT * FROM users WHERE username = '$username'")->num_rows != 0) {
        exit('A user with this username already exists.');
    }
    if ($conn->query("SELECT * FROM users WHERE email = '$email'")->num_rows != 0) {
        exit('A user with this email already exists.');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $uid = generate_random_string(20);

    $stmt = $conn->prepare("INSERT INTO users (uid, username, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $uid, $username, $email, $hashed_password);

    if(!$stmt->execute()) {
        exit('Failed to execute query');
    }

    $_SESSION['uid'] = $uid;

    header('Location: /');
});

$router->get('/signin', function() use($twig) {
    if (isset($_SESSION['uid'])) {
        header('Location: /');
    }

    echo $twig->render('auth/signin.twig.html');
});
$router->post('/signin', function() use($twig, $conn) {
    if (isset($_SESSION['uid'])) {
        header('Location: /');
    }

    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = trim($_POST['password']);

    if (empty($username) || empty($password) ) {
        exit('One or more values were empty.');
    }

    if ($conn->query("SELECT * FROM users WHERE username = '$username'")->num_rows != 1) {
        exit('Username or password was incorrect.');
    }

    if (!$result = $conn->query("SELECT password, uid FROM users WHERE username = '$username'")) {
        exit('Failed to execute query');
    }

    $data = $result->fetch_assoc();

    if (!password_verify($password, $data['password'])) {
        exit('Username or password was incorrect.');
    }

    $_SESSION['uid'] = $data['uid'];

    header('Location: /');
});

$router->get('/logout', function() use($twig){
   if (isset($_SESSION['uid'])) {
       unset($_SESSION['uid']);
   }

   header('Location: /');
});