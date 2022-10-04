<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_controllers extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('bill_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
			$data['title'] = "Bill -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Manage Patient Registration Status";
			$data['button_action']='bill_controllers/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/bill_view'; 
			$this->load->view('system',$data);
	}
	
	function lookup() //MST 13
	{		
			$keyword = $this->input->post('keyword');
			$data['title'] = "Bill -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($keyword)
			{$data['bill_data'] = $this->bill_model->get_bill($keyword);}
			else
			{$data['items_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Manage Patient Registration Status";
			$data['button_action']='bill_controllers/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/closed_registration'; 
			$this->load->view('system',$data);
	}
	
	function deactivate_reg($reg_id=NULL)
	{
	
		$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '13',
				   'requested_by' => $this->input->post('user_requested').' deactivate Registration id= '.$reg_id.' to database '.$this->session->userdata('db_name')
					);
			$this->sys_model->logging($logs);
		if($this->bill_model->set_deactivate_billing($reg_id))
		{
		}
		
		echo "0";
	}
	function activate_reg($reg_id=NULL)
	{
	
		$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '13',
				   'requested_by' => $this->input->post('user_requested').' activate Registration id= '.$reg_id.' to database '.$this->session->userdata('db_name')
					);
			$this->sys_model->logging($logs);
		if($this->bill_model->set_activate_billing($reg_id))
		{
		}
		
		echo "1";
	}
	
}
