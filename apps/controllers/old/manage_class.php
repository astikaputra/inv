<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_class extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('manage_class_model');
			  $this->load->model('sys_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
		if($this->session->userdata('db_name'))
		{	
			if($this->sys_model->security(20) == true)
			{
			$data['title'] = "Hospital Information :: Change Patient Class ".$this->session->userdata('hospital_name');
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = 'manage_class/get_unclosed_patient';
			$data['content_title'] = "Manage Patient Class";
			$data['content'] = 'main_app/class_manage_filter'; 
			$this->load->view('system',$data);
			}
			else
			{
			redirect('core', 'refresh');
			}
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
	
	
	function get_unclosed_patient()
	{
		if($this->sys_model->security(20) == false)
			{
			redirect('core', 'refresh');
			}
		if($this->session->userdata('db_name'))
		{	
			$keyword = $this->input->post('keyword');
			$data['title'] = "Hospital Information :: List Unclosed Patient ".$this->session->userdata('hospital_name');
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = 'manage_class/get_unclosed_patient';
			$data['form_change_class'] = 'manage_class/save_classes_correction';
			$data['content_title'] = "Manage Patient Class";
			$data['button_action'] = 'manage_class/update_patient_class/';
			$data['content'] = 'main_app/class_manage_filter';
			$data['list_patient_class'] =  $this->manage_class_model->lookup_patient_class();
			$data['pathisdata'] =   $this->manage_class_model->get_unclosed_patient($keyword);
			$this->load->view('system',$data);
		
		}
	}
	
	function update_patient_class()
	{
		

	}
	
	function save_classes_correction()
	{
		

	}


}