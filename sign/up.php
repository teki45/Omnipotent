<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/layout/header.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/classes/user.php'; use helpers\user;
$user = new user($conn);
?>S

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

    $result = $user->create($username, $email, $password);

    if ($result === 2) {
        exit('Username or email is already registered.');
    } elseif ($result == 0) {
        exit('User creation failed');
    }

    $_SESSION['uid'] = $uid;

    header('Location: /sign/in.php');
}
?>

<div class="card">
    <div id="cd-title">Sign up to Omnipotent</div>
    <div id="cd-content" class="padded-content">
        <form method="post" action="" class="auth">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirm" placeholder="Confirm password" required>
            <input type="submit" value="Sign up">
        </form>
    </div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/layout/footer.php'; ?>