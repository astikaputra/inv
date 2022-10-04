<?php

class Patientreport_model extends CI_Model {
	
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
	
	function count_all_patient($datestart,$dateend,$lob=NULL)
	{
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT count(*) AS TotalPatients
	FROM Patients LEFT JOIN PatientRegs ON Patients.Id = PatientRegs.PatientId
	LEFT JOIN HuLobRels ON PatientRegs.HuLobRelId = HuLobRels.Id
	LEFT JOIN RefGenders ON RefGenders.Id = Patients.GenderId
	LEFT JOIN RefLobs ON RefLobs.Id = HuLobRels.LineOffBusinessUnitID
	WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND  '".$dateend."' AND RefLobs.NameValue like '%".$lob."%'";
	$query =  $conn->query($sql);
	return $query->row()->TotalPatients;
	}
	
	function get_closed_patient($datestart,$dateend,$lob)
	{
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT * FROM (SELECT Patients.Id,PatientRegs.id as 'RegID',Patients.MedicalRecordNumber,RefLobs.NameValue as 'Lob',
PatientRegs.CodeValue AS 'RegistrationCode',Patients.FirstName+' '+Patients.MiddleName+' '+Patients.LastName AS PatientsName,
PatientRegs.RegistrationTime,CONVERT(DATE,PatientRegs.RegistrationTime) AS DateRegistration,
CONVERT(VARCHAR(8),PatientRegs.RegistrationTime,108) AS TimeRegistration,RefGenders.NameValue AS Genders,
PatientRegs.RecordStatus as 'Status',PatientRegs.CreatedBy+' '+PatientRegs.ModifiedBy As CreatedBy,
		(SELECT COUNT (*)
		FROM
			(SELECT DISTINCT 
Bills.Id,
PatientRegs.Id  as PatientRegsID
FROM
Bills
LEFT JOIN GSCSBillRels ON GSCSBillRels.BillId = Bills.Id
LEFT JOIN GSCDetails ON GSCSBillRels.GSCDetailId =GSCDetails.Id
LEFT JOIN PatientRegs ON PatientRegs.Id = GSCDetails.RegId
WHERE Bills.RecordStatus = 1
) a
WHERE a.PatientRegsID = PatientRegs.id ) as TotalBill,
(SELECT TOP 1
(dbo.Employees.TitleBeforeName + ' ' +dbo.Employees.FirstName + ' '+ ' '+ dbo.Employees.LastName+ ' ' +dbo.Employees.TitleAfterName) AS DoctorName
FROM
dbo.MRDoctorRels 
LEFT JOIN dbo.Doctors ON dbo.Doctors.Id = dbo.MRDoctorRels.DoctorId
LEFT JOIN dbo.Employees ON dbo.Employees.id = dbo.Doctors.EmployeeId
WHERE dbo.MRDoctorRels.IsPrimary = 1 AND dbo.MRDoctorRels.RecordStatus = 1 AND dbo.MRDoctorRels.RegId = PatientRegs.id
) AS 'DoctorName'
FROM
Patients
LEFT JOIN PatientRegs ON Patients.Id = PatientRegs.PatientId
LEFT JOIN HuLobRels ON PatientRegs.HuLobRelId = HuLobRels.Id
LEFT JOIN RefGenders ON RefGenders.Id = Patients.GenderId
LEFT JOIN RefLobs ON RefLobs.Id = HuLobRels.LineOffBusinessUnitID
	WHERE PatientRegs.RecordStatus = 0 AND CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND  '".$dateend."' AND RefLobs.NameValue = '".$lob."') a WHERE TotalBill > 0";
	$query =  $conn->query($sql);
	return $query;
	}
	
	function get_canceled_patient($datestart,$dateend,$lob)
	{
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT * FROM (SELECT Patients.Id,PatientRegs.id as 'RegID',Patients.MedicalRecordNumber,RefLobs.NameValue as 'Lob',
PatientRegs.CodeValue AS 'RegistrationCode',Patients.FirstName+' '+Patients.MiddleName+' '+Patients.LastName AS PatientsName,
PatientRegs.RegistrationTime,CONVERT(DATE,PatientRegs.RegistrationTime) AS DateRegistration,
CONVERT(VARCHAR(8),PatientRegs.RegistrationTime,108) AS TimeRegistration,RefGenders.NameValue AS Genders,
PatientRegs.RecordStatus as 'Status',PatientRegs.CreatedBy+' '+PatientRegs.ModifiedBy AS CreatedBy,
		(SELECT COUNT (*)
		FROM
			(SELECT DISTINCT 
Bills.Id,
PatientRegs.Id  as PatientRegsID
FROM
Bills
LEFT JOIN GSCSBillRels ON GSCSBillRels.BillId = Bills.Id
LEFT JOIN GSCDetails ON GSCSBillRels.GSCDetailId =GSCDetails.Id
LEFT JOIN PatientRegs ON PatientRegs.Id = GSCDetails.RegId
WHERE Bills.RecordStatus = 1
) a
WHERE a.PatientRegsID = PatientRegs.id ) as TotalBill,
(SELECT TOP 1
(dbo.Employees.TitleBeforeName + ' ' +dbo.Employees.FirstName + ' '+ ' '+ dbo.Employees.LastName+ ' ' +dbo.Employees.TitleAfterName) AS DoctorName
FROM
dbo.MRDoctorRels 
LEFT JOIN dbo.Doctors ON dbo.Doctors.Id = dbo.MRDoctorRels.DoctorId
LEFT JOIN dbo.Employees ON dbo.Employees.id = dbo.Doctors.EmployeeId
WHERE dbo.MRDoctorRels.IsPrimary = 1 AND dbo.MRDoctorRels.RecordStatus = 1 AND dbo.MRDoctorRels.RegId = PatientRegs.id
) AS 'DoctorName'
FROM
Patients
LEFT JOIN PatientRegs ON Patients.Id = PatientRegs.PatientId
LEFT JOIN HuLobRels ON PatientRegs.HuLobRelId = HuLobRels.Id
LEFT JOIN RefGenders ON RefGenders.Id = Patients.GenderId
LEFT JOIN RefLobs ON RefLobs.Id = HuLobRels.LineOffBusinessUnitID
	WHERE PatientRegs.RecordStatus = 0 AND CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND  '".$dateend."' AND RefLobs.NameValue = '".$lob."') a WHERE TotalBill = 0";
	$query =  $conn->query($sql);
	return $query;
	}
	
	function get_active_patient($datestart,$dateend,$lob)
	{
	$conn =	$this->load->database($this->set_db(),true);
	$sql = " SELECT  Patients.Id,PatientRegs.id as 'RegID',Patients.MedicalRecordNumber,RefLobs.NameValue as 'Lob',
PatientRegs.CodeValue AS 'RegistrationCode',Patients.FirstName+' '+Patients.MiddleName+' '+Patients.LastName AS PatientsName,
PatientRegs.RegistrationTime,CONVERT(DATE,PatientRegs.RegistrationTime) AS DateRegistration,
CONVERT(VARCHAR(8),PatientRegs.RegistrationTime,108) AS TimeRegistration,RefGenders.NameValue AS Genders,
PatientRegs.RecordStatus as 'Status',PatientRegs.CreatedBy+' '+PatientRegs.ModifiedBy AS CreatedBy,
		(SELECT COUNT (*)
		FROM
			(SELECT DISTINCT 
Bills.Id,
PatientRegs.Id  as PatientRegsID
FROM
Bills
LEFT JOIN GSCSBillRels ON GSCSBillRels.BillId = Bills.Id
LEFT JOIN GSCDetails ON GSCSBillRels.GSCDetailId =GSCDetails.Id
LEFT JOIN PatientRegs ON PatientRegs.Id = GSCDetails.RegId
WHERE Bills.RecordStatus = 1
) a
WHERE a.PatientRegsID = PatientRegs.id ) as TotalBill,
(SELECT TOP 1
(dbo.Employees.TitleBeforeName + ' ' +dbo.Employees.FirstName + ' '+ ' '+ dbo.Employees.LastName+ ' ' +dbo.Employees.TitleAfterName) AS DoctorName
FROM
dbo.MRDoctorRels 
LEFT JOIN dbo.Doctors ON dbo.Doctors.Id = dbo.MRDoctorRels.DoctorId
LEFT JOIN dbo.Employees ON dbo.Employees.id = dbo.Doctors.EmployeeId
WHERE dbo.MRDoctorRels.IsPrimary = 1 AND dbo.MRDoctorRels.RecordStatus = 1 AND dbo.MRDoctorRels.RegId = PatientRegs.id
) AS 'DoctorName'
FROM
Patients
LEFT JOIN PatientRegs ON Patients.Id = PatientRegs.PatientId
LEFT JOIN HuLobRels ON PatientRegs.HuLobRelId = HuLobRels.Id
LEFT JOIN RefGenders ON RefGenders.Id = Patients.GenderId
LEFT JOIN RefLobs ON RefLobs.Id = HuLobRels.LineOffBusinessUnitID
	WHERE PatientRegs.RecordStatus = 1 AND CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND  '".$dateend."' AND RefLobs.NameValue = '".$lob."'";
	$query =  $conn->query($sql);
	return $query;
	}
	
	function get_retail_patient($datestart,$dateend,$status)
    { 
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT * FROM
	(SELECT DISTINCT h.MedicalRecordNumber, d.DescValue AS LOS, f.CodeValue AS LOB, CONVERT(DATE,a.RegistrationTime) AS DateRegistration, CONVERT(VARCHAR(8),a.RegistrationTime,108) AS TimeRegistration, CASE WHEN g.DoctorId IS NULL THEN 'Retail' ELSE 'Regular' END AS 'PatientType', h.FirstName +' '+h.MiddleName+' '+h.LastName AS PatientName FROM dbo.PatientRegs a
	LEFT JOIN dbo.GSCDetails b ON b.RegId = a.Id
	LEFT JOIN dbo.HuLobRelLosRels c ON c.Id = b.HuLobRelLosRelId
	LEFT JOIN dbo.RefLoses d ON d.id = c.LosId
	LEFT JOIN dbo.HuLobRels e ON e.Id = a.HuLobRelId
	LEFT JOIN dbo.RefLobs f ON f.Id = e.LineOffBusinessUnitID
	LEFT JOIN dbo.MRDoctorRels g ON g.RegId = a.Id
	LEFT JOIN dbo.Patients h ON h.Id = a.PatientId
	WHERE  CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND  '".$dateend."' AND d.DescValue != 'FINANCE')a
	WHERE a.PatientType = '".$status."'";
	$query =  $conn->query($sql);
    return $query;
    }
	
	function get_patient_discharge($startdate,$enddate)
	{
	//$parm = new DateTime($monthyear);

	//$month = $parm->format('m');
	//$year = $parm->format('Y');
	
	//$month= date('Y', "2013-12-11");
	
	//echo $month;
	//echo $year;
	//$year = date('Y',$monthyear->format('Y-m'));
	//break;
	
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "
SELECT DISTINCT
	ab.RegCode,
	ab.MedicalRecordNumber,
	ab.PatientName,
	ab.DoctorName,
	ab.RegistrationTime,
	--(SELECT TOP 1 ac.DischargeDate FROM dbo.DischargeOrder ac WHERE ab.RegId = ac.RegId ORDER BY ab.DateOfDischarge ASC) AS DSG,
	ab.DateOfDischarge,
	DATEPART(HOUR, (SELECT
			TOP 1 ac.DischargeDate
		FROM
			dbo.DischargeOrder ac
		WHERE
			ab.RegId = ac.RegId
		ORDER BY
			ab.DateOfDischarge ASC)) AS DischargeHour,
	ab.PatientClosedTime,
	--ab.DayOfService,
	DATEDIFF(DAY, ab.RegistrationTime, ab.DateOfDischarge) AS DayOfService,
	--ab.LengthOfStay,
	ab.DischargeStatus,
	ab.DischargeType,
	ab.DischargeReasons,
	ab.PayerName
FROM
	(
		SELECT DISTINCT
			a.RegId,      
			b.CodeValue AS RegCode,
			c.MedicalRecordNumber,
			c.FirstName + ' ' + c.MiddleName + ' ' + c.LastName AS PatientName,
			e.TitleBeforeName + ' ' + e.FirstName + ' ' + e.LastName + ' ' + TitleAfterName AS DoctorName,
			b.RegistrationTime,
			a.DischargeDate,
			--j.FromDate, 
			--j.ToDate, 
			fdate.FromDate,
			tdate.ToDate,
			DATEPART(HOUR,a.DischargeDate) AS DischargeHour, 
			CASE WHEN a.DischargeDate <= tdate.ToDate THEN tdate.ToDate ELSE a.DischargeDate END AS DateOfDischarge, 
			CASE WHEN PatientClosed.InstitutionId IS NOT NULL THEN PatientClosed.BillGenerate ELSE BillPaid END AS PatientClosedTime, 
			--DATEDIFF(DAY, j.FromDate, j.ToDate) AS LengthOfStay, 
			--DATEDIFF(DAY, b.RegistrationTime,a.DischargeDate) AS DayOfService, 
			f.NameValue AS DischargeStatus, 
			g.NameValue AS DischargeType, 
			h.NameValue AS DischargeReasons,
			CASE WHEN PatientClosed.PayerName IS NULL THEN '-' ELSE PatientClosed.PayerName END AS PayerName 
			FROM dbo.DischargeOrder a 
			INNER JOIN dbo.PatientRegs b ON b.id = a.RegId 
			INNER JOIN dbo.Patients c ON c.id = b.PatientId 
			INNER JOIN dbo.Doctors d ON d.id = a.DoctorId 
			INNER JOIN dbo.Employees e ON e.id = d.EmployeeId 
			INNER JOIN dbo.RefDischargeRequestStatus f ON f.id = a.DischargeStatus 
			INNER JOIN dbo.RefDischargeRequestTypes g ON g.id = a.RequestType 
			INNER JOIN dbo.RefDischargeRequestReasons h ON h.id = a.DischargeReason 
			INNER JOIN dbo.Admissions i ON i.RegId = b.Id 
			INNER JOIN dbo.AdmissionDetails j ON j.AdmissionId = i.Id 			 
			OUTER APPLY (SELECT TOP 1 * FROM dbo.AdmissionDetails WHERE AdmissionId = i.id ORDER BY FromDate ASC) fdate
			OUTER APPLY (SELECT TOP 1 * FROM dbo.AdmissionDetails WHERE AdmissionId = i.id ORDER BY FromDate DESC) tdate
			OUTER APPLY (SELECT TOP 1 cc.CodeValue,cc.BillDate,cc.InstitutionId,cc.CreatedOn AS BillGenerate ,dd.RecordTime AS BillPaid, ee.NameValue AS PayerName FROM dbo.GSCDetails aa 
			INNER JOIN dbo.GSCSBillRels bb ON aa.id = bb.GSCDetailId
			INNER JOIN dbo.Bills cc ON cc.id = bb.BillId 
			LEFT JOIN dbo.Payments dd ON cc.id = dd.BillId
			LEFT JOIN dbo.Institutions ee ON c.PrimaryPayerId = ee.Id
			WHERE aa.RegId = b.id AND bb.RecordStatus = 1) AS PatientClosed 
			WHERE 
			--CONVERT(DATE, a.DischargeDate) BETWEEN '2014-04-12' AND '2014-04-22' --OR CONVERT(DATE, j.ToDate) BETWEEN '2014-04-12' AND '2014-04-22' 
			c.RecordStatus = 1)ab WHERE CONVERT(DATE, ab.DateOfDischarge) BETWEEN '".$startdate."' AND '".$enddate."'";
	$query =  $conn->query($sql);
	return $query;
	}
	
	function get_patient_discharge10($startdate,$enddate)
	{
	//$parm = new DateTime($monthyear);

	//$month = $parm->format('m');
	//$year = $parm->format('Y');
	
	//$month= date('Y', "2013-12-11");
	
	//echo $month;
	//echo $year;
	//$year = date('Y',$monthyear->format('Y-m'));
	//break;
	
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "

SELECT DISTINCT
	ab.RegCode,
	ab.MedicalRecordNumber,
	ab.PatientName,
	ab.DoctorName,
	ab.RegistrationTime,
	--(SELECT TOP 1 ac.DischargeDate FROM dbo.DischargeOrder ac WHERE ab.RegId = ac.RegId ORDER BY ab.DateOfDischarge ASC) AS DSG,
	ab.DateOfDischarge,
	DATEPART(HOUR, (SELECT
			TOP 1 ac.DischargeDate
		FROM
			dbo.DischargeOrder ac
		WHERE
			ab.RegId = ac.RegId
		ORDER BY
			ab.DateOfDischarge ASC)) AS DischargeHour,
	ab.PatientClosedTime,
	--ab.DayOfService,
	DATEDIFF(DAY, ab.RegistrationTime, ab.DateOfDischarge) AS DayOfService,
	--ab.LengthOfStay,
	ab.DischargeStatus,
	ab.DischargeType,
	ab.DischargeReasons,
	ab.PayerName
FROM
	(
		SELECT DISTINCT
			a.RegId,      
			b.CodeValue AS RegCode,
			c.MedicalRecordNumber,
			c.FirstName + ' ' + c.MiddleName + ' ' + c.LastName AS PatientName,
			e.TitleBeforeName + ' ' + e.FirstName + ' ' + e.LastName + ' ' + TitleAfterName AS DoctorName,
			b.RegistrationTime,
			a.DischargeDate,
			--j.FromDate, 
			--j.ToDate, 
			fdate.FromDate,
			tdate.ToDate,
			DATEPART(HOUR,a.DischargeDate) AS DischargeHour, 
			CASE WHEN a.DischargeDate <= tdate.ToDate THEN tdate.ToDate ELSE a.DischargeDate END AS DateOfDischarge, 
			CASE WHEN PatientClosed.InstitutionId IS NOT NULL THEN PatientClosed.BillGenerate ELSE BillPaid END AS PatientClosedTime, 
			--DATEDIFF(DAY, j.FromDate, j.ToDate) AS LengthOfStay, 
			--DATEDIFF(DAY, b.RegistrationTime,a.DischargeDate) AS DayOfService, 
			f.NameValue AS DischargeStatus, 
			g.NameValue AS DischargeType, 
			h.NameValue AS DischargeReasons,
			CASE WHEN PatientClosed.PayerName IS NULL THEN '-' ELSE PatientClosed.PayerName END AS PayerName 
			FROM dbo.DischargeOrder a 
			INNER JOIN dbo.PatientRegs b ON b.id = a.RegId 
			INNER JOIN dbo.Patients c ON c.id = b.PatientId 
			INNER JOIN dbo.Doctors d ON d.id = a.DoctorId 
			INNER JOIN dbo.Employees e ON e.id = d.EmployeeId 
			INNER JOIN dbo.RefDischargeRequestStatus f ON f.id = a.DischargeStatus 
			INNER JOIN dbo.RefDischargeRequestTypes g ON g.id = a.RequestType 
			INNER JOIN dbo.RefDischargeRequestReasons h ON h.id = a.DischargeReason 
			INNER JOIN dbo.Admissions i ON i.RegId = b.Id 
			INNER JOIN dbo.AdmissionDetails j ON j.AdmissionId = i.Id 			 
			OUTER APPLY (SELECT TOP 1 * FROM dbo.AdmissionDetails WHERE AdmissionId = i.id ORDER BY FromDate ASC) fdate
			OUTER APPLY (SELECT TOP 1 * FROM dbo.AdmissionDetails WHERE AdmissionId = i.id ORDER BY FromDate DESC) tdate
			OUTER APPLY (SELECT TOP 1 cc.CodeValue,cc.BillDate,cc.InstitutionId,cc.CreatedOn AS BillGenerate ,dd.RecordTime AS BillPaid, ee.NameValue AS PayerName FROM dbo.GSCDetails aa 
			INNER JOIN dbo.GSCSBillRels bb ON aa.id = bb.GSCDetailId
			INNER JOIN dbo.Bills cc ON cc.id = bb.BillId 
			LEFT JOIN dbo.Payments dd ON cc.id = dd.BillId
			LEFT JOIN dbo.Institutions ee ON c.PrimaryPayerId = ee.Id
			WHERE aa.RegId = b.id AND bb.RecordStatus = 1) AS PatientClosed 
			WHERE 
			--CONVERT(DATE, a.DischargeDate) BETWEEN '2014-04-12' AND '2014-04-22' --OR CONVERT(DATE, j.ToDate) BETWEEN '2014-04-12' AND '2014-04-22' 
			c.RecordStatus = 1)ab WHERE CONVERT(DATE, ab.DateOfDischarge) BETWEEN '".$startdate."' AND '".$enddate."' AND DATEPART(HOUR,ab.DateOfDischarge) <= 10";
	$query =  $conn->query($sql);
	return $query;
	}
	
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
	
	//--------------------------------- Get Floor In Hospital--------------------------------------------
	function get_floor_row()
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
) AS Total FROM HuFloors)floor WHERE floor.Total <> 0 ORDER BY Id DESC";
	$query =  $conn->query($sql);
	return $query->result();
	}
	//--------------------------------- End Get Floor In Hospital---------------------------------------------
	
	//--------------------------------- Get Ward In Hospital--------------------------------------------
	function get_ward_row()
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
) AS Total FROM HuWards)ward WHERE ward.Total <> 0 ORDER BY Id DESC";
	$query =  $conn->query($sql);
	return $query->result();
	}
	//--------------------------------- End Get Ward In Hospital---------------------------------------------
	
	//--------------------------------- Get Bed Status in Every Floor-----------------------------------------
	function get_list_bed()
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT
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
	a.ICDCode,
	a.RegId,
	a.AdmissionId,
	a.Class
FROM
	(SELECT DISTINCT
	TOP (100) PERCENT A.Id AS AdmissionId,
	B.Id AS AdmissionDetailId,
	B.ToDate,
	A.RegId,
	B.PriceListClassId,
	J.NameValue AS Class,
	(SELECT TOP 1 FromDate FROM dbo.AdmissionDetails WHERE AdmissionId = A.id ORDER BY FromDate ASC) AS AdmitDate,
	A.OutDate,
	A.DischargeDate,
	C.Id AS BedId,
	C.CodeValue AS BedCode,
	C.NameValue AS BedName,
	case when C.CurrentStatus = 0 THEN 'Vacant' when C.CurrentStatus = 1 THEN 'Occupied'when C.CurrentStatus = 2 THEN 'Release Not Vacated'
	when C.CurrentStatus = 3 THEN 'To Be Cleaned'when C.CurrentStatus = 4 THEN 'Alloted Not Occupied'
	else 'Not In Used'END AS BedStatus,
	O.NameValue AS BedType,
	C.IsETC,
	F.NameValue AS RoomName,
	N.Id AS FloorId,
	N.NameValue AS Floor,
	F.Id AS RoomId,
	G.Id AS WardId,
	G.NameValue AS WardName,
	G.DescValue AS WardDesc,
	D.CodeValue AS RegCode,
	D.IsDischarge,
	E.Id AS PatientId,
	E.MedicalRecordNumber,
	E.FirstName + ' ' + E.MiddleName + ' ' + E.LastName AS PatientName,
	E.Birthdate,
	E.GenderId,
	K.NameValue AS Gender,
	I.TitleBeforeName + ' ' + I.FirstName + ' ' + I.LastName + ' ' + I.TitleAfterName AS DoctorName,
	I.FirstName,
	I.LastName,
	H.CodeValue AS DoctorCode,
	H.Id AS DoctorId,
	D.RecordStatus,
	C.CurrentStatus,
	B.IsPhoneBillingStarted,
	B.RecordStatus AS AdmissionDetailRecordStatus,
	B.ParentRegId,
	Q.CodeValue AS LOB,
	(SELECT TOP 1 R.Diagnosis FROM dbo.AdmissionOrder R WHERE R.Diagnosis IS NOT NULL AND E.Id = R.PatientId ORDER BY R.OrderDate DESC)AS Diagnosis,
	L.OrderDate,
	L.EstDurationStay,
	L.ICDCode
FROM
	dbo.Admissions A
INNER JOIN dbo.AdmissionDetails B ON A.Id = B.AdmissionId
INNER JOIN dbo.PatientRegs D ON D.Id = A.RegId
INNER JOIN dbo.Patients E ON E.Id = D.PatientId
INNER JOIN dbo.HuBeds C ON A.HuBedId = C.Id
INNER JOIN dbo.HuRooms F ON F.Id = C.RoomId
INNER JOIN dbo.HuWards G ON G.Id = F.WardId
LEFT JOIN dbo.Doctors H ON A.PrimaryDoctorId = H.Id
LEFT JOIN dbo.Employees I ON I.Id = H.EmployeeId
LEFT JOIN dbo.PriceListClasses J ON J.Id = C.PriceListClassId
LEFT JOIN dbo.RefGenders K ON K.Id = E.GenderId
LEFT JOIN dbo.AdmissionOrder L ON L.PatientId = E.Id AND L.RegistrationId = d.Id
LEFT JOIN dbo.HuFloors N ON G.Floor = N.Id
LEFT JOIN dbo.RefBedTypes O ON C.BedTypeId = O.Id
LEFT JOIN dbo.HuLobRels P ON G.HuLobId = P.Id
LEFT JOIN dbo.RefLobs Q ON Q.Id = P.LineOffBusinessUnitID
WHERE
	A.HuBedId IS NOT NULL
	--AND C.RecordStatus != 0
	AND C.CurrentStatus IN (1,4)
	--AND D.RecordStatus != 0
	--AND A.DischargeDate IS NULL
	AND B.RecordStatus = 1
ORDER BY
	AdmissionId DESC) a 
	WHERE a.BedCode IS NOT NULL
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
	
	function get_patient_data_sheet($startdate,$enddate)
	{
	$this->set_db();
	$conn = $this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT
	a.BedCode,
	a.BedName,
	a.BedStatus,
	a.BedType,
	a.RoomName,
	a.WardName,
	a.WardDesc,
	a.Floor,
	a.LOB,
	a.MedicalRecordNumber,
	a.PatientName,
	a.Gender,
	a.Birthdate,
	a.Age,
	a.AgeDetail,
	a.RoomName,
	a.AdmitDate,
	a.DoctorName,
	datename(weekday, a.AdmitDate) AS DAY,
	a.OutDate,
	a.DischargeDate,
	a.Payer,
	a.OrderDate
FROM
	(SELECT DISTINCT
	TOP (100) PERCENT A.Id AS AdmissionId,
	B.Id AS AdmissionDetailId,
	B.ToDate,
	A.RegId,
	B.PriceListClassId,
	J.NameValue AS Class,
	A.AdmitDate,
	A.OutDate,
	A.DischargeDate,
	C.Id AS BedId,
	C.CodeValue AS BedCode,
	C.NameValue AS BedName,
	case when C.CurrentStatus = 0 THEN 'Vacant' when C.CurrentStatus = 1 THEN 'Occupied'when C.CurrentStatus = 2 THEN 'Release Not Vacated'
	when C.CurrentStatus = 3 THEN 'To Be Cleaned'when C.CurrentStatus = 4 THEN 'Alloted Not Occupied'
	else 'Not In Used'END AS BedStatus,
	O.NameValue AS BedType,
	C.IsETC,
	F.NameValue AS RoomName,
	N.Id AS FloorId,
	N.NameValue AS Floor,
	F.Id AS RoomId,
	G.Id AS WardId,
	G.NameValue AS WardName,
	G.DescValue AS WardDesc,
	D.CodeValue AS RegCode,
	D.IsDischarge,
	E.MedicalRecordNumber,
	RTRIM(LTRIM(E.FirstName)) + (
		CASE
		WHEN RTRIM(LTRIM(E.MiddleName)) IS NULL THEN
			''
		ELSE
			(
				CASE
				WHEN RTRIM(LTRIM(E.MiddleName)) = '' THEN
					' '
				ELSE
					' ' + RTRIM(LTRIM(E.MiddleName)) + ' '
				END
			)
		END
	) + RTRIM(LTRIM(E.LastName)) AS PatientName,
	E.Birthdate,
	DATEDIFF(yy, E.Birthdate, getdate()) AS Age,
	CAST(DATEDIFF(yy, E.Birthdate, getdate()) AS varchar(4)) +' year '+
	CAST(DATEDIFF(mm, DATEADD(yy, DATEDIFF(yy, E.Birthdate, getdate()), E.Birthdate), getdate()) AS varchar(2)) +' month '+
	CAST(DATEDIFF(dd, DATEADD(mm, DATEDIFF(mm, DATEADD(yy, DATEDIFF(yy, E.Birthdate, getdate()), E.Birthdate), getdate()), DATEADD(yy, DATEDIFF(yy, E.Birthdate, getdate()), E.Birthdate)), getdate()) AS varchar(2)) +' day' AS AgeDetail,
	E.GenderId,
	K.NameValue AS Gender,
	I.TitleBeforeName + ' ' + I.FirstName + ' ' + I.LastName + ' ' + I.TitleAfterName AS DoctorName,
	I.FirstName,
	I.LastName,
	H.CodeValue AS DoctorCode,
	H.Id AS DoctorId,
	D.RecordStatus,
	C.CurrentStatus,
	B.IsPhoneBillingStarted,
	L.DoctorId AS CurrentDoctorId,
	M.DoctorName AS CurrentDoctorName,
	B.RecordStatus AS AdmissionDetailRecordStatus,
	B.ParentRegId,
	Q.CodeValue AS LOB,
	E.Id AS PatientId,
	L.Diagnosis,
	L.OrderDate,
	R.NameValue AS Payer,
	L.EstDurationStay,
	L.ICDCode
FROM
	dbo.Admissions AS A
INNER JOIN dbo.AdmissionDetails AS B ON A.Id = B.AdmissionId
INNER JOIN dbo.PatientRegs AS D ON D.Id = A.RegId
INNER JOIN dbo.Patients AS E ON E.Id = D.PatientId
LEFT OUTER JOIN dbo.HuBeds AS C ON B.HuBedId = C.Id
LEFT OUTER JOIN dbo.HuRooms AS F ON F.Id = C.RoomId
LEFT OUTER JOIN dbo.HuWards AS G ON G.Id = F.WardId
LEFT OUTER JOIN dbo.Doctors AS H ON A.PrimaryDoctorId = H.Id
INNER JOIN dbo.Employees AS I ON I.Id = H.EmployeeId
LEFT OUTER JOIN dbo.PriceListClasses AS J ON J.Id = B.PriceListClassId
INNER JOIN dbo.RefGenders AS K ON K.Id = E.GenderId
LEFT OUTER JOIN dbo.AdmissionOrder AS L ON L.PatientId = E.Id
LEFT OUTER JOIN dbo.VDoctor AS M ON L.DoctorId = M.Id
LEFT OUTER JOIN dbo.HuFloors N ON G.Floor = N.Id
LEFT OUTER JOIN dbo.RefBedTypes O ON C.BedTypeId = O.Id
LEFT OUTER JOIN dbo.HuLobRels P ON G.HuLobId = P.Id
LEFT OUTER JOIN dbo.RefLobs Q ON Q.Id = P.LineOffBusinessUnitID
INNER JOIN dbo.Institutions R ON R.Id = E.PrimaryPayerId
WHERE
	(L.RegistrationId IS NULL)
OR (
	L.RegistrationId = (
		SELECT
			MAX (RegistrationId) AS Expr1
		FROM
			dbo.AdmissionOrder
		WHERE
			(PatientId = L.PatientId)
	)
)
AND CONVERT(DATE,AdmitDate) BETWEEN '".$startdate."' AND '".$enddate."'
AND C.RecordStatus != 0
AND D.RecordStatus != 0
AND A.DischargeDate IS NULL 
ORDER BY
	AdmissionId DESC) a 
	WHERE a.BedCode IS NOT NULL
	AND a.BedStatus = 'Occupied'
	AND a.LOB = 'IPD'
--AND dbo.HuBeds.CurrentStatus <> 0";
	$query = $conn->query($sql);
	return $query->result();
	}

	function get_employee_clinic($payer_id,$startdate,$enddate)
	{
        $this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "SELECT * FROM 
(SELECT DISTINCT
	A.CodeValue AS RegistrationCode,
	A.RegistrationTime,
	E.Id AS PatId,
	E.FirstName+' '+E.MiddleName+' '+E.LastName AS PatientName,
	CASE WHEN (SELECT count(1) FROM PatientRegs p WHERE p.PatientId = E.Id AND p.RegistrationTime < A.RegistrationTime) = 0 THEN 'New Patient' ELSE 'Old Patient' END AS PatientsDescription,
	CASE WHEN ((SELECT TOP 1 InstitutionId FROM dbo.PatientPayers WHERE PatientId = E.id AND RecordStatus = 1) IN ($payer_id,'700')) THEN 'Internal Employee' ELSE 'General' END AS PatientsCategory,
	E.Birthdate,
	DATEDIFF(yy, E.Birthdate, getdate()) AS Age,
	J.AddressDesc AS Address,
	CAST(DATEDIFF(yy, E.Birthdate, getdate()) AS varchar(4)) +' year '+
	CAST(DATEDIFF(mm, DATEADD(yy, DATEDIFF(yy, E.Birthdate, getdate()), E.Birthdate), getdate()) AS varchar(2)) +' month '+
	CAST(DATEDIFF(dd, DATEADD(mm, DATEDIFF(mm, DATEADD(yy, DATEDIFF(yy, E.Birthdate, getdate()), E.Birthdate), getdate()), DATEADD(yy, DATEDIFF(yy, E.Birthdate, getdate()), E.Birthdate)), getdate()) AS varchar(2)) +' day' AS AgeDetail,
	I.NameValue AS IdentityType,
	E.IdentityCardbNumber,
	G.NameValue AS Gender,
	CASE WHEN J.PhoneNumber = '' THEN E.PhoneNumber ELSE J.PhoneNumber END AS PhoneNumber,
	H.CodeValue AS LOB,
	D.DescValue AS LOS,
	L.CodeValue AS DoctorsCode,
	O.TitleBeforeName+' '+O.FirstName+' '+O.LastName+' '+O.TitleAfterName AS DoctorName,
	Q.NameValue AS SpecialistGroup,
	P.NameValue AS Specialist,
	N.NameValue AS SubSpecialist
FROM dbo.PatientRegs A
LEFT JOIN GSCDetails B ON A.Id = B.RegId
LEFT JOIN HuLobRelLosRels C ON B.HuLobRelLosRelId = C.Id
LEFT JOIN RefLoses D ON C.LosId = D.Id
LEFT JOIN Patients E ON A.PatientId = E.Id
LEFT JOIN HuLobRels F ON A.HuLobRelId = F.Id
LEFT JOIN RefGenders G ON E.GenderId = G.Id
LEFT JOIN RefLobs H ON F.LineOffBusinessUnitID = H.Id
LEFT JOIN RefIdentityCardTypes I ON E.IdentityCardTypeId = I.Id
LEFT JOIN Addresses J ON E.Id = J.PatientId
LEFT JOIN MRDoctorRels K ON A.Id = K.RegId
LEFT JOIN Doctors L ON K.DoctorId = L.Id
LEFT JOIN DoctorSpecRels M ON L.Id = M.DoctorId
LEFT JOIN RefSubSpecialist N ON M.SubSpecialistId = N.Id
LEFT JOIN Employees O ON L.EmployeeId = O.Id
LEFT JOIN RefSpecialist P ON N.SpecialistId = P.Id
LEFT JOIN RefSpecialistGroups Q ON P.GroupSpecialistId = Q.Id
WHERE H.CodeValue = 'OPD'
--AND D.DescValue = 'OUT PATIENT DEPARTMENT CLINICS'
)AA WHERE CONVERT (DATE, AA.RegistrationTime) BETWEEN '".$startdate."' AND '".$enddate."'
AND AA.PatientsCategory = 'Internal Employee'
AND AA.LOS IN ('OUT PATIENT DEPARTMENT CLINICS','FRONT OFFICE')
ORDER BY AA.RegistrationTime DESC";
        $query = $conn->query($sql);
        return $query->result();
	}

}