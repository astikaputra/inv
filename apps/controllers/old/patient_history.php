<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Patient_history extends CI_Controller 
{ 
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('patient_his_model');
              $this->load->model('sys_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
			if($this->session->userdata('db_name'))
		{
			$data['title'] = "Hospital Information :: Patient History Dashboard ".$this->session->userdata('hospital_name');
			$data['pathisdata'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['button_action']='patient_history/patient_trace/';
			//$data['form_request'] = 'patient_history/lookup/';
			$data['content_title'] = "Filter Data For Patient History";
			$data['content'] = 'main_app/patient_history_filter'; 
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
    
    function patient_his_dashboard()
    {
 		if($this->session->userdata('db_name') && $this->input->post('mrnorpn'))
		{
		$payer_id = $this->session->userdata('payer_id');
		$medcornum = $this->input->post('mrnorpn');
		$patient_name = $this->input->post('mrnorpn');
		$data['mrnorpn'] = $medcornum;
		$data['mrnorpn'] = $patient_name;
		$data['page']='datatable';
		$data['style'] = 'portal.css'; 
		
		$data['pathis_page']='patient_single_his';
		$data['title'] = "Patient History -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
		$data['pathis_title']='Patient History Details Of '.$this->input->post('mrnorpn').'<br />'.$this->session->userdata('hospital_name');
		$data['pathisdata'] = NULL;
	
		//$data['form_request'] = "patient_history/patient_his_dashboard";
		$data['content_title'] = "Patients History Report";
		$data['button_action']='patient_history/patient_trace/';
		
		$data['detailsdata'] = $this->patient_his_model->get_identity_details($payer_id, $medcornum, $patient_name);
		$data['pathisdata'] = $this->patient_his_model->get_patient_history($payer_id, $medcornum, $patient_name);
		$data['hisdata'] = $this->patient_his_model->get_patient_tracking($payer_id, $medcornum, $patient_name);

		$data['content'] = 'report/patient_history'; 
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
	
	function lookup()
	{		
			$keyword = $this->input->post('keyword');
			$data['title'] = "List Patients History -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            $data['payer_id']= $this->session->userdata('payer_id');
			if($keyword)
			{$data['pathisdata'] = $this->patient_his_model->get_patient_tracking($keyword);}
			else
			{$data['pathisdata'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "List Patients History ";
			$data['button_action']='patient_history/patient_trace/';
			//$data['form_request'] = 'patient_history/patient_his_dashboard';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['pathis_title']='Patients History Details Of '.$this->session->userdata('hospital_name');
			$data['content'] = 'main_app/patient_history_filter'; 
			$this->load->view('system',$data);
	}
	
	function lookup_json($keyword) //MST 10
	{		
			$this->benchmark->mark('code_start');
			if($keyword)
			{$data= $this->patient_his_model->get_patient_tracking($keyword);}
			else
			{$data= NULL;}
			$arr_data=array();
			foreach($data as $patients){
				$arr_data['patients'][]=array('patienthis'=>array('mr_number'=>$patients->MedicalRecordNumber,'patient_name'=>$patients->PatientName,'doctor_name'=>$patients->DoctorName,'reg_code'=>$patients->RegistrationCode,'reg_time'=>$patients->RegistrationTime));
			}
			print json_encode($arr_data);
			$this->benchmark->mark('code_end');
			echo $this->benchmark->elapsed_time('code_start', 'code_end');
	}
	
	function patient_trace($patient_id=NULL)
	{
		$data['pathis_title']='Patients History Details Of '.$this->input->post('keyword').'<br />'.$this->session->userdata('hospital_name');
		//$data['payer_id']= $this->session->userdata('payer_id');
		//$data['hisdata'] = $this->patient_his_model->get_patient_tracking($patient_id);
		$data['hisdata'] = $this->patient_his_model->get_patient_list($patient_id);
		$data['patientname'] = $this->patient_his_model->get_identity_details($patient_id);
		
		$this->load->view('data/data_his_tab',$data);
    }
	
}