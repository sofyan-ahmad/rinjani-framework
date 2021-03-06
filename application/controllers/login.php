<?php
class Login extends PublicController
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		if($this->Employee->is_logged_in())
		{
			redirect('home');
		}
		else
		{
			$this->form_validation->set_rules('username', 'lang:login_undername', 'callback_login_check');
    	    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == FALSE)
			{
                $this->data['hide_page_header'] = true;
                $this->data['hide_side_nav'] = true;

                $this->data['title'] = 'Login ';
                $this->data['pagebody'] = 'login';

                $this->data['template'] = 'theme/login_template';

                $this->render();

				//$data['no_navigation'] = true;
				//$this->load->view('login', $data);
			}
			else
			{
				redirect('home');
			}
		}
	}
	
	function login_check($username)
	{
		$password = $this->input->post("password");	
		
		if(!$this->Employee->login($username,$password))
		{
			$this->form_validation->set_message('login_check', $this->lang->line('login_invalid_username_and_password'));
			return false;
		}
		return true;		
	}
}
?>