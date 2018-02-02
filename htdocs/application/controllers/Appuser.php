<?php
require_once('Access.php');
class Appuser extends Access
{
	function __construct()
	{
		parent::__construct('appuser');
	}
	
	function index()
	{
		$this->session->unset_userdata('searchterm');
	
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('appuser/index');
		$pag['total_rows'] = $this->appuser_model->count_all();
		$data['appusers'] = $this->appuser_model->get_all($pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('appuser/view',$data,true);
		$this->load->view('template',$content);
	}
	
	function search()
	{
		$search_term = $this->searchterm_handler($this->input->post('searchterm'));
		
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('appuser/search');
		$pag['total_rows'] = $this->appuser_model->count_all_by(array('searchterm'=>$search_term));
		$data['searchterm'] = $search_term;
		$data['appusers'] = $this->appuser_model->get_all_by(array('searchterm'=>$search_term),$pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('appuser/search',$data,true);
		$this->load->view('template',$content);
	}
	
	function searchterm_handler($searchterm)
	{
	    if($searchterm){
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
	
	function detail($appuser_id)
	{
		$data['appuser'] = $this->appuser_model->get_info($appuser_id);
		
		$content['content'] = $this->load->view('appuser/detail',$data,true);
		$this->load->view('template',$content);
	}

	function ban($appuser_id = 0)
	{
		$this->check_access('ban');
		
		$data = array(
			'is_banned'=> 1
		);
			
		if ($this->appuser_model->save($data,$appuser_id)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	function unban($appuser_id = 0)
	{
		$this->check_access('ban');
		
		$data = array(
			'is_banned'=> 0
		);
			
		if ($this->appuser_model->save($data,$appuser_id)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
}
?>