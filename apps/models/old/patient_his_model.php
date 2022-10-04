<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Patient_his_model extends CI_Model {
 	
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

	function count_all_patient($datestart,$dateend,$lob,$payer_id)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT count(*) AS TotalPatients FROM
	(SELECT * FROM fn_getpatientreg($payer_id)
	WHERE CONVERT(date,RegistrationTime) BETWEEN '".$datestart."' AND '".$dateend."' AND LOB like '%".$lob."%')a";
	$query =  $conn->query($sql);
	return $query->row()->TotalPatients;
	}
	
	function get_patient_history($payer_id, $medcornum=NULL , $patient_name=NULL)
	{
	$conn =$this->load->database($this->set_db(),true);
	$sql = "SELECT TOP 50 MedicalRecordNumber, PatientName, RegistrationCode, RegistrationTime, DoctorName FROM fn_getpatientreg($payer_id) WHERE MedicalRecordNumber = '".$medcornum."' OR  PatientName LIKE '%".$patient_name."%'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
//	function get_identity_details($payer_id, $medcornum=NULL , $patient_name=NULL)
//	{
//	$conn =$this->load->database($this->set_db(),true);
//	$sql = "SELECT TOP 50 MedicalRecordNumber, PatientName, Age, Gender, Address FROM fn_getpatientreg($payer_id) WHERE MedicalRecordNumber = '".$medcornum."' OR  PatientName LIKE '%".$patient_name."%'";
//	$query =  $conn->query($sql);
//	return $query->row();
//	}
	
	function get_patient_tracking($keyword)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT TOP 50 PatientId, MedicalRecordNumber, PatientName FROM (SELECT DISTINCT
dbo.PatientRegs.Id AS PatientRegsId,
dbo.Patients.Id AS PatientId,
dbo.Patients.MedicalRecordNumber,
dbo.Patients.FirstName +' '+dbo.Patients.MiddleName+' '+dbo.Patients.LastName AS PatientName,
DATEDIFF(yy, dbo.Patients.Birthdate, getdate()) AS Age,
dbo.RefGenders.NameValue AS Gender,
dbo.Addresses.AddressDesc AS Address,
dbo.Employees.TitleBeforeName+' '+dbo.Employees.FirstName+' '+dbo.Employees.LastName+' '+dbo.Employees.TitleAfterName AS DoctorName,
dbo.PatientRegs.CodeValue AS RegistrationCode,
dbo.PatientRegs.RegistrationTime

FROM
dbo.PatientRegs
LEFT JOIN dbo.MRDoctorRels ON dbo.PatientRegs.Id = dbo.MRDoctorRels.RegId
LEFT JOIN dbo.Doctors ON dbo.MRDoctorRels.DoctorId = dbo.Doctors.Id
LEFT JOIN dbo.Patients ON dbo.Patients.Id = dbo.PatientRegs.PatientId
LEFT JOIN dbo.Employees ON dbo.Employees.Id = dbo.Doctors.EmployeeId
LEFT JOIN dbo.Addresses ON dbo.patients.Id= dbo.Addresses.PatientId
LEFT JOIN dbo.RefGenders ON dbo.RefGenders.Id = dbo.Patients.GenderId
)a
			WHERE a.MedicalRecordNumber LIKE '%".$keyword."%' OR  PatientName LIKE '%".$keyword."%'";
	$query =  $conn->query($sql);
	return $query->result();
	}

	function patient_details($pat_id) 
	{
	$conn = $this->load->database($this->set_db(),true);
	$conn->where('Id',$pat_id);
	return $conn->get('Patients')->row();
	}
	
	function get_patient_list($pat_id)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "SELECT PatientId, MedicalRecordNumber, PatientName, DoctorsCode, DoctorName, RegistrationCode, Class, AdmisionId, RegistrationTime FROM (SELECT DISTINCT
dbo.PatientRegs.Id AS PatientRegsId,
dbo.Patients.Id AS PatientId,
dbo.Patients.MedicalRecordNumber,
dbo.Patients.FirstName +' '+dbo.Patients.MiddleName+' '+dbo.Patients.LastName AS PatientName,
DATEDIFF(yy, dbo.Patients.Birthdate, getdate()) AS Age,
dbo.RefGenders.NameValue AS Gender,
dbo.Addresses.AddressDesc AS Address,
dbo.Doctors.CodeValue AS DoctorsCode,
dbo.Employees.TitleBeforeName+' '+dbo.Employees.FirstName+' '+dbo.Employees.LastName+' '+dbo.Employees.TitleAfterName AS DoctorName,
dbo.PatientRegs.CodeValue AS RegistrationCode,
dbo.Admissions.id AS AdmisionId,
(SELECT TOP 1 b.NameValue AS Classes FROM dbo.AdmissionDetails a INNER JOIN dbo.PriceListClasses b ON b.Id = a.PriceListClassId
WHERE a.AdmissionId = dbo.Admissions.id AND a.RecordStatus = 1 ) AS Class,
dbo.PatientRegs.RegistrationTime

FROM
dbo.PatientRegs
LEFT JOIN dbo.Admissions ON dbo.Admissions.RegId = dbo.PatientRegs.Id
LEFT JOIN dbo.AdmissionDetails ON dbo.AdmissionDetails.AdmissionId = dbo.Admissions.Id
LEFT JOIN dbo.HuBeds ON dbo.HuBeds.id = dbo.AdmissionDetails.HuBedId
LEFT JOIN dbo.HuRooms ON dbo.HuRooms.Id = dbo.HuBeds.RoomId
LEFT JOIN dbo.PriceListClasses ON dbo.PriceListClasses.id = dbo.HuBeds.PriceListClassId
LEFT JOIN dbo.MRDoctorRels ON dbo.PatientRegs.Id = dbo.MRDoctorRels.RegId
LEFT JOIN dbo.Doctors ON dbo.MRDoctorRels.DoctorId = dbo.Doctors.Id
LEFT JOIN dbo.Patients ON dbo.Patients.Id = dbo.PatientRegs.PatientId
LEFT JOIN dbo.Employees ON dbo.Employees.Id = dbo.Doctors.EmployeeId
LEFT JOIN dbo.Addresses ON dbo.patients.Id= dbo.Addresses.PatientId
LEFT JOIN dbo.RefGenders ON dbo.RefGenders.Id = dbo.Patients.GenderId
)a
	WHERE a.PatientId = '".$pat_id."'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_identity_details($pat_id)
	{
	$conn =$this->load->database($this->set_db(),true);
	$sql = "SELECT * FROM (SELECT DISTINCT
dbo.PatientRegs.Id AS PatientRegsId,
dbo.Patients.Id AS PatientId,
dbo.Patients.MedicalRecordNumber,
dbo.Patients.FirstName +' '+dbo.Patients.MiddleName+' '+dbo.Patients.LastName AS PatientName,
dbo.Patients.Birthdate,
dbo.Patients.Birthplace,
DATEDIFF(yy, dbo.Patients.Birthdate, getdate()) AS Age,
dbo.RefGenders.NameValue AS Gender,
dbo.RefTypes.NameValue AS BloodType,
dbo.Patients.Weight,
dbo.Patients.Height,
dbo.RefEthnicities.NameValue AS Ethnic,
dbo.RefReligions.DescValue AS Religion,
dbo.RefMaritals.NameValue AS Marital,
dbo.RefSalutations.NameValue AS Salutation,
dbo.RefOccupations.DescValue AS Occupation,
dbo.RefEducations.NameValue AS Education,
dbo.Addresses.AddressDesc AS Address,
dbo.RefAreas.AreaName AS Area,
dbo.RefCities.NameValue AS City,
dbo.RefProvinces.NameValue AS Province,
dbo.RefCountries.NameValue AS Country,
dbo.Patients.PhoneNumber,
dbo.Patients.Email,
dbo.RefIdentityCardTypes.NameValue AS IdentityType,
dbo.Patients.IdentityCardbNumber AS IdCardNumber

FROM
dbo.PatientRegs
LEFT JOIN dbo.MRDoctorRels ON dbo.PatientRegs.Id = dbo.MRDoctorRels.RegId
LEFT JOIN dbo.Doctors ON dbo.MRDoctorRels.DoctorId = dbo.Doctors.Id
LEFT JOIN dbo.Patients ON dbo.Patients.Id = dbo.PatientRegs.PatientId
LEFT JOIN dbo.Employees ON dbo.Employees.Id = dbo.Doctors.EmployeeId
LEFT JOIN dbo.Addresses ON dbo.patients.Id= dbo.Addresses.PatientId
LEFT JOIN dbo.RefTypes ON dbo.Patients.BloodTypeId = dbo.RefTypes.Id
LEFT JOIN dbo.RefGenders ON dbo.RefGenders.Id = dbo.Patients.GenderId
LEFT JOIN dbo.RefReligions ON dbo.Patients.ReligionId = dbo.RefReligions.Id
LEFT JOIN dbo.RefEthnicities ON dbo.Patients.EthnicityId = dbo.RefEthnicities.Id
LEFT JOIN dbo.RefMaritals ON dbo.Patients.MaritalId = dbo.RefMaritals.Id
LEFT JOIN dbo.RefSalutations ON dbo.RefSalutations.Id = dbo.Patients.SalutationId
LEFT JOIN dbo.RefOccupations ON dbo.RefOccupations.Id = dbo.Patients.OccupationId
LEFT JOIN dbo.RefEducations ON dbo.RefEducations.Id = dbo.Patients.EducationId
LEFT JOIN dbo.RefCountries ON dbo.RefCountries.Id = dbo.Addresses.CountryId
LEFT JOIN dbo.RefProvinces ON dbo.RefProvinces.Id = dbo.Addresses.ProvinceId
LEFT JOIN dbo.RefAreas ON dbo.RefAreas.Id = dbo.Addresses.AreaId
LEFT JOIN dbo.RefCities ON dbo.RefCities.Id = dbo.Addresses.CityId
LEFT JOIN dbo.RefIdentityCardTypes ON dbo.Patients.IdentityCardTypeId = dbo.RefIdentityCardTypes.Id)a
WHERE a.PatientId = '".$pat_id."'";
	$query =  $conn->query($sql);
	return $query->row();
	}
	
	function get_historical_class($admision_id)
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$sql = " SELECT a.FromDate,a.ToDate,b.NameValue AS Classes,a.RecordStatus  FROM dbo.AdmissionDetails a INNER JOIN dbo.PriceListClasses b ON b.Id = a.PriceListClassId 
	WHERE AdmissionId = $admision_id ORDER By a.FromDate DESC";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
}