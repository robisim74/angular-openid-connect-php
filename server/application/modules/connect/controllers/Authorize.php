<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

/*
 * Authorization endpoint.
 * 
 * @see http://openid.net/specs/openid-connect-implicit-1_0.html
 */
class Authorize extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Methods: GET');

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
            redirect('account/login', 'refresh');
        }

        $request = Request::createFromGlobals();
        $response = new Response();
                
        // Validates the authorize request. If it is invalid, redirects back to the client with the errors.
        if (!$this->oauth2_server->server->validateAuthorizeRequest($request, $response)) {
            $this->oauth2_server->server->getResponse()->send();
            die();
        }

        // Obtains End-User Consent/Authorization.
        // http://openid.net/specs/openid-connect-implicit-1_0.html#Consent.
        $scopes = $this->oauth2_server->server->getStorage('scope')->supportedScopes;

        $this->data['title'] = $this->title;
        $this->data['client_id'] = $request->query('client_id');
        $this->data['scopes'] = $scopes;

        // Stores the request.
        $this->session->set_flashdata('request', $request);

        $this->load->view('connect/authorize', $this->data);
    }

    public function authorize_post()
    {
		// Gets the request.
        $request = $this->session->flashdata('request');
        $response = new Response();

        $is_authorized = isset($_POST['authorize']);
        $user_id = $this->ion_auth->get_user_id();

        $this->oauth2_server->server->handleAuthorizeRequest($request, $response, $is_authorized, $user_id)->send();
    }
}
