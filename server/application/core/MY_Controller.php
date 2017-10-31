<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_Controller extends CI_Controller
{
    public $title = 'OIDC PHP';
    public $meta_description = 'Angular & PHP CodeIgniter server through OAuth 2.0 OpenID Connect';
    public $logged_in = FALSE;
    public $is_admin = FALSE;
    public $user = null;

    public $scripts = array();

    protected $data = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('language', 'cookie'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        if ($this->ion_auth->logged_in()) {
            $this->logged_in = true;
        }
        if ($this->ion_auth->is_admin()) {
            $this->is_admin = true;
        }

        $id = $this->ion_auth->get_user_id();
        $this->user = $this->ion_auth->user($id)->row();
    }

    public function _output($content)
    {
        $data['content'] = &$content;
        echo ($this->load->view('layout', $data, true));
    }

    protected function authorize()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('account/login');
        }
    }

    protected function authorize_admin()
    {
        $this->authorize();
        if (!$this->ion_auth->is_admin()) {
            redirect('home');
        }
    }

    protected function set_messages()
    {
        $this->data['error_message'] = (validation_errors()) ? validation_errors() : $this->ion_auth->errors();
    }

    protected function render_page($view)
    {
        return $this->load->view($view, $this->data);
    }
}
