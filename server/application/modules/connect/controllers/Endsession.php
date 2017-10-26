<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

/*
 * Endsession endpoint.
 * 
 * @see http://openid.net/specs/openid-connect-session-1_0.html
 */
class Endsession extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Methods: GET');

        // Authentication library.
        $this->load->library('ion_auth');
        
        // OAuth 2.0 Server.
        $this->load->library('oauth2_server');
    }

    public function index()
    {
        $request = Request::createFromGlobals();
        $response = new Response();

        $redirect_uri = $request->query('post_logout_redirect_uri');

        // Logout.
        $logout = $this->ion_auth->logout();

        $response->setRedirect(302, $redirect_uri);
        $response->send();
    }
}
