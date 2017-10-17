<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Server_model');
    }

    public function index()
    {
        // Handle a request to a resource and authenticate the access token
        if (!$this->Server_model->server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
            $this->Server_model->server->getResponse()->send();
            die;
        }
        echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
    }

}