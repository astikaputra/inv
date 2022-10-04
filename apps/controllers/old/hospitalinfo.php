<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hospitalinfo extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('dashboard_info');
			  $this->load->model('sys_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Hospital Information :: Nurse Dashboard ".$this->session->userdata('hospital_name');
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['linkto'] = "hospitalinfo/nurse_dashboard";
			$data['content_title'] = "Select Hospital Floors / Ward";
			$data['list_floor'] = $this->dashboard_info->get_floor();
			$data['list_ward'] = $this->dashboard_info->get_ward();
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'hospitalinfo/selecting_hospital_floor'; 
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
	
	function nurse_dashboard($floor_id=NULL,$ward=NULL) 
	{		
		if($this->session->userdata('db_name'))
		{	
			
			if($floor_id==NULL)
			{
			redirect('hospitalinfo', 'refresh');
			}
			else
			{
				if($ward!=NULL)
				{
				$data['listbedstatus']= $this->dashboard_info->get_list_bed($floor_id,$ward);
				}
				else
				{
				$data['listbedstatus']= $this->dashboard_info->get_list_bed($floor_id);
				}
			}
			$data['title'] = "Hospital Information :: Nurse Dashboard - ".$this->session->userdata('hospital_name');
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Nurse Dashboard";
			$data['content'] = 'hospitalinfo/nurse_dashboard'; 
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
