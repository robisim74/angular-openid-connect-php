<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

/*
 * Revocation endpoint: only for reference tokens.
 * 
 * @see https://tools.ietf.org/html/rfc7009
 */
class Revocation extends CI_Controller
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
        $request = Request::createFromGlobals();
        $response = new Response();

        $this->oauth2_server->server->handleRevokeRequest($request, $response)->send();
    }
}
