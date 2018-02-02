<?php
require_once('Access.php');
class Podcast extends Access
{
   //public $countz = 0;
   static private $countz = 0;
   //static public $imsess = array();

	function __construct()
	{
		parent::__construct('podcast');
		$this->load->library('amazon3integration_lib');

	}

	function index()
	{
		$this->session->unset_userdata('searchterm');
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('podcast/index');
		$pag['total_rows'] = $this->track_model->count_all();
		$data['items'] = $this->track_model->get_all($pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('podcast/view',$data,true);
		$this->load->view('template',$content);
		$this->session->unset_userdata('trk');
		
	}

	function add()
	{

		$this->check_access('add');
		if ($this->input->server('REQUEST_METHOD')=='POST') {

			$datrk = $this->session->userdata("trk");
			
			foreach ($datrk as $key => $value) {

				static $co = 1;
				$track_all_name = explode("-",$value);
				$trak_artist = $track_all_name[0];
				
				$data_artist = array(

					'name' => $trak_artist,
					'image' => 'art_artist.jpg'

					);

				if ($artid = $this->artist_model->save_artist($data_artist, $trak_artist)) {

					$data_track = array(

					'style' => $this->input->post('style_id'),
					'album' => $this->input->post('album_id'),
					'isPublish' => 1,
					'artist' => $artid
					
					);

				    $this->track_model->save_track($data_track,$value);
				    
				} else {
					$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
				}

				if ($co == count($datrk)){

					redirect('podcast');
 
				}

				$co ++;


			}
			
		}

		$content['content'] = $this->load->view('podcast/add',array(),true);
		$this->load->view('template',$content);
		$this->session->unset_userdata('trk');
	}

		
	function delete($item_id=0)
	{
		$this->check_access('delete');

		$trk = $this->track_model->get_info($item_id)->file;
		$track_path = 'music/'.$trk;
		if($this->amazon3integration_lib->delete_s3_object($track_path)){

			if ($this->track_model->delete($item_id)) {

			$this->playtrack_model->delete_all_track($item_id);
			$this->usertrack_model->delete_all_track($item_id);	
			$this->session->set_flashdata('success','The item is successfully deleted.');
		    } else {
			$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
		    }
		redirect(site_url('podcast'));


		}
		
	}

	

	function upload_files(){

		
		$imsess = $this->session->userdata("trk");
		
		 $files = $_FILES;

		 $cpt = count($_FILES['userfile']['name']);
		 
		 
		    for ($i = 0; $i < $cpt; $i++)
		    {           

		        $config['upload_path']   = './music/';
				$config['allowed_types'] = '*';
				$config['overwrite'] = TRUE;
				$config['remove_spaces'] = FALSE;
				$config['acl'] = 'public-read';
                $config['make_unique_filename'] = false;
			   //$config['encrypt_name'] = TRUE;
			   //$new_name = time().$_FILES["userfile"]['name'][$i];
		       //$config['file_name'] = $new_name;
				
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

		        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
		        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
		        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
		        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
		        $_FILES['userfile']['size']= $files['userfile']['size'][$i];   
		
		        $this->upload->initialize($config);
		       
		        $this->upload->do_upload_s3();
		        
		        
		        $file_name=$files['userfile']['name'][$i];
		        $token=$this->input->post('token');
		        $tname = str_replace(".mp3", "", $file_name);
		        $file_track = str_replace(" ", "+", $file_name);
		        $file_track2 = str_replace("amp;", "", $file_name);
		        $file_track3 = str_replace("&", "%26amp%3B", $file_track2);

		        $this->db->insert('track',array('name'=>$tname,'file'=>$file_name));

		        $dataimage[0] = $file_name;
		      
		        if($imsess == NULL){

		        	$this->session->set_userdata("trk",$dataimage);



		        } else {

		        	array_push($imsess, $file_name);
		             $this->session->set_userdata("trk",$imsess);
		        }
		      
		    }
		    
	}
	
	

	function deletez(){
		
		$token=$this->input->post('file');	
		$file_path = 'music/'.$token;
		
		$imsess = $this->session->userdata("trk");
		
		$icv = count($imsess);

		foreach($imsess as $rs => $key){

				   if ($token == $key){
				
						unset($imsess[$rs]);

						$this->session->unset_userdata('trk');
						$this->session->set_userdata("trk",$imsess);
					}
				}
					
		$query=$this->db->get_where('track',array('file'=>$token));
		if($query->num_rows()>0){
			$data=$query->row();
			
			   $this->amazon3integration_lib->delete_s3_object($file_path);
			}
		$this->db->delete('track',array('file'=>$token));
		echo json_encode(array('deleted'=>true));
		}


	function edit($item_id=0)
	{
		$this->check_access('edit');

		if ($this->input->server('REQUEST_METHOD')=='POST') {
			
			$datatrack = array(

				'name'   => $this->input->post('name'),
				'file'   => $this->input->post('url_track'),
				'style'  => $this->input->post('style_id'),
				'album'  => $this->input->post('album_id'),
				'artist' => $this->input->post('artist_id')

			);

			if ($this->track_model->save($datatrack,$item_id)) {
				$this->session->set_flashdata('success','track is successfully updated.');
				redirect('podcast');
			} else {
				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
			}
			redirect(site_url('podcast'));
		}

		$data['item'] = $this->track_model->get_info($item_id);

		$content['content'] = $this->load->view('podcast/edit',$data,true);
		$this->load->view('template',$content);
	}

	function search()
	{

        $search_term = array(
			"searchterm" =>$this->input->post('searchterm'),
			"artist_id"  =>$this->input->post('artist_id'),
			"style_id"   =>$this->input->post('style_id'),
			"album_id"   =>$this->input->post('album_id'),
			"isPublish"  =>$this->input->post('is_publish')
		);

		$data = $search_term;
        $pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('podcast/search');
		$pag['total_rows'] = $this->track_model->count_all_by($search_term);
		$data['items'] = $this->track_model->get_all_by($search_term,$pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('podcast/search',$data,true);
		$this->load->view('template',$content);
	}

	function publish($id = 0)
	{
		
		$item_data = array(
			'isPublish'=> 1
		);
			
		if ($this->track_model->save($item_data,$id)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	function unpublish($id = 0)
	{
		
		$item_data = array(
			'isPublish'=> 0
		);
			
		if ($this->track_model->save($item_data,$id)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	


}
?>