<?php

class Medical_record extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function set_db()
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
	return $config;
	}

	
//---------------------------------------------------- Medical Record Data Raw -------------------------------------------
	function retrieve_patient_info($hospital_payer)
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT * FROM fn_getpatientreg($hospital_payer)";
	$query =  $conn->query($sql);
	}




	
}