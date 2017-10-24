<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;

/* 
 * Token endpoint: not used with implicit flow.
 */
class Token extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    }
}