<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_sysmex extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('sysmex_interfacing');
			  $this->load->model('sys_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
		if($this->session->userdata('db_name'))
		{	
			if($this->sys_model->security(20) == true)
			{
			$data['title'] = "Hospital Information :: Sysmex Lab Interfacing  ".$this->session->userdata('hospital_name');
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = 'manage_sysmex/list_transaction';
			$data['content_title'] = "Manage Sysmex Lab Interfacing";
			$data['content'] = 'sysmex_interfacing/manage_sysmex'; 
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
	
	function lab_doctor()
	{
	
		if($this->sys_model->security(20) == false)
			{
			redirect('core', 'refresh');
			}
			
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Hospital Information :: Sysmex Lab Interfacing  ".$this->session->userdata('hospital_name');
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = 'manage_sysmex/add_doctor';
			$data['content_title'] = "Manage Doctor Lab";
			$data['doctor_lab'] = $this->sysmex_interfacing->lookup_sysmex_doctor();
			$data['doctor_list'] = $this->sysmex_interfacing->lookup_all_doctor();
			$data['service'] = $this->sysmex_interfacing->lookup_item_services();
			$data['content'] = 'sysmex_interfacing/manage_lab_doctor'; 
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
	
	function add_doctor()
	{
		if($this->sys_model->security(20) == false)
			{
			redirect('core', 'refresh');
			}
	
		if($this->session->userdata('db_name'))
		{	
			$data['doctor_id'] = $this->input->post('doctor');
			$data['service_id'] = $this->input->post('service');
			$this->sysmex_interfacing->add_sysmex_doctor($data);
			redirect('manage_sysmex/lab_doctor', 'refresh');
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
	
	
	function list_transaction($startdate=NULL,$enddate=NULL)
	{
		if($this->sys_model->security(20) == false)
			{
			redirect('core', 'refresh');
			}
		if($this->session->userdata('db_name'))
		{	
			if($startdate == NULL)
			{
			$startdate= $this->input->post('startdate');
			$enddate= $this->input->post('enddate');
			}
			$url_param = array('sysmex_list_param' => "$startdate/$enddate");
			$this->session->set_userdata($url_param);
			$data['title'] = "Hospital Information :: List Of Lab Transaction ".$this->session->userdata('hospital_name');
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = 'manage_sysmex/list_transaction';
			$data['form_correcting_doctor'] = 'manage_sysmex/save_doctor_correction';
			$data['content_title'] = "Manage Transaction";
			$data['button_action'] = 'manage_sysmex/doctor_correction/';
			$data['content'] = 'sysmex_interfacing/manage_lab_transaction'; 
			$data['list_doctor_sysmex'] =  $this->sysmex_interfacing->lookup_sysmex_doctor();
			$data['list_transaction'] = $this->sysmex_interfacing->get_lab_transaction($startdate,$enddate);
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
	
	function save_doctor_correction()
	{
		if($this->sys_model->security(20) == false)
			{
			redirect('core', 'refresh');
			}
		if($this->session->userdata('db_name'))
		{	
				$doctor_code = $this->input->post('corrected_doctor');
				$trans_id = $this->input->post('trans_id');
				$this->sysmex_interfacing->overide_doctor_transaction($doctor_code,$trans_id);
				$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '20',// sysmex modul
				   'requested_by' => $this->session->userdata('HISUser').' / '.$this->session->userdata('username').'correcting lab order doctor'.$trans_id.' to database '.$this->session->userdata('db_name')
					);
				$this->sys_model->logging($logs);
				redirect('manage_sysmex/list_transaction/'.$this->session->userdata('sysmex_list_param'), 'refresh');
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