<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,900&display=swap"
            rel="stylesheet"
                >
        <link rel="shortcut icon" href="/static/img/logo_sm.svg" type="image/x-icon">
        <link rel="stylesheet" href="/static/css/main.css">
        <title>Omnipotent</title>
    </head>
    <body>
    <div id="navbar">
        <div id="left">
            <div id="logo"><img src="/static/img/logo.svg"></div>
            <div id="wrap">
                <a href="/" class="link active">Home</a>
                <a href="" class="link">Feed</a>
                <a href="" class="link">Omnis</a>
            </div>
        </div>
        <div id="right">
            <?php
            if (!isset($_SESSION['uid'])) {
                echo '<a href="/sign/up.php" class="link">Sign up</a> <a href="/sign/in.php" class="link">Sign in</a>';
            } else {
                echo '<a href="/sign/out.php" class="link">Sign out </a>';
            }
            ?>
        </div>
    </div>
    <div id="content">
            <div id="left-side">
                <div class="card">
                    <div id="cd-title"><?php if (isset($_SESSION['uid'])) { echo htmlspecialchars($user_info['username']); } ?></div>
                    <div id="cd-content" class="padded-content">

                    </div>
                </div>
            </div>
            <div id="right-side">
