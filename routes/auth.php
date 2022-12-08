<?php

$router->get('/signup', function() use($twig) {
    echo $twig->render('auth/signup.twig.html');
});
$router->post('/signup', function() use($twig, $conn) {
    
});

$router->get('/signin', function() use($twig) {
    echo $twig->render('auth/signin.twig.html');
});
$router->post('/signin', function() use($twig, $conn) {

});