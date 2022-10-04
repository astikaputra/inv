<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Patient_discharge extends CI_Controller 
{ 
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('patientreport_model');
              $this->load->model('sys_model');
			  $this->load->helper('array');
    }
    
   	function index()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Generate Monthly Patient Discharge Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "patient_discharge/dicharge_dashboard";
			$data['content_title'] = "Generate Monthly Patient Discharge Report";
			$data['button_action']='patient_discharge/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/patient_report_filter'; 
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
			$keyword = $this->input->post('repmoyr');
			$data['title'] = "Check Patient Discharge Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            //$data['payer_id']= $this->session->userdata('payer_id');
			if($keyword)
			{$data['discharge_data'] = $this->patientreport_model->get_patient_discharge($monthyear);}
			else
			{$data['discharge_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Check Patient Discharge Report ";
			$data['button_action']='patient_discharge/lookup/';
			$data['button_detail_action']='patient_discharge/detail/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/patient_report_filter'; 
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
    
	function dicharge_dashboard() 
	{		
		if($this->session->userdata('db_name') && $this->input->post('repmoyr'))
		{	
			$monthyear = $this->input->post('repmoyr');
            //$payer_id = $this->session->userdata('payer_id');
			$data['title'] = "Generate Monthly Patient Discharge Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            $data['repmoyr'] = $monthyear;
			$data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			
			$data['discharge_data'] = $this->patientreport_model->get_patient_discharge($monthyear);
			$data['discharge_data_10'] = $this->patientreport_model->get_patient_discharge10($monthyear);
			//$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);
            
            $data['form_request'] = "patient_discharge/dicharge_dashboard";
			$data['content_title'] = "Generate Monthly Patient Discharge Report";
			$data['button_action']='patient_discharge/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'report/discharge_report';
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