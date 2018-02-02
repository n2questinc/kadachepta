<?php 
require_once(APPPATH.'/libraries/REST_Controller.php');

class Track extends REST_Controller
{

	function alltrackbystyle_get()
	{

		$stid = $this->get('id');

		if ($styles = $this->track_model->get_by_style($stid)) {
			$this->response(array('respon' => $this->track_model->get_by_style($stid)->result(),'error' =>0));
		} else {
			$this->response(array('respon' => 'incorrect_login', 'error' => 1));
		}
	}

	function trackbyid_get($track_id = 0)
	{

		if ($styles = $this->track_model->get_info($track_id)) {
			$this->response(array('respon' => $this->track_model->get_info($track_id),'error' =>0));
		} else {
			$this->response(array('respon' => 'incorrect_login', 'error' => 1));
		}

	}

	function search_post()
	{
	
	$data = $this->post();
	
	if (!array_key_exists('searchterm', $data)) {
			
			$search = null;
			
		} else {
		
		$search =  $data['searchterm'];
		
	}
	
	if (!array_key_exists('artist_id', $data)) {
			
			$artist_id = null;
			
		} else {
		
		$artist_id =  $data['artist_id'];
		
	}
	if (!array_key_exists('style_id', $data)) {
			
			$style_id = null;
			
		} else {
		
		$style_id =  $data['style_id'];
		
	}
	if (!array_key_exists('album_id', $data)) {
			
			$album_id = null;
			
		} else {
		
		$album_id =  $data['album_id'];
		
	}
	if (!array_key_exists('isPublish', $data)) {
			
			$isPublish = null;
			
		} else {
		
		$isPublish =  $data['isPublish'];
		
	}
	
	if (!array_key_exists('limit', $data)) {
			
			$limit = null;
			
		} else {
		
		$limit =  $data['limit'];
		
	}
	if (!array_key_exists('offset', $data)) {
			
			$offset = null;
			
		} else {
		
		$offset =  $data['offset'];
		
	}
	

        $search_term = array(
			"searchterm" => $search,
			"artist_id"  => $artist_id,
			"style_id"   => $style_id,
			"album_id"   => $album_id ,
			"isPublish"  => $isPublish
			
		);
		
		
		$this->response(array('respon' => $this->track_model->getapi_all_by($search_term,$limit,$offset)->result(),'error' =>0));
		
	}
	
	function trend_post()
	{
		
		$limit = $this->post('limit');
		$offset = $this->post('offset');
		
		if ($styles = $this->track_model->gettrend_all($limit, $offset)) {
			$this->response(array('respon' => $this->track_model->gettrend_all($limit, $offset)->result(),'error' =>0));
		} else {
			$this->response(array('respon' => 'incorrect_login', 'error' => 1));
		}
		
	}
	
	function trendcount_post()
	{
		
		$data = $this->post();
		
		if ($data == null)
		{
			$this->response(array('respon' => 'invalid_json', 'error' => 0));
		}
		
		if (!array_key_exists('id', $data))
		{
			$this->response(array('respon' =>  'require_radio_id', 'error'=> 0));
		}
		
		$tr_data = array(
			'id' => $data['id'],
			'plays' =>  1
		);
		
		if ($this->track_model->exists($tr_data))
		{
			$radioold = $this->track_model->getby_trackid($tr_data)->result();
			$newcount = intval($radioold[0]->plays) + 1;
			
			$newdata = array(
				'id' => $data['id'],
				'plays' =>  $newcount
			);
			
			$this->track_model->plustrend($newdata, $radioold[0]->id);
			$this->response(array('error' => array('message' => 'plus on trend')));
			
		} else {
			
			$this->track_model->save($tr_data);
			$this->response(array('success'=>'make new trend'));
		}
		
	}

}

?>