<?php 
require_once(APPPATH.'/libraries/REST_Controller.php');

class Album extends REST_Controller
{


	function search_post()
	{

		$data = $this->post();

		$search_term = array(
			"searchterm" => $data['searchterm']
			//"artist_id"  =>$this->input->post('artist_id'),
			//"style_id"   =>$this->input->post('style_id'),
			//"album_id"   =>$this->input->post('album_id'),
			//"isPublish"  =>$this->input->post('is_publish')
			
		);

		//$limit = $this->input->post('limit');
		//$offset = $this->input->post('offset');
		$this->response(array('respon' => $this->album_model->get_all_by($search_term)->result(),'error' =>0));
	}

}