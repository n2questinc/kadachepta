<?php 
require APPPATH.'/libraries/REST_Controller.php';
//require APPPATH.'/libraries/Uploader.php';

class Images extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function upload_post()
	{
		
		$user_id = $this->post('userId');
		if (!$user_id)
		{
			$this->response(array('error' => array('message' => 'require_user_id')));
		}
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '1000*50';
		$config['max_width']  = '10024';
		$config['max_height']  = '10024';
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
				
		if ( ! $this->upload->do_upload('file')) 
		{
			$error = array('error' => $this->upload->display_errors());
						
		} else {
			
			$data = array('upload_data' => $this->upload->data());
	    }
	    
		$basename = $user_id.'-'.time().'-'.$_FILES['file']['name'];
		move_uploaded_file($_FILES['file']['tmp_name'],$config['upload_path'].$basename);
		$urlfile_uploaded = base_url(). 'uploads/' . $basename;
		$this->response(array('response' => array('image' => $urlfile_uploaded)));
			
	}
	
}
?>