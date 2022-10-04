<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Radiology_report_model extends CI_Model{
 	
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
	
	function get_radiology_throughput_dashboard($param)
	{	
		$startdate = element('startdate',$param);
		$enddate = element('enddate',$param);
		$doctor_code = element('doctor_code',$param);
		$order_type = element('order_type',$param);
		$custom_where = '';
		if($doctor_code != 'all')
		{
		$custom_where = " AND PhysicianPerformingCode like '%".$doctor_code."%' ";
		}
		if($order_type != 'all')
			{
			$custom_where = $custom_where."AND OrderType = '".$order_type."' ";
			}
		
		$this->set_db();
		$pivot_column = $this->get_radiology_service_group($startdate,$enddate);
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "SELECT * FROM ( 
				SELECT CONVERT(DATE,OrderDate) AS OrderDate ,
				ItemServiceParent.NameValue AS ServiceGroup
				  FROM dbo.InfPacs 
				OUTER APPLY (SELECT b.NameValue FROM dbo.ItemServices a INNER JOIN dbo.GSSubCategories b ON b.id = a.GSSubCategoryId WHERE a.id  = (SELECT TOP 1  ParentId FROM dbo.ItemServices WHERE CodeValue = ItemServiceCode)) as ItemServiceParent 
				WHERE OrderStatus != 'CANCELED' AND (CONVERT(DATE,OrderDate) BETWEEN '".$startdate."' AND '".$enddate."'".$custom_where."				
				)) a 
				pivot (COUNT(a.ServiceGroup) for a.ServiceGroup IN(".$pivot_column.")) AS pvt
			  ";
		$query = $conn->query($sql);
        return $query->result();
	}
	
	function get_radiology_service_group($startdate,$enddate)
	{
		$conn =	$this->load->database($this->set_db(),true);
		$this->set_db();
		$sql = "
		DECLARE @cols AS NVARCHAR(MAX); 
		select @cols = STUFF((SELECT DISTINCT ',' + QUOTENAME(ServiceGroup)  FROM (SELECT CONVERT(DATE,OrderDate) AS OrderDate,ItemServiceParent.NameValue AS ServiceGroup	FROM dbo.InfPacs 
		OUTER APPLY (SELECT b.NameValue FROM dbo.ItemServices a INNER JOIN dbo.GSSubCategories b ON b.id = a.GSSubCategoryId WHERE a.id  = (SELECT TOP 1  ParentId FROM dbo.ItemServices WHERE CodeValue = ItemServiceCode)) as ItemServiceParent 
		WHERE ItemServiceParent.NameValue != '' AND OrderStatus != 'CANCELED' ) a
				   FOR XML PATH(''), TYPE
				   ).value('.', 'NVARCHAR(MAX)') 
			   ,1,1,'') 
		SELECT @cols AS ColumnName
		";
		$query = $conn->query($sql);
        return $query->row()->ColumnName;
	}
	
	function get_service_group($startdate,$enddate)
	{
		$conn =	$this->load->database($this->set_db(),true);
		$this->set_db();
		$sql = "
		SELECT DISTINCT ServiceGroup FROM (
		SELECT CONVERT(DATE,OrderDate) AS OrderDate ,
		ItemServiceParent.NameValue AS ServiceGroup	
		FROM	dbo.InfPacs
		OUTER APPLY (SELECT b.NameValue FROM dbo.ItemServices a INNER JOIN dbo.GSSubCategories b ON b.id = a.GSSubCategoryId WHERE a.id  = (SELECT TOP 1  ParentId FROM dbo.ItemServices WHERE CodeValue = ItemServiceCode)) as ItemServiceParent
		WHERE ItemServiceParent.NameValue != '' AND OrderStatus != 'CANCELED' AND (CONVERT(DATE,OrderDate) BETWEEN '".$startdate."' AND '".$enddate."')) a
		";
		$query = $conn->query($sql);
		return $query->result();
	
	}

	function get_radiology_manual($startdate,$enddate,$regcode)
	{
		$conn =	$this->load->database($this->set_db(),true);
		$this->set_db();
		$sql = "
		SELECT OrderDate, e.CodeValue AS RegCode, MedicalRecordNumber, f.FirstName +' '+f.MiddleName+' '+f.LastName AS PatientName, g.NameValue AS Gender, Birthdate, h.CodeValue AS ServiceCode, d.NameValue AS ServiceName, c.Id AS QueueStatesId, CASE WHEN c.OrderStatus = 0 THEN 'Not Ordered' ELSE 'Ordered' END AS StatusOrder FROM dbo.MRRadiologies a
		INNER JOIN dbo.MRRadiologieDetails b ON a.Id = b.MRRadiologyId
		INNER JOIN dbo.RadiologyOrderQueueStates c ON b.Id = c.RadOrderDetailId
		INNER JOIN dbo.GSCDetails d ON d.Id = b.GSCDetailId
		INNER JOIN dbo.PatientRegs e ON e.Id = d.RegId
		INNER JOIN dbo.Patients f ON f.Id = e.PatientId
		INNER JOIN dbo.RefGenders g ON g.Id = f.GenderId
		LEFT JOIN dbo.ItemServices h ON h.Id = d.ItemServiceId
		WHERE a.OrderDate BETWEEN '".$startdate."' AND '".$enddate."'
		AND e.CodeValue = '".$regcode."'
		AND c.OrderStatus = 0
		ORDER BY OrderDate DESC";
		$query = $conn->query($sql);
		return $query->result();
		
	}
	
	function set_deactivate_order($StatesId)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "UPDATE dbo.RadiologyOrderQueueStates SET OrderStatus = 0 WHERE Id = '".$StatesId."'";
	$query =  $conn->query($sql);
	}
	
	function set_activate_order($postdata,$StatesId)
	{
	$user = $this->session->userdata('HISUser');
	if($this->session->userdata('HISUser')==NULL)
	{$user = $this->session->userdata('user').'';}
	$this->set_db();
 	$conn =	$this->load->database($this->set_db(),true);
	$BeforeValue = json_encode($conn->get_where('RadiologyOrderQueueStates',array('Id'=>$StatesId))->row());
	$StatesId = $this->uri->segment(3);
	// ------------Update to table --------------/
	$conn->where('Id', $StatesId);
	$conn->update('RadiologyOrderQueueStates', $postdata); 

	// ------------insert to syslog ----------/	
	$log = array(
				'CurrentValue' => json_encode($conn->get_where('RadiologyOrderQueueStates',array('Id'=>$StatesId))->row()),
				'TableName' =>'RadiologyOrderQueueStates',
				'RecordId' => $StatesId,
				'UserId' => $user,
				'ColumnName' => 'OrderStatus', //column change when data overide
				'BeforeValue'=> $BeforeValue,
				'EventDateUTC'=> date('Y-m-d H:i:s',time()),
				'EventType'=>'M'
				);
	$conn->insert('SysLogs',$log);
	}

	function overide_radiology_manual_correction($StatesId)
	{
	$user = $this->session->userdata('HISUser');
	if($this->session->userdata('HISUser')==NULL)
	{$user = $this->session->userdata('user').'';}
	$this->set_db();
    $conn =	$this->load->database($this->set_db(),true);
	$BeforeValue = json_encode($conn->get_where('RadiologyOrderQueueStates',array('Id'=>$StatesId))->row());
	// ------------Update to table --------------/
	$conn->where('StatesId', $StatesId);
	$conn->update('RadiologyOrderQueueStates', $postdata); 
	// ------------insert to syslog ----------/	
		$log = array(
				'CurrentValue' => json_encode($conn->get_where('RadiologyOrderQueueStates',array('Id'=>$StatesId))->row()),
				'TableName' =>'RadiologyOrderQueueStates',
				'RecordId' => $StatesId,
				'UserId' => $user,
				'ColumnName' => 'OrderStatus', //column change when data overide
				'BeforeValue'=> $BeforeValue,
				'EventDateUTC'=> date('Y-m-d H:i:s',time()),
				'EventType'=>'M'
				);
	$conn->insert('SysLogs',$log);
	}

	
}