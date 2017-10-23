<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->scripts[] = 'home';
    }

    public function index()
    {
        $this->authorize();

        $this->set_messages();
        $this->render_page('home');
    }
}
