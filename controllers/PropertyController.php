<?php

namespace Controllers;

use \Models\PropertyModel;
use \Models\SearchModel;
use \Models\UserModel;

/**
 * Used to show how we can also use controllers to do same actions.
 */
class PropertyController
{
    protected $container;

    /**
     * Set up this controller with neccessary container
     */
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    public function index ($request, $response, $args) {
        return $this->container->get('view')->render($response, 'index.twig', [
            'properties' => PropertyModel::all(),
        ]);
    }

    public function allProperties ($request, $response, $args) {
        return $this->container->get('view')->render($response, 'propertylist.twig', [
            'properties' => PropertyModel::all(),
            'admin' => $this->container->get('session')->is_admin,
        ]);
    }

    public function singleProperty($request, $response, $args) {
        return $this->container->get('view')->render($response, 'propertylist.twig', [
            // view expects array of properties, even if only single one
            'properties' => [PropertyModel::find($args['id'])],
            'admin' => $this->container->get('session')->is_admin,
        ]);
    }

    public function search($request, $response, $args) {
        $results = PropertyModel::where('description', 'like', '%'.$request->getParam('search').'%')->get();
        $search = new SearchModel($request->getParam('search'), $_SERVER['REMOTE_ADDR'], $this->container->get('session')->exists('username') ? $this->container->get('session')->username : NULL);
        $search->save();
        return $response->withJson($results);
    }

    public function edit($request, $response, $args) {
        //ensure user is logged in and admin
        if (isset($this->container->get('session')->username) && $this->container->get('session')->is_admin) {
            $property = PropertyModel::find($args['id']);
            if ($property == NULL) {
                return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write('page not found!');
            } else {
                return $this->container->get('view')->render($response, 'edit.twig', [
                    'property' => $property,
                    'id' => $args['id'],
                ]);
            }
        } else {
            // redirect to login page with error header
            return $response->withRedirect('/login')->withoutHeader('WWW-Authenticate');
        }
    }
    
    public function delete($request, $response, $args) {
        //ensure user is logged in and admin
        if (isset($this->container->get('session')->username) && $this->container->get('session')->is_admin) {
            $property = PropertyModel::find($args['id']);
            if ($property == NULL) {
                return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write('page not found!');
            } else {
                return $this->container->get('view')->render($response, 'delete.twig',[
                    'property' => $property,
                    'id' => $args['id'],
                ]);
            }
        } else {
            // redirect to login page with error header
            return $response->withRedirect('/login')->withoutHeader('WWW-Authenticate');
        }
    }

    public function editpost($request, $response, $args) {
                //ensure user is logged in and admin
        if (isset($this->container->get('session')->username) && $this->container->get('session')->is_admin) {
            $params = $request->getParsedBody();
            $editPost = PropertyModel::find($args['id']);
            $editPost->update($params);
            $directory = $this->container->get('upload_directory');
            $files = $request->getUploadedFiles();
            if ($files['image']->getSize() > 0) {
                $newfile = $files['image'];
                $relativepath = sha1($newfile->getClientFilename() . time());
                $filename = $this->container->get('upload_directory') . '/' . $relativepath;
                $newfile->moveTo($filename);
                $editPost->image = '/uploads/' . $relativepath;
            }
            $editPost->save();
            return $response->withStatus(200)->withRedirect('/admin');
        } else {
            return $response->withRedirect('/login')->withoutHeader('WWW-Authenticate');
        }
    }

    public function deletepost($request, $response, $args) {
        if (isset($this->container->get('session')->username) && $this->container->get('session')->is_admin) {
            $deletePost = PropertyModel::find($args['id']);
            $deletePost->delete();
            return $response->withStatus(200)->withRedirect('/admin');
        } else {
            return $response->withRedirect('/login')->withoutHeader('WWW-Authenticate');
        }
    }
}