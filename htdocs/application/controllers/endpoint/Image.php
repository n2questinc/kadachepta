<?php 
require APPPATH.'/libraries/REST_Controller.php';

class Image extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		
	}
	
	function upload_post()
	{
		$data = null;
		$data2 = null;
		if ($this->input->server('REQUEST_METHOD')=='POST') {

			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '10000*100';
			$config['max_width']  = '10024';
			$config['max_height']  = '10024';
			$config['overwrite'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload('file')) //not working
				{
				$error = array('error' => $this->upload->display_errors());
				var_dump($error);
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
			}
			$basename = time().$_FILES['file']['name'];

			move_uploaded_file($_FILES['file']['tmp_name'],$config['upload_path'].$basename);
			$urlfile_uploaded = base_url(). 'uploads/' . $basename;

		}
		
		$data['image'] = $basename;

		$this->response( $data);

		
	}
}
?>