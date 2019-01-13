<?php
// Render Twig template in route
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $this->view->render($response, 'name.twig', [
        'name' => $args['name']
    ]);
})->setName('profile');

// Render Twig template within container
$app->get('/', 'Controllers\\PropertyController:index');
$app->get('/property', 'Controllers\\PropertyController:allProperties');
$app->get('/property/{id}', 'Controllers\\PropertyController:singleProperty');
$app->post('/editpost/{id}', 'Controllers\\PropertyController:editpost');
$app->post('/deletepost/{id}', 'Controllers\\PropertyController:deletepost');
$app->post('/search.{type}', 'Controllers\\PropertyController:search');
$app->get('/admin', 'Controllers\\UserController:admin');
$app->get('/admin/{id}', 'Controllers\\UserController:adminById');
$app->get('/login', 'Controllers\\UserController:login');
$app->post('/login', 'Controllers\\UserController:loginpost');
$app->get('/logout', 'Controllers\\UserController:logout');
$app->get('/edit/{id}', 'Controllers\\PropertyController:edit');
$app->get('/delete/{id}', 'Controllers\\PropertyController:delete');