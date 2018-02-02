<?php
class Usertrack_model extends Appteve_Model
{

	protected $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = 'user_track';
	}

	function save(&$data,$id=false)
	{
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
		$this->db->like('user_id',$data['user_id']);
		$this->db->like('track_id',$data['track_id']);
		$query = $this->db->get();
		return ($query->num_rows()==1);
	}

	function alltrack_by_user($iduser=false){

		$this->db->from($this->table_name);
		$this->db->where('user_id',$iduser);
		return $this->db->get();


	}

	function delete_track($id_user = false, $id_track = false){

		$this->db->from($this->table_name);

		$this->db->where('track_id',$id_track);
		$this->db->where('user_id',$id_user);
		return $this->db->delete($this->table_name);


	}

	function delete_all_track($id_track = false)
	{

		$this->db->from($this->table_name);
		$this->db->where('track_id',$id_track);
		return $this->db->delete($this->table_name);

	}



}