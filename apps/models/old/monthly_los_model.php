<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Monthly_los_model extends CI_Model{
 	
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
	
	function get_monthly_los_report($los,$year,$month)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "
	SELECT DescValue, COUNT(*) AS Total FROM
	(SELECT a.RegId,b.NameValue AS ItemServiceName,e.DescValue,f.NameValue,a.CreatedDate FROM dbo.GSCDetails a
	LEFT JOIN dbo.ItemServices b ON b.id = a.ItemServiceId
	LEFT JOIN dbo.HuLobRelLosRels c ON c.Id = a.HuLobRelLosRelId
	LEFT JOIN dbo.HuLobRels d ON d.Id = c.HuLobRelId
	LEFT JOIN dbo.RefLoses e ON e.id = c.LosId
	LEFT JOIN dbo.RefLobs f ON f.Id = d.LineOffBusinessUnitID 
	WHERE e.Id NOT BETWEEN '17' AND '19' AND a.ItemServiceId IS NOT NULL AND e.DescValue = '".$los."' AND DATEPART(year,a.CreatedDate) = '".$year."' AND DATEPART(mm,a.CreatedDate) = '".$month."' )a
	GROUP BY a.DescValue";
	$query =  $conn->query($sql);
	return $query->row()->Total;
	}
	
	function get_monthly_lob_report($los,$lob,$year,$month)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "
	SELECT DescValue, NameValue, COUNT(*) AS Total FROM
	(SELECT a.RegId,b.NameValue AS ItemServiceName,e.DescValue,h.NameValue,a.CreatedDate FROM dbo.GSCDetails a
	LEFT JOIN dbo.ItemServices b ON b.id = a.ItemServiceId
	LEFT JOIN dbo.HuLobRelLosRels c ON c.Id = a.HuLobRelLosRelId
	LEFT JOIN dbo.RefLoses e ON e.id = c.LosId
	LEFT JOIN dbo.PatientRegs g ON g.Id = a.RegId
	LEFT JOIN dbo.HuLobRels d ON d.Id = g.HuLobRelId
	LEFT JOIN dbo.RefLobs h ON h.Id = d.LineOffBusinessUnitID
	WHERE a.ItemServiceId IS NOT NULL AND e.DescValue IN (".$los.")  AND h.NameValue = '".$lob."' AND DATEPART(year,a.CreatedDate) = '".$year."' AND DATEPART(mm,a.CreatedDate) = '".$month."' )a
	GROUP BY a.DescValue, a.NameValue";
	$query =  $conn->query($sql);
	if($query->num_rows()<1)
		{
		return 0;
		}	
	else
		{
	return $query->row()->Total;
		}
	}
	
	function get_mcu_report($los,$lob,$year,$month)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "
	SELECT a.LOS,a.LOB,COUNT(*) AS Total FROM
	(SELECT a.id,b.NameValue AS ItemServiceName,c.NameValue AS PackageName,d.DescValue AS LOS,h.NameValue AS LOB,e.RegId,e.CreatedDate FROM dbo.PackageDetails a
	LEFT JOIN dbo.ItemServices b ON b.id  = a.ItemServiceId 
	LEFT JOIN dbo.Packages c ON c.id = a.PackageId
	LEFT JOIN dbo.RefLoses d ON d.id = b.LosesId
	LEFT JOIN dbo.GSCDetails e ON e.HuPackageId = c.id
	LEFT JOIN dbo.PatientRegs f ON f.id = e.RegId
	LEFT JOIN dbo.HuLobRels g ON g.id = f.HuLobRelId
	LEFT JOIN dbo.RefLobs h ON h.id = g.LineOffBusinessUnitID 
	WHERE h.NameValue = '".$lob."' AND d.DescValue IN (".$los.") AND DATEPART(year,e.CreatedDate) = '".$year."' AND DATEPART(mm,e.CreatedDate) = '".$month."') a
	GROUP BY a.LOS,a.LOB";
	$query =  $conn->query($sql);
	if($query->num_rows()<1)
		{
		return 0;
		}	
	else
		{
	return $query->row()->Total;
		}
	}
	
	function get_montlyreg_los_retail_report($los,$year,$month,$status)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "
	SELECT a.LOS, a.PatientType, COUNT(1) AS Total FROM
	(SELECT DISTINCT a.Id, d.DescValue AS LOS, a.RegistrationTime, CASE WHEN g.DoctorId IS NULL THEN 'Retail' ELSE 'Regular' END AS 'PatientType' FROM dbo.PatientRegs a
	LEFT JOIN dbo.GSCDetails b ON b.RegId = a.Id
	LEFT JOIN dbo.HuLobRelLosRels c ON c.Id = b.HuLobRelLosRelId
	LEFT JOIN dbo.RefLoses d ON d.id = c.LosId
	LEFT JOIN dbo.HuLobRels e ON e.Id = a.HuLobRelId
	LEFT JOIN dbo.RefLobs f ON f.Id = e.LineOffBusinessUnitID
	LEFT JOIN dbo.MRDoctorRels g ON g.RegId = a.Id
	WHERE d.DescValue IN (".$los.") AND DATEPART(year,a.RegistrationTime) = '".$year."' AND DATEPART(mm,a.RegistrationTime) = '".$month."') a
	WHERE a.PatientType =  '".$status."'
	GROUP BY a.LOS, a.PatientType";
	$query =  $conn->query($sql);
	if($query->num_rows()<1)
		{
		return 0;
		}	
	else
		{
	return $query->row()->Total;
		}
	}
	
	function get_montlyreg_lob_report($los,$lob,$year,$month,$status)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "
	SELECT a.LOS, a.LOB, a.PatientType, COUNT(1) AS Total FROM
	(SELECT DISTINCT a.Id, d.DescValue AS LOS, f.NameValue AS LOB, a.RegistrationTime, CASE WHEN g.DoctorId IS NULL THEN 'Retail' ELSE 'Regular' END AS 'PatientType' FROM dbo.PatientRegs a
	LEFT JOIN dbo.GSCDetails b ON b.RegId = a.Id
	LEFT JOIN dbo.HuLobRelLosRels c ON c.Id = b.HuLobRelLosRelId
	LEFT JOIN dbo.RefLoses d ON d.id = c.LosId
	LEFT JOIN dbo.HuLobRels e ON e.Id = a.HuLobRelId
	LEFT JOIN dbo.RefLobs f ON f.Id = e.LineOffBusinessUnitID
	LEFT JOIN dbo.MRDoctorRels g ON g.RegId = a.Id
	WHERE g.RegId = a.Id AND d.DescValue IN (".$los.")  AND f.NameValue = '".$lob."' AND DATEPART(year,a.RegistrationTime) = '".$year."' AND DATEPART(mm,a.RegistrationTime) = '".$month."') a
	WHERE a.PatientType =  '".$status."'
	GROUP BY a.LOS, a.LOB, a.PatientType";
	$query =  $conn->query($sql);
	if($query->num_rows()<1)
		{
		return 0;
		}	
	else
		{
	return $query->row()->Total;
		}
	}
	
	function get_montlyreg_mcu_report($los,$lob,$year,$month)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "
	SELECT a.LOS,a.LOB, COUNT(1) AS Total FROM
	(SELECT DISTINCT d.DescValue AS LOS, h.NameValue AS LOB, e.CreatedDate FROM dbo.PackageDetails a
	LEFT JOIN dbo.ItemServices b ON b.id  = a.ItemServiceId 
	LEFT JOIN dbo.Packages c ON c.id = a.PackageId
	LEFT JOIN dbo.RefLoses d ON d.id = b.LosesId
	LEFT JOIN dbo.GSCDetails e ON e.HuPackageId = c.id
	LEFT JOIN dbo.PatientRegs f ON f.id = e.RegId
	LEFT JOIN dbo.HuLobRels g ON g.id = f.HuLobRelId
	LEFT JOIN dbo.RefLobs h ON h.id = g.LineOffBusinessUnitID 
	WHERE d.DescValue IN (".$los.") AND h.NameValue = '".$lob."' AND DATEPART(year,e.CreatedDate) = '".$year."' AND DATEPART(mm,e.CreatedDate) = '".$month."') a
	GROUP BY a.LOS,a.LOB";
	$query =  $conn->query($sql);
	if($query->num_rows()<1)
		{
		return 0;
		}	
	else
		{
	return $query->row()->Total;
		}
	}
	
	function get_monthly_med_support($lob,$month)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "
	SELECT DISTINCT
		a.RegId ,
		CONVERT(DATE,a.AdmitDate) AS AdmitDate,
		b.CodeValue AS 'Nomor Registrasi',
		c.MedicalRecordNumber ,
		c.FirstName + ' ' + c.MiddleName + ' ' + c.LastName AS 'Patient Name' ,
		l.TitleBeforeName+' '+l.FirstName+' '+l.LastName+' '+l.TitleAfterName AS 'Doctor Name',
		c.Birthdate ,
		c.Birthplace ,
		e.NameValue AS 'Classes'
	FROM	dbo.Admissions a
		LEFT JOIN dbo.PatientRegs b ON b.id = a.RegId
		LEFT JOIN dbo.Patients c ON c.id = b.PatientId
		LEFT JOIN dbo.AdmissionDetails d ON d.AdmissionId = a.id
		LEFT JOIN dbo.PriceListClasses e ON e.id = d.PriceListClassId
		LEFT JOIN dbo.HuBeds f ON f.id = d.HuBedId
		LEFT JOIN dbo.HuRooms g ON g.Id = f.RoomId
		LEFT JOIN dbo.HuWards h ON h.Id = g.WardId
		LEFT JOIN dbo.HuFloors i ON i.Id = h.Floor		
		LEFT JOIN dbo.MRDoctorRels j ON j.RegId = b.Id
		LEFT JOIN dbo.Doctors k ON k.id = j.DoctorId
		LEFT JOIN dbo.Employees l ON l.id = k.EmployeeId 
	WHERE b.CodeValue LIKE '"%$lob%"' AND c.RecordStatus != 0 AND DATEPART(MONTH,a.AdmitDate) = '".$month."' AND j.IsPrimary = 1 ORDER BY a.RegId";
	$query = $conn->query($sql);
		if($query->num_rows()<1)
		{
		return 0;
		}	
	else
		{
	return $query->row()->Total;
		}
	}
	
	function get_diagnostic_report($package,$lob,$year,$month,$status)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "
	SELECT a.LOB ,a.Paket, a.Bulan, a.Tahun, a.PatientType, COUNT(1) AS Total FROM
	(SELECT DISTINCT a.Id, d.DescValue AS LOS, f.NameValue AS LOB, g.NameValue AS Paket, DAY(CONVERT(DATE,a.RegistrationTime)) AS Tanggal, DATEPART(MONTH,a.RegistrationTime) AS Bulan, DATEPART(YEAR,a.RegistrationTime) AS Tahun, CASE WHEN h.DoctorId IS NULL THEN 'Retail' ELSE 'Regular' END AS 'PatientType' FROM dbo.PatientRegs a
	LEFT JOIN dbo.GSCDetails b ON b.RegId = a.Id
	LEFT JOIN dbo.HuLobRelLosRels c ON c.Id = b.HuLobRelLosRelId
	LEFT JOIN dbo.RefLoses d ON d.id = c.LosId
	LEFT JOIN dbo.HuLobRels e ON e.Id = a.HuLobRelId
	LEFT JOIN dbo.RefLobs f ON f.Id = e.LineOffBusinessUnitID
	LEFT JOIN dbo.ItemServices g ON b.ItemServiceId = g.Id
	LEFT JOIN dbo.MRDoctorRels h ON h.RegId = a.Id
	WHERE f.NameValue = '".$lob."' AND DATEPART(YEAR,a.RegistrationTime) = '".$year."' AND g.NameValue IN (".$package."))a 
	WHERE a.Bulan = '".$month."'
	AND a.PatientType =  '".$status."'
	GROUP BY a.LOB, a.Paket, a.Bulan, a.Tahun, a.PatientType ";
	$query = $conn->query($sql);
		if($query->num_rows()<1)
		{
		return 0;
		}	
	else
		{
	return $query->row()->Total;
		}
	}
	
	function get_diagnosticmcu_report($package,$lob,$year,$month,$status)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "
SELECT a.Paket
     , a.LOB
     , a.Bulan
     , a.Tahun
     , a.PatientType
     , count(1) AS Total
FROM
  (SELECT b.NameValue AS Paket
        , d.DescValue AS LOS
        , h.NameValue AS LOB
        , day(convert(DATE, e.CreatedDate)) AS Tanggal
        , datepart (MONTH, e.CreatedDate) AS Bulan
        , datepart (YEAR, e.CreatedDate) AS Tahun
        , CASE
            WHEN i.DoctorId IS NULL THEN
              'Retail'
            ELSE
              'Regular'
          END AS 'PatientType'
   FROM
     dbo.PackageDetails a
     LEFT JOIN dbo.ItemServices b
       ON b.id = a.ItemServiceId
     LEFT JOIN dbo.Packages c
       ON c.id = a.PackageId
     LEFT JOIN dbo.RefLoses d
       ON d.id = b.LosesId
     LEFT JOIN dbo.GSCDetails e
       ON e.HuPackageId = c.id
     LEFT JOIN dbo.PatientRegs f
       ON f.id = e.RegId
     LEFT JOIN dbo.HuLobRels g
       ON g.id = f.HuLobRelId
     LEFT JOIN dbo.RefLobs h
       ON h.id = g.LineOffBusinessUnitID
     LEFT JOIN dbo.MRDoctorRels i
       ON i.RegId = f.Id
   WHERE
     h.NameValue = 'MCU'
     AND datepart (YEAR, e.CreatedDate) = '".$year."'
     AND b.NameValue IN (".$package.")) a
WHERE
  a.Bulan = '".$month."'
  AND a.PatientType =  '".$status."'
GROUP BY
  a.Paket
, a.LOB
, a.Bulan
, a.Tahun
, a.PatientType";
	$query = $conn->query($sql);
		if($query->num_rows()<1)
		{
		return 0;
		}	
	else
		{
	return $query->row()->Total;
		}
	}
	
	function get_diagnostic_tran_report($package,$lob,$year,$month)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "
	SELECT a.LOB
     , a.Paket
     , a.Bulan
     , a.Tahun
     , count(*) AS Total
FROM
  (SELECT a.RegId
        , b.NameValue AS Paket
        , e.DescValue AS LOS
        , h.NameValue AS LOB
        , day(convert(DATE, a.CreatedDate)) AS Tanggal
        , datepart (MONTH, a.CreatedDate) AS Bulan
        , datepart (YEAR, a.CreatedDate) AS Tahun
   FROM
     dbo.GSCDetails a
     LEFT JOIN dbo.ItemServices b
       ON b.id = a.ItemServiceId
     LEFT JOIN dbo.HuLobRelLosRels c
       ON c.Id = a.HuLobRelLosRelId
     LEFT JOIN dbo.RefLoses e
       ON e.id = c.LosId
     LEFT JOIN dbo.PatientRegs g
       ON g.Id = a.RegId
     LEFT JOIN dbo.HuLobRels d
       ON d.Id = g.HuLobRelId
     LEFT JOIN dbo.RefLobs h
       ON h.Id = d.LineOffBusinessUnitID
   WHERE
     b.NameValue IN (".$package.")
     AND h.NameValue = '".$lob."'
     AND datepart (YEAR, a.CreatedDate) = '".$year."') a
WHERE
  a.Bulan = '".$month."'
GROUP BY
  a.LOB
, a.Paket
, a.Bulan
, a.Tahun";
	$query = $conn->query($sql);
		if($query->num_rows()<1)
		{
		return 0;
		}	
	else
		{
	return $query->row()->Total;
		}
	}
	
	function get_diagnosticmcu_tran_report($package,$lob,$year,$month)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "
SELECT a.LOB
     , a.Paket
     , a.Bulan
     , a.Tahun
     , count(*) AS Total
FROM
  (SELECT a.id
        , b.NameValue AS Paket
        , c.NameValue AS PackageName
        , d.DescValue AS LOS
        , h.NameValue AS LOB
        , e.RegId
        , datepart (MONTH, e.CreatedDate) AS Bulan
        , datepart (YEAR, e.CreatedDate) AS Tahun
   FROM
     dbo.PackageDetails a
     LEFT JOIN dbo.ItemServices b
       ON b.id = a.ItemServiceId
     LEFT JOIN dbo.Packages c
       ON c.id = a.PackageId
     LEFT JOIN dbo.RefLoses d
       ON d.id = b.LosesId
     LEFT JOIN dbo.GSCDetails e
       ON e.HuPackageId = c.id
     LEFT JOIN dbo.PatientRegs f
       ON f.id = e.RegId
     LEFT JOIN dbo.HuLobRels g
       ON g.id = f.HuLobRelId
     LEFT JOIN dbo.RefLobs h
       ON h.id = g.LineOffBusinessUnitID
   WHERE
     h.NameValue = '".$lob."'
     AND datepart (MONTH, e.CreatedDate) = '".$month."'
     AND datepart (YEAR, e.CreatedDate) = '".$year."'
     AND b.NameValue IN (".$package.")) a
GROUP BY
  a.LOB
, a.Paket
, a.Bulan
, a.Tahun;";
	$query = $conn->query($sql);
		if($query->num_rows()<1)
		{
		return 0;
		}	
	else
		{
	return $query->row()->Total;
		}
	}
	
}