<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Emr_model extends CI_Model{
 	
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
	
    function get_emr($payer_id,$startdate,$enddate)
    {
        $this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "
		SELECT * FROM fn_getpatientreg($payer_id) WHERE CONVERT(date,RegistrationTime) BETWEEN '".$startdate."' AND  '".$enddate."' order by PatientRegsId";
        $query = $conn->query($sql);
        return $query->result();
    }
	
	function get_unique_patient($payer_id)
	{
        $this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "SELECT DISTINCT MedicalRecordNumber, PatientName, Birthdate, Birthplace, Age, AgeDetail, IdentityType, IdentityCardbNumber, Gender, BloodType, Weight, Height, Address, PhoneNumber, Fax, Area, City, Province, Country, Religion, Marital, Occupation, Education, PayerInstitution, PayerCategory, CreatedByOn,Ethnic,Email,Address2,PhoneNumber2 FROM fn_getpatientreg($payer_id) order by MedicalRecordNumber";
        $query = $conn->query($sql);
        return $query->result();
	}
	
	function get_unique_patient_reg($payer_id,$startdate,$enddate)
	{
        $this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "
		SELECT DISTINCT 
		RegistrationTime,RegistrationCode,MedicalRecordNumber,PatientName,PatientsDescription,PatientsCategory,Birthdate,Birthplace,Age,IdentityType,IdentityCardbNumber,Gender,BloodType,Address,PhoneNumber,Area,City,Province,Country,
		Religion,Marital,Ethnic,Education,Occupation,PayerInstitution,PayerCategory,LOB,RegisteredBy,Email,Address2,PhoneNumber2
		FROM fn_getpatientreg($payer_id) WHERE CONVERT(date,RegistrationTime) BETWEEN '".$startdate."' AND  '".$enddate."' ORDER By RegistrationTime";
        $query = $conn->query($sql);
        return $query->result();
	}
	
	function get_discharge_patient($payer_id,$startdate,$enddate)
	{
		 $this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "
		SELECT  DISTINCT MedicalRecordNumber,RegistrationCode,PatientName ,Classes ,RegistrationTime ,
		ToDate ,CloseDate ,LOB ,PatientsDescription ,PatientsCategory ,Birthdate ,Age,Birthplace ,
		IdentityType ,IdentityCardbNumber ,Gender ,BloodType ,Address ,PhoneNumber ,Fax ,Area ,City ,		Province ,		Country ,
		AddressType ,Email ,Weight ,Height ,CreatedByOn ,Ethnic ,Religion ,Marital ,Occupation ,Education ,ModifiedBy ,ModifiedOn ,
		PayerInstitution ,PayerCategory ,TotalGSC
		FROM dbo.fn_getpatientreg($payer_id) WHERE CloseDate IS NOT NULL AND CONVERT(date,CloseDate) BETWEEN '".$startdate."' AND  '".$enddate."' ORDER By RegistrationTime";
		$query = $conn->query($sql);
        return $query->result();
	}
    
   	

}