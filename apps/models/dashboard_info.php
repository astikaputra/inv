<?php

class Dashboard_info extends CI_Model {
	
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

//----------------------------------------Dashboard Bed Status --------------------------/

	//--------------------------------- Get Ward In Hospital--------------------------------------------
	function get_ward()
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT * FROM(SELECT Id,NameValue,DescValue,Floor, (SELECT
count(1) as total
FROM
dbo.Admissions a
LEFT JOIN dbo.HuBeds b ON a.HuBedId = b.Id 
LEFT JOIN dbo.HuRooms c ON b.RoomId = c.Id
LEFT JOIN dbo.HuWards  d ON c.WardId = d.Id 
LEFT JOIN dbo.PatientRegs e ON a.RegId = e.Id
WHERE e.RecordStatus = 1 AND d.Id = HuWards.Id 
--AND b.CurrentStatus <> 0
) AS Total FROM HuWards)ward WHERE ward.Total <> 0";
	$query =  $conn->query($sql);
	return $query->result();
	}
	//--------------------------------- End Get Ward In Hospital---------------------------------------------
	
	//--------------------------------- Get Floor In Hospital--------------------------------------------
	function get_floor()
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT * FROM (SELECT Id,NameValue,(SELECT
count(1) as total
FROM
dbo.Admissions a
LEFT JOIN dbo.HuBeds b ON a.HuBedId = b.Id 
LEFT JOIN dbo.HuRooms c ON b.RoomId = c.Id
LEFT JOIN dbo.HuWards  d ON c.WardId = d.Id 
LEFT JOIN dbo.PatientRegs e ON a.RegId = e.Id
WHERE e.RecordStatus = 1 AND d.Floor = HuFloors.Id
--AND b.CurrentStatus <> 0
) AS Total FROM HuFloors)floor WHERE floor.Total <> 0";
	$query =  $conn->query($sql);
	return $query->result();
	}
	//--------------------------------- End Get Floor In Hospital---------------------------------------------

	//--------------------------------- Get Bed Status in Every Floor-----------------------------------------
	function get_list_bed($floor_id,$ward=NULL)
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	if($ward != NULL)
		{
		$ward_clause = "AND dbo.HuWards.Id = $ward";
		}
	else
		{
		$ward_clause = '';
		}
	$sql = "
	SELECT
	a.BedCode,
	a.BedName,
	a.IsETC,
	a.RecordStatus,
	a.CurrentStatus,
	a.BedStatus,
	a.BedType,
	a.RoomName,
	a.WardName,
	a.WardDesc,
	a.FloorId,
	a.Floor,
	a.LOB,
	a.RegCode,
	a.DoctorName,
	a.PatientName,
	a.MedicalRecordNumber,
	a.Diagnosis,
	a.RoomName,
	a.AdmitDate,
	datename(weekday, a.AdmitDate) AS DAY,
	a.OutDate,
	a.DischargeDate,
	a.Diagnosis,
	a.OrderDate,
	a.EstDurationStay,
	a.ICDCode,
	a.RegId,
	a.AdmisionId,
	a.Class
FROM
	(SELECT
dbo.HuBeds.CodeValue AS BedCode,dbo.HuBeds.NameValue AS BedName,dbo.HuBeds.IsETC,dbo.HuBeds.RecordStatus,dbo.HuBeds.CurrentStatus,case when dbo.HuBeds.CurrentStatus = 0 THEN 'Vacant' when dbo.HuBeds.CurrentStatus = 1 THEN 'Occupied'when dbo.HuBeds.CurrentStatus = 2 THEN 'Release Not Vacated'
when dbo.HuBeds.CurrentStatus = 3 THEN 'To Be Cleaned'when dbo.HuBeds.CurrentStatus = 4 THEN 'Alloted Not Occupied'
else 'Not In Used'END AS BedStatus,dbo.RefBedTypes.NameValue AS BedType,dbo.HuRooms.CodeValue AS RoomName,
dbo.HuWards.NameValue AS WardName,dbo.HuWards.DescValue AS WardDesc,dbo.HuFloors.Id AS  FloorId,dbo.HuFloors.NameValue AS Floor,dbo.RefLobs.CodeValue AS LOB,
dbo.PatientRegs.CodeValue AS RegCode,dbo.Patients.MedicalRecordNumber,dbo.Patients.FirstName+' '+dbo.Patients.MiddleName+' '+dbo.Patients.LastName As PatientName,
dbo.Employees.TitleBeforeName+' '+dbo.Employees.FirstName+' '+dbo.Employees.LastName+' '+dbo.Employees.TitleAfterName As DoctorName,
(SELECT TOP 1 FromDate FROM dbo.AdmissionDetails WHERE AdmissionId = dbo.Admissions.id ORDER BY FromDate ASC) AS AdmitDate,dbo.Admissions.OutDate,dbo.Admissions.DischargeDate,dbo.AdmissionOrder.Diagnosis,dbo.AdmissionOrder.OrderDate,dbo.AdmissionOrder.EstDurationStay,
dbo.AdmissionOrder.ICDCode,dbo.PatientRegs.Id AS RegId,
dbo.Admissions.id AS AdmisionId,
(SELECT TOP 1 b.NameValue AS Classes FROM dbo.AdmissionDetails a INNER JOIN dbo.PriceListClasses b ON b.Id = a.PriceListClassId
WHERE a.AdmissionId = dbo.Admissions.id AND a.RecordStatus = 1 ) AS Class
FROM
dbo.Admissions LEFT JOIN dbo.HuBeds ON dbo.Admissions.HuBedId = dbo.HuBeds.Id
LEFT JOIN dbo.HuRooms ON dbo.HuBeds.RoomId = dbo.HuRooms.Id
LEFT JOIN dbo.HuWards ON dbo.HuRooms.WardId = dbo.HuWards.Id
LEFT JOIN dbo.HuFloors ON dbo.HuWards.Floor = dbo.HuFloors.Id
LEFT JOIN dbo.HuLobRels ON dbo.HuWards.HuLobId = dbo.HuLobRels.Id
LEFT JOIN dbo.PatientRegs ON dbo.Admissions.RegId = dbo.PatientRegs.Id 
LEFT JOIN dbo.AdmissionOrder ON dbo.AdmissionOrder.RegistrationId = dbo.PatientRegs.Id
LEFT JOIN dbo.Doctors ON dbo.Admissions.PrimaryDoctorId = dbo.Doctors.Id
LEFT JOIN dbo.RefBedTypes ON dbo.HuBeds.BedTypeId = dbo.RefBedTypes.Id
LEFT JOIN dbo.PriceListClasses ON dbo.HuBeds.PriceListClassId = dbo.PriceListClasses.Id
LEFT JOIN dbo.Employees ON dbo.Doctors.EmployeeId = dbo.Employees.Id
LEFT JOIN dbo.RefLobs ON dbo.RefLobs.Id = dbo.HuLobRels.LineOffBusinessUnitID
LEFT JOIN dbo.Patients ON dbo.PatientRegs.PatientId = dbo.Patients.Id
WHERE dbo.Admissions.HuBedId IS NOT NULL AND dbo.HuBeds.RecordStatus != 0 AND dbo.PatientRegs.RecordStatus != 0 AND dbo.Admissions.DischargeDate IS NULL AND dbo.HuFloors.Id = $floor_id $ward_clause --AND dbo.HuBeds.CurrentStatus != 0
) a
--AND dbo.HuBeds.CurrentStatus <> 0";
	$query =  $conn->query($sql);
	return $query->result();
	}
	//--------------------------------- Get Bed Status in Every Floor---------------------------------------------
	//--------------------------------- Function Get doctor --------------------------------
	
	function get_doctorrel($reg_id)
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT
dbo.MRDoctorRels.RegId,
dbo.PatientRegs.CodeValue,
dbo.Employees.TitleBeforeName+' '+dbo.Employees.FirstName+' '+dbo.Employees.LastName+' '+dbo.Employees.TitleAfterName AS DoctorName,
dbo.MRDoctorRels.IsPrimary,
CASE WHEN dbo.MRDoctorRels.IsPrimary = 1 THEN '(Primary)'
WHEN dbo.MRDoctorRels.IsPrimary = 2 THEN '(Single Consult)'
WHEN dbo.MRDoctorRels.IsPrimary = 3 THEN ''
ELSE ''
END AS DoctorStatus
FROM
dbo.MRDoctorRels
LEFT JOIN dbo.Doctors ON dbo.Doctors.Id = dbo.MRDoctorRels.DoctorId
LEFT JOIN dbo.Employees ON dbo.Employees.Id = dbo.Doctors.EmployeeId
LEFT JOIN dbo.PatientRegs ON dbo.PatientRegs.Id = dbo.MRDoctorRels.RegId
WHERE MRDoctorRels.RegId = $reg_id AND MRDoctorRels.RecordStatus = 1";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_historical_class($admision_id)
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "
SELECT datename(weekday, a.FromDate) AS DAY,a.FromDate,a.ToDate,b.NameValue AS Classes,a.RecordStatus  FROM dbo.AdmissionDetails a INNER JOIN dbo.PriceListClasses b ON b.Id = a.PriceListClassId
WHERE AdmissionId = $admision_id ORDER By a.FromDate DESC";
	$query =  $conn->query($sql);
	return $query->result();
	}


}