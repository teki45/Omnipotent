<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/layout/header.php'; ?>

<?php
if (isset($_SESSION['uid'])) { header('Location: /'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
}
?>

<div class="card">
    <div id="cd-title">Sign up to Omnipotent</div>
    <div id="cd-content">
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirm" placeholder="Confirm password" required>
            <input type="submit" value="Sign up">
        </form>
    </div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/layout/footer.php'; ?>