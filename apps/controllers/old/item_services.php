<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_services extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('mst_model');
			  $this->load->helper('array');
    }
	
	function auto_assign_all_item_services_to_specialist($execute=NULL) //MST 07
	{
		if($this->sys_model->security(9) == true)
		{
			
			if($execute == "commit")
				{	
					
				$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '5',
				   'requested_by' => $this->input->post('user_requested').' to database '.$this->session->userdata('db_name')
					);
			$this->sys_model->logging($logs);
			
				if($this->mst_model->auto_assign_item_service()==1)
				{	
				$data['content'] = 'component/success_info'; 
				$data['title'] = "Assign All Item Services To All Specialist in database -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
				$data['style'] = 'portal.css'; 
				$data['page']='menu';
				$data['content_title'] = "Assign All Item Services to database ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name').' Success';
				$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
				}
			}
			else
			{
			
			$data['title'] = "Assign All Item Services To All Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign All Item Services To Specialist";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'item_services/auto_assign_all_item_services_to_specialist/commit';
			}
			$this->load->view('system',$data);
			//$this->output->cache(5);
		}
		else
		{
		redirect('core', 'refresh');
		}
	}
	
	function one_item_services_to_specialist($execute=NULL,$item_id=NULL) //MST 06
	{
		if($this->sys_model->security(10) == true)
		{
			$data['title'] = "Assign One Item Services To All Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($execute=='assign')
			{
			if(!$this->session->userdata('user_request'))
					{
					redirect('item_services/one_item_services_to_specialist', 'refresh');
					}	
				if($item_id != '')
					{	
					
					$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '6',
				   'requested_by' => $this->session->userdata('user_request').' assign item '.$item_id.' to all store in database '.$this->session->userdata('db_name')
					);
					$this->sys_model->logging($logs);
					if($this->mst_model->assign_item_service_to_specialist($item_id)==1)
						{
						$data['back_to_list'] = 'item_services/one_item_services_to_specialist/list_data';
						$data['content'] = 'component/success_info'; 
						$data['title'] = "Assign One Item Services To All Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
						$data['style'] = 'portal.css'; 
						$data['page']='menu';
						$data['content_title'] = " Assign Item Services With ID = $item_id to all Specialist in database ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name').' Success';
						}
					}
				else{
					redirect('tools', 'refresh');
				}
			} 
			else if($execute=='list_data')
			{
			if(!$this->session->userdata('user_request'))
					{
					if($this->input->post('user_requested'))
						{
						$sesdata = array('user_request'  => $this->input->post('user_requested'));
						$this->session->set_userdata($sesdata);
						redirect('item_services/one_item_services_to_specialist/list_data', 'refresh');
						}
					else
						{
						redirect('item_services/one_item_services_to_specialist', 'refresh');
						}
					}
			else
			{
			$keyword = $this->input->post('keyword');
			if($keyword)
					{$data['items_data'] = $this->mst_model->get_item_services($keyword);}
				else
					{$data['items_data'] = NULL;}	

				$data['page']='datatable';
			$data['form_search_action']='item_services/one_item_services_to_specialist/list_data';
			$data['style'] = 'portal.css'; 
			$data['button_action']='item_services/one_item_services_to_specialist/assign/';
			$data['content_title'] = "Assign Services To All Specialist";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/item_service_data'; 
			}
			}
			else
			{
			$data['title'] = "Assign One Item Services To Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign One Item Services To All Specialist";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'item_services/one_item_services_to_specialist/list_data';
			}
			$this->load->view('system',$data);
			//$this->output->cache(1);
			}
		else
		{
		redirect('tools', 'refresh');
		}
	}


	
}
