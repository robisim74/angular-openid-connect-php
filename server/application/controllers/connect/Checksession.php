<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Response;

/* 
 * Checksession endpoint.
 * 
 * @see http://openid.net/specs/openid-connect-session-1_0.html
 */
class Checksession extends OAuth2_server
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // TODO
    }
}