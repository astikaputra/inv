<?php

class Itemservices_model extends CI_Model {
	
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
	function get_item() 
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	return $conn->get('Items')->result();
	}
	
	/*-------------Get All Item Services Data ------------------*/
	function get_item_services() 
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	return $conn->get('ItemServices')->result();
	}
	
	/*-------------Get All Item Services Data ------------------*/
	function get_stores() 
	{
	$this->set_db();
	$conn =	$this->load->database($this->set_db(),true);
	return $conn->get('Stores')->result();
	}
	
	//--------------------------------- Tracking Item Services ---------------------------------------------
	function get_item_services_track($keyword)
	{
	$this->set_db();
	$data['connected_on'] = $this->session->userdata('db_name').' '.$this->session->userdata('db_host');
	$conn =	$this->load->database($this->set_db(),true);
	$sql = "select TOP(50) ItemServices.Id,ItemServices.CodeValue,ItemServices.NameValue,ItemServices.RecordStatus,gs.NameValue AS GS,a.NameValue AS Parent,RefLoses.DescValue AS Loses from ItemServices LEFT JOIN RefLoses ON ItemServices.LosesId=RefLoses.Id LEFT JOIN ItemServices a ON ItemServices.ParentId=a.Id LEFT JOIN GSSubCategories gs ON ItemServices.GSSubCategoryId=gs.Id
			WHERE (ItemServices.CodeValue like '%$keyword%' OR ItemServices.NameValue like '%$keyword%') AND ItemServices.RecordStatus = 1";
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
	$sql = "SELECT
	a.ItemServiceId,
	a.PriceName,
	a.PriceClass AS 'PriceClass',
	a.PriceAmount AS 'PriceAmount',
	CASE
WHEN a.ItemServiceId IN ('1310','1311','1312','1313') THEN
	a.PriceAmount
ELSE
	a.PriceAmount + (
		a.PriceAmount * c.PercentageMarkup / 100
	)
END AS 'PricePassport',
	CASE
WHEN a.ItemServiceId IN ('1310','1311','1312','1313') THEN
	a.PriceAmount
ELSE
	a.PriceAmount + (
		a.PriceAmount * d.PercentageMarkup / 100
	)
END AS 'PriceKitas'
FROM
	RefIdentityCardTypes d,
	RefIdentityCardTypes c,
	VPriceList a
LEFT JOIN PriceListClasses b ON a.PriceListClassId = b.Id
WHERE
	b.RecordStatus = 1
AND c.Id = 3
AND d.Id = 4
AND a.PriceId = $item_service_id
";
	$query =  $conn->query($sql);
	return $query->result();
	}
	//--------------------------------- End Tracking Item---------------------------------------------
	
}