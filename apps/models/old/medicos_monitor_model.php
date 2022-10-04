<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Medicos_monitor_model extends CI_Model{
 	
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
	
    function get_patient_transaction($startdate,$enddate)
    {
		$where = '';
		if($startdate != NULL)
		{
		$where = "WHERE	CONVERT(DATE, a.RegistrationTime) BETWEEN '".$startdate."' AND '".$enddate."'";
		}
		
        $this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "
		SELECT TOP 1000 * FROM (
		SELECT DISTINCT 
		b.RegId ,
		a.CodeValue AS RegNo , 
		e.MedicalRecordNumber ,
		e.FirstName + ' ' + e.MiddleName + ' ' + e.LastName AS lastName ,
		a.RegistrationTime ,
		d.CodeValue AS BillNo ,
		d.CreatedOn AS BillCreatedOn ,
		first_gsc.CreatedDate AS FirstGSCInput,
		last_gsc.CreatedDate AS LastGSCInput,
		gsccount.gsctotal ,
		( dbo.f_dateDiffHumanReadable(a.RegistrationTime, d.CreatedOn, DEFAULT) ) AS TAT_BILL ,
		( dbo.f_dateDiffHumanReadable(a.RegistrationTime, f.RecordTime,
									  DEFAULT) ) AS TAT_PAYMENT ,
		DATEDIFF(second,a.RegistrationTime,d.CreatedOn) AS TAT_Second,
		( dbo.f_dateDiffHumanReadable(a.RegistrationTime,
									  first_gsc.CreatedDate, DEFAULT) ) AS RegtoFirstGSC ,
		( dbo.f_dateDiffHumanReadable(first_gsc.CreatedDate,
									  last_gsc.CreatedDate, DEFAULT) ) AS GSCInputTime ,
		( dbo.f_dateDiffHumanReadable(last_gsc.CreatedDate, d.CreatedOn,
									  DEFAULT) ) AS LastGsctoBILL ,
		( dbo.f_dateDiffHumanReadable(d.CreatedOn, f.RecordTime, DEFAULT) ) AS BilltoPayment,		
		d.TotalAmount AS BillAmount,
		d.Discount AS BillDiscount,
		(d.TotalAmount - (d.Discount/100*(d.TotalAmount))) AS BillAmountAfterDiscount 
		FROM	dbo.PatientRegs a 
		LEFT JOIN dbo.GSCDetails b ON a.id = b.RegId 
		LEFT JOIN dbo.GSCSBillRels c ON c.GSCDetailId = b.id 
		LEFT JOIN dbo.Bills d ON d.id = c.BillId 
		LEFT JOIN dbo.Patients e ON e.id = a.PatientId 
		LEFT JOIN dbo.Payments f ON d.id = f.BillId 
		OUTER APPLY ( SELECT TOP 1
								dbo.GSCDetails.CreatedDate
					  FROM		dbo.GSCDetails
					  WHERE		RegId = a.id
								AND dbo.GSCDetails.CreatedDate > a.RegistrationTime
					  ORDER BY	dbo.GSCDetails.CreatedDate ASC
					) AS first_gsc 
		OUTER APPLY ( SELECT TOP 1
								dbo.GSCDetails.CreatedDate
					  FROM		dbo.GSCDetails
					  WHERE		RegId = a.id
					  ORDER BY	dbo.GSCDetails.CreatedDate DESC
					) AS last_gsc 
		OUTER APPLY ( SELECT	COUNT(1) AS gsctotal
					  FROM		dbo.GSCDetails
					  WHERE		RegId = a.id
					) AS gsccount 
		$where ) ddata
		ORDER BY ddata.RegistrationTime DESC 
		";
		$query = $conn->query($sql);
        return $query->result();
    }
	
	function get_throughput_by_lob($startdate,$enddate)
	{
		$where = '';
		if($startdate != NULL)
		{
		$where = "WHERE	CONVERT(DATE, a.RegistrationDate) BETWEEN '".$startdate."' AND '".$enddate."'";
		}
		
        $this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "
		SELECT RegistrationDate,
		CASE WHEN OPD IS NULL THEN 0 ELSE OPD END AS 'OPD', 
		CASE WHEN IPD IS NULL THEN 0 ELSE IPD END AS 'IPD',
		CASE WHEN MCU IS NULL THEN 0 ELSE MCU END AS 'MCU',
		CASE WHEN ETC IS NULL THEN 0 ELSE ETC END AS 'ETC'
		FROM(
		SELECT	RegistrationDate ,LOB,
				COUNT(1) AS TotalPatient
		FROM	( SELECT DISTINCT
							CONVERT(DATE, RegistrationTime) RegistrationDate ,
							LOB ,
							PatientName ,
							Gender ,
							RegistrationCode ,
							PatientsDescription ,
							PatientsCategory
				  FROM		dbo.fn_getpatientreg(700)
				) a
		WHERE	CONVERT(DATE, a.RegistrationDate) BETWEEN '".$startdate."' AND '".$enddate."'
		GROUP BY RegistrationDate ,	LOB)a
		pivot(max(TotalPatient) FOR LOB IN ([ETC],[IPD],[OPD],[MCU])) AS ReportForLOB
		ORDER BY 1 ASC
		";
		$query = $conn->query($sql);
        return $query->result();
	}

	


}