<?php
class Podcast_model extends Appteve_Model
{

	protected $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = 'podcast';
	}


	function count_all()
	{
		$this->db->from($this->table_name);
		return $this->db->count_all_results();
	}

	function get_all($limit=false,$offset=false)
	{
		$this->db->from($this->table_name);

		if ($limit) {
			$this->db->limit($limit);
		}

		if ($offset) {
			$this->db->offset($offset);
		}

		return $this->db->get();
	}

	function save(&$data,$id=false)
	{
		if (!$id && !$this->exists(array('id'=>$id))) {
			if ($this->db->insert($this->table_name,$data)) {
				$data['id'] = $this->db->insert_id();
				return true;
			}
		} else {
			$this->db->where('id',$id);
			return $this->db->update($this->table_name,$data);
		}
		return false;
	}

	function save_track($data,$track)
	{

		$this->db->where('file',$track);
		$this->db->update($this->table_name,$data);

	}

	function exists($data)
	{
		$this->db->from($this->table_name);

		if (isset($data['id'])) {
			$this->db->where('id',$data['id']);
		}

		if (isset($data['title'])) {
			$this->db->where('title',$data['title']);
		}


		$query = $this->db->get();
		return ($query->num_rows()==1);
	}

	function delete($id)
	{
		$this->db->where('id',$id);
		return $this->db->delete($this->table_name);
	}

	function get_info($id)
	{
		$query = $this->db->get_where($this->table_name,array('id'=>$id));

		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}


}
?>