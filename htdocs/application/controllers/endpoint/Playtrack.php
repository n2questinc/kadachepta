<?php 
require_once(APPPATH.'/libraries/REST_Controller.php');

class Playtrack extends REST_Controller
{


	function add_post()
	{

		$data = $this->post();
		
		$track_data = array(
			'playlist_id' => $data['playlist_id'],
			'track_id' => $data['track_id']
			
		);

		if ($this->playtrack_model->exists($track_data))
		{
			$this->response(array('respon' => 'track_in_list', 'error' => 1));
		} else {
			$this->playtrack_model->add_playtrack($track_data);
			$this->response(array('respon' => 'track_saved', 'error' => 0));
		}

	}

	function alltrack_get()
	{

		$playlist_id = $this->get('id');
		$outputdata = array();

		if ($styles = $this->playtrack_model->alltrack_by_plist($playlist_id)) {

			$data_track = $this->playtrack_model->alltrack_by_plist($playlist_id)->result();
			foreach ($data_track as $keys ) {
				
				$track = $this->track_model->get_by_idtrack($keys->track_id)->result();
				
				if($track == null){
					
				}else {
					
					array_push($outputdata,$track);
					
				}
				
			}

			$this->response(array('respon' => $outputdata ,'error' =>0));
			
		} else {
			$this->response(array('respon' => 'incorrect_data', 'error' => 1));
		}

	}

	function delete_post()
	{

		$trackId = $this->post('track_id');
		$playlistId = $this->post('playlist_id');

		if ($tracks = $this->playtrack_model->delete($trackId,$playlistId)) {
			$this->response(array('respon' => 'deleted','error' =>0));
		} else {
			$this->response(array('respon' => 'incorrect_delete', 'error' => 1));
		}
	}

}