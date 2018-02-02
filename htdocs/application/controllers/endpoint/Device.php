<?php 
require_once(APPPATH.'/libraries/REST_Controller.php');

class Device extends REST_Controller
{
	function token_post()
	{
		$data = $this->post();
		
		if ($data == null)
		{
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('system', $data))
		{
			$this->response(array('error' => array('message' => 'require_system')));
		}
			
		if (!array_key_exists('token', $data))
		{
			$this->response(array('error' => array('message' => 'require_token')));
		}
		
				
		$device_data = array(
			'system' => $data['system'],
			'token' => $data['token']
			
		);
		
		if ($this->device_model->exists($device_data))
		{
			$this->response(array('error' => array('message' => 'Token have in base')));
		} else {
			$this->device_model->save($device_data);
			$this->response(array('success'=>'Token is saved successfully!'));
		}

	}
	
	function chektoken_get()
	{
		
		$data = null;
		$id = $this->get('token');
        header('Content-type: application/json');
		
		if ($this->device_model->checktoken($id)) {
			$this->response(array('message' => 'token_yes'));
		} else {
			$this->response(array('message' => 'token_new'));
		}
	}
}
?>