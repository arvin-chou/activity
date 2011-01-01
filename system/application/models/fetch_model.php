<?php  
class fetch_model extends Model {  
  
	public $pattern = array();
	public $ci ;
    function fetch_model()  
    {  
        // Call the Model constructor  
        parent::Model();  
		$this->priority= array
			(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21);
		$this->pattern = array
			("U","H","F","y","l","L","s","t","T","k","d","B","cs","ps","et","tt","lt","as","il","dl","sl","xl");
		$this->patterno = array
			("","U","H","F","y","l","L","s","t","T","k","d","B","cs","ps","et","tt","lt","as","il","dl","sl","xl");
		$this->record = array
			(
				'nextmin'=>array
				(
					'homepage'=>array
					(
						'http://www.nextmin.com.tw/ongoing/',
						"<a\s[^>]*href=(\"??)\/event\/([^\" >]*?)\\1[^>]*>(.*)<\/a>" 
					),
					'event'=>array
					(
						'http://www.nextmin.com.tw/event/',
						"<div>\s[^>]*<b>.*<\/b>(.*)<\/div>"
						. ".*(<div\s[^>]*class=\"??block_standard[^\" >]"
						. "*?\"??[^>]*>)(.*)\\2"
					)
				)
			);
		//$this->getnextmin();
		//$this->load->model('hbase_model');
		$this->ci =& get_instance();
		$this->ci->load->model('hbase_model');
		$this->ci->hbase_model->hbaseini();
		//for($i=1;$i<=10;$i++)		
		//$this->getnextmin($i);
		//$this->hbase_model->hbaseini();
    }  
	function hbaseget($coldes,$col,$num=1)
	{
		return $this->hbase_model->hbaseget($coldes,$col,$num);
	}
	function hbasegetrange($coldes,$start,$end,$num=1)
	{
		return $this->hbase_model->hbasegetrange($coldes,$start,$end,$num);
	}
	function getnextmin($page=1)
	{
		date_default_timezone_set('UTC'); 
		/*$homepage = file_get_contents
			('http://www.nextmin.com.tw/ongoing/' 
			. $page == 1 ? "" : ("page=" . $page));
		preg_match_all("/calendar_month.+>(\w+)</",$homepage,$matches);
		*/$url = "http://www.nextmin.com.tw/ongoing/" 
			. ($page == 1 ? "" : ("?page=" . $page));
		$input = @file_get_contents($url) or die("Could not access file: $url"); 
		$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>"; 
		$regexp = "<div\s[^>]*class=\"??calendar[^\" >]*?\"??[^>]*>(.*)<\/div>";
		$regexp = "<a\s[^>]*href=(\"??)\/event\/([^\" >]*?)\\1[^>]*>(.*)<\/a>"; 
		if(preg_match_all("/$regexp/siU", $input, $matches)) 
		{
			foreach($matches[2] as $v)
			{
				$input= file_get_contents('http://www.nextmin.com.tw/event/'.$v);
				$regexp = "<div>\s[^>]*<b>.*<\/b>(.*)<\/div>"
					. ".*(<div\s[^>]*class=\"??block_standard[^\" >]*?\"??[^>]*>)(.*)\\2";
				$iteration = 0;
				if(preg_match_all("/$regexp/siU", $input, $m)) 
				{
					foreach($m as $v1)
					{
						if($iteration % 4 == 0) 
						{
							$regexp = "<div>\s[^>]*<b>.*<\/b>(.*)<\/div>";
							preg_match_all("/$regexp/siU", $v1[0], $m1);
							$date = explode("~",$m1[1][0]);
							foreach($date as $v2)
							{
								//            2011/03/25 (???? 07:30PM
								//echo preg_replace("/[\(\):]/","/",$v2);
								(int)$times = explode("/",
									preg_replace("/[\(\):]/","/",$v2));
								$date = mktime(strlen($times[4])==1?0:(int)$times[4]
									,substr(empty($times[5]) ?0:(int)$times[5],0,2)
									,0,(int)$times[1],(int)$times[2],(int)$times[0]);
								
								//echo (int)strlen($times[4]) . "|" . ((int)substr(empty($times[5])?0:$times[5],0,2)
								//	 .(int)$times[1].(int)$times[2].(int)$times[0])."<br/>";
								break;
							}
							$place = $m1[1][1];
							$regexp = "<div\s[^>]*class=\"??event_detail_description"
								. "[^\" >]*?\"??[^>]*>(.*)"
								. "<div\s[^>]*class=\"??block_standard[^\" >]*?\"??[^>]*>";
							preg_match_all("/$regexp/siU", $v1[0], $m2);
							//print_r($m2);	
							$content = $m2[1][0];
							$this->ci->hbase_model->hbaseinsert($date,'place','place',urlencode($place));
							$this->ci->hbase_model->hbaseinsert($date,'place','content',urlencode($content));

							$nextmin[] = array
								(
									'place'=>$place,
									'content'=>$content,
									'date'=>$date.= "|" . implode("",$times)
									);
						}
						if($iteration % 4 == 1)
						{
						}
						$iteration++;
					}
				}
			}
		}
		return $nextmin;
	}
	function gethtmlparam()
	{
		$data = array(
				'title' => 'Aeil\'s Search Engine',
				'heading' => 'My Heading',
				'message' => 'My Message',
				'url' => base_url()
				);
		return $data;
	}
  
	function queryoptions($content,$c,$p,$v)
	{
		//ex:(apple & pie) | banana
		$pos = FALSE;
		if( $p == 'y')
		{
			mb_internal_encoding('UTF-8');
			//if($t === $k)echo $k;
			//if(mb_ereg_match($content,$v)) 
				//echo "PPP<br/>";
			$pre = explode(" ",$v);
			if($c == 'y')
			{
			foreach($pre as $k)
				if($content === $k)$pos++;
			}
			else
			{
			foreach($pre as $k)
				if(strcasecmp($k,$content)== 0)$pos++;
			}
		}
		else
		{
			$pattern = "/".$content."/";
			$pattern .= $c == 'y' ? "" : "i";
			preg_match_all($pattern,$v,$matches);
			$pos = (count($matches[0]) == 0) ? FALSE : count($matches[0]); 
		}
		return $pos;
	}
    function getData($content,$c,$p)
	{  
		//Query the data table for every record and row  

		//if ($query->num_rows() > 0)  
		//{  
		//	//show_error('Database is empty!');  
		//}else{  
		//	return $query->result();  
		//}  
		$this->load->helper('file');
		$this->load->helper('string');
		$this->load->library('typography');
		$string = explode("@\n",read_file('./record/recode.txt'));
		unset($string[0]);
				//$content = "AEWIN";
		$r = $r1 = Array();
		foreach($string as $s)
		{
			//echo count($s,COUNT_RECURSIVE);
			//print_r($s);
			$match = FALSE;
			$score = 0;
			foreach(preg_split('/\n@/',$s) as $k=>$v)
			{
				$v = preg_replace('/^.{1,2}:/','',$v);
				//echo $v . "<br />";
				$pos = $this->queryoptions($content,$c,$p,$v);
				if ($pos === false) {}
				else
				{
					//echo $k."||".$v."||".$pos;
					$match = TRUE;
					$score += $this->priority[$k] * $pos; 
					//echo $score ."|".$pos."|".$this->priority[$k]. "<br />";
				}
				$r1[$this->pattern[$k]] = preg_replace('/^@\w+:/','',$v);
			}
			if($match)
			{
				//array_push($r,array($r1,$score));
				$r1['score'] = $score;
				$r1['encrypt'] = "";
				foreach($r1 as $e)
				{
					$r1['encrypt'].= "|".$e;
				}
				$r1['encrypt'] = addslashes(
						$this->typography->
						format_characters(str_replace("/","&sl",$r1['encrypt'])));
				//$r1['encrypt'] = $encrypt;//$this->encrypt->encode($r1['encrypt']);
				//echo $r1['encrypt'];
				array_push($r,$r1);
				//$r[] = array($r1,$score);
				//print_r($r);
			}
			
			//echo $this->pattern->cs . "EEE";
			//echo "<pre>";
			//preg_match($content, preg_split('/\n@/',$s), $matches);
//print_r($matches);
			//echo ( array_search($content,preg_split('/\n@/',$s)));
			//print_r ( preg_split('/\n@/',$s));
			//print_r( $s);
			//echo "</pre>";
			//echo  "SSSS";
		}
		if(!empty($r))$this->getsort($r);
		//preg_match_all("/hnol/","T:AEWIN Technologies Co., Ltd.AEWINAEWINAEWINAEWINAEWINAEWINAEWINAEWINAEWIN",$matches);
		//$pre = explode(" ","T:AEWIN Technologies Co., Ltd.AEWINAEWINAEW    INAEWINAEWINAEWINAEWINAEWINAEWIN");
		//$t = "t:aEWIN";
		////print_r($pre);
		//foreach($pre as $k)
		//{
		//	if(strlen($k)>=strlen($t))
		//	{
		//		//echo strcasecmp($k,$t);
		//		//echo "{".strlen($k)."|".strlen($t)."}".substr_compare($k,$t,0,strlen($t),FALSE);
		//	}
		//	//if($t === $k)echo $k;
		//}
		//echo count($matches,COUNT_RECURSIVE) . var_dump($matches) . "EE";
		return $r;
	}  
	function getsort(&$r)
	{
		foreach($r as $k=>$v)
		{
			$orgk[$k] = $k;
			$score[$k] = $v['score'];
		}
		array_multisort($score,SORT_DESC,$orgk,SORT_ASC,$r);
			//echo "<pre>";
		//print_r($r);
		//echo 
		
		//print_r($r);
		
	//echo "</pre>";
	}
  
}  
?>  

