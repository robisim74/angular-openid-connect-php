<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->scripts[] = 'account';
	}

	public function login()
	{
		$this->form_validation->set_rules('identity', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		// Gets the request.
		$request_url = $this->session->flashdata('request_url');

		// Checks whether the user should be redirected to the Authorize endpoint.
		$redirect_url = '/';
		if ($request_url) {
			$redirect_url = $request_url;
		}

		if ($this->form_validation->run() == true) {
			$remember = (bool)$this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
				redirect($redirect_url, 'refresh');
			}
		}

		// Stores the request.
		$this->session->set_flashdata('request_url', $request_url);

		$this->set_messages();
		$this->render_page('account/login');
	}

	public function logout()
	{
		$logout = $this->ion_auth->logout();

		redirect('account/login', 'refresh');
	}
}
