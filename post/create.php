<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/layout/header.php'; ?>

<?php
if (!isset($_SESSION['uid'])) {
    header('Location: /');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string(trim($_POST['title']));
    var_dump($title);
}
?>

<div class="card">
    <div id="cd-title">Create a post</div>
    <div id="cd-content" class="padded-content">
        <form action="" method="post" class="post">
            <input type="text" name="title" placeholder="Title (not required)"/>
            <textarea name="body" cols="30" rows="10" placeholder="Body/Description" required></textarea>
            <input type="submit" value="Create post">
        </form>
    </div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/layout/footer.php'; ?>