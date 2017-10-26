<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;

/*
 * Resource API controller.
 */
class Resource extends REST_Controller
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

    /* 
     * Browsers preflight the request to look for CORS headers.
     * If the request is acceptable, then they will send the real request.
     */
    public function index_options()
    {
        $this->response(null, REST_Controller::HTTP_OK);
    }

    public function index_get()
    {
        /*
         * OAuth 2.0 authentication: 'resource' scope & 'members' group.
         */
        If (!$this->oauth2_server->authorize(Request::createFromGlobals(), 'resource', ['members'])) {
            $this->response(null, REST_Controller::HTTP_UNAUTHORIZED);
        }

        /*
         * The request is valid.
         */
        $data = array(80, 85, 88, 90, 100, 101, 104, 87, 92, 97, 100, 102);
        $this->response($data);
    }
}