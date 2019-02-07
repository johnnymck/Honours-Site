<?php
// Render Twig template within container
$app->get('/', 'Controllers\\UserController:index');
$app->get('/admin', 'Controllers\\UserController:admin');
$app->get('/admin/pending-users', 'Controllers\\UserController:pendingUsers');
$app->get('/admin/{id}', 'Controllers\\UserController:adminById');
$app->get('/login', 'Controllers\\UserController:login');
$app->post('/login', 'Controllers\\UserController:loginpost');
$app->get('/logout', 'Controllers\\UserController:logout');
$app->get('/signup', 'Controllers\\UserController:signup');
$app->post('/signup', 'Controllers\\UserController:signupPost');
