<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Medicine_consume extends CI_Controller 
{ 
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('item_model');
              $this->load->model('sys_model');
			  $this->load->helper('array');
    }
    
   	function index()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Generate Medicine Consumption Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "medicine_consume/medicine_dashboard";
			$data['content_title'] = "Generate Medicine Consumption Report";
			$data['button_action']='medicine_consume/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_date_range'; 
			$this->load->view('system',$data);
		}
			else
		{
			if($this->session->userdata('username'))
			{
			redirect('core/select_database', 'refresh');
			}
			else
			{
			$this->session->sess_destroy();
			redirect('core', 'refresh');
			}
			
		}
			
	}
    
	function lookup()
	{		
			$keyword = $this->input->post('keyword');
			$data['title'] = "Check Medicine Consumption Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            //$data['payer_id']= $this->session->userdata('payer_id');
			if($keyword)
			{$data['items_data'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);}
			else
			{$data['items_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Check Medicine Consumption Report ";
			$data['button_action']='medicine_consume/lookup/';
			$data['button_detail_action']='medicine_consume/detail/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_date_range'; 
			$this->load->view('system',$data);
	}
    
   	function detail($doctor_id, $lob='NULL')
	{
		$data['active_doctor_opd'] = $this->item_model->get_medicine_consumsion($doctor_id, $lob = 'OPD');
		$data['active_doctor_ipd'] = $this->item_model->get_medicine_consumsion($doctor_id, $lob = 'IPD');
		$data['active_doctor_etc'] = $this->item_model->get_medicine_consumsion($doctor_id, $lob = 'ETC');
		$data['active_doctor_mcu'] = $this->item_model->get_medicine_consumsion($doctor_id, $lob = 'MCU');
		$this->load->view('data/data_tab_doctor',$data);
	}
    
	function medicine_dashboard() 
	{		
		if($this->session->userdata('db_name') && $this->input->post('startdate'))
		{	
			$datestart = $this->input->post('startdate');
			$dateend = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
			$data['title'] = "Generate Medicine Consumption Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            $data['startdate'] = $datestart;
			$data['enddate'] = $dateend;
			$data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			
			$data['medicine_data'] = $this->item_model->get_medicine_consumption($datestart,$dateend);
			$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
			//$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);
            
            $data['form_request'] = "medicine_consume/medicine_dashboard";
			$data['content_title'] = "Generate Medicine Consumption Report";
			$data['button_action']='medicine_consume/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'report/medicine_report'; 
			$this->load->view('system',$data);
		}
			else
		{
			if($this->session->userdata('username'))
			{
			redirect('tools', 'refresh');
			}
			else
			{
			$this->session->sess_destroy();
			redirect('core', 'refresh');
			}
			
		}
	}
	
}