<?php
class User extends Appteve_Model
{
	protected $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = "users";
	}

	function exists($user_data)
	{
		$this->db->from($this->table_name);

		if (isset($user_data['user_id'])) {
			$this->db->where('user_id',$user_data['user_id']);
		}

		if (isset($user_data['user_name'])) {
			$this->db->where('user_name',$user_data['user_name']);
		}

		$query = $this->db->get();
		return ($query->num_rows()==1);
	}


	function save(&$user_data, $permission_data, $user_id=false)
	{
		$this->db->trans_start();
		$success = false;
		if (!$user_id && !$this->exists(array('user_id'=>$user_id))) {
			if ($this->db->insert($this->table_name,$user_data)) {
				$user_data['user_id']= $user_id = $this->db->insert_id();
				$success = true;
			}
		} else {
			$this->db->where('user_id',$user_id);
			$success = $this->db->update($this->table_name,$user_data);
		}

		if ($success) {
			$success = $this->db->delete('permissions',array('user_id'=>$user_id));

			if ($success) {
				foreach ($permission_data as $module) {
					$success = $this->db->insert('permissions',
						array(
							'module_id'=>$module,
							'user_id'=>$user_id));
				}
			}
		}
		$this->db->trans_complete();
		return $success;
	}

	function update_profile($user_data, $user_id)
	{
		$this->db->where('user_id',$user_id);
		$success = $this->db->update($this->table_name,$user_data);

		return $success;
	}


	function get_all($limit=false, $offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('status',1);

		if ($limit) {
			$this->db->limit($limit);
		}

		if ($offset) {
			$this->db->offset($offset);
		}

		$this->db->order_by('added','desc');
		return $this->db->get();
	}


	function get_info($user_id)
	{
		$query = $this->db->get_where($this->table_name,array('user_id'=>$user_id));

		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}


	function get_multiple_info($user_ids)
	{
		$this->db->from($this->table_name);
		$this->db->where_in($user_ids);
		return $this->db->get();
	}


	function get_info_by_email($email)
	{
		$query = $this->db->get_where($this->table_name,array('user_email'=>$email));

		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}


	function count_all()
	{
		$this->db->from($this->table_name);
		$this->db->where('status',1);
		return $this->db->count_all_results();
	}

	function count_all_by($conditions=array())
	{
		$this->db->from($this->table_name);

		if (isset($conditions['searchterm'])) {
			$this->db->like('user_name',$conditions['searchterm']);
		}

		$this->db->where('status',1);
		return $this->db->count_all_results();
	}

	function get_all_by($conditions=array(), $limit=false, $offset=false)
	{
		$this->db->from($this->table_name);

		if (isset($conditions['searchterm'])) {
			$this->db->like('user_name',$conditions['searchterm']);
		}

		$this->db->where('status',1);
		if ($limit) {
			$this->db->limit($limit);
		}

		if ($offset) {
			$this->db->offset($offset);
		}

		$this->db->order_by('added','desc');
		return $this->db->get();
	}


	function delete($user_id)
	{
		$success = false;

		if ($user_id==$this->get_logged_in_user_info()->user_id) {
			return false;
		}

		if ($this->db->delete('permissions',array('user_id'=>$user_id))) {
			$this->db->where('user_id',$user_id);
			$success = $this->db->update($this->table_name,array('deleted'=>1));
		}

		$this->db->where('user_id',$user_id);
		$success = $this->db->update($this->table_name,array('status'=>0));

		return $success;
	}


	function delete_list($user_ids)
	{
		$success = false;

		if (in_array($this->get_logged_in_user_info()->user_id,$user_ids)) {
			return false;
		}

		$this->db->where_in('user_id',$user_ids);
		if ($this->db->delete('permissions')) {
			$this->db->where_in('user_id',$user_ids);
			$success = $this->db->update($this->table_name,array('status'=>0));
		}
		return $success;
	}


	function login($user_name, $user_pass)
	{
		$query = $this->db->get_where($this->table_name,array('user_name'=>$user_name,'user_pass'=>md5($user_pass),'status'=>1),1);
		if ($query->num_rows()==1) {
			$row = $query->row();
			$this->session->set_userdata('user_id',$row->user_id);
			return true;
		}
		return false;
	}


	function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url('login'));
	}


	function is_logged_in()
	{
		return $this->session->userdata('user_id')!=false;
	}


	function get_logged_in_user_info()
	{
		if ($this->is_logged_in()) {
			return $this->get_info($this->session->userdata('user_id'));
		}
		return false;
	}


	function has_permission($module_id, $user_id)
	{
		if ($module_id==null) {
			return true;
		}
		$this->db->from('permissions');
		$this->db->where('user_id',$user_id);
		$this->db->join('modules','modules.module_id=permissions.module_id');
		$this->db->where('modules.module_name',$module_id);
		$query = $this->db->get();

		return $query->num_rows() ==1;
	}


	function has_access($action_id, $role_id)
	{
		if ($action_id == null) {
			return true;
		}

		$this->db->from('role_access');
		$this->db->where('role_id',$role_id);
		$this->db->where('action_id',$action_id);
		$query = $this->db->get();

		return $query->num_rows() == 1;
	}
}
?>