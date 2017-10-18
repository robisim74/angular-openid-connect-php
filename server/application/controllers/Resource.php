<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends OAuth2_Server
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Handle a request to a resource and authenticate the access token
        if (!$this->server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
            $this->server->getResponse()->send();
            die;
        }
        echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
    }

}