<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Sysmex_interfacing extends CI_Model{
 	
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
	
	function lookup_all_doctor($doctorcode = NULL)
	{	
		if($doctorcode != NULL)
		{
		$where = " AND a.CodeValue = '$doctorcode'";
		}
		else
		{
		$where = '';
		}
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "SELECT a.CodeValue, b.TitleBeforeName+' '+b.FirstName+' '+b.LastName+' '+TitleAfterName AS DoctorName,
				e.Id AS SpecialistId,
				e.NameValue AS SpecialistName,
				d.Id AS SubSpecialistId,
				d.NameValue AS SubSpecialistName
				FROM dbo.Doctors a
				LEFT JOIN dbo.Employees b ON B.Id = a.EmployeeId 
				LEFT JOIN dbo.DoctorSpecRels c ON a.Id = c.DoctorId
				LEFT JOIN dbo.RefSubSpecialist d ON d.Id = c.SubSpecialistId 
				LEFT JOIN dbo.RefSpecialist e ON e.Id = d.SpecialistId
				WHERE a.RecordStatus = 1 $where 
				";
		$query = $conn->query($sql);
        return $query;
	}
	
	function lookup_sysmex_doctor($doctorcode = NULL) // from table InfSysmex_Doctor
	{
	if($doctorcode != NULL)
		{
		$where = " WHERE Code = '$doctorcode'";
		}
		else
		{
		$where = '';
		}
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "SELECT 	Code,Name,SpecialistId ,
		SpecialistName ,SubSpecialistId ,
		SubSpecialistName ,ItemServiceRootId ,
		ItemServiceRootCode ,ItemServiceRootName ,
		ItemServiceGSSubCategoryId ,ItemServiceGSSubCategoryName
		FROM dbo.InfSysmex_Doctor $where";
		$query = $conn->query($sql);
        return $query;
	}
	
	function lookup_item_services($itemservice_code = NULL )
	{
		if($itemservice_code != NULL)
		{
		$where = " AND a.CodeValue = '$itemservice_code'";
		}
		else
		{
		$where = '';
		}
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "SELECT a.*,b.Id AS GsSubId,b.NameValue AS GsSubName,b.CodeValue AS GsSubCodeValue FROM dbo.ItemServices a LEFT JOIN dbo.GSSubCategories b ON b.id = a.GSSubCategoryId
				WHERE a.RecordStatus = 1 AND (a.ParentId = 0 OR a.ParentId IS NULL) AND b.CodeValue IN('RAD','LAB')  $where";
		$query = $conn->query($sql);
        return $query;
	}
	
	function add_sysmex_doctor($data)
	{
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
	// retrieve first.
	$doctor = $this->lookup_all_doctor($data['doctor_id'])->row();
	$service = $this->lookup_item_services($data['service_id'])->row();
	// ------------insert to table -----------/
	$doctor_lab = array(
		'Code' => $doctor->CodeValue ,
		'Name' => $doctor->DoctorName,
		'SpecialistId' => $doctor->SpecialistId,
		'SpecialistName' => $doctor->SpecialistName,
		'SubSpecialistId' => $doctor->SubSpecialistId,
		'SubSpecialistName' => $doctor->SubSpecialistName,
		'ItemServiceRootId' => $service->Id ,
		'ItemServiceRootCode' => $service->CodeValue ,
		'ItemServiceRootName' => $service->NameValue ,
		'ItemServiceGSSubCategoryId' => $service->GsSubId ,
		'ItemServiceGSSubCategoryName' => $service->GsSubName ,
		'IsActive' => TRUE,
		'IsDeleted' => FALSE,
		'CreatedBy' => $this->session->userdata('HISUser'),
		'CreatedDate' => date('m/d/Y h:i:s a', time()),
		'CreatedFrom' => $this->input->ip_address()	
				);
	
	$conn->insert('dbo.InfSysmex_Doctor',$doctor_lab);
	// ------------insert to syslog ----------/
	$log = array(
				'CurrentValue' => json_encode($doctor_lab),
				'TableName' =>'InfSysmex_Doctor',
				'RecordId' => 0,
				'UserId' => $this->session->userdata('HISUser'),
				'BeforeValue'=> NULL,
				'EventType'=>'A'
				);
	$conn->insert('SysLogs',$log);
	
	}
	
	function update_sysmex_doctor($data,$id)
	{	$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
	$BeforeValue = json_encode($conn->get_where('InfSysmex_Doctor',array('Id'=>$id))->row());
	// ------------Update to table --------------/
	$conn->where('Id', $id);
	$conn->update('InfSysmex_Doctor', $data); 
	// ------------insert to syslog ----------/
	$log = array(
				'CurrentValue' => json_encode($data),
				'TableName' =>'InfSysmex_Doctor',
				'RecordId' => 0,
				'UserId' => $this->session->userdata('HISUser'),
				'BeforeValue'=> $BeforeValue,
				'EventType'=>'A'
				);
	$conn->insert('SysLogs',$log);
	}

	function get_lab_transaction($startdate,$enddate)
	{
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "SELECT a.*,b.OrderDate FROM dbo.InfSysmexOrderDetails a INNER JOIN dbo.MRLabOrders b ON  b.id= a.OrderID WHERE convert(date,b.OrderDate) between '".$startdate."' AND '".$enddate."'";
		$query = $conn->query($sql);
        return $query->result();
		
	}
	
	function get_lab_transaction_detail($trans_id)
	{
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "SELECT a.*,b.OrderDate FROM dbo.InfSysmexOrderDetails a INNER JOIN dbo.MRLabOrders b ON  b.id= a.OrderID WHERE InfSysmexOrderDetailsId = $trans_id";
		$query = $conn->query($sql);
        return $query->row();
		
	}
	
	function overide_doctor_transaction($doctor_code,$transId)
	{
		$user = $this->session->userdata('HISUser');
		if($this->session->userdata('HISUser')==NULL)
		{$user = 'supporting_tools';}
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
		$BeforeValue = json_encode($conn->get_where('InfSysmexOrderDetails',array('InfSysmexOrderDetailsId'=>$transId))->row());
		$doctor = $this->lookup_sysmex_doctor($doctor_code)->row();
	$data = array(
		'InfHIS_DoctorLabCode' => $doctor->Code,
		'InfHIS_DoctorLabName' => $doctor->Name,
		'InfHIS_DoctorLabCreatedBy' => $this->session->userdata('HISUser').' '.$this->session->userdata('user'),
		'InfHIS_DoctorLabCreatedDate' => date('m/d/Y h:i:s a', time()),
		'InfHIS_DoctorLabCreatedFrom' => $this->input->ip_address()	
				);
	// ------------Update to table --------------/
	$conn->where('InfSysmexOrderDetailsId', $transId);
	$conn->update('InfSysmexOrderDetails', $data); 
	// ------------insert to syslog ----------/	
	$log = array(
				'CurrentValue' => json_encode($conn->get_where('InfSysmexOrderDetails',array('InfSysmexOrderDetailsId'=>$transId))->row()),
				'TableName' =>'InfSysmexOrderDetails',
				'RecordId' => 0,
				'UserId' => $this->session->userdata('HISUser'),
				'BeforeValue'=> $BeforeValue,
				'EventType'=>'A'
				);
	$conn->insert('SysLogs',$log);
	}
}