<?php
class Login extends Controller {
function Login()
	{
		parent::Controller();	
	}

	function index()
	{
	    if ($this->session->userdata('logged_in') == TRUE)
	    {
	        redirect('dashboard/index');
	    }

	    $data['title'] = 'MyCoolBibleApp';
	    $data['username'] = array('id' => 'username', 'name' => 'username');
	    $data['password'] = array('id' => 'password', 'name' => 'password');	        
	    $this->load->view('login', $data);
	}

	function process_login()
	{
	    $username = $this->input->post('username');    
	    $password  = $this->input->post('password');

		//http://webcache.googleusercontent.com/search?q=cache:LG3szOIvmI8J:godbit.com/article/codeigniter-session-class+codeigniter+example+login+form&cd=6&hl=zh-TW&ct=clnk&gl=tw
	    if ($username == 'James' AND $password == 'James1:12')
	    {
	        $data = array(
                   'username'  => $username,
                   'logged_in'  => TRUE
                );

                $this->session->set_userdata($data);

                redirect('dashboard/index');
	    } 
	    else 
	    {
	        $this->session->set_flashdata('message', '<div id="message">Oopsie, it seems your username or password is incorrect, please try again.</div>');
	        redirect('login/index');
	    }
	}

	function logout()
	{
	    $this->session->sess_destroy();

	    redirect('login/index');
	}
}
?>
