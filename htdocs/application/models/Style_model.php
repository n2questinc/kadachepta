<?php
class Style_model extends Appteve_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table_name = 'style';
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

		$this->db->order_by('added','desc');
		return $this->db->get();
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

	function exists($data)
	{
		$this->db->from($this->table_name);

		if (isset($data['id'])) {
			$this->db->where('id',$data['id']);
		}

		if (isset($data['name'])) {
			$this->db->where('name',$data['name']);
		}

		$query = $this->db->get();
		return ($query->num_rows()==1);
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


	function delete($id)
	{
		$this->db->where('id',$id);
		return $this->db->delete($this->table_name);
	}

	function count_all_by($conditions=array())
	{
		$this->db->from($this->table_name);

		if (isset($conditions['searchterm'])) {
			$this->db->like('name',$conditions['searchterm']);
		}


		return $this->db->count_all_results();
	}

	function get_all_by($conditions=array(),$limit=false,$offset=false)
	{
		$this->db->from($this->table_name);

		if (isset($conditions['searchterm'])) {
			$this->db->like('name',$conditions['searchterm']);
		}


		if ($limit) {
			$this->db->limit($limit);
		}

		if ($offset) {
			$this->db->offset($offset);
		}

		$this->db->order_by('added','desc');
		return $this->db->get();
	}


}