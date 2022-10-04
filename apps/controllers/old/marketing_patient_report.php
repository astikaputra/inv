<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketing_patient_report extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('marketing_report_model');
			  $this->load->model('sys_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
		if($this->session->userdata('db_name'))
		{	
		
			$data['card_type_list'] = $this->marketing_report_model->get_identity_card_type();
			//$data['lab_services'] = $this->marketing_report_model->get_laboratory_service();

			$data['title'] = "Hospital Information :: Generate Marketing Report ".$this->session->userdata('hospital_name');
			$data['service_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = 'marketing_patient_report/list_patient_report';
			$data['content_title'] = "Generate Patient Data Report";
			$data['content'] = 'markreport/data_filter_patient'; 
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
	
	function get_ktp_patientreg($servcode=0) // return json data
	{
	if($this->session->userdata('db_name'))
		{
		$data['all_ktp_report']= $this->marketing_report_model->get_ktp_patient_report();
		$this->load->view('markreport/marketing_ktp_patient',$data);
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
	
	// Get List Transaction by input or by url
	
	function list_patient_report($servcode=0)
	{
		$this->load->model('marketing_report_model');
	
		if($this->session->userdata('db_name'))
		{		
		$markpage = $this->input->post('servcode');
		$data['servcode'] = $markpage;
		
		if($markpage == 0)
			{
				//$data['all_nationality_report'] = $this->marketing_report_model->get_all_patient_report();
				$data['all_ktp_report'] = $this->marketing_report_model->get_spes_patient_report('1');
				$data['all_sim_report'] = $this->marketing_report_model->get_spes_patient_report('2');
				$data['all_pass_report'] = $this->marketing_report_model->get_spes_patient_report('3');
				$data['all_kitas_report'] = $this->marketing_report_model->get_spes_patient_report('4');
				$data['all_none_report'] = $this->marketing_report_model->get_no_identity_report();
				//$data['detail_cardide'] = $this->marketing_report_model->get_identity_card_detail();
				$data['content'] = 'markreport/marketing_all_patient_report';
			}
		else
			{
				$data['spes_nationality_report'] = $this->marketing_report_model->get_spes_patient_report($markpage);
				$data['detail_cardide'] = $this->marketing_report_model->get_identity_card_detail($markpage);
                $data['content'] = 'markreport/marketing_spes_patient_report';
			}

		$data['title'] = "Hospital Information :: List Of Patient Data ".$this->session->userdata('hospital_name');
		$data['page']='datatable';
		$data['style'] = 'portal.css'; 
		$data['form_request'] = 'marketing_report/list_marketing_report';
		$data['content_title'] = "List Of Patient Data";
		//$data['content'] = 'markreport/marketing_all_service_report';
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
	

	

}