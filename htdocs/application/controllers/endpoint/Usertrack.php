<?php 
require_once(APPPATH.'/libraries/REST_Controller.php');

class Usertrack extends REST_Controller
{

	function save_post()
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
			
		if (!array_key_exists('track_id', $data))
		{
			$this->response(array('respon' => 'incorrect_trackid', 'error' => 1));
		}
		
				
		$track_data = array(
			'user_id' => $data['user_id'],
			'track_id' => $data['track_id']
			
		);
		
		if ($this->usertrack_model->exists($track_data))
		{
			$this->response(array('respon' => 'track_in_list', 'error' => 1));
		} else {
			$this->usertrack_model->save($track_data);
			$this->response(array('respon' => 'track_saved', 'error' => 0));
		}



	}

	function allusertrack_get()
	{

		$stid = $this->get('id');
		$outputdata = array();


		if ($styles = $this->usertrack_model->alltrack_by_user($stid)) {
			$data_track = $this->usertrack_model->alltrack_by_user($stid)->result();
			foreach ($data_track as $keys ) {
				
				$track = $this->track_model->get_by_idtrack($keys->track_id)->result();
				
				if ($track == null){
					
				} else {
					
					array_push($outputdata,$track);
				}
				
			}

			$this->response(array('respon' => $outputdata ,'error' =>0));

			
		} else {
			$this->response(array('respon' => 'incorrect_data', 'error' => 1));
		}


	}

	function delete_get()
	{

		$stid = $this->get('id_user');
		$trsd = $this->get('id_track');

		if ($tracks = $this->usertrack_model->delete_track($stid,$trsd)) {
			$this->response(array('respon' => 'deleted','error' =>0));
		} else {
			$this->response(array('respon' => 'incorrect_delete', 'error' => 1));
		}

	} 

	function checklike_post()
	{

		$data = $this->post();

		$track_data = array(
			'user_id' => $data['user_id'],
			'track_id' => $data['track_id']
			
		);

		if ($tracks = $this->usertrack_model->exists($track_data)) {
			$this->response(array('respon' => 'like','error' =>0));
		} else {
			$this->response(array('respon' => 'dislike', 'error' => 1));
		}

	}

}

?>