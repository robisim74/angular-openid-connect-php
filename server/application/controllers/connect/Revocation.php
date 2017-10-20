<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

/*
 * Revocation endpoint: only for reference tokens.
 * 
 * @see https://tools.ietf.org/html/rfc7009
 */
class Revocation extends OAuth2_server
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $request = Request::createFromGlobals();
        $response = new Response();

        $this->server->handleRevokeRequest($request, $response);
        $this->server->getResponse()->send();
    }
}
