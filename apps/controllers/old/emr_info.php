<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emr_info extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('emr_model');
			  $this->load->model('sys_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Hospital Information :: EMR Dashboard ".$this->session->userdata('hospital_name');
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = 'emr_info/emr_dashboard';
			$data['content_title'] = "Filter Data For EMR";
			$data['content'] = 'emrinfo/emr_data_filter'; 
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
	
	function get_emr_data($startdate=NULL,$enddate=NULL) //  return json data
	{
	if($this->session->userdata('db_name'))
		{
		ob_start('ob_gzhandler');
		$data['emrdata']= $this->emr_model->get_emr($this->session->userdata('payer_id'),$startdate,$enddate);
		$this->load->view('emrinfo/emr_json',$data);
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
	
	function get_emr_patientreg($startdate=NULL,$enddate=NULL) // return json data
	{
	if($this->session->userdata('db_name'))
		{
		ob_start('ob_gzhandler');
		$data['emrdata']= $this->emr_model->get_unique_patient_reg($this->session->userdata('payer_id'),$startdate,$enddate);
		$this->load->view('emrinfo/emr_patient_reg',$data);
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
	

	function get_emr_patient() // return json data
	{
	if($this->session->userdata('db_name'))
		{
		ob_start('ob_gzhandler');
        $payer_id = $this->session->userdata('payer_id');
		$data['emrdata'] = $this->emr_model->get_unique_patient($payer_id);
		$this->load->view('emrinfo/emr_patient_unique',$data);
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

	function get_discharge_patient($startdate=NULL,$enddate=NULL) // return json data
	{
	if($this->session->userdata('db_name'))
		{
		ob_start('ob_gzhandler');
        $payer_id = $this->session->userdata('payer_id');
		$data['emrdata'] = $this->emr_model->get_discharge_patient($payer_id,$startdate,$enddate);
		$this->load->view('emrinfo/emr_patient_discharge',$data);
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
	
	
	function emr_dashboard() 
	{		
		if($this->session->userdata('db_name'))
		{	
		$emrpage = $this->input->post('datatype');
		$data['start_date']= $this->input->post('startdate');
		$data['end_date']= $this->input->post('enddate');
			if($emrpage=='all')
				{$data['emr_page']='all_patient';
				 $data['emr_title']='List Patients With All Transaction Between '.$data['start_date'].' to '.$data['end_date'].'<br />'.$this->session->userdata('hospital_name');
				}
			else if($emrpage=='registration')
				{$data['emr_page']='unique_patient_reg';
				 $data['emr_title']='List Registration Patients Between '.$data['start_date'].' to '.$data['end_date'].'<br />'.$this->session->userdata('hospital_name');}
			else if($emrpage=='patientonly')
				{$data['emr_page']='patient_only';	
				 $data['emr_title']='List Patient In '.$this->session->userdata('hospital_name');}
			else if($emrpage=='discharge')
				{$data['emr_page']='patient_discharge';	
				 $data['emr_title']='List Discharge Patients Between '.$data['start_date'].' to '.$data['end_date'].'<br />'.$this->session->userdata('hospital_name');}
			else{
				redirect('emr_info', 'refresh');
				}
			
			$data['title'] = "Hospital Information :: EMR Dashboard - ".$this->session->userdata('hospital_name');
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "EMR Dashboard";
			$data['content'] = 'emrinfo/emr_dashboard'; 
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
