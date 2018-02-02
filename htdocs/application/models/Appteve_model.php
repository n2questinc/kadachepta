<?php
class Appteve_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}


	function get_empty_object($table_name)
	{
		$obj = new stdClass();

		$fields = $this->db->list_fields($table_name);
		foreach ($fields as $field) {
			$obj->$field = '';
		}
		return $obj;
	}

	public function get_now()
	{
		$query = $this->db->query('SELECT NOW( ) as now');

		return $query->row()->now;
	}
}
?>