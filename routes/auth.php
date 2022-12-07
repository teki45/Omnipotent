<?php

$router->get('/signup', function() use($twig) {
    echo $twig->render('/navbar.twig.html');
});