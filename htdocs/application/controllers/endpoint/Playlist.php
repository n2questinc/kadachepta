<?php 
require_once(APPPATH.'/libraries/REST_Controller.php');

class Playlist extends REST_Controller
{


	function add_post()
	{

		$data = $this->post();



		if ($data == null)
		{
			$this->response(array('respon' => 'incorrect_json', 'error' => 1));
		}
		
		if (!array_key_exists('user_id', $data))
		{
			$this->response(array('respon' => 'incorrect_userid', 'error' => 1));
		}
			
		if (!array_key_exists('name', $data))
		{
			$this->response(array('respon' => 'incorrect_name', 'error' => 1));
		}
		
		
				
		$playlist_data = array(
			'user_id' => $data['user_id'],
			'name' => $data['name'],
			'is_private' => '1'
			
			
		);
		
		if ($this->playlist_model->save($playlist_data))
		{
			$this->response(array('respon' => 'playlist_saved', 'error' => 0));

		} else {

			$this->response(array('respon' => 'playlist_no_save', 'error' => 1));
		}



	}

	function alluserplaylist_post()
	{

		$stid = $this->post('user_id');

		if ($styles = $this->playlist_model->allplaylist_by_user($stid)) {
			
			$this->response(array('respon' => $this->playlist_model->allplaylist_by_user($stid)->result(),'error' =>0));

		} else {

			$this->response(array('respon' => 'incorrect_data', 'error' => 1));
		}


	}

	function delete_post()
	{

		$id = $this->post('id');
		
		if ($tracks = $this->playlist_model->delete_playlist($id)) {
			$this->playtrack_model->delete_all_track_inpl($id);
			$this->response(array('respon' => 'deleted','error' =>0));
		} else {
			$this->response(array('respon' => 'incorrect_delete', 'error' => 1));
		}

	}
	
	function setprivate_post()
	{
		$id = $this->post('id');
		
		$data = array(
			
			'is_private' => $this->post('is_private')
		);
		
		if ($private = $this->playlist_model->set_private($data,$id)){
			
			$this->response(array('respon' => 'setprivate','error' =>0));
			
		} else {
			
			$this->response(array('respon' => 'error','error' =>1));
		}
		
		
	}
	
	function allpublic_post()
	{
		
		if ($styles = $this->playlist_model->all_public()) {
			
			$this->response(array('respon' => $this->playlist_model->all_public()->result(),'error' =>0));
			
		} else {
			$this->response(array('respon' => 'incorrect_data', 'error' => 1));
		}
		
	}











}