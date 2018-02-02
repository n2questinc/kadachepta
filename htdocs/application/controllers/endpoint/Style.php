<?php 
require_once(APPPATH.'/libraries/REST_Controller.php');

class Style extends REST_Controller
{

	function all_get()
	{

		if ($styles = $this->style_model->get_all(null,null)) {
			$this->response(array('respon' => $this->style_model->get_all()->result(),'error' =>0));
		} else {
			$this->response(array('respon' => 'incorrect_login', 'error' => 1));
		}

	}

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
		$this->response(array('respon' => $this->style_model->get_all_by($search_term)->result(),'error' =>0));
		
	}

}

?>
