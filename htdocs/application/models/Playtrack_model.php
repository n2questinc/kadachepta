<?php
class Playtrack_model extends Appteve_Model
{

	protected $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = 'playtrack';
	}

	function add_playtrack(&$data,$id=false)
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
		$this->db->like('playlist_id',$data['playlist_id']);
		$this->db->like('track_id',$data['track_id']);
		$query = $this->db->get();
		return ($query->num_rows()==1);
	}

	function alltrack_by_plist($iddata=false)
	{

		$this->db->from($this->table_name);
		$this->db->where('playlist_id',$iddata);
		return $this->db->get();

	}

	function delete($track_id = false, $playlist_id = false)
	{

		$this->db->from($this->table_name);
		$this->db->where('track_id',$track_id);
		$this->db->where('playlist_id',$playlist_id);
		return $this->db->delete($this->table_name);

	}

	function delete_all_track($id_track = false)
	{

		$this->db->from($this->table_name);
		$this->db->where('track_id',$id_track);
		return $this->db->delete($this->table_name);

	}

	function delete_all_track_inpl($id_track = false)
	{

		$this->db->from($this->table_name);
		$this->db->where('playlist_id',$id_track);
		return $this->db->delete($this->table_name);

	}



}