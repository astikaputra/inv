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
	$sql = "SELECT TOP(50) Items.Id,Items.CodeValue,Items.NameValue,buy.NameValue as 'uom_buy',sell.NameValue as 'uom_sell', CASE items.IsFormularium WHEN 0 Then 'NO' WHEN 1 Then 'YES' ELSE 'Not Set' END AS IsFormularium,
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
	$sql = "select PriceClass,PriceAmount from VPricelistItems WHERE PriceCode='".$item_code."'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_stock($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT DISTINCT BarCode,StoreName,QtyOnHand FROM VItemStockBatchNumbers WHERE ItemCode='".$item_code."'";
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
	$sql = "select vgd.CodeValue AS 'nomor_po',gm.CodeValue as 'nomor_grn',vgd.QtyPo,vgd.QtyGrn,vgd.ExpiredDate,vgd.BatchNumberLocal from VGrnDetail vgd INNER JOIN GrnMasters gm ON vgd.GrnMstId=gm.Id WHERE vgd.ItemCode='".$item_code."'";
	$query =  $conn->query($sql);
	return $query->result();
	}
	//--------------------------------- Update Items -------------------------------------------------
	
	function set_activate($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "UPDATE Items SET isFormularium=1,RecordStatus=1 WHERE CodeValue='".$item_code."'";
	$query =  $conn->query($sql);
	}
	
	function set_deactivate($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "UPDATE Items SET RecordStatus=0 WHERE CodeValue='".$item_code."'";
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
	

	
}