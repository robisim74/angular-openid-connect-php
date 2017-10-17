<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;

/* 
 * Token endpoint.
 */
class Token extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');

        $this->load->model('Server_model');
    }

    public function index()
    {
        // Handle a request for an OAuth2.0 Access Token and send the response to the client
        return $this->Server_model->server->handleTokenRequest(Request::createFromGlobals())->send();
    }
}