<?php

class Mst_model extends CI_Model {
	
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

//----------------------------------------Function Get Basic Data --------------------------/
	/*-------------Get All Item Data ------------------*/
	function get_item($keyword=NULL) 
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$conn->like('CodeValue',$keyword);
	$conn->or_like('NameValue',$keyword);
	$conn->limit(50);
	return $conn->get('Items')->result();
	}
	
	/*-------------Get All Item Services Data ------------------*/
	function get_item_services($keyword=NULL) 
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$conn->like('CodeValue',$keyword);
	$conn->or_like('NameValue',$keyword);
	$conn->limit(50);
	return $conn->get('ItemServices')->result();
	}
	
	/*-------------Get All Item Services Data ------------------*/
	function get_stores() 
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	return $conn->get('Stores')->result();
	}
	
	//---------------------------------HELPER FUNCTION---------------------------------------------
	function get_uom() 
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$conn->where('RecordStatus',1);
	return $conn->get('RefUomTypes')->result();
	}
	function get_item_types() 
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$conn->where('RecordStatus',1);
	return $conn->get('RefItemTypes')->result();
	}
	function get_shapes() 
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$conn->where('RecordStatus',1);
	return $conn->get('RefItemShapes')->result();
	}
	
	
//---------------------------------------------------- Start Item Module -------------------------------------------
	
	// assign item to store ------------ mst1 mst2 modul 
	function auto_assign_item_to_store() //MST 2 Set one item to all Locations
	{  
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "INSERT Into ItemStores select a.Id,b.Id,100,1,0 from Items a, Stores b WHERE CONVERT(varchar,a.Id)+'-'+CONVERT(varchar,b.Id) NOT IN (select CONVERT(varchar,ItemId)+'-'+CONVERT(varchar,StoreId) from ItemStores)";
	$query =  $conn->query($sql);
	return $conn->trans_status();
	}
	
	
	function assign_item_to_store($item_id) //MST 1
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "INSERT Into ItemStores select a.Id,b.Id,100,1,0 from Items a, Stores b WHERE a.Id = $item_id AND CONVERT(varchar,a.Id)+'-'+CONVERT(varchar,b.Id) NOT IN (select CONVERT(varchar,ItemId)+'-'+CONVERT(varchar,StoreId) from ItemStores)";
	$query =  $conn->query($sql);
	return $conn->trans_status();
	}
	
	// End assign item to store ------------ mst1 modul 
	
	// assign item to specialist ------------ mst 3 mst 4 modul 
	
	function assign_item_to_specialist($item_id) //MST 3 Set one item to all specialists
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "INSERT Into SpecialistChargeables select a.Id,NULL,b.Id from Items a, RefSpecialist b WHERE a.Id = $item_id AND CONVERT(varchar,a.Id)+'-'+CONVERT(varchar,b.Id) NOT IN (select CONVERT(varchar,ItemId)+'-'+CONVERT(varchar,SpecialistId) from SpecialistChargeables WHERE ItemId IS NOT NULL)";
	$query =  $conn->query($sql);
	return $conn->trans_status();
	}
	
	
	function auto_assign_item_to_specialist() //MST 4 Set all items to all specislists
	{  
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "INSERT Into SpecialistChargeables select a.Id,NULL,b.Id from Items a, RefSpecialist b WHERE CONVERT(varchar,a.Id)+'-'+CONVERT(varchar,b.Id) NOT IN (select CONVERT(varchar,ItemId)+'-'+CONVERT(varchar,SpecialistId) from SpecialistChargeables WHERE ItemId IS NOT NULL)";
	$query =  $conn->query($sql);
	return $conn->trans_status();
	}
	
	// End assign item to specialist ------------ mst 3 mst 4 modul 

//---------------------------------------------------- End Item Module -------------------------------------------
	
//---------------------------------------------------- Start Service Module --------------------------------------
	
	function assign_item_service_to_specialist($item_id) //Set one service to all specialists
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "INSERT Into SpecialistChargeables select NULL,a.Id,b.Id from ItemServices a, RefSpecialist b WHERE  a.Id = $item_id AND CONVERT(varchar,a.Id)+'-'+CONVERT(varchar,b.Id) NOT IN (select CONVERT(varchar,ItemServiceId)+'-'+CONVERT(varchar,SpecialistId) from SpecialistChargeables WHERE ItemServiceId IS NOT NULL)";
	$query =  $conn->query($sql);
	return $conn->trans_status();
	}
	
	
	function auto_assign_item_service() //MST 6 Set all services to all specislists
	{  
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "INSERT Into SpecialistChargeables select NULL,a.Id,b.Id from ItemServices a, RefSpecialist b WHERE CONVERT(varchar,a.Id)+'-'+CONVERT(varchar,b.Id) NOT IN (select CONVERT(varchar,ItemServiceId)+'-'+CONVERT(varchar,SpecialistId) from SpecialistChargeables WHERE ItemServiceId IS NOT NULL)";
	$query =  $conn->query($sql);
	return $conn->trans_status();
	}
	//---------------------------------------------------- End Service Module --------------------------------------

	//---------------------------------Tracking Item---------------------------------------------
	function get_item_tracking()
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select Items.Id,Items.CodeValue,Items.NameValue,buy.NameValue as 'uom_buy',sell.NameValue as 'uom_sell',
			CASE items.IsFormularium WHEN 0 Then 'NO' WHEN 1 Then 'YES' ELSE 'Not Set' END AS IsFormularium,
			CASE items.RecordStatus  WHEN 0 Then 'Not Active' WHEN 1 Then 'Active' ELSE 'Not Set' END AS RecordStatus
			from Items LEFT JOIN RefUomTypes buy ON Items.BuyUomId=buy.Id LEFT JOIN RefUomTypes sell ON Items.SellUomId=sell.Id 
			";
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
	
	function check_item_mapping_store($item_code)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "SELECT COUNT(ItemId) AS TotalStore FROM dbo.VItemStore WHERE ItemCode ='".$item_code."'";
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
	
	//--------------------------------- End Tracking Item---------------------------------------------
	
	//--------------------------------- Tracking Item Services ---------------------------------------------
	function get_item_services_track()
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select ItemServices.Id,ItemServices.CodeValue,ItemServices.NameValue,ItemServices.RecordStatus,gs.NameValue AS GS,a.NameValue AS Parent,RefLoses.DescValue AS Loses from ItemServices LEFT JOIN RefLoses ON ItemServices.LosesId=RefLoses.Id LEFT JOIN ItemServices a ON ItemServices.ParentId=a.Id LEFT JOIN GSSubCategories gs ON ItemServices.GSSubCategoryId=gs.Id";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_services_detail($item_id) 
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	$conn->where('Id',$item_id);
	return $conn->get('ItemServices')->row();
	}
	
	function get_item_services_specialist($item_service_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select RefSpecialist.CodeValue,RefSpecialist.NameValue from SpecialistChargeables LEFT JOIN RefSpecialist ON SpecialistChargeables.SpecialistId=RefSpecialist.Id WHERE SpecialistChargeables.ItemServiceId=$item_service_id";
	$query =  $conn->query($sql);
	return $query->result();
	}
	
	function get_item_services_price($item_service_id)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select PriceClass,PriceAmount from VPriceList Where PriceId=$item_service_id";
	$query =  $conn->query($sql);
	return $query->result();
	}
	//--------------------------------- End Tracking Item---------------------------------------------
	
}