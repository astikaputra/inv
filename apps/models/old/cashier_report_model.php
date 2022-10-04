<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Cashier_report_model extends CI_Model {

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
	
	
	function get_deposit_report()
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
		$sql = " SELECT
	B.Id AS RegId,
	B.CodeValue AS RegNum,
	A.Id AS AdmissionId,
	A.AdmitDate,
	F.CodeValue AS RoomName,
	E.NameValue AS BedName,
	I.NameValue AS Class,
	C.FirstName +' '+C.MiddleName+' '+C.LastName AS PatientName,
	C.MedicalRecordNumber AS MRNum,
	J.NameValue AS IdentityType,
	CONVERT (
		DECIMAL (18, 2),
		(
			SELECT
				SUM (Amount) AS Amount
			FROM
				dbo.Deposits AS D
			WHERE
				(InOut = 0)
			AND (AdmissionId = A.Id)
		) - ISNULL(
			(
				SELECT
					SUM (Amount) AS Amount
				FROM
					dbo.Deposits AS D
				WHERE
					(InOut = 1)
				AND (AdmissionId = A.Id)
			),
			0
		)
	) AS AmmountDeposit,
	CONVERT (
		DECIMAL (18, 2),
		ISNULL(
			(
				SELECT
					SUM (
						dbo.UDF_Discount (
							(Cost + CostPayer) * Qty,
							ISNULL(Discount, 0)
						)
					) AS Expr1
				FROM
					dbo.GSCDetails
				WHERE
					(RegId = B.Id)
			),
			0
		)
	) AS AmmountUsed,
	(CONVERT (
		DECIMAL (18, 2),
		(
			SELECT
				SUM (Amount) AS Amount
			FROM
				dbo.Deposits AS D
			WHERE
				(InOut = 0)
			AND (AdmissionId = A.Id)
		) - ISNULL(
			(
				SELECT
					SUM (Amount) AS Amount
				FROM
					dbo.Deposits AS D
				WHERE
					(InOut = 1)
				AND (AdmissionId = A.Id)
			),
			0
		)
	)-	CONVERT (
		DECIMAL (18, 2),
		ISNULL(
			(
				SELECT
					SUM (
						dbo.UDF_Discount (
							(Cost + CostPayer) * Qty,
							ISNULL(Discount, 0)
						)
					) AS Expr1
				FROM
					dbo.GSCDetails
				WHERE
					(RegId = B.Id)
			),
			0
		)
	)) AS Remaining,  
	B.IsDischarge,
	B.RecordStatus
FROM
	dbo.Admissions AS A
INNER JOIN dbo.PatientRegs AS B ON B.Id = A.RegId
INNER JOIN dbo.Patients AS C ON B.PatientId = C.Id
LEFT JOIN dbo.HuBeds AS E ON A.HuBedId = E.Id
LEFT JOIN dbo.HuRooms AS F ON E.RoomId = F.Id
LEFT JOIN dbo.HuWards AS G ON F.WardId = G.Id
LEFT JOIN dbo.RefBedTypes AS H ON G.Id = H.Id
LEFT JOIN dbo.PriceListClasses AS I ON E.PriceListClassId = I.Id
LEFT JOIN dbo.RefIdentityCardTypes AS J ON C.IdentityCardTypeId = J.Id
WHERE
	(
		A.Id IN (
			SELECT
				AdmissionId
			FROM
				dbo.Deposits AS Deposits_1
		)
	)  AND CONVERT (
		DECIMAL (18, 2),
		(
			SELECT
				SUM (Amount) AS Amount
			FROM
				dbo.Deposits AS D
			WHERE
				(InOut = 0)
			AND (AdmissionId = A.Id)
		) - ISNULL(
			(
				SELECT
					SUM (Amount) AS Amount
				FROM
					dbo.Deposits AS D
				WHERE
					(InOut = 1)
				AND (AdmissionId = A.Id)
			),
			0
		)
	) != .00
	";
		$query = $conn->query($sql);
		return $query->result();
	}
	
	function get_deposit_detail_list($regid)
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
		$sql = " SELECT
	RegId,
	RegNumber,
	PatientName,
	MedicalRecordNumber,
	AmmountDeposit,
	DepositUsed,
	Cost,
	CostPayer,
	Category,
	Qty,
	Discount,
	(Cost*Qty) AS Amount,
	CategoryName
	FROM 
	VGSCDetailsDepositUsed
	WHERE
	RegId = '".$regid."'";
		$query = $conn->query($sql);
		return $query->result();
	}

	function get_deposit_detail($regid)
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
		$sql = " SELECT
	B.Id AS RegId,
	B.CodeValue AS RegNumber,
	A.Id AS AdmissionId,
	C.FirstName + ' ' + C.MiddleName + ' ' + C.LastName AS PatientName,
	C.Birthdate,
	DATEDIFF(yy, C.Birthdate, getdate()) AS Age,
	CAST(DATEDIFF(yy, C.Birthdate, getdate()) AS varchar(4)) +' year '+
	CAST(DATEDIFF(mm, DATEADD(yy, DATEDIFF(yy, C.Birthdate, getdate()), C.Birthdate), getdate()) AS varchar(2)) +' month '+
	CAST(DATEDIFF(dd, DATEADD(mm, DATEDIFF(mm, DATEADD(yy, DATEDIFF(yy, C.Birthdate, getdate()), C.Birthdate), getdate()), DATEADD(yy, DATEDIFF(yy, C.Birthdate, getdate()), C.Birthdate)), getdate()) AS varchar(2)) +' day' AS AgeDetail,
	F.NameValue AS Gender,
	E.NameValue AS BloodType,
	C.MedicalRecordNumber,
	G.NameValue AS PayerInstitution,
	CONVERT (
		DECIMAL (18, 2),
		(
			SELECT
				SUM (Amount) AS Amount
			FROM
				dbo.Deposits AS D
			WHERE
				(InOut = 0)
			AND (AdmissionId = A.Id)
		) - ISNULL(
			(
				SELECT
					SUM (Amount) AS Amount
				FROM
					dbo.Deposits AS D
				WHERE
					(InOut = 1)
				AND (AdmissionId = A.Id)
			),
			0
		)
	) AS AmmountDeposit,
	CONVERT (
		DECIMAL (18, 2),
		ISNULL(
			(
				SELECT
					SUM (
						dbo.UDF_Discount (
							(Cost + CostPayer) * Qty,
							ISNULL(Discount, 0)
						)
					) AS Expr1
				FROM
					dbo.GSCDetails
				WHERE
					(RegId = B.Id)
			),
			0
		)
	) AS DepositUsed,
(CONVERT (
		DECIMAL (18, 2),
		(
			SELECT
				SUM (Amount) AS Amount
			FROM
				dbo.Deposits AS D
			WHERE
				(InOut = 0)
			AND (AdmissionId = A.Id)
		) - ISNULL(
			(
				SELECT
					SUM (Amount) AS Amount
				FROM
					dbo.Deposits AS D
				WHERE
					(InOut = 1)
				AND (AdmissionId = A.Id)
			),
			0
		)
	) -
	CONVERT (
		DECIMAL (18, 2),
		ISNULL(
			(
				SELECT
					SUM (
						dbo.UDF_Discount (
							(Cost + CostPayer) * Qty,
							ISNULL(Discount, 0)
						)
					) AS Expr1
				FROM
					dbo.GSCDetails
				WHERE
					(RegId = B.Id)
			),
			0
		)
	)) AS Remaining,
	B.IsDischarge,
	B.RecordStatus
FROM
	dbo.Admissions AS A
INNER JOIN dbo.PatientRegs AS B ON A.RegId = B.Id
INNER JOIN dbo.Patients AS C ON C.Id = B.PatientId
LEFT JOIN dbo.RefTypes AS E ON C.BloodTypeId = E.Id
LEFT JOIN dbo.RefGenders AS F ON C.GenderId = F.Id
LEFT JOIN dbo.Institutions AS G ON G.Id = C.PrimaryPayerId
WHERE
	(
		A.Id IN (
			SELECT
				AdmissionId
			FROM
				dbo.Deposits AS Deposits_1
		)
	)
AND B.Id = '".$regid."'";
		$query = $conn->query($sql);
		return $query->row();
	}
	
	function get_deposit_log($regid)
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
		$sql = "SELECT
	A.Id,
	CONVERT (DATE, A.CreatedOn) AS DepositDate,
	A.CreatedOn AS DepositTime,
	A.Amount,
	D.FirstName + ' ' + D.MiddleName + ' ' + D.LastName AS PatientName,
	B.RegId,
	C.CodeValue AS RegistrationNumber,
	A.PaidBy,
	A.CardNumber,
	A.EDCNumber,
	E.NameValue,
	B.AdmitDate,
	F.EmployeeName,
	A.CreatedBy,
	A.InOut,
	CONVERT (DATE, A.DepositDate) AS DateRefund,
	A.IsDepositRefund,
	H.NameValue AS BedType
FROM
	dbo.Deposits AS A
INNER JOIN dbo.Admissions AS B ON A.AdmissionId = B.Id
INNER JOIN dbo.PatientRegs AS C ON C.Id = B.RegId
INNER JOIN dbo.Patients AS D ON D.Id = C.PatientId
LEFT OUTER JOIN dbo.RefPaymentMethods AS E ON A.PaymentMethodId = E.Id
INNER JOIN dbo.VMemberLogin AS F ON A.CreatedBy = F.UserId
INNER JOIN dbo.AdmissionDetails AS G ON B.Id = G.AdmissionId
INNER JOIN dbo.PriceListClasses AS H ON G.PriceListClassId = H.Id
WHERE G.RecordStatus = 1
AND B.RegId = '".$regid."'";
		$query = $conn->query($sql);
		return $query->result();
	}
	
	function get_deposit_log_export($regid)
	{
		$this->set_db();
		$conn = $this->load->database($this->set_db(),true);
		$sql = "SELECT
	--A.Id,
	CONVERT (DATE, A.CreatedOn) AS DepositDate,
	A.CreatedOn AS DepositTime,
	A.Amount,
	D.FirstName + ' ' + D.MiddleName + ' ' + D.LastName AS PatientName,
	B.RegId,
	C.CodeValue AS RegistrationNumber,
	A.PaidBy,
	A.CardNumber,
	A.EDCNumber,
	E.NameValue,
	B.AdmitDate,
	F.EmployeeName,
	A.CreatedBy,
	A.InOut,
	CONVERT (DATE, A.DepositDate) AS DateRefund,
	A.IsDepositRefund,
	H.NameValue AS BedType
FROM
	dbo.Deposits AS A
INNER JOIN dbo.Admissions AS B ON A.AdmissionId = B.Id
INNER JOIN dbo.PatientRegs AS C ON C.Id = B.RegId
INNER JOIN dbo.Patients AS D ON D.Id = C.PatientId
LEFT OUTER JOIN dbo.RefPaymentMethods AS E ON A.PaymentMethodId = E.Id
INNER JOIN dbo.VMemberLogin AS F ON A.CreatedBy = F.UserId
INNER JOIN dbo.AdmissionDetails AS G ON B.Id = G.AdmissionId
INNER JOIN dbo.PriceListClasses AS H ON G.PriceListClassId = H.Id
WHERE G.RecordStatus = 1
AND B.RegId  = '".$regid."'";
		 $query = $conn->query($sql);
	  	return $query;
	}
	
}