<?php

class Bill_model extends CI_Model {
	
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

	
//---------------------------------------------------- Start Item Module -------------------------------------------


	function get_unclosed_patient($keyword)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT TOP(20)* FROM 
			(SELECT Patients.Id ,Patients.MedicalRecordNumber,
			RefLobs.CodeValue AS  'LOB',Patients.FirstName+' '+Patients.MiddleName+' '+Patients.LastName As 'PatientName',
			PatientRegs.CodeValue As RegCode,PatientRegs.RegistrationTime,PatientRegs.CreatedBy
			FROM PatientRegs
			INNER JOIN Patients ON Patients.Id = PatientRegs.PatientId
			INNER JOIN HuLobRels ON HuLobRels.Id = PatientRegs.HuLobRelId
			INNER JOIN RefLobs ON RefLobs.Id = HuLobRels.LineOffBusinessUnitID
			WHERE dbo.PatientRegs.RecordStatus = '1') a WHERE a.PatientName Like '%".$keyword."%' OR a.MedicalRecordNumber like '%".$keyword."%'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_billdetail_patient($keyword)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT TOP(100)* FROM 
			(SELECT DISTINCT PR.Id AS 'RegId',
      B.Id AS 'BillId',
	 CASE WHEN patientlookup.RegistrationNumber IS NULL
             THEN 'Retail Patient'
             ELSE patientlookup.RegistrationNumber
      END AS RegCode,
      B.CodeValue As BillNo,
			RL.CodeValue AS 'LOB',
      CASE WHEN patientlookup.PatientName IS NULL
             THEN retailpatientlookup.PatientName
             ELSE patientlookup.PatientName
      END AS PatientName ,
      PR.RegistrationTime,
      PR.CreatedBy
FROM Bills B
      LEFT JOIN GSCSBillRels GR ON GR.BillId = B.Id
      LEFT JOIN GSCDetails G ON G.Id = GR.GSCDetailId
      LEFT JOIN PatientRegs PR ON PR.Id = G.RegId
  		LEFT JOIN HuLobRels H ON H.Id = PR.HuLobRelId
			LEFT JOIN RefLobs RL ON RL.Id = H.LineOffBusinessUnitID
		OUTER APPLY ( SELECT TOP 1
                                pr.id AS RegId ,
                                pr.CodeValue AS RegistrationNumber ,
                                pa.FirstName + ' ' + pa.MiddleName + ' '
                                + pa.LastName AS PatientName
                      FROM      dbo.PatientRegs pr
                                INNER JOIN dbo.Patients pa ON pa.id = pr.PatientId
                                INNER JOIN dbo.GSCDetails gsc ON pr.id = gsc.RegId
                                INNER JOIN dbo.GSCSBillRels gscb ON gsc.id = gscb.GSCDetailId
                      WHERE  gscb.BillId = B.Id
                    ) patientlookup
        OUTER APPLY ( SELECT TOP 1
                                NULL AS RegId ,
                                'RETAIL PATIENT' AS RegistationNumber ,
                                rp.FirstName + ' ' + rp.LastName AS PatientName
                      FROM      dbo.PrescriptionQueueBillRels pqb
                                INNER JOIN dbo.PrescriptionQueueDetails pqd ON pqd.id = pqb.PrescriptionQueueDetailId
                                                              AND pqb.BillId = B.Id
                                INNER JOIN dbo.RetailPatients rp ON rp.id = pqd.RetailPatientId
                    ) retailpatientlookup
					WHERE patientlookup.RegistrationNumber IS NOT NULL AND RL.CodeValue = 'IPD'
					)PatDet WHERE PatDet.PatientName Like '%".$keyword."%' OR PatDet.RegCode like '%".$keyword."%'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_reg_bill($bill_id, $reg_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT TOP(1)* FROM 
			(SELECT DISTINCT PR.Id AS 'RegId',
      B.Id AS 'BillId',
	 CASE WHEN patientlookup.RegistrationNumber IS NULL
             THEN 'Retail Patient'
             ELSE patientlookup.RegistrationNumber
      END AS RegCode,
      B.CodeValue As BillNo,
			RL.CodeValue AS 'LOB',
      CASE WHEN patientlookup.PatientName IS NULL
             THEN retailpatientlookup.PatientName
             ELSE patientlookup.PatientName
      END AS PatientName ,
      PR.RegistrationTime,
      PR.CreatedBy
	FROM Bills B
      LEFT JOIN GSCSBillRels GR ON GR.BillId = B.Id
      LEFT JOIN GSCDetails G ON G.Id = GR.GSCDetailId
      LEFT JOIN PatientRegs PR ON PR.Id = G.RegId
			LEFT JOIN Patients P ON P.Id = PR.PatientId
  		LEFT JOIN HuLobRels H ON H.Id = PR.HuLobRelId
			LEFT JOIN RefLobs RL ON RL.Id = H.LineOffBusinessUnitID
		OUTER APPLY ( SELECT TOP 1
                                pr.id AS RegId ,
                                pr.CodeValue AS RegistrationNumber ,
                                pa.FirstName + ' ' + pa.MiddleName + ' '
                                + pa.LastName AS PatientName
                      FROM      dbo.PatientRegs pr
                                INNER JOIN dbo.Patients pa ON pa.id = pr.PatientId
                                INNER JOIN dbo.GSCDetails gsc ON pr.id = gsc.RegId
                                INNER JOIN dbo.GSCSBillRels gscb ON gsc.id = gscb.GSCDetailId
                      WHERE  gscb.BillId = B.Id
                    ) patientlookup
        OUTER APPLY ( SELECT TOP 1
                                NULL AS RegId ,
                                'RETAIL PATIENT' AS RegistationNumber ,
                                rp.FirstName + ' ' + rp.LastName AS PatientName
                      FROM      dbo.PrescriptionQueueBillRels pqb
                                INNER JOIN dbo.PrescriptionQueueDetails pqd ON pqd.id = pqb.PrescriptionQueueDetailId
                                                              AND pqb.BillId = B.Id
                                INNER JOIN dbo.RetailPatients rp ON rp.id = pqd.RetailPatientId
                    ) retailpatientlookup
					WHERE patientlookup.RegistrationNumber IS NOT NULL AND RL.CodeValue = 'IPD'
					)PatDet WHERE PatDet.BillId Like '%".$bill_id."%' AND PatDet.RegId like '%".$reg_id."%'";
	$query =  $conn->query($sql);
	return $query->row();
	}

	function get_reopen_bill_update($bill_id, $reg_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "BEGIN TRANSACTION

				UPDATE B
				SET 
				B.RecordStatus = 0
				FROM Bills B
				WHERE B.Id = '".$bill_id."'

				UPDATE GR
				SET 
				GR.RecordStatus = 0
				FROM GSCSBillRels GR
				WHERE GR.BillId = '".$bill_id."'

				UPDATE PR
				SET 
				PR.RecordStatus = 1
				FROM PatientRegs PR
				WHERE PR.Id = '".$reg_id."'

				UPDATE ADL
				SET 
				ADL.RecordStatus = 1
				FROM AdmissionDetails ADL 
				LEFT JOIN Admissions AD ON AD.Id = ADL.AdmissionId
				WHERE AD.RegId = '".$reg_id."'

				DELETE FROM Payments
				WHERE BillId='".$bill_id."' AND InstitutionId IS NULL

				COMMIT";
	$query =  $conn->query($sql);
	return $query->result();
	}	
	
	function get_detail_patient($patient_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT TOP(1)* FROM 
			(SELECT Patients.Id ,Patients.MedicalRecordNumber,
			RefLobs.CodeValue AS  'LOB',Patients.FirstName+' '+Patients.MiddleName+' '+Patients.LastName As 'PatientName'
			FROM PatientRegs
			INNER JOIN Patients ON Patients.Id = PatientRegs.PatientId
			INNER JOIN HuLobRels ON HuLobRels.Id = PatientRegs.HuLobRelId
			INNER JOIN RefLobs ON RefLobs.Id = HuLobRels.LineOffBusinessUnitID
			WHERE dbo.PatientRegs.RecordStatus = '1') a WHERE a.Id = '".$patient_id."'";
	$query =  $conn->query($sql);
	return $query->row();
	}
	
	function get_gscdetail($patient_id,$lob)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT GSCDetails.ItemId,GSCDetails.ItemServiceId,GSCDetails.NameValue,GSCDetails.Category,GSCDetails.Qty,GSCDetails.Cost,GSCDetails.CreatedDate,
	RefLobs.NameValue AS LOB,PatientRegs.PatientId,PatientRegs.CodeValue AS PatientRegCode
	FROM PatientRegs
	LEFT JOIN GSCDetails ON GSCDetails.RegId = PatientRegs.Id
	LEFT JOIN HuLobRels ON HuLobRels.Id = PatientRegs.HuLobRelId
	LEFT JOIN RefLobs ON RefLobs.Id = HuLobRels.LineOffBusinessUnitID
	WHERE RefLobs.NameValue like '%".$lob."%' AND PatientRegs.PatientId = '".$patient_id."'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	//---------------------------------Tracking Item---------------------------------------------
	function get_bill($code)
	{
	
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT TOP 100 * FROM (
SELECT d.CodeValue AS patient_reg_no,
CASE d.RecordStatus WHEN 1 THEN 'Active' ELSE 'Non Active' END AS RecordStatus,
Patients.FirstName+' '+Patients.MiddleName+' '+Patients.LastName As PatientName,
Patients.MedicalRecordNumber,
d.Id AS reg_id
FROM
dbo.PatientRegs AS d 
INNER JOIN dbo.Patients ON d.PatientId = dbo.Patients.Id
)registerdata
WHERE 
patient_reg_no like '%".$code."%' OR PatientName like '%".$code."%' OR MedicalRecordNumber like '%".$code."%'
ORDER BY reg_id DESC
";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	//--------------------------------- Update Items -------------------------------------------------
	
	function set_deactivate_billing($reg_code)
	{
	$user = $this->session->userdata('HISUser');
		if($this->session->userdata('HISUser')==NULL)
		{$user = $this->session->userdata('user').'';}
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$BeforeValue = json_encode($conn->get_where('PatientRegs',array('Id'=>$reg_code))->row());
	$sql = "UPDATE PatientRegs SET RecordStatus=0 WHERE Id='".$reg_code."'";
	$query =  $conn->query($sql);
	$log = array(
				'CurrentValue' => json_encode($conn->get_where('PatientRegs',array('Id'=>$reg_code))->row()),
				'TableName' =>'PatientReg',
				'RecordId' => $reg_code,
				'UserId' => $user.'- Supporting Tools',
				'ColumnName' => 'RecordStatus', //column change when data overide
				'BeforeValue'=> $BeforeValue,
				'EventDateUTC'=> date('Y-m-d H:i:s',time()),
				'EventType'=>'M'
				);
	$conn->insert('SysLogs',$log);

	}
	
	function set_activate_billing($reg_code)
	{
		$user = $this->session->userdata('HISUser');
		if($this->session->userdata('HISUser')==NULL)
		{$user = $this->session->userdata('user').'';}
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$BeforeValue = json_encode($conn->get_where('PatientRegs',array('Id'=>$reg_code))->row());
	$sql = "UPDATE PatientRegs SET RecordStatus=1 WHERE Id='".$reg_code."'";
	$query =  $conn->query($sql);
	$log = array(
				'CurrentValue' => json_encode($conn->get_where('PatientRegs',array('Id'=>$reg_code))->row()),
				'TableName' =>'PatientReg',
				'RecordId' => $reg_code,
				'UserId' => $user.'- Supporting Tools',
				'ColumnName' => 'RecordStatus', //column change when data overide
				'BeforeValue'=> $BeforeValue,
				'EventDateUTC'=> date('Y-m-d H:i:s',time()),
				'EventType'=>'M'
				);
	$conn->insert('SysLogs',$log);

	}

	function get_outstanding_bill($startdate, $enddate)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT
	AA.regid,
	AA.RegCode,
	AA.pasien
FROM
	(SELECT DISTINCT
			b.Id AS regid,
			b.CodeValue AS RegCode,
			d.Id AS billid,
			d.IsSettle,
			d.CodeValue AS BillCode,
			e.FirstName + ' ' + e.MiddleName + ' ' + e.LastName AS pasien,
			d.RecordStatus,
			(
				SELECT
					TOP 1 replace(NameValue, '-', '')
				FROM
					institutions
				WHERE
					Id = a.RemInstitutionId
			) AS payer,
			d.BillDate,
			d.TotalAmount,
			d.Discount,
			f.Id AS AdmissionId
			--Bills.TotalAmount - d.Amount - (Bills.Discount/100 * dbo.Bills.TotalAmount) Balances 
			FROM dbo.GSCDetails a
			INNER JOIN dbo.PatientRegs b ON b.Id = a.RegId
			INNER JOIN dbo.GSCSBillRels c ON c.GSCDetailId = a.Id 
			INNER JOIN dbo.Bills d ON d.Id = c.BillId  
			INNER JOIN dbo.Patients e ON e.Id = b.PatientId
			LEFT JOIN dbo.Admissions f ON f.RegId = b.Id 
			--LEFT JOIN dbo.Deposits d ON d.AdmissionId = a.Id 
			WHERE not exists (select 1 from payments where billid = d.id) 
			AND d.RecordStatus = 1 
			AND c.RecordStatus = 1 
			AND d.BillDate BETWEEN '".$startdate."' AND '".$enddate."')AA --WHERE AA.regid = '12172'
	GROUP BY 
	AA.regid,
	AA.RegCode,
	AA.pasien";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_outbill_detail($reg_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn = $this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT 
dbo.PatientRegs.Id as regid,
dbo.Bills.Id as billid,
dbo.Bills.CodeValue AS BillCode,
ROUND(dbo.Bills.TotalAmount,0) AS TotalAmount
FROM
dbo.GSCDetails
INNER JOIN dbo.PatientRegs ON dbo.GSCDetails.RegId = dbo.PatientRegs.Id
INNER JOIN dbo.GSCSBillRels ON dbo.GSCSBillRels.GSCDetailId = dbo.GSCDetails.Id
INNER JOIN dbo.Bills ON dbo.GSCSBillRels.BillId = dbo.Bills.Id
--INNER JOIN dbo.Patients ON dbo.PatientRegs.PatientId = dbo.Patients.Id
--LEFT JOIN dbo.Admissions a on a.RegId = PatientRegs.Id
WHERE
not exists (select 1 from payments where billid = dbo.Bills.id) AND
dbo.Bills.RecordStatus = 1
AND dbo.PatientRegs.Id = '".$reg_id."'
AND dbo.GSCSBillRels.RecordStatus = 1";
	$query =  $conn->query($sql);
	return $query->result();
	}

	function get_outbill_payer($reg_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn = $this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT 
dbo.PatientRegs.Id as regid,
CASE WHEN (select top 1 replace(NameValue,'-','') from institutions where Id= dbo.GSCDetails.RemInstitutionId) IS NULL THEN 'Personal' ELSE (select top 1 replace(NameValue,'-','') from institutions where Id= dbo.GSCDetails.RemInstitutionId) END AS payer,
dbo.Bills.TotalAmount
FROM
dbo.GSCDetails
INNER JOIN dbo.PatientRegs ON dbo.GSCDetails.RegId = dbo.PatientRegs.Id
INNER JOIN dbo.GSCSBillRels ON dbo.GSCSBillRels.GSCDetailId = dbo.GSCDetails.Id
INNER JOIN dbo.Bills ON dbo.GSCSBillRels.BillId = dbo.Bills.Id
--INNER JOIN dbo.Patients ON dbo.PatientRegs.PatientId = dbo.Patients.Id
--LEFT JOIN dbo.Admissions a on a.RegId = PatientRegs.Id
WHERE
not exists (select 1 from payments where billid = dbo.Bills.id) AND
dbo.Bills.RecordStatus = 1
AND dbo.PatientRegs.Id = '".$reg_id."'
AND dbo.GSCSBillRels.RecordStatus = 1";
	$query =  $conn->query($sql);
	return $query->result();
	}

	function count_total_bill($reg_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn = $this->load->database($this->set_db(),true);
	$sql = "SELECT SUM(a.TotalAmount) AS GrandTotAmount FROM
(SELECT DISTINCT 
patientregs.Id as regid,
Bills.Id as billid,
dbo.Bills.CodeValue AS BillCode,
CASE WHEN (select top 1 replace(NameValue,'-','') from institutions where Id= dbo.GSCDetails.RemInstitutionId) IS NULL THEN 'Personal' ELSE (select top 1 replace(NameValue,'-','') from institutions where Id= dbo.GSCDetails.RemInstitutionId) END AS payer,
ROUND(dbo.Bills.TotalAmount,0) AS TotalAmount
FROM
dbo.GSCDetails
INNER JOIN dbo.PatientRegs ON dbo.GSCDetails.RegId = dbo.PatientRegs.Id
INNER JOIN dbo.GSCSBillRels ON dbo.GSCSBillRels.GSCDetailId = dbo.GSCDetails.Id
INNER JOIN dbo.Bills ON dbo.GSCSBillRels.BillId = dbo.Bills.Id
INNER JOIN dbo.Patients ON dbo.PatientRegs.PatientId = dbo.Patients.Id
LEFT JOIN dbo.Admissions a on a.RegId = PatientRegs.Id
WHERE
not exists (select 1 from payments where billid = bills.id) AND
dbo.Bills.RecordStatus = 1
and PatientRegs.Id= '".$reg_id."'
AND GSCSBillRels.RecordStatus = 1
GROUP BY 
patientregs.Id,
Bills.Id,
dbo.Bills.CodeValue,
dbo.GSCDetails.RemInstitutionId,
dbo.Bills.TotalAmount
) a";
	$query =  $conn->query($sql);
	return $query->result();
	}

	function count_total_deposit($reg_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn = $this->load->database($this->set_db(),true);
	$sql = "SELECT (SELECT SUM (ROUND(Amount,0))FROM Deposits WHERE admissionid = BB.AdmissionId) AS GrandTotDeposit FROM
(SELECT DISTINCT 
patientregs.Id as regid,
Bills.Id as billid,
dbo.Bills.CodeValue AS BillCode,
a.Id AS AdmissionId,
CASE WHEN (select top 1 replace(NameValue,'-','') from institutions where Id= dbo.GSCDetails.RemInstitutionId) IS NULL THEN 'Personal' ELSE (select top 1 replace(NameValue,'-','') from institutions where Id= dbo.GSCDetails.RemInstitutionId) END AS payer	
FROM
dbo.GSCDetails
INNER JOIN dbo.PatientRegs ON dbo.GSCDetails.RegId = dbo.PatientRegs.Id
INNER JOIN dbo.GSCSBillRels ON dbo.GSCSBillRels.GSCDetailId = dbo.GSCDetails.Id
INNER JOIN dbo.Bills ON dbo.GSCSBillRels.BillId = dbo.Bills.Id
INNER JOIN dbo.Patients ON dbo.PatientRegs.PatientId = dbo.Patients.Id
LEFT JOIN dbo.Admissions a on a.RegId = PatientRegs.Id
WHERE
not exists (select 1 from payments where billid = bills.id) AND
dbo.Bills.RecordStatus = 1
and PatientRegs.Id= '".$reg_id."'
AND GSCSBillRels.RecordStatus = 1
GROUP BY 
patientregs.Id,
Bills.Id,
dbo.Bills.CodeValue,
dbo.GSCDetails.RemInstitutionId,
a.Id
)BB GROUP BY BB.AdmissionId";
	$query =  $conn->query($sql);
	return $query->result();
	}

	function count_total_discount($reg_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn = $this->load->database($this->set_db(),true);
	$sql = "SELECT (ROUND(BB.Discount,0) / 100 * ROUND(BB.TotalAmount,0)) AS GrandTotDiscount FROM
(SELECT DISTINCT 
patientregs.Id as regid,
Bills.Id as billid,
dbo.Bills.CodeValue AS BillCode,
a.Id AS AdmissionId,
CASE WHEN (select top 1 replace(NameValue,'-','') from institutions where Id= dbo.GSCDetails.RemInstitutionId) IS NULL THEN 'Personal' ELSE (select top 1 replace(NameValue,'-','') from institutions where Id= dbo.GSCDetails.RemInstitutionId) END AS payer,	
ROUND(Bills.Discount,0) AS Discount,
ROUND(Bills.TotalAmount,0) AS TotalAmount
FROM
dbo.GSCDetails
INNER JOIN dbo.PatientRegs ON dbo.GSCDetails.RegId = dbo.PatientRegs.Id
INNER JOIN dbo.GSCSBillRels ON dbo.GSCSBillRels.GSCDetailId = dbo.GSCDetails.Id
INNER JOIN dbo.Bills ON dbo.GSCSBillRels.BillId = dbo.Bills.Id
INNER JOIN dbo.Patients ON dbo.PatientRegs.PatientId = dbo.Patients.Id
LEFT JOIN dbo.Admissions a on a.RegId = PatientRegs.Id
WHERE
not exists (select 1 from payments where billid = Bills.id) 
AND dbo.Bills.RecordStatus = 1
and PatientRegs.Id= '".$reg_id."'
AND GSCSBillRels.RecordStatus = 1
GROUP BY 
patientregs.Id,
Bills.Id,
dbo.Bills.CodeValue,
dbo.GSCDetails.RemInstitutionId,
a.Id,
dbo.Bills.Discount,
dbo.Bills.TotalAmount
)BB";
	$query =  $conn->query($sql);
	return $query->result();
	}

	function get_deposit_bill($startdate, $enddate)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT
patientregs.Id as regid,
dbo.PatientRegs.CodeValue AS RegCode,
Bills.Id as billid,
bills.IsSettle,
dbo.Bills.CodeValue AS BillCode,
dbo.Patients.FirstName +' '+ dbo.Patients.MiddleName +' '+dbo.Patients.LastName AS pasien,
dbo.Bills.RecordStatus,
(select top 1 replace(NameValue,'-','') from institutions where Id= GSCDetails.RemInstitutionId) AS payer,
dbo.Bills.BillDate,
ROUND(dbo.Bills.TotalAmount,0) AS TotalAmount,
d.DepositDate,
(select sum(Amount) from Deposits where admissionid = a.id) as deposit,
ROUND(Bills.Discount,0) AS Discount,
(ROUND(Bills.Discount,0)/100 * ROUND(dbo.Bills.TotalAmount,0)) totalDiscount
--Bills.TotalAmount - d.Amount - (Bills.Discount/100 * dbo.Bills.TotalAmount) Balances

FROM
dbo.GSCDetails
INNER JOIN dbo.PatientRegs ON dbo.GSCDetails.RegId = dbo.PatientRegs.Id
INNER JOIN dbo.GSCSBillRels ON dbo.GSCSBillRels.GSCDetailId = dbo.GSCDetails.Id
INNER JOIN dbo.Bills ON dbo.GSCSBillRels.BillId = dbo.Bills.Id
INNER JOIN dbo.Patients ON dbo.PatientRegs.PatientId = dbo.Patients.Id
LEFT JOIN dbo.Admissions a on a.RegId = PatientRegs.Id
LEFT JOIN dbo.Deposits d ON d.AdmissionId = a.Id
WHERE
dbo.Bills.RecordStatus = 1
AND GSCSBillRels.RecordStatus=1
AND dbo.Bills.BillDate BETWEEN '".$startdate."' AND '".$enddate."'";
	$query =  $conn->query($sql);
	return $query->result();
	}

	function get_refund_deposit()
	{		
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT
patientregs.Id as regid,
dbo.PatientRegs.CodeValue AS RegCode,
Bills.Id as billid,
bills.IsSettle, 
dbo.Bills.CodeValue AS BillCode,
dbo.Patients.FirstName +' '+ dbo.Patients.MiddleName +' '+dbo.Patients.LastName AS pasien,
dbo.Bills.RecordStatus,
(select top 1 replace(NameValue,'-','') from institutions where Id= GSCDetails.RemInstitutionId) AS payer,
dbo.Bills.BillDate,
ROUND(dbo.Bills.TotalAmount,0) AS TotalAmount,
(select sum(ROUNT(Amount,0) AS Amount from Deposits where admissionid = a.id) as deposit,
ROUND(Bills.Discount,0) AS Discount,
(ROUND(Bills.Discount,0)/100 * ROUND(dbo.Bills.TotalAmount,0)) totalDiscount
--Bills.TotalAmount - d.Amount - (Bills.Discount/100 * dbo.Bills.TotalAmount) Balances

FROM
dbo.GSCDetails
INNER JOIN dbo.PatientRegs ON dbo.GSCDetails.RegId = dbo.PatientRegs.Id
INNER JOIN dbo.GSCSBillRels ON dbo.GSCSBillRels.GSCDetailId = dbo.GSCDetails.Id
INNER JOIN dbo.Bills ON dbo.GSCSBillRels.BillId = dbo.Bills.Id
INNER JOIN dbo.Patients ON dbo.PatientRegs.PatientId = dbo.Patients.Id
LEFT JOIN dbo.Admissions a on a.RegId = PatientRegs.Id
LEFT JOIN dbo.Deposits d ON d.AdmissionId = a.Id
WHERE
dbo.Bills.RecordStatus = 1
AND GSCSBillRels.RecordStatus=1
AND dbo.Bills.BillDate BETWEEN '".$startdate."' AND '".$enddate."'";
	$query =  $conn->query($sql);
	return $query->result();
	}

}