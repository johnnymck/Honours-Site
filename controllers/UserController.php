<?php

namespace Controllers;

use \Models\PropertyModel;
use \Models\UserModel;

class UserController
{
    protected $container;

    public function __construct(\Slim\Container $container)
    {
        $this->container = $container;
    }

    public function login($request, $response, $args)
    {
        return $this->container->get('view')->render($response, 'login.twig', []);
    }

    public function loginpost($request, $response, $args)
    {
        $params = $request->getParsedBody();
        if ($this->validateLogin($params['username'], $params['password'])) {
            $this->container->get('session')->set('username', $params['username']);
            $this->container->get('session')->set('is_admin', UserModel::where('username', $params['username'])->first()->isAdmin);
            return $response->withStatus(200)->withRedirect('/admin');
        } else {
            return $response->withRedirect('/login')->withoutHeader('WWW-Authenticate');
        }
    }

    public function validateLogin($username, $password)
    {
        $user = UserModel::where('email', $username)->first();
        if ($user != null) {
            return(password_verify($password, $user->password)
        }
    }

    public function admin($request, $response, $args)
    {
        if ($this->container->get('session')->exists('username')) {
            return $this->container->get('view')->render($response, 'admin.twig', [
                'admin' => true,
                'properties' => PropertyModel::all(),
            ]);
        } else {
            return $response->withRedirect('/login')->withoutHeader('WWW-Authenticate');
        }
    }

    public function logout($request, $response, $args)
    {
        $this->container->get('session')->delete('username');
        $this->container->get('session')->delete('is_admin');
        return $response->withStatus(200)->withRedirect('login');
    }

    public function index($request, $response, $args)
    {
        return $this->container->get('view')->render($response, 'index.twig', []);
        //return $response->withStatus(200)->getBody()->write("Hello, world!");
    }
}
