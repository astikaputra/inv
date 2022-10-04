<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_Check extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('bill_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
			$data['title'] = "Check Unclosed Billing -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Check Unclosed Billing";
			$data['button_action']='bill_check/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/bill_view'; 
			$this->load->view('system',$data);
	}
	
	function lookup() //MST 10
	{		
			$keyword = $this->input->post('keyword');
			$data['title'] = "Check Unclosed Billing -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($keyword)
			{$data['patient_data'] = $this->bill_model->get_unclosed_patient($keyword);}
			else
			{$data['patient_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Check Unclosed Billing ";
			$data['button_action']='bill_check/lookup/';
			$data['button_detail_action']='bill_check/detail/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/bill_view'; 
			$this->load->view('system',$data);
	}
	
	function detail($patient_id)
	{
		$data['gsc_opd'] = $this->bill_model->get_gscdetail($patient_id,'OPD');
		$data['gsc_ipd'] = $this->bill_model->get_gscdetail($patient_id,'IPD');
		$data['gsc_etc'] = $this->bill_model->get_gscdetail($patient_id,'ETC');
		$data['gsc_mcu'] = $this->bill_model->get_gscdetail($patient_id,'MCU');
		$data['gsc_other'] = $this->bill_model->get_gscdetail($patient_id,'');
		$data['patient'] = $this->bill_model->get_detail_patient($patient_id);
		$this->load->view('data/data_tab_gsc',$data);
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
	
	function reopen_bill_filter()
	{		
			$bill_id = $this->uri->segment(3); //billid
			$reg_id = $this->uri->segment(4); //regid
			$keyword = $this->input->post('keyword');
			$data['title'] = "Reopen Bill & Payment -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($keyword)
			{$data['reopenbill_data'] = $this->bill_model->get_billdetail_patient($keyword);}
			else
			{$data['reopenbill_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Reopen Bill & Payment ";
			$data['button_action']='bill_check/reopen_bill_filter/';
			$data['button_detail_action']='bill_check/reopen_bill_input_reason/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/admin/reopen_filter'; 
			$this->load->view('system',$data);
	}
	
	function reopen_bill_input_reason($bill_id, $reg_id)
	{
		$bill_id = $this->uri->segment(3); //billid
		$reg_id = $this->uri->segment(4); //regid
		$userreqpos  = $this->input->post('userreq');
		$reasonpos = $this->input->post('reason');
		$data['bill_data'] = $this->bill_model->get_reg_bill($bill_id, $reg_id);
		$data['title'] = "Reopen Bill & Payment -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
		$data['button_action']='bill_check/reopen_bill_exec/'.$bill_id.'/'.$reg_id.'';
		$data['page']='datatable';
		$data['style'] = 'portal.css'; 
		$data['content'] = 'moduls/admin/reopen_details';

		$this->load->view('system',$data);
	}
	
	function reopen_bill_exec($bill_id, $reg_id)
	{
		$bill_id = $this->uri->segment(3); //billid
		$reg_id = $this->uri->segment(4); //regid
		$data['bill_data'] = $this->bill_model->get_reg_bill($bill_id, $reg_id);
		$data['title'] = "Reopen Bill & Payment -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
		$data['button_action']='bill_check/reopen_bill_exec/'.$bill_id.'/'.$reg_id.'';
		$data['exec_open_bill'] = $this->bill_model->get_reopen_bill_update($bill_id,$reg_id);
		$data['page']='datatable';
		$data['style'] = 'portal.css'; 
		$data['content'] = 'moduls/admin/reopen_notif';
		
					// save logs
					$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id.' ('.$this->session->userdata('HISUser').')',
				   'modul_id'  => '68',
				   'requested_by' => $this->session->userdata('HISUser').' from IP '.$this->input->ip_address().' Update Bill & Payment Of '.$bill_id.' On Registration '.$reg_id.' For '.$this->input->post('userreq').' Request For '.$this->input->post('reason')
					);
					$this->sys_model->logging($logs);
		
		$this->load->view('system',$data);
	}
		
}
