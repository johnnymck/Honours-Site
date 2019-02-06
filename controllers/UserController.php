<?php

namespace Controllers;

use FormManager\Factory as F;
use \Models\ProjectModel;
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
        if (UserModel::validateLogin($params['email'], $params['password'])) {
            $this->container->get('session')->set('email', $params['email']);
            $this->container->get('session')->set('isAdmin', UserModel::where('email', $params['email'])->first()->isAdmin);
            $this->container->get('session')->set('firstName', UserModel::where('email', $params['email'])->first()->firstName);
            $this->container->get('session')->set('lastName', UserModel::where('email', $params['email'])->first()->lastName);
            return $response->withStatus(200)->withRedirect('/admin');
        } else {
            return $response->withRedirect('/login')->withoutHeader('WWW-Authenticate');
        }
    }

    public function admin($request, $response, $args)
    {
        if ($this->container->get('session')->exists('email') && $this->container->get('session')->isAdmin) {
            return $this->container->get('view')->render($response, 'admin.twig', [
                'admin' => true,
                'projects' => ProjectModel::all(),
            ]);
        } else {
            return $response->withRedirect('/login')->withoutHeader('WWW-Authenticate');
        }
    }

    public function logout($request, $response, $args)
    {
        $this->container->get('session')->delete('email');
        $this->container->get('session')->delete('isAdmin');
        return $response->withStatus(200)->withRedirect('login');
    }

    public function index($request, $response, $args)
    {
        $userForm = F::form([
            'username' => F::text('User name'),
            'password' => F::password('Password'),
            '' => F::submit('Login'),
        ]);
        $userForm->setAttributes([
            'action' => '/signup',
            'method' => 'post',
        ]);
        if ($this->container->get('session')->email != null) {
            return $this->container->get('view')->render($response, 'index.twig', [
                'name' => $this->container->get('session')->firstName,
                'form' => $userForm,
            ]);
        } else {
            return $this->container->get('view')->render($response, 'index.twig', [
                'form' => $userForm,
            ]);
        }

    }
}
