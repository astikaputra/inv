<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Marketing_report_model extends CI_Model{
 	
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

	function get_allrad_service_report($startdate,$enddate)
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
	 	$sql = " SELECT DISTINCT a.OrderDate,a.PhysicianPerformingName As DoctorName,a.PatientFullName,a.PatientGender,a.PatientBirthdate,a.PatientPhoneMobile,a.ItemServiceName,a.ClinicalNotes,b.PhoneNumber,b.Email,b.MedicalRecordNumber,a.RegistrationNo FROM dbo.fn_get_radiology_report('$startdate','$enddate') AS a Outer APPLY (SELECT c.* FROM dbo.Patients c INNER JOIN dbo.PatientRegs d ON c.id = d.PatientId WHERE d.CodeValue = a.RegistrationNo ) AS b ";
		$query = $conn->query($sql);
		return $this->db->query($sql);
		return $query->result();
	}
	
	function get_radiology_service_report($startdate,$enddate,$servcode)
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
		$sql = " SELECT DISTINCT a.OrderDate,a.PhysicianPerformingName As DoctorName,a.PatientFullName,a.PatientGender,a.PatientBirthdate,a.PatientPhoneMobile,a.ItemServiceCode,a.ItemServiceName,a.ClinicalNotes,b.PhoneNumber,b.Email,b.MedicalRecordNumber,a.RegistrationNo FROM dbo.fn_get_radiology_report('$startdate','$enddate') AS a Outer APPLY (SELECT c.* FROM dbo.Patients c INNER JOIN dbo.PatientRegs d ON c.id = d.PatientId WHERE d.CodeValue = a.RegistrationNo ) AS b WHERE a.ItemServiceCode IN (".$servcode.")";
		$query = $conn->query($sql);
		return $query->result();
	}
	
	function get_radiology_servic_report($startdate,$enddate)
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);	
		$sql = " SELECT
dbo.GSCDetails.Note,
convert (DATE ,dbo.GSCDetails.CreatedDate,121) as [Date],
dbo.Patients.Birthdate,
dbo.Patients.FirstName +' '+ dbo.Patients.MiddleName +' '+ dbo.Patients.LastName AS PatientName,
dbo.Employees.TitleBeforeName +' '+ dbo.Employees.FirstName AS Doctor,
dbo.RefGenders.DescValue AS Gender,
dbo.Patients.PhoneNumber,
dbo.Patients.Email,
dbo.PatientRegs.CodeValue AS RegCode,
dbo.Patients.MedicalRecordNumber

FROM
dbo.GSCDetails
INNER JOIN dbo.PatientRegs ON dbo.PatientRegs.Id = dbo.GSCDetails.RegId
INNER JOIN dbo.Patients ON dbo.PatientRegs.PatientId = dbo.Patients.Id
INNER JOIN dbo.Doctors ON dbo.Doctors.Id = dbo.GSCDetails.DoctorId
INNER JOIN dbo.Employees ON dbo.Employees.Id = dbo.Doctors.EmployeeId
INNER JOIN dbo.RefGenders ON dbo.RefGenders.Id = dbo.Patients.GenderId
WHERE
dbo.GSCDetails.HuPackageId IN ((
select distinct PackageId from PackageDetails where ItemServiceId=864
)) AND
dbo.GSCDetails.RegId IN ((select Id from PatientRegs where codevalue like '%MCU%'))
AND convert (DATE ,dbo.GSCDetails.CreatedDate) BETWEEN '".$startdate."' AND '".$enddate."'
ORDER BY date ASC";
		$query = $conn->query($sql);
		return $query->result();
	}
	
	function get_radiology_service_detail($startdate,$enddate,$servcode)
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
		$sql = " SELECT DISTINCT a.ItemServiceCode,a.ItemServiceName FROM dbo.fn_get_radiology_report('$startdate','$enddate') AS a Outer APPLY (SELECT c.* FROM dbo.Patients c INNER JOIN dbo.PatientRegs d ON c.id = d.PatientId WHERE d.CodeValue = a.RegistrationNo ) AS b WHERE a.ItemServiceCode IN (".$servcode.")";
		$query = $conn->query($sql);
		return $query->row();		
	}
	
	function get_radiology_service()
	{
		$this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(),true);
		$sql = " SELECT DISTINCT ItemServiceCode, ItemServiceName FROM fn_get_radiology_report('1999-01-01','2014-02-10');";
		$query = $conn->query($sql);
		return $query->result();
	}
	
	function get_laboratory_service()
	{
		$this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(),true);
		$sql = " SELECT * FROM dbo.ItemServices WHERE dbo.ItemServices.LosesId = '8' ORDER BY ItemServices.Id";
		$query = $conn->query($sql);
		return $query->result();
	}
        
        function get_all_patient_report()
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
	 	$sql = " SELECT DISTINCT FirstName + ' ' + MiddleName + ' ' + LastName AS 'PatientName',
                         (select top 1 AddressDesc from Addresses where PatientId = a.id) Address,
                         (select namevalue from RefCities where Id in (select top 1 CityId from Addresses where PatientId = a.id)) as Cities,
                          Email,
						  b.PhoneNumber + ' , ' + Address2.PhoneNumber AS PhoneNumber,
                          case when identitycardtypeid in (1,2) then 'Indonesia' else
                         (select distinct top 1 rc.namevalue as nationality from
                          patientpassids pp inner join refcountries rc on rc.id= pp.nationality
                          where pp.patientid = a.Id)
                          end as Nationality,
                          CreatedOn,
                          ModifiedOn
                          from
                          Patients a
						  LEFT JOIN dbo.Addresses b ON a.Id = b.PatientId
                          OUTER APPLY (SELECT TOP 1 * FROM dbo.Addresses WHERE TypeId = 2 AND PatientId = a.Id) AS Address2
						  WHERE a.RecordStatus = 1";
		$query = $conn->query($sql);
		return $query->result();
	}
	
	function get_spes_patient_report($idecode)
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
		$sql = " SELECT DISTINCT FirstName + ' ' + MiddleName + ' ' + LastName AS 'PatientName',
                         (select top 1 AddressDesc from Addresses where PatientId = a.id) Address,
                         (select namevalue from RefCities where Id in (select top 1 CityId from Addresses where PatientId = a.id)) as Cities,
                          Email,
						  b.PhoneNumber + ' , ' + Address2.PhoneNumber AS PhoneNumber,
                          case when identitycardtypeid in (1,2) then 'Indonesia' else
                         (select distinct top 1 rc.namevalue as nationality from
                          patientpassids pp inner join refcountries rc on rc.id= pp.nationality
                          where pp.patientid = a.Id)
                          end as Nationality,
                          CreatedOn,
                          ModifiedOn
                          from
                          Patients a
						  LEFT JOIN dbo.Addresses b ON a.Id = b.PatientId
                          OUTER APPLY (SELECT TOP 1 * FROM dbo.Addresses WHERE TypeId = 2 AND PatientId = a.Id) AS Address2
                          WHERE identitycardtypeid IN ($idecode) AND a.RecordStatus = 1";
		$query = $conn->query($sql);
		return $query->result();
	}
	
	function get_ktp_patient_report()
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
		$sql = " SELECT DISTINCT FirstName + ' ' + MiddleName + ' ' + LastName AS 'PatientName',
                         (select top 1 AddressDesc from Addresses where PatientId = a.id) Address,
                         (select namevalue from RefCities where Id in (select top 1 CityId from Addresses where PatientId = a.id)) as Cities,
                          Email,
						  b.PhoneNumber + ' , ' + Address2.PhoneNumber AS PhoneNumber,
                          case when identitycardtypeid in (1,2) then 'Indonesia' else
                         (select distinct top 1 rc.namevalue as nationality from
                          patientpassids pp inner join refcountries rc on rc.id= pp.nationality
                          where pp.patientid = a.Id)
                          end as Nationality,
                          CreatedOn,
                          ModifiedOn
                          from
                          Patients a
						  LEFT JOIN dbo.Addresses b ON a.Id = b.PatientId
                          OUTER APPLY (SELECT TOP 1 * FROM dbo.Addresses WHERE TypeId = 2 AND PatientId = a.Id) AS Address2
                          WHERE identitycardtypeid IN ('1') AND a.RecordStatus = 1";
		$query = $conn->query($sql);
		return $query->result();
	}
	
	function get_no_identity_report()
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
		$sql = " 	SELECT DISTINCT FirstName + ' ' + MiddleName + ' ' + LastName AS 'PatientName',
                         (select top 1 AddressDesc from Addresses where PatientId = a.id) Address,
                         (select namevalue from RefCities where Id in (select top 1 CityId from Addresses where PatientId = a.id)) as Cities,
                          Email,
						  b.PhoneNumber + ' , ' + Address2.PhoneNumber AS PhoneNumber,
                          case when identitycardtypeid in (1,2) then 'Indonesia' else
                         (select distinct top 1 rc.namevalue as nationality from
                          patientpassids pp inner join refcountries rc on rc.id= pp.nationality
                          where pp.patientid = a.Id)
                          end as Nationality,       
                          CreatedOn,
                          ModifiedOn
                          from
                          Patients a
						  LEFT JOIN dbo.Addresses b ON a.Id = b.PatientId
                          OUTER APPLY (SELECT TOP 1 * FROM dbo.Addresses WHERE TypeId = 2 AND PatientId = a.Id) AS Address2
                          WHERE identitycardtypeid IS NULL AND a.RecordStatus = 1";
		$query = $conn->query($sql);
		return $query->result();
	}
        
        function get_identity_card_type()
        {
                $this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(),true);
 		$sql = " SELECT DISTINCT identitycardtypeid,
                          RefIdentityCardTypes.NameValue AS IdentityType
                          from
                          Patients
                          LEFT JOIN RefIdentityCardTypes ON IdentityCardTypeId = RefIdentityCardTypes.Id WHERE identitycardtypeid IS NOT NULL ORDER BY identitycardtypeid ASC";
		$query = $conn->query($sql);
		return $query->result();               
        }
       
        function get_identity_card_detail($servcode)
        {
                $this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(),true);
 		$sql = " SELECT DISTINCT identitycardtypeid,
                          RefIdentityCardTypes.NameValue AS IdentityType
                          from
                          Patients
                          LEFT JOIN RefIdentityCardTypes ON IdentityCardTypeId = RefIdentityCardTypes.Id WHERE identitycardtypeid IS NOT NULL AND identitycardtypeid = '".$servcode."'  ORDER BY identitycardtypeid ASC";
		$query = $conn->query($sql);
		return $query->row();               
        }
        
        
        
	
}