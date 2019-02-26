<?php

namespace Controllers;

use Models\ProjectModel;

class ProjectController
{
    protected $container;

    public function __construct(\Slim\Container $container)
    {
        $this->container = $container;
    }

    public function newProject($request, $response, $args)
    {
        // ensure user is logged in, else redirect to login
        if ($this->container->get('session')->exists('email')) {
            return $this->container->get('view')->render($response, 'project.twig', [
                'form' => ProjectModel::getProjectForm(),
            ]);
        } else {
            return $response->withRedirect('/login')->withoutHeader('WWW-Authenticate');
        }
    }
}
