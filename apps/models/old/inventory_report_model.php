<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inventory_report_model extends CI_Model
{

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
        $config['pconnect'] = false;
        $config['db_debug'] = true;
        $config['cache_on'] = false;
        $config['cachedir'] = "";
        $config['char_set'] = "utf8";
        $config['dbcollat'] = "utf8_general_ci";
        return $config;
    }

    //---------------------------------Tracking Item---------------------------------------------
    function get_item_tracking($keyword)
    {

        $this->set_db();
        $data['connected_on'] = $this->session->userdata('db_name') . ' ' . $this->
            session->userdata('db_host');
        $conn = $this->load->database($this->set_db(), true);
        $sql = "SELECT TOP 50 Items.Id,Items.CodeValue,Items.NameValue,buy.NameValue as 'uom_buy',sell.NameValue as 'uom_sell', CASE items.IsFormularium WHEN 0 Then 'NO' WHEN 1 Then 'YES' ELSE 'Not Set' END AS IsFormularium,
			CASE items.RecordStatus  WHEN 0 Then 'Not Active' WHEN 1 Then 'Active' ELSE 'Not Set' END AS 'RecordStatus',ROW_NUMBER() OVER (ORDER BY Items.Id) AS 'RowNumber' from Items LEFT JOIN RefUomTypes buy ON Items.BuyUomId=buy.Id LEFT JOIN RefUomTypes sell ON Items.SellUomId=sell.Id
			WHERE Items.CodeValue like '%$keyword%' OR Items.NameValue like '%$keyword%'";
        $query = $conn->query($sql);
        return $query->result();
    }

    function get_store_stock($store_code)
    {
        $this->set_db();
        $data['connected_on'] = $this->session->userdata('db_name') . ' ' . $this->
            session->userdata('db_host');
        $conn = $this->load->database($this->set_db(), true);
        $sql = "
		Select * FROM (
		select
		c.CodeValue as ItemCode,
		c.NameValue as ItemName,
		case when substring(c.codevalue,1,2)='PH' then 'Drugs' else 'MedicalSupplies' end as Categories,
		e.Id as StoreId,
		e.NameValue StoreName,
		sum(a.InValue - a.OutValue) as StockOnHand,
		c.CostValue UnitCost
		from
		ItemStocks a inner join ItemBatchNumbers b on a.ItemBatchNumberId = b.Id
		inner join Items c on c.Id= b.ItemId
		inner join ItemStores d on d.Id= a.ItemStoreId
		inner join Stores e on e.Id= d.StoreId
		where 
		not exists (select 1 from GSCDetails where ItemId  = c.Id)
		group by 
		c.CodeValue,
		c.NameValue,
		e.Id,
		e.NameValue,
		c.CostValue)a
	WHERE A.StoreName = '" . $store_code . "'";
        $query = $conn->query($sql);
        return $query->result();
    }

    function get_all_expire($stardate, $enddate)
    {
        $this->set_db();
        $data['connected_on'] = $this->session->userdata('db_name') . ' ' . $this->
            session->userdata('db_host');
        $conn = $this->load->database($this->set_db(), true);
        $sql = " SELECT
	TOP (100) PERCENT a.ItemStoreId,
	a.StoreId,
	c.NameValue AS StoreName,
	a.ItemId,
	a.ItemName,
	a.BatchNumberLocal AS BatchNo,
	a.BarCode AS BatchBarcode,
	a.QtyOnHand AS QtyOnBatch,
	a.SellUomId,
	a.SellUom,
	d.CodeValue,
	a.SuppName,
	CONVERT (
		VARCHAR (10),
		a.ExpiredDate,
		121
	) AS ExpDate,
	a.ItemCode,
	a.CostValuePerItem
FROM
	dbo.VItemStockBatchNumbers AS a
LEFT OUTER JOIN dbo.Stores AS c ON a.StoreId = c.Id
LEFT OUTER JOIN dbo.GrnMasters AS d ON a.POId = d.Id
WHERE (a.QtyOnHand > 0)
AND (a.BatchNumberLocal <> '')
AND CONVERT (VARCHAR (10), a.ExpiredDate,121) BETWEEN '" . $stardate .
            "' AND  '" . $enddate . "'";
        $query = $conn->query($sql);
        return $query->result();
    }

    function get_name_item_expire($stardate, $enddate, $code_item)
    {
        $this->set_db();
        $data['connected_on'] = $this->session->userdata('db_name') . ' ' . $this->
            session->userdata('db_host');
        $conn = $this->load->database($this->set_db(), true);
        $sql = " SELECT
	TOP (100) PERCENT a.ItemStoreId,
	a.StoreId,
	c.NameValue AS StoreName,
	a.ItemId,
	a.ItemName,
	a.BatchNumberLocal AS BatchNo,
	a.BarCode AS BatchBarcode,
	a.QtyOnHand AS QtyOnBatch,
	a.SellUomId,
	a.SellUom,
	d.CodeValue,
	a.SuppName,
	CONVERT (
		VARCHAR (10),
		a.ExpiredDate,
		121
	) AS ExpDate,
	a.ItemCode,
	a.CostValuePerItem
FROM
	dbo.VItemStockBatchNumbers AS a
LEFT OUTER JOIN dbo.Stores AS c ON a.StoreId = c.Id
LEFT OUTER JOIN dbo.GrnMasters AS d ON a.POId = d.Id
WHERE (a.QtyOnHand > 0)
AND (a.BatchNumberLocal <> '')
AND CONVERT (VARCHAR (10), a.ExpiredDate,121) BETWEEN '" . $stardate .
            "' AND  '" . $enddate . "'
AND a.ItemId = '" . $code_item . "'";
        $query = $conn->query($sql);
        return $query->result();
    }

    function get_store_item_expire($stardate, $enddate, $store_code)
    {
        $this->set_db();
        $data['connected_on'] = $this->session->userdata('db_name') . ' ' . $this->
            session->userdata('db_host');
        $conn = $this->load->database($this->set_db(), true);
        $sql = " SELECT
	TOP (100) PERCENT a.ItemStoreId,
	a.StoreId,
	c.NameValue AS StoreName,
	a.ItemId,
	a.ItemName,
	a.BatchNumberLocal AS BatchNo,
	a.BarCode AS BatchBarcode,
	a.QtyOnHand AS QtyOnBatch,
	a.SellUomId,
	a.SellUom,
	d.CodeValue,
	a.SuppName,
	CONVERT (
		VARCHAR (10),
		a.ExpiredDate,
		121
	) AS ExpDate,
	a.ItemCode,
	a.CostValuePerItem
FROM
	dbo.VItemStockBatchNumbers AS a
LEFT OUTER JOIN dbo.Stores AS c ON a.StoreId = c.Id
LEFT OUTER JOIN dbo.GrnMasters AS d ON a.POId = d.Id
WHERE (a.QtyOnHand > 0)
AND (a.BatchNumberLocal <> '')
AND CONVERT (VARCHAR (10), a.ExpiredDate,121) BETWEEN '" . $stardate .
            "' AND  '" . $enddate . "'
AND a.StoreId = '" . $store_code . "'";
        $query = $conn->query($sql);
        return $query->result();
    }

    function get_name_item_detail($code_item)
    {
        $this->set_db();
        $data['connected_on'] = $this->session->userdata('db_name') . ' ' . $this->
            session->userdata('db_host');
        $conn = $this->load->database($this->set_db(), true);
        $sql = " SELECT
	TOP (100) PERCENT a.ItemStoreId,
	a.StoreId,
	c.NameValue AS StoreName,
	a.ItemId,
	a.ItemName,
	a.BatchNumberLocal AS BatchNo,
	a.BarCode AS BatchBarcode,
	d.CodeValue,
	a.SuppName,
	CONVERT (
		VARCHAR (10),
		a.ExpiredDate,
		121
	) AS ExpDate,
	a.ItemCode,
	a.CostValuePerItem
FROM
	dbo.VItemStockBatchNumbers AS a
LEFT OUTER JOIN dbo.Stores AS c ON a.StoreId = c.Id
LEFT OUTER JOIN dbo.GrnMasters AS d ON a.POId = d.Id
WHERE (a.QtyOnHand > 0)
AND (a.BatchNumberLocal <> '')
AND CONVERT (VARCHAR (10), a.ExpiredDate,121) BETWEEN '" . $stardate .
            "' AND  '" . $enddate . "'
AND a.ItemId = '" . $code_item . "'";
        $query = $conn->query($sql);
        return $query->row();
    }

    function get_store_item_detail($store_code)
    {
        $this->set_db();
        $data['connected_on'] = $this->session->userdata('db_name') . ' ' . $this->
            session->userdata('db_host');
        $conn = $this->load->database($this->set_db(), true);
        $sql = " SELECT
	TOP (100) PERCENT a.ItemStoreId,
	a.StoreId,
	c.NameValue AS StoreName,
	a.ItemId,
	a.ItemName,
	a.BatchNumberLocal AS BatchNo,
	a.BarCode AS BatchBarcode,
	d.CodeValue,
	a.SuppName,
	CONVERT (
		VARCHAR (10),
		a.ExpiredDate,
		121
	) AS ExpDate,
	a.ItemCode,
	a.CostValuePerItem
FROM
	dbo.VItemStockBatchNumbers AS a
LEFT OUTER JOIN dbo.Stores AS c ON a.StoreId = c.Id
LEFT OUTER JOIN dbo.GrnMasters AS d ON a.POId = d.Id
WHERE (a.QtyOnHand > 0)
AND (a.BatchNumberLocal <> '')
AND CONVERT (VARCHAR (10), a.ExpiredDate,121) BETWEEN '" . $stardate .
            "' AND  '" . $enddate . "'
AND a.StoreId = '" . $store_code . "'";
        $query = $conn->query($sql);
        return $query->row();
    }

    function get_store_stock_detail($store_code)
    {
        $this->set_db();
        $data['connected_on'] = $this->session->userdata('db_name') . ' ' . $this->
            session->userdata('db_host');
        $conn = $this->load->database($this->set_db(), true);
        $sql = " SELECT
	TOP (100) PERCENT a.ItemStoreId,
	a.StoreId,
	c.NameValue AS StoreName,
	a.ItemId,
	a.ItemName,
	a.BatchNumberLocal AS BatchNo,
	a.BarCode AS BatchBarcode,
	d.CodeValue,
	a.SuppName,
	CONVERT (
		VARCHAR (10),
		a.ExpiredDate,
		121
	) AS ExpDate,
	a.ItemCode,
	a.CostValuePerItem
FROM
	dbo.VItemStockBatchNumbers AS a
LEFT OUTER JOIN dbo.Stores AS c ON a.StoreId = c.Id
LEFT OUTER JOIN dbo.GrnMasters AS d ON a.POId = d.Id
WHERE (a.QtyOnHand > 0)
AND (a.BatchNumberLocal <> '')
AND CONVERT (VARCHAR (10), a.ExpiredDate,121) BETWEEN '" . $stardate .
            "' AND  '" . $enddate . "'
AND a.StoreId = '" . $store_code . "'";
        $query = $conn->query($sql);
        return $query->row();
    }

    function get_all_store_stock($datestart, $dateend)
    {
        $this->set_db();
        $data['connected_on'] = $this->session->userdata('db_name') . ' ' . $this->
            session->userdata('db_host');
        $conn = $this->load->database($this->set_db(), true);
        $sql = "
		SELECT
	c.CodeValue AS ItemCode,
	c.NameValue AS ItemName,
	e.Id AS StoreId,
	e.NameValue StoreName,
	SUM (
		isnull(a.InValue, 0) - isnull(a.OutValue, 0)
	) AS StockOnHand,
	isnull(c.CostValue, 0) CostValue,
	SUM (
		isnull(a.InValue, 0) - isnull(a.OutValue, 0)
	) * isnull(c.CostValue, 0) TotalCost
FROM
	ItemStocks a
INNER JOIN ItemStores b ON a.ItemStoreId = b.Id
INNER JOIN Items c ON c.Id = b.ItemId
INNER JOIN Stores e ON e.Id = b.StoreId
WHERE
	a.RecordDate BETWEEN '" . $datestart . "' AND '" . $dateend .
            "' --and c.RecordStatus=0
	--and e.RecordStatus=1
GROUP BY
	c.CodeValue,
	c.NameValue,
	e.Id,
	e.NameValue,
	c.CostValue
ORDER BY
	e.Id,
	c.CodeValue";
        $query = $conn->query($sql);
        return $query->result();
    }
    
    function get_spes_store_stock($datestart, $dateend, $storecode)
    {
        $this->set_db();
        $data['connected_on'] = $this->session->userdata('db_name') . ' ' . $this->
            session->userdata('db_host');
        $conn = $this->load->database($this->set_db(), true);
        $sql = "
		SELECT
	c.CodeValue AS ItemCode,
	c.NameValue AS ItemName,
	e.Id AS StoreId,
	e.NameValue StoreName,
	SUM (
		isnull(a.InValue, 0) - isnull(a.OutValue, 0)
	) AS StockOnHand,
	isnull(c.CostValue, 0) CostValue,
	SUM (
		isnull(a.InValue, 0) - isnull(a.OutValue, 0)
	) * isnull(c.CostValue, 0) TotalCost
FROM
	ItemStocks a
INNER JOIN ItemStores b ON a.ItemStoreId = b.Id
INNER JOIN Items c ON c.Id = b.ItemId
INNER JOIN Stores e ON e.Id = b.StoreId
WHERE
	a.RecordDate BETWEEN '" . $datestart . "' AND '" . $dateend .
            "' and e.Id = '".$storecode."' --and c.RecordStatus=0
	--and e.RecordStatus=1
GROUP BY
	c.CodeValue,
	c.NameValue,
	e.Id,
	e.NameValue,
	c.CostValue
ORDER BY
	e.Id,
	c.CodeValue";
        $query = $conn->query($sql);
        return $query->result();
    }

    function get_list_store()
    {
        $this->set_db();
        $data['connected_on'] = $this->session->userdata('db_name') . ' ' . $this->
            session->userdata('db_host');
        $conn = $this->load->database($this->set_db(), true);
        $sql = "
		SELECT
	e.Id AS StoreId,
	e.NameValue StoreName
FROM
	ItemStocks a
INNER JOIN ItemStores b ON a.ItemStoreId = b.Id
INNER JOIN Stores e ON e.Id = b.StoreId
GROUP BY
	e.Id,
	e.NameValue
ORDER BY
	e.Id,
	e.NameValue";
        $query = $conn->query($sql);
        return $query->result();
    }
}
