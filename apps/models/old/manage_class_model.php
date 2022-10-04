<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Manage_class_model extends CI_Model{
 	
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
	
	function lookup_patient_class()
	{	
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "SELECT a.id,a.NameValue AS Class,c.CodeValue FROM dbo.PriceListClasses a INNER JOIN dbo.HuLobRels b ON b.Id = a.HuLobRelId
				LEFT JOIN dbo.RefLobs c ON c.id = b.LineOffBusinessUnitID WHERE c.CodeValue = 'IPD' AND a.RecordStatus = 1";
		$query = $conn->query($sql)->result();
        return $query;
	}
	
	function overide_price_classes($regid)
	{
		$user = $this->session->userdata('HISUser');
		if($this->session->userdata('HISUser')==NULL)
		{$user = ' supporting_tools ';}
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
		$BeforeValue = json_encode($conn->get_where('sp_changeclass',array('a.RegId'=>$regid))->row());
		$patient = $this->lookup_patient_class($regid)->row();
		$data = array(
		'a.RegId' => $patient->regid,
		'a.PricelistClassId' => $patient->PricelistClassId,
		'c.PriceListClassId' => $patient->PricelistClassId,
				);
	// ------------Update to table --------------/
	$conn->where('a.RegId', $regid);
	$conn->update('sp_changeclass', $data); 
	}
	
	function get_unclosed_patient($keyword=NULL)
	{
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = " SELECT TOP 50 * FROM (
SELECT DISTINCT a.RegId,c.CodeValue AS 'RegCode',d.MedicalRecordNumber,d.FirstName+' '+d.MiddleName+' '+d.LastName AS PatientName,a.PricelistClassId,b.NameValue AS 'PricelistClass',f.NameValue AS 'LOB'
 FROM dbo.GSCDetails a 
 LEFT JOIN dbo.PriceListClasses b ON b.id = a.PricelistClassId
 LEFT JOIN dbo.PatientRegs c ON c.id = a.RegId
 LEFT JOIN dbo.Patients d ON d.id = c.PatientId
 LEFT JOIN dbo.HuLobRels e ON e.id = c.HuLobRelId
 LEFT JOIN dbo.RefLobs f ON f.id = e.LineOffBusinessUnitID
 WHERE c.RecordStatus = 1 AND a.PricelistClassId IS NOT NULL) a WHERE a.LOB = 'IPD' AND (a.PatientName LIKE '%".$keyword."%' OR a.MedicalRecordNumber LIKE '%".$keyword."%' OR a.RegCode LIKE '%".$keyword."%')";
		$query = $conn->query($sql);
        return $query->result();
		
	}
	
}