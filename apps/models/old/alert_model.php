<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Alert_model extends CI_Model{
 	
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
	
    function get_stock_alert($item_types)
    {
        $this->set_db();
      	$conn =	$this->load->database($this->set_db(),true);
        $sql = "SELECT (ROW_NUMBER() OVER ( ORDER BY ItemName)) AS NO,ItemCode 'Item Code',ItemName 'Item Name',(SELECT dbo.RefUomTypes.NameValue FROM dbo.RefUomTypes WHERE Id = temp.BuyUOM) AS 'BuyUOM', SellUom 'UoM',QtyOnHand AS 'Current Stock On Hand',MinValue AS 'Minimum Stock',MaxValue AS 'Maximum Stock',OrderPrice AS 'Purchase Price',Supplier AS Distributor,
				CASE Manufacture WHEN 'UNDEFINED' THEN '-' ELSE Manufacture  END AS Manufacture FROM dbo.fn_stock_alert() AS temp WHERE ItemCode like '%$item_types%'";
		$query = $conn->query($sql);
        return $query;
    }

   	

}