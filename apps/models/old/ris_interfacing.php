<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Ris_interfacing extends CI_Model{
 	
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
	
	function lookup_ris_doctor($doctorcode = NULL)
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
        $sql = "SELECT a.CodeValue AS Code, b.TitleBeforeName+' '+b.FirstName+' '+b.LastName+' '+TitleAfterName AS Name,
				e.Id AS SpecialistId,
				e.NameValue AS SpecialistName,
				d.Id AS SubSpecialistId,
				d.NameValue AS SubSpecialistName
				FROM dbo.Doctors a
				LEFT JOIN dbo.Employees b ON B.Id = a.EmployeeId 
				LEFT JOIN dbo.DoctorSpecRels c ON a.Id = c.DoctorId
				LEFT JOIN dbo.RefSubSpecialist d ON d.Id = c.SubSpecialistId 
				LEFT JOIN dbo.RefSpecialist e ON e.Id = d.SpecialistId
				WHERE a.RecordStatus = 1 AND d.NameValue LIKE '%General Radiology%' $where 
				";
		$query = $conn->query($sql);
        return $query;
	}

	function matching_doctor($doctorname)
	{
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "SELECT DISTINCT TOP 1 PhysicianPerformingCode,PhysicianPerformingEmail,PhysicianPerformingName FROM dbo.InfPacs WHERE PhysicianPerformingName LIKE '%".$doctorname."%'";
		$query = $conn->query($sql);
        return $query->row();
	}

	
	function get_ris_transaction($startdate,$enddate,$roles=NULL)
	{
		$whereclause = ' AND a.PhysicianPerformingName IS NULL';
		
		if($roles == 'hod-radiologi')
			{
			$whereclause = ' ';
			}
		else if($roles == 'finance')
			{
			//$whereclause = ' AND a.RIS_ReportCreatedBy IS NOT NULL AND a.DoctorFee_IsApproved = 1';
			$whereclause = ' AND a.RIS_ReportCreatedBy IS NOT NULL ';
			}
		$this->set_db();
      	$conn = $this->load->database($this->set_db(),true);
        $sql = "
		SELECT a.*,CASE WHEN b.RecordStatus = 0 THEN 'Bill Paid' ELSE 'Bill Unpaid' END AS BillStatus
		FROM dbo.InfPacs a INNER JOIN dbo.PatientRegs b ON b.CodeValue = a.RegistrationNo 
		WHERE convert(date,a.OrderDate) between '".$startdate."' AND '".$enddate."' AND a.OrderStatus <> 'CANCELED' $whereclause ORDER BY a.OrderDate ASC ";
		$query = $conn->query($sql);
        return $query->result();
		
	}

	function get_ris_undefinedtrans($name,$physician){
		 	$conn =	$this->load->database($this->set_db(),true);
		 	$sql = "execute [10.83.129.20].[RT_medicosRadiag].dbo.sp_getUndefinedata '".$name."','".$physician."'";
		 	$query = $conn->query($sql);
		 	return $query->result();
	}
	
		
	function overide_doctor_transaction($postdata,$transId)
	{
		$user = $this->session->userdata('HISUser');
		if($this->session->userdata('HISUser')==NULL)
		{$user = $this->session->userdata('user').'';}
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
		$BeforeValue = json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row());
	//	$doctor = $this->lookup_ris_doctor($doctor_code)->row();
	// ------------Update to table --------------/
	$conn->where('RecID', $transId);
	$conn->update('InfPacs', $postdata); 
	// ------------insert to syslog ----------/	
	$log = array(
				'CurrentValue' => json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row()),
				'TableName' =>'InfPacs',
				'RecordId' => $transId,
				'UserId' => $user,
				'ColumnName' => 'PhysicianPerformingName', //column change when data overide
				'BeforeValue'=> $BeforeValue,
				'EventDateUTC'=> date('Y-m-d H:i:s',time()),
				'EventType'=>'M'
				);
	$conn->insert('SysLogs',$log);
	}
	
	function transaction_checked($transId)
	{
	$user = $this->session->userdata('HISUser');
		if($this->session->userdata('HISUser')==NULL)
		{$user = $this->session->userdata('user').'';}
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
	$conn->trans_start();
		$BeforeValue = json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row());
	$data = array(
		'InfHIS_ReportCheck' => 1,
		'InfHIS_ReportCheckBy ' => $user,
		'InfHIS_ReportCheckDate' => date('m/d/Y h:i:s a', time()),
		'InfHIS_ReportCheckFrom' => $this->input->ip_address()	
				);
	// ------------Update to table -----------/
	$conn->where('RecID', $transId);
	$conn->update('InfPacs', $data); 
	// ------------insert to syslog ----------/	
	$log = array(
				'CurrentValue' => json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row()),
				'TableName' =>'InfPacs',
				'RecordId' => $transId,
				'UserId' => $user,				
				'ColumnName' => 'InfHIS_ReportCheck', //column change when transaction Corrected
				'BeforeValue'=> $BeforeValue,
				'EventDateUTC'=> date('Y-m-d H:i:s',time()),
				'EventType'=>'M'
				);
	$conn->insert('SysLogs',$log);
	$conn->trans_complete();
	if ($this->db->trans_status() === FALSE)
		{
			return 0;
		}
	else
		{
			return 1;
		}
	}
	
	
	function transaction_approved($transId)
	{
	$user = $this->session->userdata('HISUser');
		if($this->session->userdata('HISUser')==NULL)
		{$user = $this->session->userdata('user').'';}
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
	$conn->trans_start();
		$BeforeValue = json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row());
	$data = array(
		'DoctorFee_IsApproved' => 1,
		'DoctorFee_ApprovedBy' => $user,
		'DoctorFee_ApprovedDate' => date('m/d/Y h:i:s a', time()),
		'DoctorFee_ApprovedFrom' => $this->input->ip_address()	
				);
	// ------------Update to table -----------/
	$conn->where('RecID', $transId);
	$conn->update('InfPacs', $data); 
	// ------------insert to syslog ----------/	
	$log = array(
				'CurrentValue' => json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row()),
				'TableName' =>'InfPacs',
				'RecordId' => $transId,
				'UserId' => $user,				
				'ColumnName' => 'DoctorFee_IsApproved', //column change when transaction approved
				'BeforeValue'=> $BeforeValue,
				'EventDateUTC'=> date('Y-m-d H:i:s',time()),
				'EventType'=>'M'
				);
	$conn->insert('SysLogs',$log);
	$conn->trans_complete();
	if ($this->db->trans_status() === FALSE)
		{
			return 0;
		}
	else
		{
			return 1;
		}
	}
	
	function paid_transaction($transId)
	{
	$user = $this->session->userdata('HISUser');
		if($this->session->userdata('HISUser')==NULL)
		{$user = $this->session->userdata('user').'';}
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
	$conn->trans_start();
		$BeforeValue = json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row());
	$data = array(
		'DoctorFee_IsPaid' => 1,
		'DoctorFee_PaidBy' => $user,
		'DoctorFee_PaidDate' => date('m/d/Y h:i:s a', time()),
		'DoctorFee_PaidFrom' => $this->input->ip_address()	
				);
	// ------------Update to table -----------/
	$conn->where('RecID', $transId);
	$conn->update('InfPacs', $data); 
	// ------------insert to syslog ----------/	
	$log = array(
				'CurrentValue' => json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row()),
				'TableName' =>'InfPacs',
				'RecordId' => $transId,
				'UserId' => $user,								
				'ColumnName' => 'DoctorFee_IsPaid', //column change when transaction paid by finance
				'BeforeValue'=> $BeforeValue,
				'EventDateUTC'=> date('Y-m-d H:i:s',time()),
				'EventType'=>'M'
				);
	$conn->insert('SysLogs',$log);
	$conn->trans_complete();
	if ($this->db->trans_status() === FALSE)
		{
			return 0;
		}
	else
		{
			return 1;
		}
	}
	
	function unpaid_transaction($transId)
	{
	$user = $this->session->userdata('HISUser');
		if($this->session->userdata('HISUser')==NULL)
		{$user = $this->session->userdata('user').'';}
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
	$conn->trans_start();
		$BeforeValue = json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row());
	$data = array(
		'DoctorFee_IsPaid' => 0,
		'DoctorFee_PaidBy' => '',
		'DoctorFee_PaidDate' => date('m/d/Y h:i:s a', time()),
		'DoctorFee_PaidFrom' => $this->input->ip_address()	
				);
	// ------------Update to table -----------/
	$conn->where('RecID', $transId);
	$conn->update('InfPacs', $data); 
	// ------------insert to syslog ----------/	
	$log = array(
				'CurrentValue' => json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row()),
				'TableName' =>'InfPacs',
				'RecordId' => $transId,
				'UserId' => $user,				
				'ColumnName' => 'DoctorFee_IsPaid', //column change when transaction unpaid by finance
				'BeforeValue'=> $BeforeValue,
				'EventDateUTC'=> date('Y-m-d H:i:s',time()),
				'EventType'=>'M'
				);
	$conn->insert('SysLogs',$log);
	$conn->trans_complete();
	if ($this->db->trans_status() === FALSE)
		{
			return 0;
		}
	else
		{
			return 1;
		}
	}
	
	function unlock_approval($transId) // can accessed by finance
	{
	$user = $this->session->userdata('HISUser');
		if($this->session->userdata('HISUser')==NULL)
		{$user = $this->session->userdata('user').'';}
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
	$conn->trans_start();
		$BeforeValue = json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row());
	$data = array(
		'DoctorFee_IsApproved' => 0,
		'DoctorFee_ApprovedBy' => 'data unlock by '.$user,
		'DoctorFee_ApprovedDate' => date('m/d/Y h:i:s a', time()),
		'DoctorFee_ApprovedFrom' => $this->input->ip_address(),
		'DoctorFee_IsPaid' => 0,		
				);
	// ------------Update to table -----------/
	$conn->where('RecID', $transId);
	$conn->update('InfPacs', $data); 
	// ------------insert to syslog ----------/	
	$log = array(
				'CurrentValue' => json_encode($conn->get_where('InfPacs',array('RecID'=>$transId))->row()),
				'TableName' =>'InfPacs',
				'RecordId' => $transId,
				'UserId' => $user,
				'ColumnName' => 'DoctorFee_IsPaid', //column change when transaction unpaid by finance
				'BeforeValue'=> $BeforeValue,
				'EventDateUTC'=> date('Y-m-d H:i:s',time()),
				'EventType'=>'M'
				);
	$conn->insert('SysLogs',$log);
	$conn->trans_complete();
	if ($this->db->trans_status() === FALSE)
		{
			return 0;
		}
	else
		{
			return 1;
		}
	}
	
	function bulk_approval($start_date,$end_date)
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$query = "SELECT RecID FROM  dbo.InfPacs WHERE DoctorFee_ApprovedBy IS NULL AND (CONVERT(DATE,RIS_ReportCreatedDate) BETWEEN '".$start_date."' AND '".$end_date."')";
	$result = $conn->query($sql)->result;
		foreach($result as $data)
			{
				$this->transaction_approved($data->RecID);
			}	
	}
	
	function bulk_payment($start_date,$end_date)
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$query = "SELECT RecID FROM  dbo.InfPacs WHERE DoctorFee_ApprovedBy IS NULL AND (CONVERT(DATE,RIS_ReportCreatedDate) BETWEEN '".$start_date."' AND '".$end_date."')";
	$result = $conn->query($sql)->result;
		foreach($result as $data)
			{
				$this->paid_transaction($data->RecID);
			}	
	}
	
}