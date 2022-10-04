<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Daily_doctor_appointment extends CI_Controller 
{ 
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('reportdoctor_model');
              $this->load->model('sys_model');
			  $this->load->helper('array');
    }
	
   	function index()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Generate Doctor Appointment Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "daily_doctor_appointment/doctor_daily_appointment";
			$data['content_title'] = "Generate Doctor Appointment Report";
			$data['button_action']='daily_doctor_appointment/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/appointment_filter'; 
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
			$data['title'] = "Check Doctor Appointment -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            $data['payer_id']= $this->session->userdata('payer_id');
			if($keyword)
			{$data['doctor_data'] = $this->reportdoctor_model->get_daily_appointment_doctor($datestart,$dateend);}
			else
			{$data['doctor_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Check Doctor Appointment ";
			$data['button_action']='daily_doctor_schedule/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/appointment_filter'; 
			$this->load->view('system',$data);
	}
	
	function doctor_daily_appointment()
	{
		if($this->session->userdata('db_name') && $this->input->post('startdate'))
		{	
			$datestart = $this->input->post('startdate');
			$dateend = $this->input->post('enddate');
            $payer_id = $this->session->userdata('payer_id');
			$data['title'] = "Generate Daily Doctor Appointment -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            $data['startdate'] = $datestart;
			$data['enddate'] = $dateend;
			$data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->userdata('hospital_id'))->real_hospital_name;
            $data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			
			//-------------------------load report daily schedule doctor-----------------------------------/
			$data['daily_appointment']= $this->reportdoctor_model->get_daily_fo_appointment_doctor($datestart,$dateend);
            
            $data['form_request'] = "daily_doctor_appointment/doctor_daily_appointment";
			$data['content_title'] = "Daily Doctor Appointment";
			$data['button_action']='daily_doctor_appointment/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'report/doctor_appointment'; 
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