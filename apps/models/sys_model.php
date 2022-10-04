<?php

class Sys_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->library('encrypt'); //load library for encrypt
    }
//------------------------Function For mst_user------------------------------------------------//
	function check_login($name,$pass)
	{
	$key = 'siloam';
	$encodesubmitedpass = $this->encrypt->encode($pass,$key); //encrypted data from user post password
	
	//Get current Password from database
	$encodepass = $this->get_salt_password($name);
	if($this->encrypt->decode($encodepass, $key) == $this->encrypt->decode($encodesubmitedpass, $key))
		{
			return TRUE;
		}
	else
		{
			$passmd5 = md5($pass); 
			$this->db->where('username', $name); 
			$this->db->where('oldpassword', $passmd5); 
			$this->db->where('active', '1'); 
			$this->db->from('mst_user');
			$record_count = $this->db->count_all_results();
				if($record_count > 0)
					{ //check the old password
					$data = array('password' => $encodesubmitedpass);
					$this->db->where('username', $name);
					$this->db->update('mst_user',$data); 
					return TRUE;
					}
				else
					{
					return FALSE;
					}				
		}
	
	
	$this->db->where('username', $name); 
	$this->db->where('password', $pass); 
	$this->db->where('active', '1'); 
	$this->db->from('mst_user');
	return $this->db->count_all_results();
	}
	
	function get_salt_password($name)
	{
	$this->db->where('username', $name); 
	$this->db->where('active', '1');
	$encodepass = $this->db->get('mst_user',1,0)->row()->password; 
	return $encodepass;
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
	
	function log_stat($data)
	{
		$this->db->insert('mst_statistics',$data);
	}

	function get_stat()
	{	
	$sql = "SELECT
    mst_statistics.modul_name
    , mst_statistics.sub_modul_name
    , mst_statistics.user_id
	,mst_statistics.username
    , mst_statistics.ip_add
	, mst_statistics.access_time
	FROM
    mst_tools.mst_statistics
	ORDER BY mst_statistics.user_id ASC";
	return $this->db->query($sql)->result(); 
	}
	
//------------------------Function function check modul------------------------------------------------//
	function check_modul($user_id,$modul_id)
	{
	$this->db->where('user_id', $user_id); 
	$this->db->where('modul_id', $modul_id); 
	$this->db->from('mst_user_assign_modul');
	return $this->db->count_all_results();
	}
        
    function check_sub_modul($con_url)
	{
    $sub_modul_id = $this->db->select('modul_id')->from('mst_tools')->where('modul_url =', $con_url);
	$this->db->where('modul_id', $sub_modul_id);        
	$this->db->from('mst_tools');
	return $this->db->row();
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
	
	function get_hospital_name($hospital_id)
	{	
		$this->db->select('real_hospital_name');
		$this->db->select('employee_payer_id');
		$this->db->where('hospital_id', $hospital_id);
		return $this->db->get('mst_hospital',1,0)->row(); 
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
    , mst_tools.modul_category_id
	FROM
    mst_tools.mst_user_assign_modul
    INNER JOIN mst_tools.mst_tools 
        ON (mst_user_assign_modul.modul_id = mst_tools.modul_id)
    INNER JOIN mst_tools.mst_user 
        ON (mst_user.user_id = mst_user_assign_modul.user_id)
	WHERE (mst_tools.modul_show =1 and parent_id = 0
    AND mst_user_assign_modul.user_id = $uid)
	ORDER BY mst_tools.modul_name ASC";
	return $this->db->query($sql)->result(); 
	}
	
		function get_sub_modul()
	{
	$uid = $this->get_data_user($this->session->userdata('user'))->user_id;
	$sql = "SELECT
    mst_user_assign_modul.modul_id
    , mst_tools.modul_name
    , mst_tools.modul_description
    , mst_tools.modul_icon
    , mst_tools.modul_url
    , mst_tools.modul_category_id
	FROM
    mst_tools.mst_user_assign_modul
    INNER JOIN mst_tools.mst_tools 
        ON (mst_user_assign_modul.modul_id = mst_tools.modul_id)
    INNER JOIN mst_tools.mst_user 
        ON (mst_user.user_id = mst_user_assign_modul.user_id)
	WHERE (mst_tools.modul_show =1 and parent_id = 70
    AND mst_user_assign_modul.user_id = $uid)
	ORDER BY mst_tools.modul_name ASC";
	return $this->db->query($sql)->result(); 
	}

	function get_sub_modul1()
	{
	$uid = $this->get_data_user($this->session->userdata('user'))->user_id;
	$sql = "SELECT
    mst_user_assign_modul.modul_id
    , mst_tools.modul_name
    , mst_tools.modul_description
    , mst_tools.modul_icon
    , mst_tools.modul_url
    , mst_tools.modul_category_id
	FROM
    mst_tools.mst_user_assign_modul
    INNER JOIN mst_tools.mst_tools 
        ON (mst_user_assign_modul.modul_id = mst_tools.modul_id)
    INNER JOIN mst_tools.mst_user 
        ON (mst_user.user_id = mst_user_assign_modul.user_id)
	WHERE (mst_tools.modul_show =1 and parent_id = 71
    AND mst_user_assign_modul.user_id = $uid)
	ORDER BY mst_tools.modul_name ASC";
	return $this->db->query($sql)->result(); 
	}

	function get_sub_modul2()
	{
	$uid = $this->get_data_user($this->session->userdata('user'))->user_id;
	$sql = "SELECT
    mst_user_assign_modul.modul_id
    , mst_tools.modul_name
    , mst_tools.modul_description
    , mst_tools.modul_icon
    , mst_tools.modul_url
    , mst_tools.modul_category_id
	FROM
    mst_tools.mst_user_assign_modul
    INNER JOIN mst_tools.mst_tools 
        ON (mst_user_assign_modul.modul_id = mst_tools.modul_id)
    INNER JOIN mst_tools.mst_user 
        ON (mst_user.user_id = mst_user_assign_modul.user_id)
	WHERE (mst_tools.modul_show =1 and parent_id = 72
    AND mst_user_assign_modul.user_id = $uid)
	ORDER BY mst_tools.modul_name ASC";
	return $this->db->query($sql)->result(); 
	}

    
    function get_sort_modul()
	{
	$uid = $this->get_data_user($this->session->userdata('user'))->user_id;
	$sql = "SELECT
    mst_user_assign_modul.modul_id
    , mst_tools.modul_name
    , mst_tools.modul_description
    , mst_tools.modul_icon
    , mst_tools.modul_url
    , mst_tools.modul_category_id
	FROM
    mst_tools.mst_user_assign_modul
    INNER JOIN mst_tools.mst_tools 
        ON (mst_user_assign_modul.modul_id = mst_tools.modul_id)
    INNER JOIN mst_tools.mst_user 
        ON (mst_user.user_id = mst_user_assign_modul.user_id)
	WHERE (mst_tools.modul_show =1
    AND mst_user_assign_modul.user_id = $uid)";
	return $this->db->query($sql)->result(); 
	}
	
	function get_cat_id()
	{
	$uid = $this->get_data_user($this->session->userdata('user'))->user_id;
	$sql = "SELECT
    mst_tools_category.category_id
    , mst_tools_category.category_name
    , mst_tools_category.category_details
	FROM
    mst_tools.mst_tools_category";
	return $this->db->query($sql)->result(); 
	}
	
	function get_conection_list()
	{
	$uid = $this->get_data_user($this->session->userdata('user'))->user_id;
	$sql = "SELECT 
	mst_database_connection.connection_id
	, mst_user_assign_database.user_id
    , mst_hospital.real_hospital_name
	, mst_database_connection.hospital_id
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
	return $this->db->query($sql); 
	}
	
	function get_conection_number()
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
	return $this->db->query($sql)->num_rows(); 
	}
	
	function get_auth_db($conn_id)
	{	
		
		$this->db->where('connection_id', $conn_id);
		return $this->db->get('mst_database_connection',1,0)->row(); 
	}
	
	function get_current_password($user_id)
	{
		$this->db->select('password');
		$this->db->where('user_id', $user_id);
		return $this->db->get('mst_user',1,0)->row(); 
	}
	
	function get_user_role($username)
	{
	$config['hostname'] = $this->session->userdata('db_host');
	$config['username'] = $this->session->userdata('db_user');
    $config['password'] = $this->session->userdata('db_password');
    $config['database'] = $this->session->userdata('db_name');
	$config['dbdriver'] = "sqlsrv";
    $config['dbprefix'] = "";
    $config['pconnect'] = FALSE;
    $config['db_debug'] = TRUE;
	$config['cache_on'] = FALSE;
    $config['cachedir'] = "";
    $config['char_set'] = "utf8";
    $config['dbcollat'] = "utf8_general_ci";
	$conn =	$this->load->database($config,true);
	$sql = "SELECT DescValue as Roles FROM SysRoles WHERE RoleId = (SELECT TOP 1 RoleId FROM SysMemberships WHERE UserId = '".$username."')";
	$query =  $conn->query($sql);
	return $query->row();
	}
	
	function get_email_for_alert($alert_modul,$hospital_id)
	{
		$this->db->where('alert_modul', $alert_modul);
		$this->db->where('hospital_id', $hospital_id);
		return $this->db->get('mst_system_alert',1,0)->row(); 
	}
	

	
}