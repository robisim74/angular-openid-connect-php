<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;

/* 
 * Token endpoint.
 */
class Token extends OAuth2_server
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * Not used with implicit flow.
     */
    public function index()
    {
        /* return $this->server->handleTokenRequest(Request::createFromGlobals())->send(); */
    }
}