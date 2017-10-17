<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Userinfo endpoint.
 */
class Userinfo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');
    }

    /* 
     * Discovery document.
     */
    public function index()
    {
        $arr = array(
            "sub" => 1
        );

        echo json_encode($arr, JSON_UNESCAPED_SLASHES);
    }
}