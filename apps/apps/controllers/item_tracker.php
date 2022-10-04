<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_tracker extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('item_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
			$data['title'] = "Item Tracker  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "ITEM TRACKER";
			$data['button_action']='item_tracker/trace/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/item_tracker'; 
			$this->load->view('system',$data);
	}
	
	function lookup() //MST 10
	{		
			$keyword = $this->input->post('keyword');
			$data['title'] = "Item Tracker  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($keyword)
			{$data['items_data'] = $this->item_model->get_item_tracking($keyword);}
			else
			{$data['items_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "ITEM TRACKER";
			$data['button_action']='item_tracker/trace/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/item_tracker'; 
			$this->load->view('system',$data);
	}
	
	
		
	function trace($item_id=NULL)
	{
		$data['item_name'] = $this->item_model->get_item_detail($item_id);
		$data['item_grn'] = $this->item_model->get_item_grn($item_id);
		$data['item_price'] = $this->item_model->get_item_price($item_id);
		$data['item_stock'] = $this->item_model->get_item_stock($item_id);
		$data['item_specialist'] = $this->item_model->get_item_specialist($item_id);
		$data['item_store'] = $this->item_model->get_item_mapping_store($item_id);
		$this->load->view('data/data_tab',$data);
	}
	
	
}
