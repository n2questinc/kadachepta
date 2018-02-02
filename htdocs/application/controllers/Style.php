<?php

require_once('Access.php');
class Style extends Access
{


	function __construct()
	{
		parent::__construct('style');
	}

	function index()
	{
		$this->session->unset_userdata('searchterm');
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('style/index');
		$pag['total_rows'] = $this->style_model->count_all();
		$data['styles'] = $this->style_model->get_all($pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('style/view',$data,true);
		$this->load->view('template',$content);
	}

	function add()
	{
		$this->check_access('add');

		if ($this->input->server('REQUEST_METHOD')=='POST') {

			$config['upload_path'] = './image/';
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

			$urlfile_uploaded = s3_site_url(). 'image/' . $basename;

			$category_data = array(
				'name' => $this->input->post('name'),
				'image_url' => $urlfile_uploaded,
				'image' => $basename
			);

			if ($this->style_model->save($category_data)) {
				$this->session->set_flashdata('success','Style is successfully added.');
				redirect('style');
			} else {
				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
			}
		}

		$content['content'] = $this->load->view('style/add',array(),true);
		$this->load->view('template',$content);
	}

	function exists($style_id=null)
	{
		$name = $_REQUEST['name'];

		if (strtolower($this->style_model->get_info($style_id)->name) == strtolower($name)) {
			echo "true";
		} else if ($this->style_model->exists(array('name'=>$_REQUEST['name']))) {
				echo "false";
			} else {
			echo "true";
		}
	}

	function delete($style_id=0)
	{
		$this->check_access('delete');
		if($this->style_model->delete($style_id)) {
			$this->session->set_flashdata('success','The style is successfully deleted.');
		} else {
			$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
		}
		redirect(site_url('style'));
	}


	function delete_items($style_id=0)
	{
		$this->check_access('delete');

		if ($this->style_model->delete($style_id)) {
			if ($this->radio_model->delete_by_cat($style_id)) {
				$this->session->set_flashdata('success','The style is successfully deleted.');
			} else {
				$this->session->set_flashdata('error','Database error occured in items.Please contact your system administrator.');
			}
		} else {
			$this->session->set_flashdata('error','Database error occured in categories.Please contact your system administrator.');
		}
		redirect(site_url('style'));
	}

	function edit($style_id=0)
	{
		$this->check_access('edit');

		if ($this->input->server('REQUEST_METHOD')=='POST') {

			$config['upload_path'] = './image/';
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
				$urlfile_uploaded = s3_site_url(). 'image/' . $basename;
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
			}

			if(file_exists($_FILES['file']['tmp_name'])){

				$basename = $_FILES['file']['name'];
			    $urlfile_uploaded = s3_site_url(). 'image/' . $basename;


			}else{

			}

			$style_data = array(
				'name' => $this->input->post('name'),
				'image_url' => $urlfile_uploaded,
				'image' => $basename
			);

			if($this->style_model->save($style_data,$style_id)) {
				$this->session->set_flashdata('success','Style is successfully updated.');
			} else {
				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
			}
			redirect(site_url('style'));
		}

		$data['style'] = $this->style_model->get_info($style_id);
		$content['content'] = $this->load->view('style/edit',$data,true);
		$this->load->view('template',$content);
	}

	function search()
	{
		$search_term = $this->searchterm_handler($this->input->post('searchterm'));
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('style/search');
		$pag['total_rows'] = $this->style_model->count_all_by(array('searchterm'=>$search_term));
		$data['searchterm'] = $search_term;
		$data['categories'] = $this->style_model->get_all_by(array('searchterm'=>$search_term),$pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('style/search',$data,true);
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