<?php
class Listall extends Controller {
	public $page = 1;
	public $page_list= 10;
	function Listall()
	{
		parent::Controller();	
	}

	function index()
	{
		$this->load->model('fetch_model','fetch');
	    if ($this->session->userdata('logged_in') == TRUE)
	    {
	        redirect('dashboard/index');
	    }

	    //$data['title'] = 'MyCoolBibleApp';
		//[0] => Array
		//(
		//	[0] => TRowResult Object
		//	(
		//		[row] => 1276758000
		//		[columns] => Array
		//		(
		//			[place:content] => TCell Object
		//			(
		//				[value] => 
		$this->_page();
		date_default_timezone_set('UTC'); 
		echo $this->page;
		$today = mktime(0, 0, 0, date("m")  
			, date("d")+($this->page ) * $this->page_list, date("Y"));
		$next_week= mktime(0, 0, 0, date("m")  
			, date("d")+( $this->page >= 0 ? 
			($this->page+1) : ($this->page-1) )
		   	* $this->page_list, date("Y"));
		if($this->page < 0)
		{
			$tmp = $today;
			$today = $next_week;
			$next_week = $tmp;
		}
		$list = $this->fetch->hbasegetrange(array('place:'),$today
			,$next_week,$this->page_list);

		//foreach($this->fetch->hbaseget('place','',5) as $v)
		if(!$this->_nolist($list))
		{
			$data['list'][] = array
				('row'=>date("Y/m/d g:i a",$today),
				'place'=>'',
				'content'=>'no action in our database',
				'fulltxt'=>'no action in our database',
				'timestamp'=>$today,
				'link'=>'#'
			);
		}
		else
		{
			$data =& $this->_listall($list);
			//			foreach($data['list'] as $v)echo $v['row'];
			if(count($list) < $this->page_list)$this->_listtoend($list);
		}
		/*
		foreach($list as $v1)
		{
			$v[0] = $v1;
			echo date("Y/m/d g:i a",$v[0]->row) . "<br />";
			if(array_key_exists('place:content',$v[0]->columns)&&
				array_key_exists('place:place',$v[0]->columns))
			{
				preg_match_all("/<b\s*?>.*<\/b><a href=\"(.*)\"[^>]*?target.*>/",urldecode($v[0]->columns['place:content']->value),$matches);
				$data['list'][] = array
					(
						'row'=>date("Y/m/d g:i a",$v[0]->row),
						'content'=>mb_substr(urldecode($v[0]->columns['place:content']->value),0,300,"UTF-8") . "<br/>...",
						'place'=>urldecode($v[0]->columns['place:place']->value),
						'link'=>(count($matches[1])==0?"":$matches[1][0]),
						'timestamp'=>$v[0]->row,
						'fulltxt'=>(($v[0]->columns['place:content']->value))
					);
			}
		}
		 */
		//print_r($data);
		$data['url'] = base_url();
		$data['page'] = $this->page;
		$this->load->view('list', $data);
	}
	function _listtoend(&$list)
	{

		$today = mktime(0, 0, 0, date("m")
			, date("d")+$this->page_list, date("Y"));
		$next_week= mktime(0, 0, 0, date("m")  
			, date("d")+2 * $this->page_list, date("Y"));
		$loop = $this->page_list - count($list);
		$list = $this->fetch->hbasegetrange(array('place:'),$today
			,$next_week,$this->page_list);
		while(($loop--) > 0)$data['list'][] = array_shift($list);
	}
	function _nolist(&$list)
	{
		if(count($list) <= 0)return 0;
		else return 1;

	}
	function _listall(&$list)
	{
		foreach($list as $v1)
		{
			$v[0] = $v1;
			//echo date("Y/m/d g:i a",$v[0]->row) . "<br />";
			if(array_key_exists('place:content',$v[0]->columns)&&
				array_key_exists('place:place',$v[0]->columns))
			{
				preg_match_all("/<b\s*?>.*<\/b><a href=\"(.*)\"[^>]*?target.*>/",urldecode($v[0]->columns['place:content']->value),$matches);
				$data['list'][] = array
					(
						'row'=>date("Y/m/d g:i a",$v[0]->row),
						'content'=>mb_substr(urldecode($v[0]->columns['place:content']->value),0,300,"UTF-8") . "<br/>...",
						'place'=>urldecode($v[0]->columns['place:place']->value),
						'link'=>(count($matches[1])==0?"":$matches[1][0]),
						'timestamp'=>$v[0]->row,
						'fulltxt'=>(($v[0]->columns['place:content']->value))
					);
			}

		}
		return $data;
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
	function _page()
	{
		$pre= $this->input->post('pre');
		$next= $this->input->post('next');
		$page= $this->input->post('now');
		if(empty($page))$page = 0;
		if(!empty($pre))(int)$page--;
		else if(!empty($next))$page++;

		//if($page < 0)$page = 0;
		$this->page = $page;
	}
}
?>
