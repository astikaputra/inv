<?php

class Restreport_model extends CI_Model {
	
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

	

	function get_slow_moving_stock($stardate,$enddate,$zeroval=FALSE)
	{
	$zerovalconstant = '';
	$this->set_db();
	if($zeroval == TRUE)
		{
		$zerovalconstant = 'WHERE a.StockOnHand != 0';
		}
		
	$conn =	$this->load->database($this->set_db(),true);
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
		not exists (select 1 from GSCDetails where ItemId  = c.Id and CONVERT(DATE,CreatedDate) between '".$stardate."' and '".$enddate."')
		group by 
		c.CodeValue,
		c.NameValue,
		e.Id,
		e.NameValue,
		c.CostValue)a ".$zerovalconstant;
	$query =  $conn->query($sql);
	return $query->result();
	}

}