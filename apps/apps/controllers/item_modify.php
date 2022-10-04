<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_modify extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('item_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
		if($this->sys_model->security(13) == true)
		{
			$data['title'] = "Modify Item -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Modify Item Data";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'item_modify/lookup/set_log';
			$this->load->view('system',$data);
		}
		else
		{
		redirect('core', 'refresh');
		}
	}
	
	function lookup($execute=NULL) //MST 10
	{		
			if($execute=='set_log')
			{
			$sesdata = array('user_request'  => $this->input->post('user_requested'));
			$this->session->set_userdata($sesdata);
			}
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
			$data['content'] = 'data/item_tracker_modify'; 
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
	
	function activate_formularium($item_id=NULL)
	{
	
		$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '13',
				   'requested_by' => $this->input->post('user_requested').'activate formularium for item '.$item_id.' to database '.$this->session->userdata('db_name')
					);
			$this->sys_model->logging($logs);
		if($this->item_model->set_activate($item_id))
		{
		echo "1";
		}
	
	}
	
	function deactivate_item($item_id=NULL)
	{
	
		$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '13',
				   'requested_by' => $this->input->post('user_requested').'deactivate item '.$item_id.' to database '.$this->session->userdata('db_name')
					);
			$this->sys_model->logging($logs);
		if($this->item_model->set_deactivate($item_id))
		{
		echo "0";
		}
	}
	
	
}
