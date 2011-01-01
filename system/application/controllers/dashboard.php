<?php
class Dashboard extends Controller {

	function Dashboard()
	{
		parent::Controller();	
	}

	function index()
	{
	    if ($this->session->userdata('logged_in') != TRUE)
	    {
	        redirect('login/index');
	    }

	    $data['title']  = 'Dashboard | MyCoolBibleApp';    
	    $this->load->view('dashboard', $data);
	}
}
?>
