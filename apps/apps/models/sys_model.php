<?php

class Sys_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
//------------------------Function For mst_user------------------------------------------------//
	function check_login($name,$pass)
	{
	$this->db->where('username', $name); 
	$this->db->where('password', $pass); 
	$this->db->where('active', '1'); 
	$this->db->from('mst_user');
	return $this->db->count_all_results();
	}
	
	function set_online($username)
	{
		$data = array('is_online' => '1');
		$this->db->where('username', $username);
		$this->db->update('mst_user',$data); 
	}
	
	function set_offline($user_id)
	{
		$data = array('is_online' => '0');
		$this->db->where('username', $user_id);
		$this->db->update('mst_user',$data); 
	}
	
	function get_data_user($username)
	{
		$this->db->where('username', $username);
		return $this->db->get('mst_user',1,0)->row(); 
		
	}
	

	
	
//------------------------End Function For mst_user------------------------------------------------//

//------------------------Function For logs------------------------------------------------//	
	function logging($data)
	{
		$this->db->insert('mst_logs',$data);
	}

//------------------------Function function check modul------------------------------------------------//
	function check_modul($user_id,$modul_id)
	{
	$this->db->where('user_id', $user_id); 
	$this->db->where('modul_id', $modul_id); 
	$this->db->from('mst_user_assign_modul');
	return $this->db->count_all_results();
	}
	
	function security($modul_id = NULL)
	{
		if($this->session->userdata('username'))
		{	
			if($this->check_modul($this->get_data_user($this->session->userdata('user'))->user_id,$modul_id) >= '1')
			{	
				return true;
			}
			else
			{
				return false;
			}
		
		}
		else
		{
		return false;
		}
	}
	
	function get_modul()
	{
	$uid = $this->get_data_user($this->session->userdata('user'))->user_id;
	$sql = "SELECT
    mst_user_assign_modul.modul_id
    , mst_tools.modul_name
    , mst_tools.modul_description
    , mst_tools.modul_icon
    , mst_tools.modul_url
	FROM
    mst_tools.mst_user_assign_modul
    INNER JOIN mst_tools.mst_tools 
        ON (mst_user_assign_modul.modul_id = mst_tools.modul_id)
    INNER JOIN mst_tools.mst_user 
        ON (mst_user.user_id = mst_user_assign_modul.user_id)
	WHERE (mst_tools.modul_show =1 and mst_tools.parent_id = 70;
    AND mst_user_assign_modul.user_id = $uid)";
	return $this->db->query($sql)->result(); 
	}
	
	function get_conection_list()
	{
	$uid = $this->get_data_user($this->session->userdata('user'))->user_id;
	$sql = "SELECT 
	mst_database_connection.connection_id
	, mst_user_assign_database.user_id
    , mst_hospital.real_hospital_name
    , mst_database_connection.ip_address
    , mst_database_connection.database_name
	, mst_database_connection.database_type
	FROM
    mst_tools.mst_user_assign_database
    INNER JOIN mst_tools.mst_database_connection 
        ON (mst_user_assign_database.connection_id = mst_database_connection.connection_id)
    INNER JOIN mst_tools.mst_hospital 
        ON (mst_database_connection.hospital_id = mst_hospital.hospital_id)
	WHERE  mst_user_assign_database.user_id = $uid 
	";
	return $this->db->query($sql)->result(); 
	}
	
	function get_auth_db($conn_id)
	{	
		
		$this->db->where('connection_id', $conn_id);
		return $this->db->get('mst_database_connection',1,0)->row(); 
	}
	

	
}