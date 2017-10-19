<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

/*
 * Revocation endpoint.
 */
class Revocation extends OAuth2_server
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * Access token is a reference token and not a JWT token.
     */
    public function index()
    {
        $request = Request::createFromGlobals();
        $response = new Response();

        $this->server->handleRevokeRequest($request, $response);
        $this->server->getResponse()->send();
    }
}
