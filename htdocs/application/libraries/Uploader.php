<?php
class Uploader extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$config['upload_path'] = './uploads';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['overwrite'] = TRUE;

		$this->upload->initialize($config);
	}

	function upload($files,$userId=0,$type="")
	{
		$data = array();

		foreach ($files as $field=>$file)
		{

			if ($userId==0)
			{
				$_FILES[$field]['name'] = time().$_FILES[$field]['name'];

			} else {
				$extension = '.jpg';
				$_FILES[$field]['name'] = $userId . "-" . $type . $extension;

				if (file_exists(".uploads/".$_FILES[$field]['name'])) {
					unlink(".uploads/".$_FILES[$field]['name']);
				}
			}

			if ($file['error'] == 0)
			{

				if ($this->upload->do_upload($field)) {
					$data[] = $this->upload->data();

					$this->image_lib->clear();
					$image_data = $this->upload->data();
					$config = array(
						'source_image' => $image_data['full_path'],
						'new_image' => './uploads/thumbs',
						'maintain_ration' => true,
						'width' => 150,
						'height' => 100
					);
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
				} else {

					$data['error'] = $this->upload->display_errors();
				}
			}
		}

		return $data;
	}
}
?>