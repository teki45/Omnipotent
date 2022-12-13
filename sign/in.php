<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/layout/header.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/classes/user.php'; use helpers\user;
$user = new user($conn);
?>


<?php
if (isset($_SESSION['uid'])) { header('Location: /'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = $conn->real_escape_string(trim($_POST['password']));

    if (empty($username) || empty($password)) {
        exit('One or more values were empty.');
    }

    $result = $user->sign_in($username, $password);

    if ($result === 0) {
        exit('Username or password was incorrect');
    }

    if ($result === 2) {
        exit('Failed to execute query');
    }

    header('Location: /');
}
?>

<div class="card">
    <div id="cd-title">Sign in to Omnipotent</div>
    <div id="cd-content" class="padded-content">
        <form method="post" action="" class="auth">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Sign in">
        </form>
    </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/layout/footer.php'; ?>