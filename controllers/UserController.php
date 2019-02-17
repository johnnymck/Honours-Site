<?php

namespace Controllers;

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

    public function pendingUsers($request, $response, $args)
    {
        if ($this->container->get('session')->exists('email') && $this->container->get('session')->isAdmin) {
            $users = UserModel::where('approved', '=', '0')->get();
            $form = UserModel::getAsFormFields($users);
            return $this->container->get('view')->render($response, 'pending-users.twig', [
                'admin' => true,
                'form' => $form,
            ]);
        } else {
            return $response->withRedirect('/login')->withoutHeader('WWW-Authenticate');
        }
    }

    public function pendingUsersPost($request, $response, $args)
    {
        if (!($this->container->get('session')->exists('email') && $this->container->get('session')->isAdmin)) {
            return $response->withRedirect('/login')->withoutHeader('WWW-Authenticate');
        }
        $params = $request->getParsedBody();
        if (array_key_exists('decline', $params)) {
            UserModel::where('id', '=', $params['id'])->delete();
            return $response->withStatus(200)->withRedirect('/admin/pending-users');
        } else if (array_key_exists('approve', $params)) {
            UserModel::where('id', '=', $params['id'])->update(['approved' => '1']);
            return $response->withStatus(200)->withRedirect('/admin/pending-users');
        } else {
            return $response->withStatus(401)->withRedirect('/admin/pending-users');
        }
    }

    public function signup($request, $response, $args)
    {
        $signupForm = UserModel::getSignUpForm();
        return $this->container->get('view')->render($response, 'signup.twig', [
            'form' => $signupForm,
        ]);
    }

    public function signupPost($request, $response, $args)
    {
        $params = $request->getParsedBody();
        $newUser = new UserModel(
            $params['email'],
            $params['password'],
            $params['firstname'],
            $params['lastname'],
            $params['title'],
            $params['address'],
            0, //user not admin by default
            0// user not approved by default
        );
        $newUser->save();
        return $response->withStatus(200)->withRedirect('/login');
    }

    public function logout($request, $response, $args)
    {
        $this->container->get('session')->delete('email');
        $this->container->get('session')->delete('isAdmin');
        return $response->withStatus(200)->withRedirect('/');
    }

    public function index($request, $response, $args)
    {
        $userForm = UserModel::getLoginForm();
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
