<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daily_report extends CI_Controller {
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
			$data['title'] = "Generate Patient Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "daily_report/show";
			$data['content_title'] = "Generate Patient Report";
			$data['button_action']='bill_check/lookup/';
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
	
	function show() 
	{		
		if($this->session->userdata('db_name') && $this->input->post('startdate'))
		{	
			$datestart = $this->input->post('startdate');
			$dateend = $this->input->post('enddate');
			$payer_id = $this->session->userdata('payer_id');
			$data['title'] = "Generate Patient Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['startdate'] = $datestart;
			$data['enddate'] = $dateend;
			$data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->userdata('hospital_id'))->real_hospital_name;
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			//-------------------------load report data total patient-----------------------------------/
			$data['total_patient']= $this->patientreport_model->count_all_patient($datestart,$dateend);
			$data['total_patient_opd']= $this->patientreport_model->count_all_patient($datestart,$dateend,'OPD');
			$data['total_patient_ipd']= $this->patientreport_model->count_all_patient($datestart,$dateend,'IPD');
			$data['total_patient_etc']= $this->patientreport_model->count_all_patient($datestart,$dateend,'ETC');
			$data['total_patient_mcu']= $this->patientreport_model->count_all_patient($datestart,$dateend,'MCU');
			//-------------------------load report data detail patient per department-----------------------------------/
			//--------------opd-----------
			$data['active_patient_opd'] = $this->patientreport_model->get_active_patient($datestart,$dateend,'OPD');
			$data['closed_patient_opd'] = $this->patientreport_model->get_closed_patient($datestart,$dateend,'OPD');
			$data['canceled_patient_opd'] = $this->patientreport_model->get_canceled_patient($datestart,$dateend,'OPD');
			//--------------opd-----------
			$data['active_patient_ipd'] = $this->patientreport_model->get_active_patient($datestart,$dateend,'IPD');
			$data['closed_patient_ipd'] = $this->patientreport_model->get_closed_patient($datestart,$dateend,'IPD');
			$data['canceled_patient_ipd'] = $this->patientreport_model->get_canceled_patient($datestart,$dateend,'IPD');
			//--------------etc-----------
			$data['active_patient_etc'] = $this->patientreport_model->get_active_patient($datestart,$dateend,'ETC');
			$data['closed_patient_etc'] = $this->patientreport_model->get_closed_patient($datestart,$dateend,'ETC');
			$data['canceled_patient_etc'] = $this->patientreport_model->get_canceled_patient($datestart,$dateend,'ETC');
			//--------------mcu-----------
			$data['active_patient_mcu'] = $this->patientreport_model->get_active_patient($datestart,$dateend,'MCU');
			$data['closed_patient_mcu'] = $this->patientreport_model->get_closed_patient($datestart,$dateend,'MCU');
			$data['canceled_patient_mcu'] = $this->patientreport_model->get_canceled_patient($datestart,$dateend,'MCU');
			
			$data['retail_patient'] = $this->patientreport_model->get_retail_patient($datestart,$dateend,'Retail');
			//$data['discharge_patient'] = $this->patientreport_model->get_patient_discharge($month,$year);
			
			$data['form_request'] = "daily_report/show";
			$data['content_title'] = "Generate Patient Report";
			$data['button_action']='bill_check/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'report/patient_report'; 
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
