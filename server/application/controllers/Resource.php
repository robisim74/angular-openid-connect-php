<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;

/*
 * Resource API controller.
 */
class Resource extends OAuth2_server
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*
         * OAuth 2.0 authentication: 'resource' scope & 'members' group.
         */
        If (!$this->authorize(Request::createFromGlobals(), 'resource', ['members'])) {
            if (!$this->response->isSuccessful()) {
                $this->response->send();
                die;
            }
            else {
                return;
            }
        }

        /*
         * The request is valid.
         */
        echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
    }
}