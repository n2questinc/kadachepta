<?php 
require_once(APPPATH.'/libraries/REST_Controller.php');

class Podcast extends REST_Controller
{
	
	function get_get()
	{
		$data = null;
		$rav = null;
		header('Content-type: application/json');
		$cats = $this->podcast_model->get_all()->result();
		
		foreach ($cats as $cat)
		{
			$data[] = $cat;
		}
		$rav["podcast"] = $data;
		$this->response($data);

	}

}
?>