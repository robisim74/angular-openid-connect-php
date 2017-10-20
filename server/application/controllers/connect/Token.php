<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;

/* 
 * Token endpoint: not used with implicit flow.
 */
class Token extends OAuth2_server
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /* return $this->server->handleTokenRequest(Request::createFromGlobals())->send(); */
    }
}