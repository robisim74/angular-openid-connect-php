<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Response;

/* 
 * Checksession endpoint.
 * 
 * @see http://openid.net/specs/openid-connect-session-1_0.html
 */
class Checksession extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');

        // Authentication library.
        $this->load->library('ion_auth');
        
        // OAuth 2.0 Server.
        $this->load->library('oauth2_server');
    }

    public function index()
    {
        // TODO
    }
}