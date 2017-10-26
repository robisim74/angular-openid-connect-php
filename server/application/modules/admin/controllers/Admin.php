<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->scripts[] = 'admin';
    }

    public function index()
    {
        $this->authorize_admin();

        $this->data['users'] = $this->ion_auth->users()->result();
        foreach ($this->data['users'] as $k => $user) {
            $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }

        $this->render_page('admin');
    }

    public function register()
    {
        $this->authorize_admin();

        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Confirm password', 'required');

        if ($this->form_validation->run() == true) {
            $username = $this->input->post('email');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name')
            );

            if ($this->ion_auth->register($username, $password, $email, $additional_data)) {
                redirect('admin', 'refresh');
            }
        }

        $this->set_messages();
        $this->render_page('admin/register');
    }

    public function edit_user($id = '')
    {
        if (!$id || empty($id)) {
            redirect('admin', 'refresh');
        }
        $this->authorize_admin();

        $user = $this->ion_auth->user($id)->row();
        if (!$user) {
            redirect('admin', 'refresh');
        }

        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == true) {
            $data = array(
                'username' => $this->input->post('email'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email')
            );

            if ($this->ion_auth->update($user->id, $data)) {
                redirect('admin', 'refresh');
            }
        }

        $this->data['user'] = $user;

        $this->set_messages();
        $this->render_page('admin/edit_user');
    }

    public function activate_user($id)
    {
        $this->authorize_admin();

        if ($this->ion_auth->activate($id)) {
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect('admin', 'refresh');
        }

        $this->session->set_flashdata('error_message', 'Failed to enable user.');
        redirect('admin', 'refresh');
    }

    public function deactivate_user($id)
    {
        $this->authorize_admin();

        if ($id != $this->user->id && $this->ion_auth->deactivate($id)) {
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect('admin', 'refresh');
        }

        $this->session->set_flashdata('error_message', 'Can not disable user.');
        redirect('admin', 'refresh');
    }
}
