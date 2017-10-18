<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;

/* 
 * Token endpoint.
 */
class Token extends OAuth2_Server
{
    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');
    }

    public function index()
    {
        // Handle a request for an OAuth2.0 Access Token and send the response to the client
        return $this->server->handleTokenRequest(Request::createFromGlobals())->send();
    }
}