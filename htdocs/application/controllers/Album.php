<?php

require_once('Access.php');
class Album extends Access
{


	function __construct()
	{
		parent::__construct('album');
	}

	function index()
	{
		$this->session->unset_userdata('searchterm');
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('album/index');
		$pag['total_rows'] = $this->album_model->count_all();
		$data['albums'] = $this->album_model->get_all($pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('album/view',$data,true);
		$this->load->view('template',$content);
	}

	function add()
	{
		$this->check_access('add');

		if ($this->input->server('REQUEST_METHOD')=='POST') {

			$config['upload_path'] = './album/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '1000*10';
			$config['max_width']  = '2024';
			$config['max_height']  = '2024';
			$config['overwrite'] = TRUE;
			$config['acl'] = 'public-read';
            $config['make_unique_filename'] = false;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload_s3('file')) //not working
				{
				$error = array('error' => $this->upload->display_errors());
				var_dump($error);
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
			}
			$basename = $_FILES['file']['name'];

			$urlfile_uploaded = s3_site_url(). 'album/' . $basename;

			$album_data = array(
				'name' => $this->input->post('name'),
				'image_url' => $urlfile_uploaded,
				'image' => $basename
			);

			if ($this->album_model->save($album_data)) {
				$this->session->set_flashdata('success','Album is successfully added.');
				redirect('album');
			} else {
				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
			}
		}

		$content['content'] = $this->load->view('album/add',array(),true);
		$this->load->view('template',$content);
	}

	function exists($album_id=null)
	{
		$name = $_REQUEST['name'];

		if (strtolower($this->album_model->get_info($album_id)->name) == strtolower($name)) {
			echo "true";
		} else if ($this->album_model->exists(array('name'=>$_REQUEST['name']))) {
				echo "false";
			} else {
			echo "true";
		}
	}

	function delete($album_id=0)
	{
		$this->check_access('delete');
		if($this->album_model->delete($album_id)) {
			$this->session->set_flashdata('success','The album is successfully deleted.');
		} else {
			$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
		}
		redirect(site_url('album'));
	}


	

	function edit($album_id=0)
	{
		$this->check_access('edit');



		if ($this->input->server('REQUEST_METHOD')=='POST') {

			$config['upload_path'] = './album/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '1000*10';
			$config['max_width']  = '1024';
			$config['max_height']  = '1024';
			$config['overwrite'] = TRUE;
			$config['acl'] = 'public-read';
            $config['make_unique_filename'] = false;
			$this->load->library('upload', $config);
			
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload_s3('file'))
			{
				$basename =  $this->session->userdata('image');
				$urlfile_uploaded = s3_site_url(). 'album/' . $basename;
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
			}

			if(file_exists($_FILES['file']['tmp_name'])){

				$basename = $_FILES['file']['name'];
			    $urlfile_uploaded = s3_site_url(). 'album/' . $basename;


			}else{

			}


			$album_data = array(
				'name' => $this->input->post('name'),
				'image_url' => $urlfile_uploaded,
				'image' => $basename
			);

			if($this->album_model->save($album_data,$album_id)) {
				$this->session->set_flashdata('success','Album is successfully updated.');
			} else {
				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
			}
			redirect(site_url('album'));
		}

		$data['albums'] = $this->album_model->get_info($album_id);
		

		$content['content'] = $this->load->view('album/edit',$data,true);
		$this->load->view('template',$content);
	}

	function search()
	{
		$search_term = $this->searchterm_handler($this->input->post('searchterm'));
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('album/search');
		$pag['total_rows'] = $this->album_model->count_all_by(array('searchterm'=>$search_term));
		$data['searchterm'] = $search_term;
		$data['categories'] = $this->album_model->get_all_by(array('searchterm'=>$search_term),$pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('album/search',$data,true);
		$this->load->view('template',$content);
	}

	function searchterm_handler($searchterm)
	{
		if ($searchterm) {
			$this->session->set_userdata('searchterm', $searchterm);
			return $searchterm;
		} elseif ($this->session->userdata('searchterm')) {
			$searchterm = $this->session->userdata('searchterm');
			return $searchterm;
		} else {
			$searchterm ="";
			return $searchterm;
		}
	}

}