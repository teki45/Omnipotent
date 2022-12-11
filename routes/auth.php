<?php

$router->get('/signup', function() use($twig) {
    echo $twig->render('auth/signup.twig.html');
});
$router->post('/signup', function() use($twig, $conn) {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = trim($_POST['password']);
    $password_confirm = trim($_POST['password_confirm']);

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
    $stmt->bind_param('ssss', $uid, $username, $email, $password);

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

});

$router->get('/logout', function() use($twig){
   if (!isset($_SESSION['uid'])) {
       header('Location: /');
   }

   unset($_SESSION['uid']);
   header('Location: /');
});