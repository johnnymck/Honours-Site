<?php
// Render Twig template within container
$app->get('/', 'Controllers\\UserController:index');
$app->get('/admin', 'Controllers\\UserController:admin');
$app->get('/admin/{id}', 'Controllers\\UserController:adminById');
$app->get('/login', 'Controllers\\UserController:login');
$app->post('/login', 'Controllers\\UserController:loginpost');
$app->get('/logout', 'Controllers\\UserController:logout');
