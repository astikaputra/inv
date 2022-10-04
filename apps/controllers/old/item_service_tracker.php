<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_service_tracker extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('itemservices_model');
			  $this->load->helper('array');
    }
	
	
	
	
	function index($execute=NULL) //MST 10
	{
			$data['title'] = "Item Tracker  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Item Service Tracker";
			$data['button_action']='item_service_tracker/trace/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/item_tracker_services'; 
			$this->load->view('system',$data);
			//$this->output->cache(1);
	
	}
	
	function lookup() //MST 10
	{
			$keyword = $this->input->post('keyword');
			$data['title'] = "Item Tracker  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($keyword)
			{$data['items_data'] = $this->itemservices_model->get_item_services_track($keyword);}
			else
			{$data['items_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Item Service Tracker";
			$data['button_action']='item_service_tracker/trace/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/item_tracker_services'; 
			$this->load->view('system',$data);
			//$this->output->cache(1);
	
	}
	
	function trace($item_id=NULL)
	{
		$data['item_name'] = $this->itemservices_model->get_item_services_detail($item_id);
		$data['item_service_price'] = $this->itemservices_model->get_item_services_price($item_id);
		$data['item_service_specialist'] = $this->itemservices_model->get_item_services_specialist($item_id);
		$this->load->view('data/data_tab_item_services',$data);
	}


	
}
