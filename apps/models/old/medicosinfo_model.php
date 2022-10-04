<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Medicosinfo_model extends CI_Model{
 	
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
	
	// purchase request data
	function get_purchase_request_data($startdate,$enddate)
	{	
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
		
        $pr_sql = "	SELECT id,CodeValue,ReleasedDate,RequestBy,NeedTime,IsAutomatic,docstatus.DocInitial,docstatus.DocsDesc,docstatus.DocumentStatus,CreateOn,CreateBy FROM dbo.PurchaseRequisitions 
					OUTER APPLY (SELECT ds.NameValue AS DocumentStatus,dt.CodeValue AS DocInitial,dt.DescValue AS DocsDesc FROM dbo.RefDocumentStatuses ds INNER JOIN dbo.RefDocumentTypes dt ON dt.Id = ds.DocumentTypeId 
					WHERE ds.id = DocumentStatusId) AS docstatus
					WHERE ReleasedDate BETWEEN '".$startdate."' AND '".$enddate."'";
		$query1 = $conn->query($pr_sql);
		$pr['total_pr']= $query1->num_rows();
		$pr['details_total_pr_data']= $query1->result();
		
		$pr_item_sql = "SELECT a.id,c.CodeValue AS PRCode,c.ReleasedDate,b.CodeValue AS ItemCode,b.NameValue AS ItemName,a.Qty 
						FROM dbo.PurchaseRequisitionDetails a INNER JOIN dbo.Items b ON b.id = a.ItemId INNER JOIN dbo.PurchaseRequisitions c ON c.id = a.PurchaseRequsitionId INNER JOIN dbo.RefUomTypes d ON d.Id = a.UnitOfMeasurementType WHERE c.ReleasedDate BETWEEN'".$startdate."' AND '".$enddate."' ORDER BY 2";
		$query2 = $conn->query($pr_item_sql);
		$pr['total_item_pr'] = $query2->num_rows(); 
		$pr['details_total_item_pr'] = $query2->result();
		
		$pr_item_qty_sql = "  SELECT SUM(pr.Qty) AS TotalItem FROM (SELECT a.id,c.CodeValue AS PRCode,c.ReleasedDate,b.CodeValue AS ItemCode, 
								b.NameValue AS ItemName,a.Qty 
								FROM dbo.PurchaseRequisitionDetails a INNER JOIN dbo.Items b ON b.id = a.ItemId 
								INNER JOIN dbo.PurchaseRequisitions c ON c.id = a.PurchaseRequsitionId
								INNER JOIN dbo.RefUomTypes d ON d.Id = a.UnitOfMeasurementType 
								WHERE c.ReleasedDate BETWEEN '".$startdate."' AND '".$enddate."') AS pr";
		$query3 = $conn->query($pr_item_qty_sql);
		$pr['total_item_pr_qty'] = $query3->row()->TotalItem;
        return $pr;
	}
	
	//purchase request auto
	function get_purchase_request_auto_data($startdate,$enddate)
	{	
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $pr_sql = "	SELECT id,CodeValue,ReleasedDate,RequestBy,NeedTime,IsAutomatic,docstatus.DocInitial,docstatus.DocsDesc,docstatus.DocumentStatus,CreateOn,CreateBy FROM dbo.PurchaseRequisitions 
					OUTER APPLY (SELECT ds.NameValue AS DocumentStatus,dt.CodeValue AS DocInitial,dt.DescValue AS DocsDesc FROM dbo.RefDocumentStatuses ds INNER JOIN dbo.RefDocumentTypes dt ON dt.Id = ds.DocumentTypeId 
					WHERE ds.id = DocumentStatusId) AS docstatus
					WHERE ReleasedDate BETWEEN '".$startdate."' AND '".$enddate."' AND IsAutomatic = 1";
		$query1 = $conn->query($pr_sql);
		$pr['total_pr_auto']= $query1->num_rows();
		$pr['total_pr_auto_data']= $query1->result();
		
		$pr_item_sql = "SELECT a.id,c.CodeValue AS PRCode,c.ReleasedDate,b.CodeValue AS ItemCode,b.NameValue AS ItemName,a.Qty 
						FROM dbo.PurchaseRequisitionDetails a INNER JOIN dbo.Items b ON b.id = a.ItemId INNER JOIN dbo.PurchaseRequisitions c ON c.id = a.Id INNER JOIN dbo.RefUomTypes d ON d.Id = a.UnitOfMeasurementType WHERE c.ReleasedDate BETWEEN'".$startdate."' AND '".$enddate."' AND IsAutomatic = 1 ORDER BY 2";
		$query2 = $conn->query($pr_item_sql);
		$pr['total_item_pr_auto'] = $query2->num_rows(); 
		$pr['total_item_pr_auto_data'] = $query2->result();
		$pr_item_qty_sql = "  SELECT SUM(pr.Qty) AS TotalItem FROM (SELECT a.id,c.CodeValue AS PRCode,c.ReleasedDate,b.CodeValue AS ItemCode, 
								b.NameValue AS ItemName,a.Qty 
								FROM dbo.PurchaseRequisitionDetails a INNER JOIN dbo.Items b ON b.id = a.ItemId 
								INNER JOIN dbo.PurchaseRequisitions c ON c.id = a.Id 
								INNER JOIN dbo.RefUomTypes d ON d.Id = a.UnitOfMeasurementType 
								WHERE c.ReleasedDate BETWEEN '".$startdate."' AND '".$enddate."' AND IsAutomatic = 1) AS pr";
		$query3 = $conn->query($pr_item_qty_sql);
		$pr['total_item_pr_auto_qty'] = $query3->row()->TotalItem;
        return $pr;
	}
	
	//purchase order data
	function get_purchase_order_data($startdate,$enddate)
	{
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
		//Po From Multiple PR
        $po_multiple_sql = "	
		SELECT * FROM 
		(
		SELECT temp.POCode,temp.PoDate,temp.DocumentStatus,temp.SupplierName,COUNT(temp.PRNumber) AS TotalPR,COUNT(ItemName) AS TotalItem,SUM(temp.Qty) AS TotalItemQty,SUM(temp.TotalAmountAfterDiscountMainPO+temp.TotalVAT) AS TOTALAmount FROM 
		(
		SELECT b.id,a.CodeValue AS POCode,a.PoDate,
		f.CodeValue AS PRNumber,
		f.ReleasedDate AS PRDate,docstatus.DocInitial,docstatus.DocsDesc,docstatus.DocumentStatus,
		c.NameValue AS ItemName,a.SupplierId,a.RoundAmount,d.NameValue AS UOM,b.Qty,
		g.NameValue AS SupplierName,
		g.VAT,
		b.Discount AS PODetailDiscount,
		a.Discount AS PODiscount,
		b.SalesPrice,
		(b.Qty*b.SalesPrice) AS TotalAmountBeforeDiscount,
		b.Qty*b.SalesPrice*(b.Discount/100) AS TotalDiscountByPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100))) AS TotalAmountAfterDiscountPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))-(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(a.Discount/100)) AS TotalAmountAfterDiscountMainPO,
		ROUND(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(g.VAT/100),0) AS TotalVAT
		FROM dbo.PurchaseOrders a INNER JOIN dbo.PurchaseOrderDetails b ON a.id = b.PoId    
		INNER JOIN dbo.Items c ON c.id = b.ItemlId 
		INNER JOIN dbo.RefUomTypes d ON d.id  = b.UnitOfMeasurementType
		LEFT JOIN dbo.PurchaseRequisitionDetails e ON e.id = b.PRDetailId 
		LEFT JOIN dbo.PurchaseRequisitions f ON f.id = e.PurchaseRequsitionId
		INNER JOIN dbo.Suppliers g ON g.id = a.SupplierId
		OUTER APPLY (SELECT ds.NameValue AS DocumentStatus,dt.CodeValue AS DocInitial,dt.DescValue AS DocsDesc FROM dbo.RefDocumentStatuses ds INNER JOIN dbo.RefDocumentTypes dt ON dt.Id = ds.DocumentTypeId 
		WHERE ds.id = a.DocumentStatusId) AS docstatus
		) temp 
		GROUP BY temp.POCode,temp.DocumentStatus,temp.PoDate,temp.SupplierName
		) po_temp
		WHERE po_temp.TotalPR > 1 AND po_temp.PoDate BETWEEN '".$startdate."' AND '".$enddate."'";
		$query1 = $conn->query($po_multiple_sql);
		$pr['total_po_multiple_pr']= $query1->num_rows();
		$pr['details_po_multiple_pr']= $query1->result();
		
		//PO From Single PR
		$po_single_pr_sql = "	
		SELECT * FROM 
		(
		SELECT temp.POCode,temp.PoDate,temp.DocumentStatus,temp.SupplierName,COUNT(temp.PRNumber) AS TotalPR,COUNT(ItemName) AS TotalItem,SUM(temp.Qty) AS TotalItemQty,SUM(temp.TotalAmountAfterDiscountMainPO+temp.TotalVAT) AS TOTALAmount FROM 
		(
		SELECT b.id,a.CodeValue AS POCode,a.PoDate,
		f.CodeValue AS PRNumber,
		f.ReleasedDate AS PRDate,docstatus.DocInitial,docstatus.DocsDesc,docstatus.DocumentStatus,
		c.NameValue AS ItemName,a.SupplierId,a.RoundAmount,d.NameValue AS UOM,b.Qty,
		g.NameValue AS SupplierName,
		g.VAT,
		b.Discount AS PODetailDiscount,
		a.Discount AS PODiscount,
		b.SalesPrice,
		(b.Qty*b.SalesPrice) AS TotalAmountBeforeDiscount,
		b.Qty*b.SalesPrice*(b.Discount/100) AS TotalDiscountByPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100))) AS TotalAmountAfterDiscountPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))-(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(a.Discount/100)) AS TotalAmountAfterDiscountMainPO,
		ROUND(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(g.VAT/100),0) AS TotalVAT
		FROM dbo.PurchaseOrders a INNER JOIN dbo.PurchaseOrderDetails b ON a.id = b.PoId    
		INNER JOIN dbo.Items c ON c.id = b.ItemlId 
		INNER JOIN dbo.RefUomTypes d ON d.id  = b.UnitOfMeasurementType
		LEFT JOIN dbo.PurchaseRequisitionDetails e ON e.id = b.PRDetailId 
		LEFT JOIN dbo.PurchaseRequisitions f ON f.id = e.PurchaseRequsitionId
		INNER JOIN dbo.Suppliers g ON g.id = a.SupplierId
		OUTER APPLY (SELECT ds.NameValue AS DocumentStatus,dt.CodeValue AS DocInitial,dt.DescValue AS DocsDesc FROM dbo.RefDocumentStatuses ds INNER JOIN dbo.RefDocumentTypes dt ON dt.Id = ds.DocumentTypeId 
		WHERE ds.id = a.DocumentStatusId) AS docstatus
		) temp 
		GROUP BY temp.POCode,temp.DocumentStatus,temp.PoDate,temp.SupplierName
		) po_temp
		WHERE po_temp.TotalPR = 1 AND po_temp.PoDate BETWEEN '".$startdate."' AND '".$enddate."'";
		$query2 = $conn->query($po_single_pr_sql);
		$pr['total_po_single_pr'] = $query2->num_rows(); 
		$pr['details_po_single_pr'] = $query2->result();
		
		//Get Supplier
		$po_supplier_sql = "	
		SELECT * FROM 
		(
		SELECT temp.POCode,temp.PoDate,temp.DocumentStatus,temp.SupplierName,COUNT(temp.PRNumber) AS TotalPR,COUNT(ItemName) AS TotalItem,SUM(temp.Qty) AS TotalItemQty,SUM(temp.TotalAmountAfterDiscountMainPO+temp.TotalVAT) AS TOTALAmount FROM 
		(
		SELECT b.id,a.CodeValue AS POCode,a.PoDate,
		f.CodeValue AS PRNumber,
		f.ReleasedDate AS PRDate,docstatus.DocInitial,docstatus.DocsDesc,docstatus.DocumentStatus,
		c.NameValue AS ItemName,a.SupplierId,a.RoundAmount,d.NameValue AS UOM,b.Qty,
		g.NameValue AS SupplierName,
		g.VAT,
		b.Discount AS PODetailDiscount,
		a.Discount AS PODiscount,
		b.SalesPrice,
		(b.Qty*b.SalesPrice) AS TotalAmountBeforeDiscount,
		b.Qty*b.SalesPrice*(b.Discount/100) AS TotalDiscountByPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100))) AS TotalAmountAfterDiscountPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))-(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(a.Discount/100)) AS TotalAmountAfterDiscountMainPO,
		ROUND(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(g.VAT/100),0) AS TotalVAT
		FROM dbo.PurchaseOrders a INNER JOIN dbo.PurchaseOrderDetails b ON a.id = b.PoId    
		INNER JOIN dbo.Items c ON c.id = b.ItemlId 
		INNER JOIN dbo.RefUomTypes d ON d.id  = b.UnitOfMeasurementType
		LEFT JOIN dbo.PurchaseRequisitionDetails e ON e.id = b.PRDetailId 
		LEFT JOIN dbo.PurchaseRequisitions f ON f.id = e.PurchaseRequsitionId
		INNER JOIN dbo.Suppliers g ON g.id = a.SupplierId
		OUTER APPLY (SELECT ds.NameValue AS DocumentStatus,dt.CodeValue AS DocInitial,dt.DescValue AS DocsDesc FROM dbo.RefDocumentStatuses ds INNER JOIN dbo.RefDocumentTypes dt ON dt.Id = ds.DocumentTypeId 
		WHERE ds.id = a.DocumentStatusId) AS docstatus
		) temp 
		GROUP BY temp.POCode,temp.DocumentStatus,temp.PoDate,temp.SupplierName
		) po_temp
		WHERE  po_temp.TotalPR >= 1 AND po_temp.PoDate BETWEEN '".$startdate."' AND '".$enddate."'";
		$query3 = $conn->query($po_supplier_sql);
		$pr['total_po_supplier'] = $query3->num_rows(); 
		$pr['details_po_suplier'] = $query3->result();
		
		//total item,
			$po_item_qty_sql = "	
		SELECT SUM(TotalItemQty) AS TotalItemQty ,SUM(TotalItem) AS TotalItem,SUM(TOTALAmount) AS TOTALAmount FROM 
		(
		SELECT temp.POCode,temp.PoDate,temp.DocumentStatus,temp.SupplierName,COUNT(temp.PRNumber) AS TotalPR,COUNT(ItemName) AS TotalItem,SUM(temp.Qty) AS TotalItemQty,SUM(temp.TotalAmountAfterDiscountMainPO+temp.TotalVAT) AS TOTALAmount FROM 
		(
		SELECT b.id,a.CodeValue AS POCode,a.PoDate,
		f.CodeValue AS PRNumber,
		f.ReleasedDate AS PRDate,docstatus.DocInitial,docstatus.DocsDesc,docstatus.DocumentStatus,
		c.NameValue AS ItemName,a.SupplierId,a.RoundAmount,d.NameValue AS UOM,b.Qty,
		g.NameValue AS SupplierName,
		g.VAT,
		b.Discount AS PODetailDiscount,
		a.Discount AS PODiscount,
		b.SalesPrice,
		(b.Qty*b.SalesPrice) AS TotalAmountBeforeDiscount,
		b.Qty*b.SalesPrice*(b.Discount/100) AS TotalDiscountByPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100))) AS TotalAmountAfterDiscountPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))-(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(a.Discount/100)) AS TotalAmountAfterDiscountMainPO,
		ROUND(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(g.VAT/100),0) AS TotalVAT
		FROM dbo.PurchaseOrders a INNER JOIN dbo.PurchaseOrderDetails b ON a.id = b.PoId    
		INNER JOIN dbo.Items c ON c.id = b.ItemlId 
		INNER JOIN dbo.RefUomTypes d ON d.id  = b.UnitOfMeasurementType
		LEFT JOIN dbo.PurchaseRequisitionDetails e ON e.id = b.PRDetailId 
		LEFT JOIN dbo.PurchaseRequisitions f ON f.id = e.PurchaseRequsitionId
		INNER JOIN dbo.Suppliers g ON g.id = a.SupplierId
		OUTER APPLY (SELECT ds.NameValue AS DocumentStatus,dt.CodeValue AS DocInitial,dt.DescValue AS DocsDesc FROM dbo.RefDocumentStatuses ds INNER JOIN dbo.RefDocumentTypes dt ON dt.Id = ds.DocumentTypeId 
		WHERE ds.id = a.DocumentStatusId) AS docstatus
		) temp 
		GROUP BY temp.POCode,temp.DocumentStatus,temp.PoDate,temp.SupplierName
		) po_temp
		WHERE  po_temp.TotalPR >= 1 AND po_temp.PoDate BETWEEN '".$startdate."' AND '".$enddate."'";
		$query4 = $conn->query($po_item_qty_sql);
		$pr['details_po_item'] = $query4->result();
		$pr['total_item_qty'] = $query4->row()->TotalItemQty;
		$pr['total_item'] = $query4->row()->TotalItem;
		$pr['total_amount'] = $query4->row()->TOTALAmount;
		
		//Purchase Order Without PR
		$po_without_pr = " 
		SELECT * FROM 
		(
		SELECT temp.POCode,temp.PoDate,temp.DocumentStatus,temp.SupplierName,COUNT(temp.PRNumber) AS TotalPR,COUNT(ItemName) AS TotalItem,SUM(temp.Qty) AS TotalItemQty,SUM(temp.TotalAmountAfterDiscountMainPO+temp.TotalVAT) AS TOTALAmount FROM 
		(
		SELECT b.id,a.CodeValue AS POCode,a.PoDate,
		f.CodeValue AS PRNumber,
		f.ReleasedDate AS PRDate,docstatus.DocInitial,docstatus.DocsDesc,docstatus.DocumentStatus,
		c.NameValue AS ItemName,a.SupplierId,a.RoundAmount,d.NameValue AS UOM,b.Qty,
		g.NameValue AS SupplierName,
		g.VAT,
		b.Discount AS PODetailDiscount,
		a.Discount AS PODiscount,
		b.SalesPrice,
		(b.Qty*b.SalesPrice) AS TotalAmountBeforeDiscount,
		b.Qty*b.SalesPrice*(b.Discount/100) AS TotalDiscountByPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100))) AS TotalAmountAfterDiscountPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))-(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(a.Discount/100)) AS TotalAmountAfterDiscountMainPO,
		ROUND(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(g.VAT/100),0) AS TotalVAT
		FROM dbo.PurchaseOrders a INNER JOIN dbo.PurchaseOrderDetails b ON a.id = b.PoId    
		INNER JOIN dbo.Items c ON c.id = b.ItemlId 
		INNER JOIN dbo.RefUomTypes d ON d.id  = b.UnitOfMeasurementType
		LEFT JOIN dbo.PurchaseRequisitionDetails e ON e.id = b.PRDetailId 
		LEFT JOIN dbo.PurchaseRequisitions f ON f.id = e.PurchaseRequsitionId
		INNER JOIN dbo.Suppliers g ON g.id = a.SupplierId
		OUTER APPLY (SELECT ds.NameValue AS DocumentStatus,dt.CodeValue AS DocInitial,dt.DescValue AS DocsDesc FROM dbo.RefDocumentStatuses ds INNER JOIN dbo.RefDocumentTypes dt ON dt.Id = ds.DocumentTypeId 
		WHERE ds.id = a.DocumentStatusId) AS docstatus
		--WHERE docstatus.DocumentStatus != 'Draft' --AND a.CodeValue LIKE '%SHTS-PO-1402-000432%'
		) temp 
		GROUP BY temp.POCode,temp.DocumentStatus,temp.PoDate,temp.SupplierName
		) po_temp
		WHERE po_temp.TotalPR = 0 AND po_temp.PoDate BETWEEN '".$startdate."' AND '".$enddate."'";
		$query5 = $conn->query($po_without_pr);
		$pr['total_po_without_pr'] = $query5->num_rows();
		$pr['details_po_withoutpr_data'] = $query5->result();
		$pr['total_po_without_pr_supplier'] = $query5->num_rows();
		
		$po_without_pr_total = " 
		SELECT SUM(TotalItem) AS TotalItem,SUM(TOTALAmount) AS TotalAmount,SUM(TotalItemQty) AS TotalItemQty FROM 
		(
		SELECT temp.POCode,temp.PoDate,temp.DocumentStatus,temp.SupplierName,COUNT(temp.PRNumber) AS TotalPR,COUNT(ItemName) AS TotalItem,SUM(temp.Qty) AS TotalItemQty,SUM(temp.TotalAmountAfterDiscountMainPO+temp.TotalVAT) AS TOTALAmount FROM 
		(
		SELECT b.id,a.CodeValue AS POCode,a.PoDate,
		f.CodeValue AS PRNumber,
		f.ReleasedDate AS PRDate,docstatus.DocInitial,docstatus.DocsDesc,docstatus.DocumentStatus,
		c.NameValue AS ItemName,a.SupplierId,a.RoundAmount,d.NameValue AS UOM,b.Qty,
		g.NameValue AS SupplierName,
		g.VAT,
		b.Discount AS PODetailDiscount,
		a.Discount AS PODiscount,
		b.SalesPrice,
		(b.Qty*b.SalesPrice) AS TotalAmountBeforeDiscount,
		b.Qty*b.SalesPrice*(b.Discount/100) AS TotalDiscountByPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100))) AS TotalAmountAfterDiscountPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))-(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(a.Discount/100)) AS TotalAmountAfterDiscountMainPO,
		ROUND(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(g.VAT/100),0) AS TotalVAT
		FROM dbo.PurchaseOrders a INNER JOIN dbo.PurchaseOrderDetails b ON a.id = b.PoId    
		INNER JOIN dbo.Items c ON c.id = b.ItemlId 
		INNER JOIN dbo.RefUomTypes d ON d.id  = b.UnitOfMeasurementType
		LEFT JOIN dbo.PurchaseRequisitionDetails e ON e.id = b.PRDetailId 
		LEFT JOIN dbo.PurchaseRequisitions f ON f.id = e.PurchaseRequsitionId
		INNER JOIN dbo.Suppliers g ON g.id = a.SupplierId
		OUTER APPLY (SELECT ds.NameValue AS DocumentStatus,dt.CodeValue AS DocInitial,dt.DescValue AS DocsDesc FROM dbo.RefDocumentStatuses ds INNER JOIN dbo.RefDocumentTypes dt ON dt.Id = ds.DocumentTypeId 
		WHERE ds.id = a.DocumentStatusId) AS docstatus
		--WHERE docstatus.DocumentStatus != 'Draft' --AND a.CodeValue LIKE '%SHTS-PO-1402-000432%'
		) temp 
		GROUP BY temp.POCode,temp.DocumentStatus,temp.PoDate,temp.SupplierName
		) po_temp
		WHERE po_temp.TotalPR = 0 AND po_temp.PoDate BETWEEN '".$startdate."' AND '".$enddate."'";
		$query6 = $conn->query($po_without_pr_total);
		$pr['total_po_without_pr_item'] = $query6->row()->TotalItem;
		$pr['total_po_without_pr_item_qty'] = $query6->row()->TotalItemQty;
		$pr['total_po_without_pr_amount'] = $query6->row()->TotalAmount;
		
		//po consignment
		$po_consignment_sql ="
		SELECT * FROM 
		(
		SELECT temp.POCode,temp.PoDate,temp.DocumentStatus,temp.SupplierName,COUNT(ItemName) AS TotalItem,SUM(temp.Qty) AS TotalItemQty,SUM(temp.TotalAmountAfterDiscountMainPO+temp.TotalVAT) AS TOTALAmount FROM 
		(
		SELECT b.id,a.CodeValue AS POCode,a.PoDate,
		docstatus.DocInitial,docstatus.DocsDesc,docstatus.DocumentStatus,
		c.NameValue AS ItemName,a.SupplierId,a.RoundAmount,d.NameValue AS UOM,b.Qty,
		g.NameValue AS SupplierName,
		g.VAT,
		b.Discount AS PODetailDiscount,
		a.Discount AS PODiscount,
		b.SalesPrice,
		(b.Qty*b.SalesPrice) AS TotalAmountBeforeDiscount,
		b.Qty*b.SalesPrice*(b.Discount/100) AS TotalDiscountByPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100))) AS TotalAmountAfterDiscountPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))-(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(a.Discount/100)) AS TotalAmountAfterDiscountMainPO,
		ROUND(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(g.VAT/100),0) AS TotalVAT
		FROM dbo.PurchaseOrders a INNER JOIN dbo.PurchaseOrderDetails b ON a.id = b.PoId    
		INNER JOIN dbo.Items c ON c.id = b.ItemlId 
		INNER JOIN dbo.RefUomTypes d ON d.id  = b.UnitOfMeasurementType
		INNER JOIN dbo.PurchaseRequisitionConsigments e ON e.id = b.PRConsignmentId
		INNER JOIN dbo.Suppliers g ON g.id = a.SupplierId
		OUTER APPLY (SELECT ds.NameValue AS DocumentStatus,dt.CodeValue AS DocInitial,dt.DescValue AS DocsDesc FROM dbo.RefDocumentStatuses ds INNER JOIN dbo.RefDocumentTypes dt ON dt.Id = ds.DocumentTypeId 
		WHERE ds.id = a.DocumentStatusId) AS docstatus
		--WHERE docstatus.DocumentStatus != 'Draft' --AND a.CodeValue LIKE '%SHTS-PO-1402-000432%'
		) temp 
		GROUP BY temp.POCode,temp.DocumentStatus,temp.PoDate,temp.SupplierName
		) po_temp
		WHERE po_temp.PoDate BETWEEN '".$startdate."' AND '".$enddate."'";
		
		$query7 = $conn->query($po_consignment_sql);
		$pr['total_po_consignment'] = $query7->num_rows();
		$pr['total_po_consignment_data'] = $query7->result();
		
		//po consigment total
		
		$po_consigment_total_sql = "
		SELECT SUM(TotalItem) AS TotalItem,SUM(TotalItemQty) AS TotalItemQty,SUM(TOTALAmount) AS TotalAmount FROM 
		(
		SELECT temp.POCode,temp.PoDate,temp.DocumentStatus,temp.SupplierName,COUNT(ItemName) AS TotalItem,SUM(temp.Qty) AS TotalItemQty,SUM(temp.TotalAmountAfterDiscountMainPO+temp.TotalVAT) AS TOTALAmount FROM 
		(
		SELECT b.id,a.CodeValue AS POCode,a.PoDate,
		docstatus.DocInitial,docstatus.DocsDesc,docstatus.DocumentStatus,
		c.NameValue AS ItemName,a.SupplierId,a.RoundAmount,d.NameValue AS UOM,b.Qty,
		g.NameValue AS SupplierName,
		g.VAT,
		b.Discount AS PODetailDiscount,
		a.Discount AS PODiscount,
		b.SalesPrice,
		(b.Qty*b.SalesPrice) AS TotalAmountBeforeDiscount,
		b.Qty*b.SalesPrice*(b.Discount/100) AS TotalDiscountByPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100))) AS TotalAmountAfterDiscountPODetails,
		((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))-(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(a.Discount/100)) AS TotalAmountAfterDiscountMainPO,
		ROUND(((b.Qty*b.SalesPrice)-(b.Qty*b.SalesPrice*(b.Discount/100)))*(g.VAT/100),0) AS TotalVAT
		FROM dbo.PurchaseOrders a INNER JOIN dbo.PurchaseOrderDetails b ON a.id = b.PoId    
		INNER JOIN dbo.Items c ON c.id = b.ItemlId 
		INNER JOIN dbo.RefUomTypes d ON d.id  = b.UnitOfMeasurementType
		INNER JOIN dbo.PurchaseRequisitionConsigments e ON e.id = b.PRConsignmentId
		INNER JOIN dbo.Suppliers g ON g.id = a.SupplierId
		OUTER APPLY (SELECT ds.NameValue AS DocumentStatus,dt.CodeValue AS DocInitial,dt.DescValue AS DocsDesc FROM dbo.RefDocumentStatuses ds INNER JOIN dbo.RefDocumentTypes dt ON dt.Id = ds.DocumentTypeId 
		WHERE ds.id = a.DocumentStatusId) AS docstatus
		--WHERE docstatus.DocumentStatus != 'Draft' --AND a.CodeValue LIKE '%SHTS-PO-1402-000432%'
		) temp 
		GROUP BY temp.POCode,temp.DocumentStatus,temp.PoDate,temp.SupplierName
		) po_temp
		WHERE po_temp.PoDate BETWEEN '".$startdate."' AND '".$enddate."'";
		$query8 = $conn->query(	$po_consigment_total_sql);
		$pr['total_po_consignment_totalitem'] = $query8->row()->TotalItem;
		$pr['total_po_consignment_totalitem_qty'] = $query8->row()->TotalItemQty;
		$pr['total_po_consignment_total_amount'] = $query8->row()->TotalAmount;
		
		return $pr;
	}
	
	//function for good_receive notes
	
	function get_good_receive_notes_data($startdate,$enddate)
	{
		$this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
		//GRN ALl
        $grn_sql = "	SELECT DISTINCT grntemp.GRN_Code,grntemp.GrnDate,grntemp.GrnStatus FROM (
SELECT a.Id ,b.CodeValue AS PO_Code,b.PoDate,a.CodeValue AS GRN_Code,a.GrnDate ,a.StoreId ,e.NameValue AS Storename,a.ReceiptStoreId ,a.UserId ,a.CreateDate ,a.GrnStatus,
d.NameValue AS ItemName,c.Qty,c.IsBonus,f.CodeValue AS suppliercode,f.NameValue AS SupplierName,POQty.TotalQty AS QtyPO FROM dbo.GrnMasters a 
INNER JOIN  dbo.PurchaseOrders b ON b.id = a.PoId INNER JOIN dbo.GrnDetails c ON a.id = c.GrnMasterId 
INNER JOIN dbo.Items d ON d.id = c.ItemId INNER JOIN dbo.Stores e ON e.id = a.StoreId INNER JOIN dbo.Suppliers f ON f.id = b.SupplierId 
OUTER APPLY (SELECT SUM(Qty) AS TotalQty FROM dbo.PurchaseOrderDetails WHERE PoId = b.id) AS POQty
) AS grntemp WHERE grntemp.GrnDate BETWEEN '".$startdate."' AND '".$enddate."' ";
		$query1 = $conn->query($grn_sql);
		$grn['total_grn']= $query1->num_rows();
		$grn['details_grn_data'] = $query1->result();
		
		// GRN Partial
		$grn_partial_sql = "	SELECT DISTINCT grntemp.GRN_Code,grntemp.GrnDate,grntemp.GrnStatus FROM (
SELECT a.Id ,b.CodeValue AS PO_Code,b.PoDate,a.CodeValue AS GRN_Code,a.GrnDate ,a.StoreId ,e.NameValue AS Storename,a.ReceiptStoreId ,a.UserId ,a.CreateDate ,a.GrnStatus,
d.NameValue AS ItemName,c.Qty,c.IsBonus,f.CodeValue AS suppliercode,f.NameValue AS SupplierName,POQty.TotalQty AS QtyPO FROM dbo.GrnMasters a 
INNER JOIN  dbo.PurchaseOrders b ON b.id = a.PoId INNER JOIN dbo.GrnDetails c ON a.id = c.GrnMasterId 
INNER JOIN dbo.Items d ON d.id = c.ItemId INNER JOIN dbo.Stores e ON e.id = a.StoreId INNER JOIN dbo.Suppliers f ON f.id = b.SupplierId 
OUTER APPLY (SELECT SUM(Qty) AS TotalQty FROM dbo.PurchaseOrderDetails WHERE PoId = b.id) AS POQty
) AS grntemp WHERE grntemp.GrnDate BETWEEN '".$startdate."' AND '".$enddate."' AND grntemp.GrnStatus = 'P' ";
		$query2 = $conn->query($grn_partial_sql);
		$grn['total_grn_partial']= $query2->num_rows();
		$grn['details_grn_partial_data'] = $query2->result();
		
		// GRN Bonus
		$grn_bonus_sql = "	SELECT DISTINCT grntemp.GRN_Code,grntemp.GrnDate,grntemp.GrnStatus FROM (
		SELECT a.Id ,b.CodeValue AS PO_Code,b.PoDate,a.CodeValue AS GRN_Code,a.GrnDate ,a.StoreId ,e.NameValue AS Storename,a.ReceiptStoreId ,a.UserId ,a.CreateDate ,a.GrnStatus,
		d.NameValue AS ItemName,c.Qty,c.IsBonus,f.CodeValue AS suppliercode,f.NameValue AS SupplierName,POQty.TotalQty AS QtyPO FROM dbo.GrnMasters a 
		INNER JOIN  dbo.PurchaseOrders b ON b.id = a.PoId INNER JOIN dbo.GrnDetails c ON a.id = c.GrnMasterId 
		INNER JOIN dbo.Items d ON d.id = c.ItemId INNER JOIN dbo.Stores e ON e.id = a.StoreId INNER JOIN dbo.Suppliers f ON f.id = b.SupplierId 
		OUTER APPLY (SELECT SUM(Qty) AS TotalQty FROM dbo.PurchaseOrderDetails WHERE PoId = b.id) AS POQty
		) AS grntemp WHERE grntemp.GrnDate BETWEEN '".$startdate."' AND '".$enddate."' AND grntemp.IsBonus = 1 AND grntemp.QtyPO <> 0 ";
				$query3 = $conn->query($grn_bonus_sql);
		$grn['total_grn_bonus']= $query3->num_rows();
		$grn['details_grn_bonus_data'] = $query3->result();
		
		// Total GRN Item and Quantity
		$grn_item_qty_sql = "SELECT SUM(grn_temp.TotalItem) AS TotalItem,SUM(grn_temp.Quantity) AS TotalQty FROM 
			(
			SELECT DISTINCT grn.PO_Code,grn.PoDate,COUNT(grn.ItemName) AS TotalItem,SUM(grn.Qty) AS Quantity
			FROM (SELECT	a.Id ,
					b.CodeValue AS PO_Code,
					b.PoDate,
					a.CodeValue AS GRN_Code,
					a.GrnDate ,
					a.StoreId ,
					e.NameValue AS Storename,
					a.ReceiptStoreId ,
					a.UserId ,
					a.CreateDate ,
					a.GrnStatus,
					d.NameValue AS ItemName,
					c.Qty,
					c.IsBonus,
					f.CodeValue AS suppliercode,
					f.NameValue AS SupplierName,
					POQty.TotalQty AS QtyPO FROM dbo.GrnMasters a 
			INNER JOIN  dbo.PurchaseOrders b ON b.id = a.PoId
			INNER JOIN dbo.GrnDetails c ON a.id = c.GrnMasterId
			INNER JOIN dbo.Items d ON d.id = c.ItemId
			INNER JOIN dbo.Stores e ON e.id = a.StoreId
			INNER JOIN dbo.Suppliers f ON f.id = b.SupplierId
			OUTER APPLY (SELECT SUM(Qty) AS TotalQty FROM dbo.PurchaseOrderDetails WHERE PoId = b.id) AS POQty
			) grn WHERE grn.QtyPO <> 0 AND grn.GrnDate BETWEEN '".$startdate."' AND '".$enddate."'
			GROUP BY grn.PO_Code,grn.PoDate
			) grn_temp
		";
		$query4 = $conn->query($grn_item_qty_sql );
		$grn['total_grn_totalitem']= $query4->row()->TotalItem;
		$grn['total_grn_totalqty']= $query4->row()->TotalQty;
		
		// Total GRN Supplier
		
		$grn_supplier_sql = " 
		SELECT SUM(grntemp.TotalSupplier) AS TotalSupplier FROM 
			(
			SELECT DISTINCT grn.GrnDate,COUNT(DISTINCT(grn.GRN_Code)) AS TotalGRN,COUNT(DISTINCT(grn.SupplierName)) AS TotalSupplier
			FROM (SELECT	a.Id ,
					b.CodeValue AS PO_Code,
					b.PoDate,
					a.CodeValue AS GRN_Code,
					a.GrnDate ,
					a.StoreId ,
					e.NameValue AS Storename,
					a.ReceiptStoreId ,
					a.UserId ,
					a.CreateDate ,
					a.GrnStatus,
					d.NameValue AS ItemName,
					c.Qty,
					c.IsBonus,
					f.CodeValue AS suppliercode,
					f.NameValue AS SupplierName,
					POQty.TotalQty AS QtyPO FROM dbo.GrnMasters a 
			INNER JOIN  dbo.PurchaseOrders b ON b.id = a.PoId
			INNER JOIN dbo.GrnDetails c ON a.id = c.GrnMasterId
			INNER JOIN dbo.Items d ON d.id = c.ItemId
			INNER JOIN dbo.Stores e ON e.id = a.StoreId
			INNER JOIN dbo.Suppliers f ON f.id = b.SupplierId
			OUTER APPLY (SELECT SUM(Qty) AS TotalQty FROM dbo.PurchaseOrderDetails WHERE PoId = b.id) AS POQty
			) grn WHERE grn.QtyPO <> 0
			GROUP BY grn.GrnDate
			) grntemp WHERE grntemp.GrnDate BETWEEN '".$startdate."' AND '".$enddate."'		
		";
		$query5 = $conn->query($grn_supplier_sql);
		$grn['total_grn_supplier']= $query5->row()->TotalSupplier;
		
		// Total GRN Quantity
		$grn_quantity = " 
		
SELECT SUM(grn.Qty) AS Quantity
FROM (SELECT	a.Id ,
		b.CodeValue AS PO_Code,
		b.PoDate,
		a.CodeValue AS GRN_Code,
		a.GrnDate ,
		a.StoreId ,
		e.NameValue AS Storename,
		a.ReceiptStoreId ,
		a.UserId ,
		a.CreateDate ,
		a.GrnStatus,
		d.NameValue AS ItemName,
		c.Qty,
		c.IsBonus,
		f.CodeValue AS suppliercode,
		f.NameValue AS SupplierName,
		POQty.TotalQty AS QtyPO FROM dbo.GrnMasters a 
INNER JOIN  dbo.PurchaseOrders b ON b.id = a.PoId
INNER JOIN dbo.GrnDetails c ON a.id = c.GrnMasterId
INNER JOIN dbo.Items d ON d.id = c.ItemId
INNER JOIN dbo.Stores e ON e.id = a.StoreId
INNER JOIN dbo.Suppliers f ON f.id = b.SupplierId
OUTER APPLY (SELECT SUM(Qty) AS TotalQty FROM dbo.PurchaseOrderDetails WHERE PoId = b.id) AS POQty
) grn WHERE grn.QtyPO <> 0 AND grn.GrnDate BETWEEN '".$startdate."' AND '".$enddate."'	

		";
		$query6 = $conn->query($grn_quantity);
		$grn['total_qty_stock']= $query6->row()->Quantity;
	
        return $grn;	
	}
	
	// function to return to vendor
	
	function get_return_to_vendor_data($startdate,$enddate)
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	//total rtv transaction 
	$rtv_sql= "
				SELECT DISTINCT rtv.RtvCode AS rtvcode,rtv.RecordDate,COUNT(ItemName)AS TotalItem,SUM(Qty) AS TotalItemQty,COUNT(DISTINCT(rtv.SupplierId)) AS TotalSupplier FROM (
			SELECT 	a.CodeValue AS RtvCode,
					a.RecordDate ,
					a.SupplierId ,
					a.Remark ,
					e.NameValue AS DocumentStatus,
					f.NameValue AS StoreName,
					b.Qty,b.ReasonId,d.NameValue AS ItemName,c.NameValue AS SupplierName FROM dbo.ItemReturs a INNER JOIN dbo.ItemReturDetails b ON b.ItemReturId = a.Id
			INNER JOIN dbo.Suppliers c ON c.id = a.SupplierId
			INNER JOIN items d ON d.id = b.ItemReturId
			INNER JOIN dbo.RefDocumentStatuses e ON e.id = a.DocumentStatusId
			INNER JOIN dbo.Stores f ON f.Id = a.StoreId
			) rtv
			WHERE rtv.RecordDate BETWEEN '".$startdate."' AND '".$enddate."'	
			GROUP BY rtv.RtvCode,rtv.RecordDate
	";
	$return_to_vendor = $conn->query($rtv_sql);
	$rtv['total_rtv'] = $return_to_vendor->num_rows();
	$rtv['details_rtv_trans_data'] = $return_to_vendor->result();
	
	//initial data rtv
		$rtv['total_rtv_item'] = 0;
		$rtv['total_rtv_item_qty'] = 0;
		$rtv['total_rtv_supplier'] = 0;
	
	foreach($return_to_vendor->result() as $rtv_data)
	{
	$rtv['total_rtv_item'] = $rtv['total_rtv_item'] + $rtv_data->TotalItem;
	$rtv['total_rtv_item_qty']  = $rtv['total_rtv_item_qty']  + $rtv_data->TotalItemQty;
	$rtv['total_rtv_supplier'] = $rtv['total_rtv_supplier'] + $rtv_data->TotalSupplier;
	}
	return $rtv;
	
	
	}
	
	//function get data stock requisition
	
	function get_stock_requisition_data($startdate,$enddate)
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$sr_sql = "	
		SELECT * FROM dbo.VStockRequesitionHeaders a
		OUTER APPLY (SELECT StockTransferId,COUNT(ItemId)AS TotalItem,SUM(Qty) AS TotalItemQty FROM 
		dbo.VStockRequesitionDetails WHERE StockTransferId = a.Id
		GROUP BY StockTransferId) b
		WHERE a.RequestDate BETWEEN '".$startdate."' AND '".$enddate."'
	";
	$stock_requisition = $conn->query($sr_sql);
		$sr['total_sr'] = $stock_requisition->num_rows();
		$sr['total_store_request'] = $stock_requisition->num_rows();
		$sr['details_stock_requistion_data'] = $stock_requisition->result();
	
	//initial data rtv
		$sr['total_sr_item'] = 0;
		$sr['total_sr_item_qty'] = 0;
	
	foreach($stock_requisition->result() as $sr_data)
	{
	$sr['total_sr_item'] = $sr['total_sr_item'] + $sr_data->TotalItem;
	$sr['total_sr_item_qty']  = $sr['total_sr_item_qty']  + $sr_data->TotalItemQty;

	}
	return $sr;
	
	}
	
	// Function get data Transfer In Transfer Out
	
	function get_data_transfer_stock($startdate,$enddate)
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
		$to_sql ="
		SELECT transferitem.RequestNumber,transferitem.RecordTime,transferitem.FromStoreId,transferitem.ToStoreId,COUNT(1) AS TotalItem,SUM(transferitem.Qty) AS TotalItemQty  FROM (
			SELECT a.*,b.NameValue AS ItemName,d.RequestNumber,
			CASE WHEN a.InOut = 0 THEN 'IN' ELSE 'OUT' END AS TransferType
			FROM dbo.StockTransferFullFills a INNER JOIN dbo.Items b ON b.id = a.ItemId
			INNER JOIN dbo.StockTransferDetails c ON c.Id = a.StockTransferDetailId
			INNER JOIN dbo.StockTransfers d ON d.id = c.StockTransferId
			) transferitem
			WHERE transferitem.TransferType = 'OUT' AND (CONVERT(date,transferitem.RecordTime) BETWEEN '".$startdate."' AND '".$enddate."')
			GROUP BY transferitem.RequestNumber,transferitem.RecordTime,transferitem.FromStoreId,transferitem.ToStoreId
		";
		$ti_sql ="
		SELECT transferitem.RequestNumber,transferitem.RecordTime,transferitem.FromStoreId,transferitem.ToStoreId,COUNT(1) AS TotalItem,SUM(transferitem.Qty) AS TotalItemQty  FROM (
			SELECT a.*,b.NameValue AS ItemName,d.RequestNumber,
			CASE WHEN a.InOut = 0 THEN 'IN' ELSE 'OUT' END AS TransferType
			FROM dbo.StockTransferFullFills a INNER JOIN dbo.Items b ON b.id = a.ItemId
			INNER JOIN dbo.StockTransferDetails c ON c.Id = a.StockTransferDetailId
			INNER JOIN dbo.StockTransfers d ON d.id = c.StockTransferId
			) transferitem
			WHERE transferitem.TransferType = 'IN' AND (CONVERT(date,transferitem.RecordTime) BETWEEN '".$startdate."' AND '".$enddate."')
			GROUP BY transferitem.RequestNumber,transferitem.RecordTime,transferitem.FromStoreId,transferitem.ToStoreId
		";
		
		$transfer_out = $conn->query($to_sql);
		$transfer_in = $conn->query($ti_sql);
		
		$transfer_item['total_to'] = $transfer_out->num_rows();
		$transfer_item['details_to_item_data'] = $transfer_out->result();
		
		$transfer_item['total_ti'] = $transfer_in->num_rows();
		$transfer_item['details_ti_item_data'] = $transfer_in->result();
		$transfer_item['total_to_stores'] = $transfer_out->num_rows();
		$transfer_item['total_ti_stores'] = $transfer_in->num_rows();
		$transfer_item['total_ti_item'] = 0;
		$transfer_item['total_ti_item_qty'] = 0;
			foreach($transfer_in->result() as $ti_data)
			{
				$transfer_item['total_ti_item'] = $transfer_item['total_ti_item'] + $ti_data->TotalItem;
				$transfer_item['total_ti_item_qty'] = $transfer_item['total_ti_item_qty'] + $ti_data->TotalItemQty;
			}
		$transfer_item['total_to_item'] = 0 ;
		$transfer_item['total_to_item_qty'] = 0;
			foreach($transfer_out->result() as $to_data)
			{
				$transfer_item['total_to_item'] = $transfer_item['total_to_item'] + $to_data->TotalItem;
				$transfer_item['total_to_item_qty'] = $transfer_item['total_to_item_qty'] + $to_data->TotalItemQty;
			}
			
		return $transfer_item;
	
	}
	
	function get_adjustment_data($startdate,$enddate)
	{
	$this->set_db();
	$conn = $conn =	$this->load->database($this->set_db(),true);
	$stock_adj_sql  = "					
			SELECT itemadj.CodeValue,itemadj.RecordDate,itemadj.UserId,itemadj.DocumentStatus,itemadj.AdjustmentReasons,itemadj.StoreId,COUNT(itemadj.ItemName) AS TotalItem,SUM(itemadj.Qty) AS TotalItemQty FROM 
			(
			SELECT a.*,f.NameValue AS AdjustmentReasons,e.NameValue AS DocumentStatus,b.InOut
			,b.Qty,d.NameValue AS ItemName FROM dbo.ItemStockAdjusts a INNER JOIN dbo.ItemStockAdjustDetails b ON a.id = b.ItemStockAdjustId
			INNER JOIN dbo.ItemBatchNumbers c ON c.id = b.ItemBatchNumberId 
			INNER JOIN dbo.Items d ON d.id = c.ItemId
			INNER JOIN dbo.RefDocumentStatuses e ON e.id = a.DocumentStatusId
			LEFT JOIN dbo.RefReasonAdjusts f ON f.Id = a.Reason AND f.AdjustmentTypeId = a.AdjustmentTypeId
			WHERE e.NameValue != 'Draft' AND a.CodeValue LIKE '%ADJ%'
			) itemadj
			WHERE itemadj.RecordDate BETWEEN '".$startdate."' AND '".$enddate."'
			GROUP BY 
			itemadj.CodeValue,itemadj.RecordDate,itemadj.UserId,itemadj.DocumentStatus,itemadj.AdjustmentReasons,itemadj.StoreId
	
	";
	
	$stock_ncc_sql_regular  = "
			SELECT itemadj.CodeValue,itemadj.RecordDate,itemadj.UserId,itemadj.DocumentStatus,itemadj.AdjustmentReasons,itemadj.StoreId,COUNT(itemadj.ItemName) AS TotalItem,SUM(itemadj.Qty) AS TotalItemQty FROM 
			(
			SELECT a.*,f.NameValue AS AdjustmentReasons,e.NameValue AS DocumentStatus,b.InOut 
			,b.Qty,d.NameValue AS ItemName FROM dbo.ItemStockAdjusts a INNER JOIN dbo.ItemStockAdjustDetails b ON a.id = b.ItemStockAdjustId 
			INNER JOIN dbo.ItemBatchNumbers c ON c.id = b.ItemBatchNumberId  
			INNER JOIN dbo.Items d ON d.id = c.ItemId 
			INNER JOIN dbo.RefDocumentStatuses e ON e.id = a.DocumentStatusId 
			LEFT JOIN dbo.RefReasonAdjusts f ON f.Id = a.Reason AND f.AdjustmentTypeId = a.AdjustmentTypeId 
			WHERE e.NameValue != 'Draft' AND a.CodeValue LIKE '%NCC%' 
			) itemadj 
			WHERE itemadj.RecordDate BETWEEN '".$startdate."' AND '".$enddate."' AND itemadj.AdjustmentReasons like '%Regular%' 
			GROUP BY 
			itemadj.CodeValue,itemadj.RecordDate,itemadj.UserId,itemadj.DocumentStatus,itemadj.AdjustmentReasons,itemadj.StoreId 
	
	";
	
	$stock_ncc_sql_damage  = "
			SELECT itemadj.CodeValue,itemadj.RecordDate,itemadj.UserId,itemadj.DocumentStatus,itemadj.AdjustmentReasons,itemadj.StoreId,COUNT(itemadj.ItemName) AS TotalItem,SUM(itemadj.Qty) AS TotalItemQty FROM 
			(
			SELECT a.*,f.NameValue AS AdjustmentReasons,e.NameValue AS DocumentStatus,b.InOut,b.Qty,d.NameValue AS ItemName FROM dbo.ItemStockAdjusts a INNER JOIN dbo.ItemStockAdjustDetails b ON a.id = b.ItemStockAdjustId 
			INNER JOIN dbo.ItemBatchNumbers c ON c.id = b.ItemBatchNumberId  
			INNER JOIN dbo.Items d ON d.id = c.ItemId 
			INNER JOIN dbo.RefDocumentStatuses e ON e.id = a.DocumentStatusId 
			LEFT JOIN dbo.RefReasonAdjusts f ON f.Id = a.Reason AND f.AdjustmentTypeId = a.AdjustmentTypeId 
			WHERE e.NameValue != 'Draft' AND a.CodeValue LIKE '%NCC%' 
			) itemadj 
			WHERE (itemadj.RecordDate BETWEEN '".$startdate."' AND '".$enddate."') AND itemadj.AdjustmentReasons like '%Damage%' 
			GROUP BY  
			itemadj.CodeValue,itemadj.RecordDate,itemadj.UserId,itemadj.DocumentStatus,itemadj.AdjustmentReasons,itemadj.StoreId 
	
	";
	
	$stock_ilc_sql  = "
			SELECT itemadj.CodeValue,itemadj.RecordDate,itemadj.UserId,itemadj.DocumentStatus,itemadj.AdjustmentReasons,itemadj.StoreId,COUNT(itemadj.ItemName) AS TotalItem,SUM(itemadj.Qty) AS TotalItemQty FROM 
			( 
			SELECT a.*,f.NameValue AS AdjustmentReasons,e.NameValue AS DocumentStatus,b.InOut 
			,b.Qty,d.NameValue AS ItemName FROM dbo.ItemStockAdjusts a INNER JOIN dbo.ItemStockAdjustDetails b ON a.id = b.ItemStockAdjustId 
			INNER JOIN dbo.ItemBatchNumbers c ON c.id = b.ItemBatchNumberId 
			INNER JOIN dbo.Items d ON d.id = c.ItemId 
			INNER JOIN dbo.RefDocumentStatuses e ON e.id = a.DocumentStatusId 
			LEFT JOIN dbo.RefReasonAdjusts f ON f.Id = a.Reason AND f.AdjustmentTypeId = a.AdjustmentTypeId 
			WHERE e.NameValue != 'Draft' AND a.CodeValue LIKE '%ILC%' 
			) itemadj 
			WHERE itemadj.RecordDate BETWEEN '".$startdate."' AND '".$enddate."' 
			GROUP BY 
			itemadj.CodeValue,itemadj.RecordDate,itemadj.UserId,itemadj.DocumentStatus,itemadj.AdjustmentReasons,itemadj.StoreId 
	";
	
	$stock_adjustment = $conn->query($stock_adj_sql );
	$non_chargeable_regular = $conn->query($stock_ncc_sql_regular);
	$non_chargeable_damage = $conn->query($stock_ncc_sql_damage);
	$indirect_chargeable = $conn->query($stock_ilc_sql);
	
	$adj['total_adjustment'] = $stock_adjustment->num_rows();
	$adj['details_adj_data'] = $stock_adjustment->result();
	$adj['details_adj_ncr_data'] = $non_chargeable_regular->result();
	$adj['details_adj_idc_data'] = $indirect_chargeable->result();
	$adj['details_adj_ncr_damage_data'] = $non_chargeable_damage->result();
	
	$adj['total_adjustment_stores'] = 	$adj['total_adjustment'];
	$adj['total_adjustment_item'] = 0;
	$adj['total_adjustment_item_qty'] = 0;
	$adj['total_adjustment_regular'] = $non_chargeable_regular->num_rows();
	$adj['total_adjustment_regular_item'] = 0;
	$adj['total_adjustment_regular_item_qty'] = 0;
	$adj['total_adjustment_damage'] = $non_chargeable_damage->num_rows();
	$adj['total_adjustment_damage_item'] = 0;
	$adj['total_adjustment_damage_item_qty'] = 0;
	$adj['total_adjustment_indirect'] = $indirect_chargeable->num_rows();
	$adj['total_adjustment_indirect_item'] = 0;
	$adj['total_adjustment_indirect_item_qty'] = 0;
	
	
	foreach($stock_adjustment->result() as $adjusmentdetail)
	{
	$adj['total_adjustment_item'] = $adj['total_adjustment_item'] + $adjusmentdetail->TotalItem;
	$adj['total_adjustment_item_qty'] = $adj['total_adjustment_item_qty'] + $adjusmentdetail->TotalItemQty;
	}
	
	foreach($non_chargeable_regular->result() as $ncr)
	{
	$adj['total_adjustment_regular_item'] = $adj['total_adjustment_regular_item'] + $ncr->TotalItem;
	$adj['total_adjustment_regular_item_qty'] = $adj['total_adjustment_regular_item_qty'] + $ncr->TotalItemQty;
	}
	
	foreach($non_chargeable_damage->result() as $ncd)
	{
	$adj['total_adjustment_damage_item'] = $adj['total_adjustment_damage_item'] + $ncd->TotalItem;
	$adj['total_adjustment_damage_item_qty'] = $adj['total_adjustment_damage_item_qty'] + $ncd->TotalItemQty;
	}
	
	foreach($indirect_chargeable->result() as $icc)
	{
	$adj['total_adjustment_indirect_item'] = $adj['total_adjustment_indirect_item'] + $icc->TotalItem;
	$adj['total_adjustment_indirect_item_qty'] = $adj['total_adjustment_indirect_item_qty'] + $icc->TotalItemQty;
	}	
	
	
	return $adj;
	
	}
	
	
	
	

}