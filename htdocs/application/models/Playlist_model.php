<?php
class Playlist_model extends Appteve_Model
{

	protected $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = 'playlist';
	}

	function save(&$data,$id=false){


		if ($this->db->insert($this->table_name,$data)) {
			return true;
		} else {
			$this->db->where('id',$id);
			return $this->db->update($this->table_name,$data);
		}

		return $false;
	}

	function exists($data)
	{
		$this->db->from($this->table_name);
		$this->db->like('id',$data['id']);
		
		$query = $this->db->get();
		return ($query->num_rows()==1);
	}

	function allplaylist_by_user($iduser=false){



		$this->db->from($this->table_name);
		$this->db->where('user_id',$iduser);
		return $this->db->get();


	}

	function delete_playlist($id = false){

		$this->db->from($this->table_name);
		$this->db->where('id',$id);
		return $this->db->delete($this->table_name);

	}
	
	function set_private(&$data, $id = false)
	{
		$this->db->from($this->table_name);
		$this->db->where('id',$id);
		return $this->db->update($this->table_name,$data);
		
		
	}
	
	function all_public()
	{
	
	    $public = "0";
		$this->db->from($this->table_name);
		$this->db->where('is_private', $public);
		$this->db->order_by('added','desc');
		return $this->db->get();
		
	}
	
}
?>