<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Reportdoctor_model extends CI_Model{
 	
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
	
	function count_all_doctor($datestart,$dateend,$lob,$payer_id)
	{
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT count(*) AS TotalDoctors FROM
(SELECT * FROM fn_getpatientreg($payer_id)
WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB like '%".$lob."%'  AND LOB != 'IPD' AND TotalGSC > 0)a";
	$query =  $conn->query($sql);
	return $query->row()->TotalDoctors;
	}
	
	function count_all_ipddoctor($datestart,$dateend,$lob,$payer_id)
	{
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT count(*) AS TotalDoctors FROM
(SELECT * FROM fn_getipd_docvisit($payer_id)
WHERE CONVERT(date,CreatedDate) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB like '%".$lob."%' AND TotalGSC > 0)a";
	$query =  $conn->query($sql);
	return $query->row()->TotalDoctors;
	}
    
    function get_daily_doctor($datestart,$dateend,$lob=NULL,$payer_id)
    { 
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT CASE WHEN a.DoctorName IS NULL THEN 'RETAIL PATIENT' ELSE a.DoctorName END AS DoctorName, a.LOB AS LOB, a.SpecialistGroup, a.Specialist, a.SubSpecialist, count(*) AS TotalPatient FROM
(SELECT * FROM fn_getpatientreg($payer_id)
WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB like '%".$lob."%' AND TotalGSC > 0)a
GROUP BY a.DoctorName, a.LOB, a.SpecialistGroup, a.Specialist, a.SubSpecialist";
	$query =  $conn->query($sql);
    return $query;
    //return $query->row();
	//return $query->row()->Alldoctor;
    }
    
    function get_daily_ipd_doctor($datestart,$dateend,$payer_id)
    { 
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT CASE WHEN a.DoctorName IS NULL THEN 'RETAIL PATIENT' ELSE a.DoctorName END AS DoctorName, a.LOB AS LOB, a.SpecialistGroup, a.Specialist, a.SubSpecialist, count(*) AS TotalPatient FROM
(SELECT * FROM fn_getipd_docvisit($payer_id)
WHERE CONVERT(date,CreatedDate) BETWEEN '".$datestart."' AND '".$dateend."' AND TotalGSC > 0)a
GROUP BY a.DoctorName, a.LOB, a.SpecialistGroup, a.Specialist, a.SubSpecialist";
	$query =  $conn->query($sql);
    return $query;
    //return $query->row();
	//return $query->row()->Alldoctor;
    }    
	
    function get_daily_top_10_doctor($datestart,$dateend,$payer_id)
    {
   	$conn = $this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT TOP 10 CASE WHEN a.DoctorName IS NULL THEN 'RETAIL PATIENT' ELSE a.DoctorName END AS DoctorName, count(*) AS TotalPatient FROM
(SELECT * FROM fn_getpatientreg($payer_id)
WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND '".$dateend."' AND TotalGSC > 0)a
WHERE a.DoctorName IS NOT NULL
AND a.SubSpecialist NOT LIKE '%General Practitioner%'
GROUP BY a.DoctorName
ORDER BY TotalPatient DESC";
	$query =  $conn->query($sql);
	return $query->result();
    }
	
	function get_daily_top_10_doctor_general($datestart,$dateend,$payer_id)
	{
		$conn = $this->load->database($this->set_db(),true);
		$sql = "SELECT DISTINCT TOP 10 CASE WHEN a.DoctorName IS NULL THEN 'RETAIL PATIENT' ELSE a.DoctorName END AS DoctorName, count(*) AS TotalPatient FROM
(SELECT * FROM fn_getpatientreg($payer_id)
WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND '".$dateend."' AND TotalGSC > 0)a
WHERE a.DoctorName IS NOT NULL
AND a.SubSpecialist LIKE '%General Practitioner%'
GROUP BY a.DoctorName
ORDER BY TotalPatient DESC";
		$query = $conn->query($sql);
		return $query->result();	
	}
    
   	function get_totalnew_patient($datestart,$dateend,$lob,$payer_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT count(*) AS TotalPatients FROM
(SELECT * FROM fn_getpatientreg($payer_id)
WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB like '%".$lob."%' AND LOB != 'IPD' AND PatientsDescription = 'New Patient' AND TotalGSC > 0)a";
	$query =  $conn->query($sql);
	return $query->row()->TotalPatients;
	}

	function get_totalnew_ipdpatient($datestart,$dateend,$lob,$payer_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT count(*) AS TotalPatients FROM
(SELECT * FROM fn_getipd_docvisit($payer_id)
WHERE CONVERT(date,CreatedDate) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB like '%".$lob."%'  AND PatientsDescription = 'New Patient' AND TotalGSC > 0)a";
	$query =  $conn->query($sql);
	return $query->row()->TotalPatients;
	}
	
   	function get_totalold_patient($datestart,$dateend,$lob,$payer_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT count(*) AS TotalPatients FROM
(SELECT * FROM fn_getpatientreg($payer_id)
WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB like '%".$lob."%' AND LOB != 'IPD' AND PatientsDescription = 'Old Patient'  AND TotalGSC > 0)a";
	$query =  $conn->query($sql);
	return $query->row()->TotalPatients;
	}
	
	function get_totalold_ipdpatient($datestart,$dateend,$lob,$payer_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT count(*) AS TotalPatients FROM
(SELECT * FROM fn_getipd_docvisit($payer_id)
WHERE CONVERT(date,CreatedDate) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB like '%".$lob."%'  AND PatientsDescription = 'Old Patient' AND TotalGSC > 0)a";
	$query =  $conn->query($sql);
	return $query->row()->TotalPatients;
	}
        
    function get_doctor_details($doctor_id,$lob,$payer_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT * FROM fn_getpatientreg($payer_id)
WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB LIKE '%".$lob."%' AND TotalGSC > 0";
	$query =  $conn->query($sql);
	return $query->result();
	}
    
    function get_master_daily_doctor($datestart,$dateend,$payer_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT a.MedicalRecordNumber, a.PatientName, a.LOB , a.Gender , a.Address , a.Area , a.City , a.PatientsDescription , a.PatientsCategory , a.SpecialistGroup , a.DoctorName , a.AdmissionDiagnosis , a.Floor+' '+a.Rooms+' '+a.Beds AS 'ServiceDetails', a.RegistrationTime , a.RegisteredBy , a.ModifiedBy  FROM
    (SELECT * FROM fn_getpatientreg($payer_id)
WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND '".$dateend."' AND TotalGSC > 0)a";
	$query =  $conn->query($sql);
	return $query->result();
	}
    
    function get_detail_patient_visits($datestart,$dateend,$lob=NULL,$payer_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT a.RegistrationCode, a.MedicalRecordNumber, a.PatientName, a.LOB, a.Gender , a.Age, a.PatientsDescription , a.PatientsCategory , a.SubSpecialist , a.DoctorName , a.AdmissionDiagnosis , a.Classes, a.RegistrationTime FROM 
(SELECT * FROM fn_getpatientreg($payer_id)
WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB like '%".$lob."%' AND TotalGSC > 0)a";
	
	$query =  $conn->query($sql);
	
	return $query->result();
	}
	
	
	function get_detail_ipdpatient_visits($datestart,$dateend,$lob=NULL,$payer_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT a.RegistrationCode, a.MedicalRecordNumber, a.PatientName, a.LOB, a.Gender , a.Age, a.PatientsDescription , a.PatientsCategory , a.SubSpecialist , a.DoctorName , a.AdmissionDiagnosis, a.CreatedDate FROM 
(SELECT * FROM fn_getipd_docvisit($payer_id)
WHERE CONVERT(date,CreatedDate) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB like '%".$lob."%' AND TotalGSC > 0)a";
	
	$query =  $conn->query($sql);
	
	return $query->result();
	}
    
	function get_daily_fo_appointment_doctor($datestart,$dateend)
	{
		$this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(), true);
		$sql = "SELECT * FROM(SELECT
dbo.Employees.TitleBeforeName+' '+dbo.Employees.FirstName+' '+dbo.Employees.LastName+' '+dbo.Employees.TitleAfterName AS DoctorName,
dbo.Doctors.CodeValue AS DoctorCode,
dbo.RefSubSpecialist.NameValue AS Specialist,
dbo.Appointments.StartTime AS StartTime,
dbo.Appointments.EndTime AS EndTime,
datename(weekday,dbo.Appointments.StartTime) AS Day,
dbo.Patients.MedicalRecordNumber,
CASE WHEN dbo.Appointments.PatientId = 0 THEN dbo.Appointments.BookerName ELSE dbo.Patients.FirstName +' '+dbo.Patients.MiddleName+' '+dbo.Patients.LastName END AS PatientName,
dbo.Appointments.PhoneNumber,
dbo.HuRooms.CodeValue AS Room

FROM
dbo.Appointments
LEFT JOIN dbo.DoctorSchedules ON dbo.DoctorSchedules.Id = dbo.Appointments.DoctorScheduleId
LEFT JOIN dbo.Doctors ON dbo.Doctors.Id = dbo.DoctorSchedules.DoctorId
LEFT JOIN dbo.Employees ON dbo.Employees.Id = dbo.Doctors.EmployeeId
LEFT JOIN dbo.Patients ON dbo.Patients.Id = dbo.Appointments.PatientId
LEFT JOIN dbo.DoctorSpecRels ON dbo.DoctorSpecRels.DoctorId = dbo.Doctors.Id
LEFT JOIN dbo.RefSubSpecialist ON dbo.DoctorSpecRels.SubSpecialistId = dbo.RefSubSpecialist.Id
LEFT JOIN dbo.HuRooms ON dbo.HuRooms.Id = dbo.DoctorSchedules.HospitalUnitRoomId

WHERE
dbo.Appointments.RecordStatus != 0 AND
CONVERT(date,StartTime) >= '".$datestart."' AND
CONVERT(date,EndTime) <= '".$dateend."'
)a ORDER BY a.EndTime";
		$query= $conn->query($sql);
		return $query->result();
	}
	
	function get_daily_mr_appointment_doctor($datestart,$dateend)
	{
		$this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(), true);
		$sql = "SELECT * FROM(SELECT
dbo.Employees.TitleBeforeName+' '+dbo.Employees.FirstName+' '+dbo.Employees.LastName+' '+dbo.Employees.TitleAfterName AS DoctorName,
dbo.Doctors.CodeValue AS DoctorCode,
dbo.RefSubSpecialist.NameValue AS Specialist,
dbo.Appointments.StartTime AS StartTime,
dbo.Appointments.EndTime AS EndTime,
datename(weekday,dbo.Appointments.StartTime) AS Day,
dbo.Patients.MedicalRecordNumber,
dbo.Patients.FirstName +' '+dbo.Patients.MiddleName+' '+dbo.Patients.LastName AS PatientName,
dbo.Appointments.PhoneNumber,
dbo.HuRooms.CodeValue AS Room

FROM
dbo.Appointments
LEFT JOIN dbo.DoctorSchedules ON dbo.DoctorSchedules.Id = dbo.Appointments.DoctorScheduleId
LEFT JOIN dbo.Doctors ON dbo.Doctors.Id = dbo.DoctorSchedules.DoctorId
LEFT JOIN dbo.Employees ON dbo.Employees.Id = dbo.Doctors.EmployeeId
LEFT JOIN dbo.Patients ON dbo.Patients.Id = dbo.Appointments.PatientId
LEFT JOIN dbo.DoctorSpecRels ON dbo.DoctorSpecRels.DoctorId = dbo.Doctors.Id
LEFT JOIN dbo.RefSubSpecialist ON dbo.DoctorSpecRels.SubSpecialistId = dbo.RefSubSpecialist.Id
LEFT JOIN dbo.HuRooms ON dbo.HuRooms.Id = dbo.DoctorSchedules.HospitalUnitRoomId

WHERE
dbo.Appointments.RecordStatus != 0 AND
CONVERT(date,StartTime) >= '".$datestart."' AND
CONVERT(date,EndTime) <= '".$dateend."' AND
dbo.Appointments.PatientId != 0
)a ORDER BY a.EndTime";
		$query= $conn->query($sql);
		return $query->result();
	}
	
	function get_detail_patientmcu_visits($datestart,$dateend,$lob=NULL,$payer_id)
	{
		$this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(), true);
		$sql = "SELECT a.RegistrationCode, a.MedicalRecordNumber, a.PatientName, a.LOB, a.Gender , a.Age, a.PatientsDescription , a.PatientsCategory , a.SubSpecialist , a.DoctorName , c.NameValue AS Package , a.Classes, a.RegistrationTime FROM fn_getpatientreg($payer_id) a
	INNER JOIN dbo.GSCDetails b ON a.PatientRegsId = b.RegId
	INNER JOIN dbo.Packages c ON b.HuPackageId = c.Id
	WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB like '%".$lob."%' AND TotalGSC > 0";
		$query= $conn->query($sql);
		return $query->result();
	}

}