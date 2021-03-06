<?php

require_once 'vendor/autoload.php';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'dev_hons_project';

$config = [
    'debug' => true,
    'displayErrorDetails' => true,
    'determineRouteBeforeAppMiddleware' => true,
    'addContentLengthHeader' => false,
    'db' => [
        'driver' => 'mysql',
        'username' => $dbuser,
        'password' => $dbpass,
        'host' => $dbhost,
        'database' => $dbname,
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ],
];
// Create app
$app = new \Slim\App(['settings' => $config]);

$app->add(new \Slim\Middleware\Session([
    'name' => 'userstore',
    'autorefresh' => true,
    'lifetime' => '2 hours',
]));

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('templates', [
        'cache' => false,
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));

    return $view;
};

$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($config['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['session'] = function ($c) {
    return new \SlimSession\Helper;
};

$container['forms'] = function ($c) {
    return Symfony\Component\Form\Forms::createFormFactory();
};

$container['upload_directory'] = __DIR__ . '/uploads';
