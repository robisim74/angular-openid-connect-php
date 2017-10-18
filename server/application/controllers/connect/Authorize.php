<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

/*
 * Authorization endpoint. 
 */
class Authorize extends OAuth2_server
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    /**
     * The user is directed here by the client in order to authorize the client app
     * to access his/her data.
     */
    public function index()
    {
        // Authenticates End-User.
        // http://openid.net/specs/openid-connect-implicit-1_0.html#Authenticates
        if (!$this->ion_auth->logged_in()) {
            // Stores the request.
            $uri_string = uri_string();
            $query_string = $this->input->server('QUERY_STRING');
            $request_url = $uri_string . '?' . $query_string;
            $this->session->set_flashdata('request_url', $request_url);
            // Redirects to login.
            redirect('auth/login', 'refresh');
        }

        $request = Request::createFromGlobals();
        
        
        // Validates the authorize request. If it is invalid, redirects back to the client with the errors.
        if (!$this->server->validateAuthorizeRequest($request)) {
            $this->server->getResponse()->send();
        }

        // Obtains End-User Consent/Authorization.
        // http://openid.net/specs/openid-connect-implicit-1_0.html#Consent.
        $memory = $this->server->getStorage('scope');
        $scopes = $memory->supportedScopes;
        $this->data['client_id'] = $this->input->get('client_id', TRUE);
        $this->data['scopes'] = $scopes;
        // Stores the request.
        $this->session->set_flashdata('request', $request);

        $this->load->view('connect/authorize/index', $this->data);
    }

    public function authorize_form_submit()
    {
		// Gets the request.
        $request = $this->session->flashdata('request');
        $response = new Response();
        $is_authorized = isset($_POST['authorize']);
        $user_id = $this->ion_auth->get_user_id();

        $this->server->handleAuthorizeRequest($request, $response, $is_authorized, $user_id);

        $response->send();
    }
}