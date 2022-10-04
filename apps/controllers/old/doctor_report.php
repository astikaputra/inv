<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Doctor_report extends CI_Controller 
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
			//$data['sub_modul'] = $this->sys_model->get_submodul('18');
			$data['title'] = "Generate Patient Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['page']='menu';
			$data['style'] = 'portal.css';
			$data['content_title'] = "Generate Patient Report";
			$data['content'] = 'moduls/doctreport/doctor_home'; 
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
    
   	function daily_doctor_report_filter()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Generate Doctor Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "doctor_report/daily_doctor_report";
			$data['content_title'] = "Generate Doctor Report";
			$data['button_action']='doctor_report/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/doctreport/doctor_report_filter'; 
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
    
	function daily_doctor_lookup()
	{		
			$keyword = $this->input->post('keyword');
			$data['title'] = "Check Doctor Activity -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            $data['payer_id']= $this->session->userdata('payer_id');
			if($keyword)
			{$data['doctor_data'] = $this->reportdoctor_model->get_daily_doctor($datestart,$dateend,$lob);}
			else
			{$data['doctor_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Check Doctor Activity ";
			$data['button_action']='doctor_report/lookup/';
			$data['button_detail_action']='doctor_report/detail/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_date_range'; 
			$this->load->view('system',$data);
	}
    
   	function daily_doctor_report_detail($doctor_id, $lob='NULL')
	{
		$data['active_doctor_opd'] = $this->reportdoctor_model->get_doctor_details($doctor_id, $lob = 'OPD');
		$data['active_doctor_ipd'] = $this->reportdoctor_model->get_doctor_details($doctor_id, $lob = 'IPD');
		$data['active_doctor_etc'] = $this->reportdoctor_model->get_doctor_details($doctor_id, $lob = 'ETC');
		$data['active_doctor_mcu'] = $this->reportdoctor_model->get_doctor_details($doctor_id, $lob = 'MCU');
		$this->load->view('data/data_tab_doctor',$data);
	}
    
	function daily_doctor_report() 
	{		
		if($this->session->userdata('db_name') && $this->input->post('startdate'))
		{	
			$datestart = $this->input->post('startdate');
			$dateend = $this->input->post('enddate');
            $payer_id = $this->session->userdata('payer_id');
			$data['title'] = "Generate Doctor Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            $data['startdate'] = $datestart;
			$data['enddate'] = $dateend;
			$data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->userdata('hospital_id'))->real_hospital_name;
            $data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			
			//-------------------------load report data total doctor-----------------------------------/
			$data['total_doctor']= (($this->reportdoctor_model->count_all_doctor($datestart,$dateend,'',$payer_id))+($this->reportdoctor_model->count_all_ipddoctor($datestart,$dateend,'IPD',$payer_id)));
			$data['total_doctor_opd']= $this->reportdoctor_model->count_all_doctor($datestart,$dateend,'OPD',$payer_id);
			$data['total_doctor_ipd']= $this->reportdoctor_model->count_all_ipddoctor($datestart,$dateend,'IPD',$payer_id);
			$data['total_doctor_etc']= $this->reportdoctor_model->count_all_doctor($datestart,$dateend,'ETC',$payer_id);
			$data['total_doctor_mcu']= $this->reportdoctor_model->count_all_doctor($datestart,$dateend,'MCU',$payer_id);
			//-------------------------load report data detail patient per department-----------------------------------/
			$data['doctor_opd'] = $this->reportdoctor_model->get_daily_doctor($datestart,$dateend,'OPD',$payer_id);
            $data['doctor_ipd'] = $this->reportdoctor_model->get_daily_ipd_doctor($datestart,$dateend,$payer_id);
			$data['doctor_etc'] = $this->reportdoctor_model->get_daily_doctor($datestart,$dateend,'ETC',$payer_id);
			$data['doctor_mcu'] = $this->reportdoctor_model->get_daily_doctor($datestart,$dateend,'MCU',$payer_id); 

			$data['opd_patient_detail'] = $this->reportdoctor_model->get_detail_patient_visits($datestart,$dateend,'OPD',$payer_id);
            $data['ipd_patient_detail'] = $this->reportdoctor_model->get_detail_ipdpatient_visits($datestart,$dateend,'IPD',$payer_id);
			$data['etc_patient_detail'] = $this->reportdoctor_model->get_detail_patient_visits($datestart,$dateend,'ETC',$payer_id);
			$data['mcu_patient_detail'] = $this->reportdoctor_model->get_detail_patientmcu_visits($datestart,$dateend,'MCU',$payer_id);             
   
            $data['top_10_doctor'] = $this->reportdoctor_model->get_daily_top_10_doctor($datestart,$dateend,$payer_id);
            $data['top_10_doctor_general'] = $this->reportdoctor_model->get_daily_top_10_doctor_general($datestart,$dateend,$payer_id);
            //---------------load new & old patient visits----------------------/
            $data['total_new_patient']= (($this->reportdoctor_model->get_totalnew_patient($datestart,$dateend,'',$payer_id))+($this->reportdoctor_model->get_totalnew_ipdpatient($datestart,$dateend,'IPD',$payer_id)));
            $data['totalnew_patient_opd'] = $this->reportdoctor_model->get_totalnew_patient($datestart,$dateend,'OPD',$payer_id);
			$data['totalnew_patient_ipd'] = $this->reportdoctor_model->get_totalnew_ipdpatient($datestart,$dateend,'IPD',$payer_id);
            $data['totalnew_patient_etc'] = $this->reportdoctor_model->get_totalnew_patient($datestart,$dateend,'ETC',$payer_id);
            $data['totalnew_patient_mcu'] = $this->reportdoctor_model->get_totalnew_patient($datestart,$dateend,'MCU',$payer_id);
            $data['total_old_patient']= (($this->reportdoctor_model->get_totalold_patient($datestart,$dateend,'',$payer_id))+($this->reportdoctor_model->get_totalold_ipdpatient($datestart,$dateend,'IPD',$payer_id)));
            $data['totalold_patient_opd'] = $this->reportdoctor_model->get_totalold_patient($datestart,$dateend,'OPD',$payer_id);
            $data['totalold_patient_ipd'] = $this->reportdoctor_model->get_totalold_ipdpatient($datestart,$dateend,'IPD',$payer_id);  			
            $data['totalold_patient_etc'] = $this->reportdoctor_model->get_totalold_patient($datestart,$dateend,'ETC',$payer_id);
            $data['totalold_patient_mcu'] = $this->reportdoctor_model->get_totalold_patient($datestart,$dateend,'MCU',$payer_id);
            
            $data['form_request'] = "doctor_report/daily_doctor_report";
			$data['content_title'] = "Generate Doctor Report";
			$data['button_action']='doctor_report/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/doctreport/doctor_report_daily'; 
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
	
   	function daily_doctor_appointment_filter()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Generate Doctor Appointment Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "doctor_report/doctor_daily_appointment_report";
			$data['content_title'] = "Generate Doctor Appointment Report";
			$data['button_action']='doctor_report/daily_doctor_appointment_lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/doctreport/appointment_filter'; 
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
    
	function daily_doctor_appointment_lookup()
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
			$data['button_action']='doctor_report/daily_doctor_appointment_lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/doctreport/appointment_filter'; 
			$this->load->view('system',$data);
	}
	
	function doctor_daily_appointment_report()
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
            
            $data['form_request'] = "doctor_report/doctor_daily_appointment_report";
			$data['content_title'] = "Daily Doctor Appointment";
			$data['button_action']='doctor_report/daily_doctor_appointment_lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/doctreport/doctor_appointment'; 
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
	
	function daily_doctor_mr_appointment_filter()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Generate Doctor Appointment Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "doctor_report/doctor_daily_mr_appointment_report";
			$data['content_title'] = "Generate Doctor Appointment Report";
			$data['button_action']='doctor_report/daily_doctor_mr_appointment_lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/doctreport/appointment_filter'; 
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
    
	function daily_doctor_mr_appointment_lookup()
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
			$data['button_action']='doctor_report/daily_doctor_mr_appointment_lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/doctreport/appointment_filter'; 
			$this->load->view('system',$data);
	}
	
	function doctor_daily_mr_appointment_report()
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
			$data['daily_appointment']= $this->reportdoctor_model->get_daily_mr_appointment_doctor($datestart,$dateend);
            
            $data['form_request'] = "doctor_report/doctor_daily_mr_appointment_report";
			$data['content_title'] = "Daily Doctor Appointment";
			$data['button_action']='doctor_report/daily_doctor_mr_appointment_lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/doctreport/doctor_appointment'; 
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