<?php
require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$twig = new Environment(new FilesystemLoader(__DIR__ . '/static/templates'));

$router = new \Bramus\Router\Router();

$router->get('/', function() use($twig) {
    echo $twig->render('/index.twig.html');
});

include __DIR__ . '/routes/auth.php';

$router->run();