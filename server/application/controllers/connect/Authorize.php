<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

/*
 * Authorization endpoint. 
 */
class Authorize extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');

        $this->load->library('ion_auth');
        $this->load->helper('url');
        $this->load->model('Server_model');
    }

    /**
     * The user is directed here by the client in order to authorize the client app
     * to access his/her data.
     */
    public function index()
    {
        // Authentication.
        if (!$this->ion_auth->logged_in()) {
            // Stores the request.
            $uri_string = uri_string();
            $query_string = $this->input->server('QUERY_STRING');
            $request_uri = $uri_string . '?' . $query_string;
            echo $request_uri;
            $this->session->set_userdata(array('last_url' => $request_uri));
            // Redirects to login.
            redirect('auth/login', 'refresh');
        }

        $request = Request::createFromGlobals();
        $response = new Response();
        
        // Validates the authorize request. If it is invalid, redirects back to the client with the errors.
        if (!$this->Server_model->server->validateAuthorizeRequest($request, $response)) {
            $response->send();
        }
        
        // End-User Consent/Authorization by default.  
        // This can done by presenting the End-User with a dialogue that enables the End-User to recognize what is being consenting to and grant consent.
        $is_authorized = true;

        $user_id = $this->ion_auth->get_user_id();
        
        // Calls the oauth server and returns the response.
        $this->Server_model->server->handleAuthorizeRequest($request, $response, $is_authorized, $user_id);
        
        $response->send();
    }
}