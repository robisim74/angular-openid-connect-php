<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

class Resource extends OAuth2_server
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*
         * The following permission checks must be at the beginning of each API.
         */

        // Browsers preflight the request to look for CORS headers.
        // If the request is acceptable, then they will send the real request.
        $bearer = $this->input->get_request_header('Authorization', TRUE);
        if (is_null($bearer)) {
            return;
        }

        $request = Request::createFromGlobals();
        $response = new Response();

        // OAuth 2.0 authentication: "resource" scope.
        if (!$this->server->verifyResourceRequest($request, $response, 'resource')) {
            $this->server->getResponse()->send();
            die;
        }

        // Allowed groups: "members".
        $token = $this->server->getAccessTokenData($request, $response);
        if (!$this->ion_auth->in_group(['members'], $token['user_id'])) {
            // Unauthorized.
            $response->setError(401, 'Invalid group');
            $response->send();
            die;
        };

        /*
         * The request is valid.
         */

        echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
    }
}