<?php
class Track_model extends Appteve_Model
{

	protected $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = 'track';
	}

	function save_track($data,$track)
	{

		$this->db->where('file',$track);
		return $this->db->update($this->table_name,$data);

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
	
	function gettrend_all($limit=false,$offset=false)
	{
		$this->db->from($this->table_name);

		if ($limit) {
			
			$this->db->limit($limit);
		}

		if ($offset) {
			$this->db->offset($offset);
		}

		$this->db->where('isPublish',1);
		$this->db->order_by('plays','desc');
		
		return $this->db->get();
	}
	
	function getby_trackid($data)
	{

		$this->db->from($this->table_name);
		$this->db->like('id',$data['id']);
		return $result =  $this->db->get();
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

	function delete($id)
	{
		$this->db->where('id',$id);
		return $this->db->delete($this->table_name);
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

	function count_all_by($conditions=array())
	{
		$this->db->from($this->table_name);

		if (isset($conditions['style_id'])) {
			$this->db->where('style',$conditions['style_id']);
		}
		if (isset($conditions['album_id'])) {
			$this->db->where('album',$conditions['album_id']);
		}
		if (isset($conditions['artist_id'])) {
			$this->db->where('artist',$conditions['artist_id']);
		}
		if (isset($conditions['isPublish'])) {
			$this->db->where('isPublish',$conditions['isPublish']);
		}

		if (isset($conditions['searchterm']) && trim($conditions['searchterm']) != "") {
			$this->db->where("( name LIKE '%".$conditions['searchterm']."%')", NULL, FALSE);
		}
		
		$this->db->where('isPublish',1);
		$this->db->order_by('added','desc');

		return $this->db->count_all_results();
	}

	function get_all_by($conditions=array(),$limit=false,$offset=false)
	{
		$this->db->from($this->table_name);

		if (isset($conditions['artist_id'])) {
			$this->db->where('artist',$conditions['artist_id']);
		}
		if (isset($conditions['album_id'])) {
			$this->db->where('album',$conditions['album_id']);
		}
		if (isset($conditions['style_id'])) {
			$this->db->where('style',$conditions['style_id']);
		}
		if (isset($conditions['isPublish'])) {
			$this->db->where('isPublish',$conditions['isPublish']);
		}

		if (isset($conditions['searchterm']) && trim($conditions['searchterm']) != "") {
			$this->db->where("(name LIKE '%".$conditions['searchterm']."%')", NULL, FALSE);
		}


		if ($limit) {
			$this->db->limit($limit);
		}

		if ($offset) {
			$this->db->offset($offset);
		}
		$this->db->where('isPublish',1);
		

		$this->db->order_by('added','desc');
		return $this->db->get();
	}

	function get_by_style($style_id=false){

		$this->db->from($this->table_name);
		$this->db->where('style',$style_id);
		$this->db->where('isPublish',1);
		$this->db->order_by('added','desc');
		return $this->db->get();

	}

	function get_by_idtrack($id=false){

		$this->db->from($this->table_name);
		$this->db->where('id',$id);
		$this->db->where('isPublish',1);
		return $this->db->get();
	}

	function getapi_all_by($conditions=array(),$limit=false,$offset=false)
	{
		$this->db->from($this->table_name);

		if (isset($conditions['artist_id'])) {
			$this->db->where('artist',$conditions['artist_id']);
			
		}
		if (isset($conditions['album_id'])) {
			$this->db->where('album',$conditions['album_id']);
		}
		if (isset($conditions['style_id'])) {
			$this->db->where('style',$conditions['style_id']);
		}
		if (isset($conditions['isPublish'])) {
			$this->db->where('isPublish',$conditions['isPublish']);
		}

		if (isset($conditions['searchterm']) && trim($conditions['searchterm']) != "") {
			$this->db->where("(name LIKE '%".$conditions['searchterm']."%')", NULL, FALSE);
		}

		if ($limit) {
			$this->db->limit($limit);
		}

		if ($offset) {
			$this->db->offset($offset);
		}
		$this->db->where('isPublish',1);

		$this->db->order_by('added','desc');
		return $this->db->get();
	}
	
	function plustrend($data, $id=false)
	{

		$this->db->where('id',$id);
		return $this->db->update($this->table_name,$data);

	}



	







}