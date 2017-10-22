<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

/*
 * Authorization endpoint.
 * 
 * @see http://openid.net/specs/openid-connect-implicit-1_0.html
 */
class Authorize extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        $this->output->set_header('Access-Control-Allow-Headers: Content-Type, Authorization');

        $this->load->library('form_validation');

        // Authentication library.
        $this->load->library('ion_auth');

        // OAuth 2.0 Server.
        $this->load->library('oauth2_server');
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
            $request_url = 'connect/authorize' . '?' . $_SERVER['QUERY_STRING'];
            $this->session->set_flashdata('request_url', $request_url);
            // Redirects to login.
            redirect('auth/login', 'refresh');
        }

        $request = Request::createFromGlobals();
                
        // Validates the authorize request. If it is invalid, redirects back to the client with the errors.
        if (!$this->oauth2_server->server->validateAuthorizeRequest($request)) {
            $this->oauth2_server->server->getResponse()->send();
            die();
        }

        // Obtains End-User Consent/Authorization.
        // http://openid.net/specs/openid-connect-implicit-1_0.html#Consent.
        $scopes = $this->oauth2_server->server->getStorage('scope')->supportedScopes;

        $this->data['client_id'] = $request->query('client_id');
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

        $this->oauth2_server->server->handleAuthorizeRequest($request, $response, $is_authorized, $user_id);

        $response->send();
    }
}