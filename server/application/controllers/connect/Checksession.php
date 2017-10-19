<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;

/* 
 * Token endpoint.
 */
class Checksession extends OAuth2_server
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }
}