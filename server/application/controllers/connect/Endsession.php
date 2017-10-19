<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

/*
 * Endsession endpoint.
 */
class Endsession extends OAuth2_server
{
    public function __construct()
    {
        parent::__construct();
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
