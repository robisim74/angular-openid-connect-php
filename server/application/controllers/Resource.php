<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

/*
 * Resource API controller.
 */
class Resource extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        $this->output->set_header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        // OAuth 2.0 Server.
        $this->load->library('oauth2_server');
    }

    public function index()
    {
        /*
         * OAuth 2.0 authentication: 'resource' scope & 'members' group.
         */
        If (!$this->oauth2_server->authorize(Request::createFromGlobals(), 'resource', ['members'])) {
            if (!$this->oauth2_server->response->isSuccessful()) {
                $this->oauth2_server->response->send();
                die();
            }
            else {
                return;
            }
        }

        /*
         * The request is valid.
         */
        echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
    }
}