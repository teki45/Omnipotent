<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/layout/header.php'; ?>


<?php
if (isset($_SESSION['uid'])) { header('Location: /'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
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
}
?>

<div class="card">
    <div id="cd-title">Sign in to Omnipotent</div>
    <div id="cd-content">
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Sign in">
        </form>
    </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/layout/footer.php'; ?>