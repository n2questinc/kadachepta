<?php
class Artist_model extends Appteve_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table_name = 'artist';
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

	function save_artist(&$data, $name)
	{
		if (!$this->exists_name(array('name'=>$name))) {
			if ($this->db->insert($this->table_name,$data)) {
				$wart = $this->db->insert_id();
				return $wart;
			}
		} else {

			$this->db->from($this->table_name);
			$this->db->where('name',$name);
			
			$query = $this->db->get();
			if($query->num_rows() > 0) {
			     $ids =  $query->result();
			     return $ids[0]->id;
			}


		}
		return false;
	}

	function exists_name($data)
	{
		$this->db->from($this->table_name);

		if (isset($data['name'])) {
			$this->db->where('name',$data['name']);
		}

		if (isset($data['name'])) {
			$this->db->where('name',$data['name']);
		}

		$query = $this->db->get();
		return ($query->num_rows()==1);
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