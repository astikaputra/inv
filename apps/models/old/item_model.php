<?php

class Item_model extends CI_Model {
	
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


	//---------------------------------Tracking Item---------------------------------------------
	function get_item_tracking($keyword)
	{
	
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT TOP 50 Items.Id,Items.CodeValue,Items.NameValue,buy.NameValue as 'uom_buy',sell.NameValue as 'uom_sell', CASE items.IsFormularium WHEN 0 Then 'NO' WHEN 1 Then 'YES' ELSE 'Not Set' END AS IsFormularium,
			CASE items.RecordStatus  WHEN 0 Then 'Not Active' WHEN 1 Then 'Active' ELSE 'Not Set' END AS 'RecordStatus',ROW_NUMBER() OVER (ORDER BY Items.Id) AS 'RowNumber' from Items LEFT JOIN RefUomTypes buy ON Items.BuyUomId=buy.Id LEFT JOIN RefUomTypes sell ON Items.SellUomId=sell.Id
			WHERE Items.CodeValue like '%$keyword%' OR Items.NameValue like '%$keyword%'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_detail($item_code) 
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$conn->where('CodeValue',$item_code);
	return $conn->get('Items')->row();
	}
	
	function get_item_price($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select a.PriceClass AS 'price_class',a.PriceAmount AS 'price_amount',a.PriceAmount+(a.PriceAmount*c.PercentageMarkup/100) AS 'price_passport',a.PriceAmount+(a.PriceAmount*d.PercentageMarkup/100) AS 'price_kitas' from RefIdentityCardTypes d,RefIdentityCardTypes c,VPricelistItems a LEFT JOIN PriceListClasses b ON a.PriceListClassId=b.Id WHERE b.RecordStatus=1 AND c.Id=3 AND d.Id=4 AND a.PriceCode='".$item_code."'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_stock($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = " SELECT * FROM (SELECT e.CodeValue AS ItemCode, d.NameValue AS StoreName,SUM(a.InValue - a.OutValue) AS QtyOnHand FROM dbo.ItemStocks a INNER JOIN dbo.ItemBatchNumbers b ON b.Id = a.ItemBatchNumberId 
			 INNER JOIN dbo.ItemStores c ON c.Id = a.ItemStoreId
			 INNER JOIN dbo.Stores d ON d.id = c.StoreId
			 INNER JOIN dbo.Items e ON e.id = b.ItemId
			 WHERE e.CodeValue = '".$item_code."'
			 GROUP BY e.CodeValue, d.NameValue ) a ORDER BY a.QtyOnHand DESC";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_specialist($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select DISTINCT RefSpecialist.CodeValue, RefSpecialist.NameValue,RefSpecialistGroups.NameValue As 'specialist_group' from VItemStoreSpecialist LEFT JOIN RefSpecialist ON VItemStoreSpecialist.SpecialistId=RefSpecialist.Id LEFT JOIN RefSpecialistGroups ON RefSpecialist.GroupSpecialistId=RefSpecialistGroups.Id WHERE VItemStoreSpecialist.ItemCode='".$item_code."'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_mapping_store($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select StoreName from VItemStore WHERE ItemCode='".$item_code."'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_grn($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select vgd.CodeValue AS 'nomor_po',gm.CodeValue as 'nomor_grn',vgd.QtyPo,vgd.QtyGrn,vgd.ExpiredDate,vgd.BatchNumberLocal,gm.GrnDate from VGrnDetail vgd INNER JOIN GrnMasters gm ON vgd.GrnMstId=gm.Id WHERE vgd.ItemCode='".$item_code."'  ORDER BY gm.Id DESC";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_po($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select a.CodeValue AS 'nomor_po',a.PoDate AS 'tanggal',c.NameValue AS 'supplier' from PurchaseOrders a LEFT JOIN PurchaseOrderDetails b ON a.Id=b.PoId LEFT JOIN Suppliers c ON a.SupplierId=c.Id LEFT JOIN Items d ON b.ItemlId=d.Id WHERE d.CodeValue='".$item_code."' ORDER BY a.Id DESC";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_order_price($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "Select c.NameValue AS 'supplier',d.OrderPrice AS 'order_price',d.OrderDiscount AS 'order_discount',d.OrderQty AS 'order_qty',d.OrderQtyToInventory AS 'convertion' from Items a INNER JOIN ItemSupplierRels b ON a.Id=b.ItemId INNER JOIN Suppliers c ON c.Id=b.SupplierId LEFT JOIN ItemSupplierOrderPrices d ON d.ItemSupplierRelId=b.Id INNER JOIN dbo.ItemSupplierPriorities e ON b.id = e.ItemSupplierRelId WHERE a.CodeValue='".$item_code."'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_pr($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select a.CodeValue AS 'pr_code',a.ReleasedDate AS 'released_date',a.RequestBy AS 'request_by',CONVERT(DATE,a.NeedTime) AS 'need_date',c.NameValue AS 'stores',IsCito AS 'iscito',b.Qty AS 'qty' from PurchaseRequisitions a LEFT JOIN PurchaseRequisitionDetails b ON a.Id=b.PurchaseRequsitionId LEFT JOIN Stores c ON c.Id=a.StoreId LEFT JOIN Items d ON d.Id=b.ItemId WHERE d.CodeValue='".$item_code."' ORDER BY a.Id DESC";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_stores($item_id){
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select a.Id,a.StoreId from ItemStores a LEFT JOIN Items b ON a.ItemId=b.Id WHERE b.CodeValue='".$item_code."'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	//--------------------------------- Update Items -------------------------------------------------
	
	function set_activate_item($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "UPDATE Items SET RecordStatus=1 WHERE CodeValue='".$item_code."'";
	$query =  $conn->query($sql);
	}
	
	function set_activate_formularium($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "UPDATE Items SET isFormularium=1 WHERE CodeValue='".$item_code."'";
	$query =  $conn->query($sql);
	}
	function set_deactivate_item($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "UPDATE Items SET RecordStatus=0 WHERE CodeValue='".$item_code."'";
	$query =  $conn->query($sql);
	}
	function set_deactivate_formularium($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "UPDATE Items SET isFormularium=0 WHERE CodeValue='".$item_code."'";
	$query =  $conn->query($sql);
	}
	
	function update_item($arr_data,$item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "UPDATE Items SET NameValue='".$arr_data[0]."',ItemTypeId=".$arr_data[1].",ItemShapeId=".$arr_data[2].",BuyUomId=".$arr_data[3].",SellUomId=".$arr_data[4]." WHERE CodeValue='".$item_code."'";
	$query =  $conn->query($sql);
	}
	//--------------------------------- End Tracking Item---------------------------------------------
	
	function get_po_number($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select DISTINCT vgd.CodeValue AS 'nomor_po', gm.CodeValue as 'nomor_grn' from VGrnDetail vgd INNER JOIN GrnMasters gm ON vgd.GrnMstId=gm.Id WHERE vgd.ItemCode='".$item_code."'";
	$query =  $conn->query($sql);
	}

	function get_medicine_consumption($datestart,$dateend)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "
	SELECT a.MedicationName AS MedicineName, COUNT(1) AS TotalPre, SUM(qty) AS TotalCon
	FROM dbo.MRPrescriptions a
	INNER JOIN dbo.MRPrescriptionHeaders b ON a.MRPrescriptionHeaderId = b.Id
	WHERE a.RecordTime BETWEEN '".$datestart."' AND '".$dateend."' GROUP BY a.MedicationName";
		$query= $conn->query($sql);
		return $query;
	}
	
	function get_medicine_consumption_retail($datestart,$dateend)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "
	SELECT DISTINCT dbo.RetailPatients.FirstName +' '+dbo.RetailPatients.MiddleName+' '+dbo.RetailPatients.LastName AS PatientName, CONVERT(DATE,CreatedOn) AS CreateDate,CreatedBy FROM dbo.RetailPatients
	WHERE CreatedOn BETWEEN '".$datestart."' AND '".$dateend."'";
		$query= $conn->query($sql);
		return $query;
	}
	
	function get_inventory_history($store_id, $bar_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn = $this->load->database($this->set_db(),true);
	$sql = "SELECT
	c.BarCode,
	a.InValue,
	a.OutValue,
	a.TransTime AS [Trans Time],
	a.RefCode,
	(
		CASE
		WHEN a.RefCode LIKE '%ADJ%'
		OR a.RefCode LIKE '%NCC%' THEN
			(
				SELECT
					UserId
				FROM
					ItemStockAdjusts
				WHERE
					CodeValue = a.RefCode
			) ELSE (
				CASE WHEN a.RefCode LIKE '%TRS%' THEN
					(
						SELECT
							z.UserId
						FROM
							StockTransfers x
						LEFT JOIN StockTransferDetails y ON x.Id = y.StockTransferId
						LEFT JOIN StockTransferFullFills z ON y.Id = z.StockTransferDetailId
						WHERE
							x.RequestNumber = RIGHT (a.RefCode, 13)
						AND z.ItemBatchNumberId = a.ItemBatchNumberId
						AND InOut = (
							CASE
							WHEN a.InValue > 0 THEN
								0
							ELSE
								1
							END
						)
					) ELSE (
						CASE WHEN a.RefCode LIKE '%GSC%' THEN
							(
								SELECT
									CreatedBy
								FROM
									GSCDetails
								WHERE
									Id = SUBSTRING (a.RefCode, 4, 10)
							) ELSE (
								CASE WHEN a.RefCode LIKE '%GRN%' THEN
									(
										SELECT
											UserId
										FROM
											GrnMasters
										WHERE
											CodeValue = a.RefCode
									) ELSE (
										CASE WHEN a.RefCode LIKE '%SO%' THEN
											 (
												SELECT
													TOP (1) k.UserId
												FROM
													StockOpnameDetails k
												LEFT JOIN ItemBatchNumbers l ON k.ItemBatchNumberId = l.Id LEFT
												JOIN ItemStores m ON k.ItemStoreId = m.ID
												WHERE
													m.StoreId = b.StoreId
												AND l.BarCode = c.BarCode
												AND k.StockOpnameId = SUBSTRING (a.RefCode, 3, 10)
												AND k.Qty = a.InValue
											) ELSE ''
										END
									)
								END
							)
						END
					)
				END
			)
		END
	) AS [User],
	(
		CASE WHEN a.RefCode LIKE '%ADJ%'
		OR a.RefCode LIKE '%NCC%' THEN
			(
				SELECT
					Remark
				FROM
					ItemStockAdjusts
				WHERE
					CodeValue = a.RefCode
			) ELSE (
				CASE WHEN a.RefCode LIKE '%TRS%' THEN
					(
						SELECT
							'Request :' + (
								SELECT
									NameValue
								FROM
									Stores
								WHERE
									Id = x.RequestStoreId
							) + ' || To:' + (
								SELECT
									NameValue
								FROM
									Stores
								WHERE
									Id = x.FromStoreId
							)
						FROM
							StockTransfers x
						LEFT JOIN StockTransferDetails y ON x.Id = y.StockTransferId
						LEFT JOIN StockTransferFullFills z ON y.Id = z.StockTransferDetailId
						WHERE
							x.RequestNumber = RIGHT (a.RefCode, 13)
						AND z.ItemBatchNumberId = a.ItemBatchNumberId
						AND InOut = (
							CASE
							WHEN a.InValue > 0 THEN
								0
							ELSE
								1
							END
						)
					) ELSE (
						CASE WHEN a.RefCode LIKE '%GSC%' THEN
							(
								SELECT
									(
										CASE
										WHEN x.IsReversal = 1 THEN
											'Reversal || '
										ELSE
											(
												CASE
												WHEN x.isRevision = 1 THEN
													'Revision || '
												ELSE
													''
												END
											)
										END
									) + 'Reg:' + CONVERT (VARCHAR, y.CodeValue)
								FROM
									GSCDetails x
								LEFT JOIN PatientRegs y ON x.RegId = y.Id
								WHERE
									x.Id = SUBSTRING (a.RefCode, 4, 10)
							) ELSE (
								CASE WHEN a.RefCode LIKE '%GRN%' THEN
									(
										SELECT
											CONVERT (nvarchar, GrnDate)
										FROM
											GrnMasters
										WHERE
											CodeValue = a.RefCode
									) ELSE (
										CASE WHEN a.RefCode LIKE '%SO%' THEN
											 (
												SELECT
													TOP (1) k.UserId
												FROM
													StockOpnameDetails k
												LEFT JOIN ItemBatchNumbers l ON k.ItemBatchNumberId = l.Id LEFT
												JOIN ItemStores m ON k.ItemStoreId = m.ID
												WHERE
													m.StoreId = b.StoreId
												AND l.BarCode = c.BarCode
												AND k.StockOpnameId = SUBSTRING (a.RefCode, 3, 10)
												AND k.Qty = a.InValue
											) ELSE (
												SELECT
													y.NameValue + ' | ' + x.Remark + ''
												FROM
													ItemReturs x
												LEFT JOIN Suppliers y ON x.SupplierId = y.Id
												WHERE
													x.CodeValue = a.RefCode
											)
										END
									)
								END
							)
						END
					)
				END
			)
		END
	) AS [Description]
FROM
	ItemStocks a
LEFT JOIN ItemStores b ON a.ItemStoreId = b.Id
LEFT JOIN ItemBatchNumbers c ON a.ItemBatchNumberId = c.Id
WHERE
	b.StoreId = '".$store_id."'
AND c.Barcode = '".$bar_code."'
ORDER BY
	a.Id";
	    $query= $conn->query($sql);
		return $query;
	}
	
	
    function get_stock_per_store($store_id)
	{
		$this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(),true);
		$sql = "SELECT DISTINCT
	a.ItemCode,
	a.ItemName,
	a.BuyUOM,
	ISNULL(c.OrderQtyToInventory, 0) AS [Convertion],
	a.SellUOM,
	a.BarCode,
	a.ExpiredDate,
	a.Qty
FROM
	(
		SELECT
			e.Id AS [StoreId],
			e.NameValue AS [StoreName],
			d.Id AS [ItemId],
			d.CodeValue AS [ItemCode],
			d.NameValue AS [ItemName],
			f.NameValue AS [BuyUOM],
			g.NameValue AS [SellUOM],
			c.BarCode,
			c.ExpiredDate,
			(
				SUM (a.InValue) - SUM (a.OutValue)
			) AS [Qty]
		FROM
			ItemStocks a
		LEFT JOIN ItemStores b ON a.ItemStoreId = b.Id
		LEFT JOIN ItemBatchNumbers c ON a.ItemBatchNumberId = c.Id
		LEFT JOIN Items d ON c.ItemId = d.Id
		LEFT JOIN Stores e ON b.StoreId = e.Id
		LEFT JOIN RefUomTypes f ON d.BuyUomId = f.Id
		LEFT JOIN RefUomTypes g ON d.SellUomId = g.Id
		GROUP BY
			e.Id,
			e.NameValue,
			d.CodeValue,
			d.NameValue,
			c.BarCode,
			b.StoreId,
			c.ExpiredDate,
			f.NameValue,
			g.NameValue,
			d.Id
	) a
LEFT JOIN ItemSupplierRels AS b ON b.ItemId = a.ItemId
AND b.SupplierId = (
	SELECT
		TOP (1) SupplierId
	FROM
		ItemSupplierPriorities x
	LEFT JOIN ItemSupplierRels y ON x.Id = y.Id
	WHERE
		y.ItemId = a.ItemId
	ORDER BY
		x.Id DESC
)
AND b.RecordStatus = 1
LEFT JOIN ItemSupplierOrderPrices c ON b.Id = c.ItemSupplierRelId
AND c.RecordStatus = 1
WHERE
	a.StoreId = '".$store_id."'
ORDER BY
	1,
	2,
	3,
	4";
	    $query= $conn->query($sql);
		return $query;
	}
	
	function get_store_from_so($store_id)
	{
		$this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(),true);
		$sql = "SELECT b.NameValue from StockOpnames a LEFT JOIN Stores b ON a.StoreId=b.Id WHERE a.Id = '".$store_id."'";
		$query= $conn->query($sql);
		return $query;
	}
	
	function get_list_so()
	{
		$this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(),true);
		$sql = "SELECT Id from StockOpnames Order By 1 Desc";
		$query= $conn->query($sql);
		return $query;
	}
	
	function get_so_cutoff_detail($store_id)
	{
		$this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(),true);
		$sql = "SELECT Id as [SO], CutOffDate, SubmitDate, StoreId from StockOpnames WHERE Id = '".$store_id."' Order By [SO] Desc";
		$query= $conn->query($sql);
		return $query;
	}
	
	function get_count_code_so($so_id)
	{
		$this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(),true);
		$sql = "SELECT COUNT(DISTINCT b.ItemId) from StockOpnameDetails a LEFT JOIN ItemBatchNumbers b ON a.ItemBatchNumberId=b.Id WHERE a.StockOpnameId = '".$store_id."' AND a.QtyCheck!=0";
		$query= $conn->query($sql);
		return $query;
	}
	
	function get_count_barcode_so($so_id)
	{
		$this->set_db();
		$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
		$conn = $this->load->database($this->set_db(),true);	
	    $sql = "SELECT COUNT(DISTINCT b.BarCode) from StockOpnameDetails a LEFT JOIN ItemBatchNumbers b ON a.ItemBatchNumberId=b.Id WHERE a.StockOpnameId = '".$store_id."' AND a.QtyCheck!=0";
		$query= $conn->query($sql);
		return $query;
	}
	
}