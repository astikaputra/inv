<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Admin_dashboard extends CI_Controller 
{ 
	 function __construct()
    {
              parent::__construct();
              $this->load->model('sys_model');
			  $this->load->helper('array');
              // $this->load->helper('array');
			 
    }
	
	function index()
	{
			if($this->session->userdata('db_name') && $this->sys_model->get_data_user($this->session->userdata('user'))->role_level == 'oracle')
		{
			
			$data['title'] = "Admin Dashboard :: MedicOS Supporting Tools Dashboard ".$this->session->userdata('hospital_name');
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['issuesdata'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
            $data['button_index'] = 'admin/admin_dashboard';
			$data['back_to_tools'] = 'tools';
			//$data['button_action']='patient_history/patient_trace/';
			//$data['form_request'] = 'patient_history/lookup/';
			$data['content_title'] = "MedicOS Supporting Tools Dashboard";
			$data['content'] = 'main_app/admin/content';
            //$data['content_panel'] = 'main_app/admin/content';
			$this->load->view('main_app/admin/admin_overview',$data);
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
    
	function get_module_stat()
	{
			if($this->session->userdata('db_name') && $this->sys_model->get_data_user($this->session->userdata('user'))->role_level == 'oracle')
		{
			
			$data['title'] = "Admin Dashboard :: MedicOS Supporting Tools Dashboard ".$this->session->userdata('hospital_name');
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['issuesdata'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
            $data['button_index'] = 'admin/admin_dashboard';
			$data['back_to_tools'] = 'tools';
			//$data['button_action']='patient_history/patient_trace/';
			//$data['form_request'] = 'patient_history/lookup/';
            $data['all_stats'] = $this->sys_model->get_stat();
            
			$data['content_title'] = "MedicOS Supporting Tools Dashboard";
			$data['content'] = 'main_app/admin/statistics/contents/modules_used';
            //$data['content_panel'] = 'main_app/admin/statistics/contents/modules_used';
			$this->load->view('main_app/admin/admin_overview',$data);
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
