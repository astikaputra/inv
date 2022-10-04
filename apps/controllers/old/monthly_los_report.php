<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Monthly_los_report extends CI_Controller 
{ 
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('monthly_los_model');
              $this->load->model('sys_model');
			  $this->load->helper('array');
    }
	
   	function index()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Generate Monthly LOS Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['total_sum'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "monthly_los_report/monthly_los_dashboard";
			$data['content_title'] = "Generate Monthly Medical Support Report";
			$data['button_action']='monthly_los_report/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/monthly_los_filter'; 
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
			$rpyear = $this->input->post('repyear');
			$data['title'] = "Check Monthly LOS -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            $data['payer_id']= $this->session->userdata('payer_id');
			if($rpyear)
			{$data['total_sum'] = $this->monthly_los_model->get_monthly_los_report($year);}
			else
			{$data['total_sum'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Check Monthly Medical Support Report ";
			$data['button_action']='monthly_los_report/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/monthly_los_filter'; 
			$this->load->view('system',$data);
	}
	
	function monthly_los_dashboard()
	{
		if($this->session->userdata('db_name') && $this->input->post('repyear'))
		{	
			$year = $this->input->post('repyear');
			$lospage = $this->input->post('datatype');
            $payer_id = $this->session->userdata('payer_id');
			$data['title'] = "Generate Monthly Medical Support Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['repyear'] = $year;
			$data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->userdata('hospital_id'))->real_hospital_name;
			$data['page']='datatable';
			$data['style'] = 'portal.css';
 
			$data['monthname'] = array("","01 January", "02 February", "03 March", "04 April", "05 May", "06 June", "07 July", "08 August", "09 September", "10 October", "11 November", "12 December");
			//$data['package'] = array("","TREADMILL TEST", "ECHOKARDIOGRAM", "ECG", "ABP MONITORING", "HOLTER MONITORING", "DOBUTAMIN STRESS ECHO", "TRANSESOPHAGEAL ECHO / TEE");
			$data['form_request'] = "monthly_los_report/monthly_los_dashboard";
			
			if($lospage=='visit')
				{$data['content']='report/monthly_los_report';
				 $data['los_title']='Medical Support Report By Transaction From '.$data['repyear'].'<br />'.$this->session->userdata('hospital_name');
				}
			else if($lospage=='registration')
				{$data['content']='report/monthly_los_report_reg';
				 $data['los_title']='Medical Support Report By Registration From '.$data['repyear'].'<br />'.$this->session->userdata('hospital_name');
				}
			else if($lospage=='diagnostic')
				{
				 $data['content']='report/monthly_diag_report';
				 $data['los_title']='Medical Support Report By Diagnostic From '.$data['repyear'].'<br />'.$this->session->userdata('hospital_name');
					{
						$pramonth = $this->input->post('repmonth');
					}
				}
			else{
				redirect('montly_los_report', 'refresh');
				}
			
			$data['content_title'] = "Monthly Medical Support Report";
			$data['button_action']='monthly_los_report/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			//$data['content'] = 'report/monthly_los_report'; 
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