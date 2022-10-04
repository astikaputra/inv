<?php

class Purchase_model extends CI_Model {
	
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
	
    function get_los()
    {
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT LOSName from Revenue ORDER BY LOSName ASC";
	$query =  $conn->query($sql);
    return $query->result();        
    }
	
    function get_purchasing_data($startdate,$enddate)
	{
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT * FROM fn_purchasing('$startdate','$enddate')";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
    function get_comsumption_data($startdate,$enddate)
	{
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT * FROM fn_consumables('$startdate','$enddate')";
	$query =  $conn->query($sql);
	return $query->result();
	}
        
    function get_spec_los_revenue($startdate,$enddate,$los)
	{
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "
	SELECT
	billdate,
	Billcreateddate,
	BillNo,
	patientName,
	gender,
	birthdate,
	CAST (
		CASE
		WHEN Datepart(yyyy, Birthdate) = DATEpart(yyyy, GETDATE()) THEN
			CAST (
				DATEpart(mm, GETDATE()) - DATEPART(mm, Birthdate) AS nvarchar (8)
			) + ' Month'
		ELSE
			CAST (
				DATEpart(yyyy, GETDATE()) - DATEpart(yyyy, Birthdate) AS nvarchar (8)
			)
		END AS nvarchar (10)
	) age,
	(
		SELECT DISTINCT
			TOP 1 ISNULL(aa.AddressDesc, '') + ' ' + isnull(aa.zipcode, '') + ' ' + ISNULL(bb.namevalue, '') + ' ' + ISNULL(cc.namevalue, '') + ' ' + ISNULL(dd.NameValue, '') + ' ' + ISNULL(aa.phoneNumber, '-')
		FROM
			Addresses aa
		LEFT JOIN RefCities bb ON bb.Id = aa.CityId
		LEFT JOIN RefProvinces cc ON cc.Id = bb.ProvinceId
		LEFT JOIN RefCountries dd ON dd.Id = cc.CountryId
		WHERE
			aa.PatientId = a.patientid
	) AS Address,
	RegistCode,
	RegistrationTime,
	LOB,
	AxdoctorCode,
	DoctorName,
	ReferingDoctor,
	SubSpecialistName,
	specialistName,
	GroupSpecialistName,
	ROOM,
	MarginClass,
	Itemcode,
	ServiceCode,
	DescName,
	LOSName,
	Qty,
	cost AS ItemPrice,
	qty * Cost AS BillAmount,
	qty * CostPayer AS PayerAmount,
	CASE
WHEN discount = 100 THEN
	0
ELSE
	(
		QTY * (
			(
				(
					CASE
					WHEN a.Institutionid IS NULL THEN
						a.cost
					ELSE
						a.costpayer
					END - (
						b.Material / 100 * CASE
						WHEN a.Institutionid IS NULL THEN
							a.cost
						ELSE
							a.costpayer
						END
					) - (
						b.SupplierA / 100 * CASE
						WHEN a.Institutionid IS NULL THEN
							a.cost
						ELSE
							a.costpayer
						END
					)
				) * isnull(b.dr / 100, 0)
			)
		)
	)
END AS DoctorFee,
 (
	QTY * (
		CASE
		WHEN a.Institutionid IS NULL THEN
			a.cost
		ELSE
			a.costpayer
		END
	) * discount / 100
) AS Discount,
 PayerName,
 payertype,
 (
	SELECT DISTINCT
		TOP 1 CASE
	WHEN paymentmethodid = 1 THEN
		'Cash'
	WHEN PaymentMethodId = 2 THEN
		'DebitCard'
	WHEN PaymentMethodId IN (3, 7) THEN
		'CreditCard'
	WHEN PaymentMethodId = 4 THEN
		'Transfer'
	WHEN PaymentMethodId = 5 THEN
		'Cheque'
	WHEN PaymentMethodId = 6 THEN
		'voucher'
	ELSE
		'Payer'
	END AS PaymentMethod
	FROM
		Payments
	WHERE
		BillId = a.billid
) AS PaymentMethod,
 Status,
 IdentityCardTypes,
 Nationality,
 isnull(isretail, 0) isretail,
 triage,
 Admitdate,
 CASE
WHEN a.issettle = 1 THEN
	(
		CASE
		WHEN a.institutionid IS NOT NULL THEN
			'Paid'
		ELSE
			a.paymentstatus
		END
	)
ELSE
	a.paymentstatus
END AS PaymentStatus
FROM
	Revenue a
LEFT JOIN itemservicecost b ON a.itemserviceid = b.itemserviceid
WHERE
	billdate BETWEEN '".$startdate."' AND '".$enddate."'
AND issettle = 1
AND status <> 'Cancel'
AND LOSName = '".$los."'
ORDER BY billdate, RegistCode DESC";
	$query =  $conn->query($sql);
	return $query->result();
	}
    
	function get_prodia_revenue($datestart,$dateend)
	{
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT No, BillDate, BillNo,	patientName, Itemcode, DescName, BILLAMOUNT from f_LabProdia('$datestart','$dateend')";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_material_cost_drugs($datestart,$dateend)
	{
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "
SELECT
	a.billdate,
	CASE
WHEN a.updatedate IS NULL THEN
	CONVERT (nvarchar, a.createddate, 111)
ELSE
	CONVERT (nvarchar, a.UpdateDate, 111)
END AS UpdatedDate,
 a.medicalrecordnumber,
 a.registCode AS 'RegNo',
 a.billno AS 'BilNo',
 a.patientname,
 a.doctorname,
 a.Itemcode,
 a.ItemName,
 a.qty,
 e.namevalue UoM,
 a.avg_cost ItemCostUom,
 a.qty * isnull(a.avg_cost, 0) 'TotalCost',
 (
	a.qty * (
		isnull(a.cost, 0) + isnull(a.costpayer, 0)
	)
) 'TotalRevenue'
FROM
	revenue a
LEFT JOIN items b ON a.Itemcode = b.CodeValue
LEFT JOIN ItemSupplierRels c ON c.ItemId = b.Id
AND c.itemid = a.itemid
INNER JOIN ItemSupplierPriorities f ON f.ItemSupplierRelId = c.Id
LEFT JOIN ItemSupplierOrderPrices d ON d.ItemSupplierRelId = c.Id
LEFT JOIN refuomtypes e ON e.id = b.selluomid
WHERE
	a.billdate >= '".$datestart."'
AND a.billdate <= '".$dateend."'
AND SUBSTRING (itemcode, 1, 2) = 'PH'
AND e.RecordStatus = 1
AND c.RecordStatus = 1
AND a.issettle = 1
AND a.status <> 'Cancel'
ORDER BY
	a.billdate";
	$query =  $conn->query($sql);
	return $query->result();	
	}
	
	function get_medical_cost_drugs($datestart,$dateend)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = "	
	SELECT
	a.billdate,
	CASE
WHEN a.updatedate IS NULL THEN
	CONVERT (nvarchar, a.createddate, 111)
ELSE
	CONVERT (nvarchar, a.UpdateDate, 111)
END AS UpdateDate,
 a.medicalrecordnumber,
 a.registCode AS 'RegNo',
 a.billno AS 'BilNo',
 a.patientname,
 a.doctorname,
 a.Itemcode,
 a.ItemName,
 a.qty,
 e.namevalue UoM,
 a.avg_cost ItemCostUom,
 a.qty * isnull(a.avg_cost, 0) 'TotalCost',
 (
	a.qty * (
		isnull(a.cost, 0) + isnull(a.costpayer, 0)
	)
) 'TotalRevenue'
FROM
	revenue a
LEFT JOIN items b ON a.Itemcode = b.CodeValue
LEFT JOIN ItemSupplierRels c ON c.ItemId = b.Id
AND c.itemid = a.itemid
INNER JOIN ItemSupplierPriorities f ON f.ItemSupplierRelId = c.Id
LEFT JOIN ItemSupplierOrderPrices d ON d.ItemSupplierRelId = c.Id
LEFT JOIN refuomtypes e ON e.id = b.selluomid
WHERE a.billdate >= '".$datestart."' AND a.billdate <= '".$dateend."'
AND SUBSTRING (itemcode, 1, 2) = 'MS'
AND e.RecordStatus=1 AND c.RecordStatus=1
AND a.issettle = 1 AND a.status <> 'Cancel' ORDER BY billdate";
	$query =  $conn->query($sql);
	return $query->result();	
	}
	
	function get_non_chargeable_items($datestart,$dateend)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = " SELECT
	c.codevalue RecordNumber,
	d.NameValue,
	c.RecordDate,
	a.barcode,
	i.namevalue ItemName,
	b.Qty,
	r.namevalue UOM,
	a.costvalue Amount
FROM
	ItemBatchNumbers a
INNER JOIN ItemStockAdjustDetails b ON b.ItemBatchNumberId = a.Id
INNER JOIN ItemStockAdjusts c ON c.Id = b.itemstockadjustid
INNER JOIN Items i ON i.Id = a.ItemId
LEFT JOIN Stores d ON d.Id = c.StoreId
LEFT JOIN RefUomTypes r ON r.Id = i.SellUomId
WHERE
	c.codevalue LIKE '%NCC%'
AND c.RecordDate BETWEEN '".$datestart."' AND  '".$dateend."'";
	$query =  $conn->query($sql);
	return $query->result();	
	}
	
	function get_doctor_fee($datestart,$dateend)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = " 
	SELECT DISTINCT registcode, billdate, billno, axdoctorcode, DoctorName, specialistname, createddate, LOB, marginclass, ROOM, patientname, servicecode, servicename, TOTALMaterialCost,TOTALDoctorFee, Total FROM dbo.f_doctorfee('$datestart','$dateend') ORDER BY billdate DESC";
	$query =  $conn->query($sql);
	return $query->result();	
	}
	
	function get_revenue_summary($datestart,$dateend)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = " SELECT
	--a.billid,
	a.patientName,
	a.RegistCode,
	a.BillNo,
	a.billdate,
	SUM (a.qty *(a.cost + a.costpayer)) AS Amount,
	a.payertype,
	Replace(a.payername, '-', ' ') Payername,
	a.Status BillStatus
FROM
	revenue a
WHERE
	billdate BETWEEN '".$datestart."' AND  '".$dateend."' AND Status <> 'Cancel' AND IsSettle=1 --and payertype='Self Paid'
	--and PaymentMethodId is null
GROUP BY
	a.patientName,
	a.RegistCode,
	a.BillNo,
	a.billdate,
	a.payertype,
	a.billid,
	a.Status,
	a.payername
 ORDER BY billdate DESC";
	$query =  $conn->query($sql);
	return $query->result();	
	}
	
	function get_clasify_of_room($datestart,$dateend)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = " SELECT
	t1.MedicalRecordNumber,
	t1.patientName,
	t1.registcode,
	t2.admitdate,
	t2.outdate,
	CASE
WHEN (
	DATEDIFF(DAY, admitdate, outdate)
) = 0 THEN
	1
ELSE
	DATEDIFF(DAY, admitdate, outdate)
END AS ALOS,
 t1.doctorname,
 t1.subspecialistname,
 t1.groupspecialistname,
 SUM (t1.C3) AS C3,
 SUM (t1.C2) AS C2,
 SUM (t1.C1A) AS C1A,
 SUM (t1.C1B) AS C1B,
 SUM (t1.VIP) AS VIP,
 SUM (t1.SVIP) AS SVIP,
 SUM (t1.PRESIDENT) AS PRESIDENT,
 SUM (t1.NURSERY) AS NURSERY
FROM
	(
		SELECT
			regid,
			MedicalRecordNumber,
			patientName,
			registcode,
			doctorname,
			subspecialistname,
			groupspecialistname,
			qty * (
				CASE
				WHEN marginclass = 'C3' THEN
					CASE
				WHEN a.Institutionid IS NULL THEN
					a.cost
				ELSE
					a.costpayer
				END
				ELSE
					0
				END
			) AS C3,
			qty * (
				CASE
				WHEN marginclass = 'C2' THEN
					CASE
				WHEN a.Institutionid IS NULL THEN
					a.cost
				ELSE
					a.costpayer
				END
				ELSE
					0
				END
			) AS C2,
			qty * (
				CASE
				WHEN marginclass = 'C1A' THEN
					CASE
				WHEN a.Institutionid IS NULL THEN
					a.cost
				ELSE
					a.costpayer
				END
				ELSE
					0
				END
			) AS C1A,
			qty * (
				CASE
				WHEN marginclass = 'C1B' THEN
					CASE
				WHEN a.Institutionid IS NULL THEN
					a.cost
				ELSE
					a.costpayer
				END
				ELSE
					0
				END
			) AS C1B,
			qty * (
				CASE
				WHEN marginclass = 'VIP' THEN
					CASE
				WHEN a.Institutionid IS NULL THEN
					a.cost
				ELSE
					a.costpayer
				END
				ELSE
					0
				END
			) AS VIP,
			qty * (
				CASE
				WHEN marginclass = 'SVIP' THEN
					CASE
				WHEN a.Institutionid IS NULL THEN
					a.cost
				ELSE
					a.costpayer
				END
				ELSE
					0
				END
			) AS SVIP,
			qty * (
				CASE
				WHEN marginclass = 'PRESIDENT' THEN
					CASE
				WHEN a.Institutionid IS NULL THEN
					a.cost
				ELSE
					a.costpayer
				END
				ELSE
					0
				END
			) AS PRESIDENT,
			qty * (
				CASE
				WHEN marginclass = 'NURSERY' THEN
					CASE
				WHEN a.Institutionid IS NULL THEN
					a.cost
				ELSE
					a.costpayer
				END
				ELSE
					0
				END
			) AS NURSERY
		FROM
			Revenue a
		WHERE
			lob = 'IPD'
		AND a.BillNo IS NOT NULL
	) t1
LEFT JOIN Admissions t2 ON t1.regid = t2.RegId
WHERE
	t2.OutDate IS NOT NULL
AND t2.outdate BETWEEN '".$datestart."' AND  '".$dateend."'
GROUP BY
	t1.regid,
	t1.MedicalRecordNumber,
	t1.patientName,
	t2.admitdate,
	t2.outdate,
	t1.registcode,
	t1.doctorname,
	t1.subspecialistname,
	t1.groupspecialistname
ORDER BY
	t2.outdate";
	$query = $conn->query($sql);
	return $query->result();
	}

	function get_special_equipment_use($datestart,$dateend)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = " SELECT * FROM fn_eq_patient('$datestart','$dateend')";
	$query = $conn->query($sql);
	return $query->result();
	}

	function get_doctor_craft_group($datestart,$dateend)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = " SELECT * FROM fn_doctor_craft_group('$datestart','$dateend')";
	$query = $conn->query($sql);
	return $query->result();
	}		
	
	function get_revenue_troughput_source($datestart,$dateend,$enddateday)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = " SELECT * FROM f_get_troug_Rev2('$datestart','$dateend','$enddateday')";
	$query = $conn->query($sql);
	return $query->result();
	}
	
	function get_revenue_resource($datestart,$dateend,$enddateday)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = " SELECT * FROM f_get_troug_Rev('$datestart','$dateend','$enddateday')";
	$query = $conn->query($sql);
	return $query->result();
	}

	function get_classify_patient_rev($datestart,$dateend,$enddateday)
	{
	$conn = $this->load->database($this->set_db(),true);
	$sql = " SELECT * FROM fn_ClassifyOfPatient_trou('$datestart','$dateend','$enddateday')";
	$query = $conn->query($sql);
	return $query->result();
	}
	
}