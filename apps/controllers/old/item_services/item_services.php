<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_services_to_all extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('mst_model');
    }
	
	public function index()
	{
		$data['title'] = "Medicos Support Tools: ".$this->config->item('company_name');
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Connected To ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name')." |  Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['modul'] = $this->sys_model->get_modul();
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['message'] = "Selamat Datang".$this->session->userdata('user');
			$data['content'] = 'main_app/tools'; 
			$this->load->view('system',$data);
		
		}
		else
		{
			redirect('core/select_database', 'refresh');
		}
		
	}
	
// ----------------------------------------------- MST 6 Auto Asign one Services to all Specialist ---------------------------
	
		
	function one_services_to_specialist($execute=NULL,$item_id=NULL) 
	{
		if($this->sys_model->security(7) == true)
		{
			$data['title'] = "Assign One Services To Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($execute=='assign')
			{
			if(!$this->session->userdata('user_request'))
					{
					redirect('item_services/item_services/one_services_to_specialist', 'refresh');
					}	
				if($item_id != '')
					{	
					
					$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '6',
				   'requested_by' => $this->session->userdata('user_request').' assign item '.$item_id.' to all store in database '.$this->session->userdata('db_name')
					);
					$this->sys_model->logging($logs);
					if($this->mst_model->assign_item_to_specialist($item_id)==1)
						{
						$data['content'] = 'component/success_info'; 
						$data['title'] = "Assign One Services To Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
						$data['style'] = 'portal.css'; 
						$data['page']='menu';
						$data['content_title'] = " Assign Services $item_id to all Specialist in database ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name').' Success';
						}
					}
				else{
					redirect('tools', 'refresh');
				}
			} 
			else if($execute=='list_data')
			{
				
			$sesdata = array('user_request'  => $this->input->post('user_requested'));
			$this->session->set_userdata($sesdata);
			if(!$this->session->userdata('user_request'))
					{
					redirect('item_services/item_services/one_services_to_specialist', 'refresh');
					}
			$data['items_data'] = $this->mst_model->get_item();
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Assign One Services To specialist";
			$data['button_action']='item_services/item_services/one_services_to_specialist/assign/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/item_data'; 
			
			}
			else
			{
			$data['title'] = "Assign One Item To Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign One Item To specialist";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'tools/one_item_to_specialist/list_data';
			}
			$this->load->view('system',$data);
			}
		else
		{
		redirect('tools', 'refresh');
		}
	}
	
	
// ----------------------------------------------- MST 7 Auto Asign All Services to all Specialist ---------------------------
	
	function auto_assign_all_services_to_specialist($execute=NULL) 
	{
		if($this->sys_model->security(8) == true)
		{
			
			if($execute == "commit")
				{	
					
				$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '5',
				   'requested_by' => $this->input->post('user_requested').' to database '.$this->session->userdata('db_name')
					);
			$this->sys_model->logging($logs);
			
				if($this->mst_model->auto_assign_item_to_specialist()==1)
				{	
				$data['content'] = 'component/success_info'; 
				$data['title'] = "Assign All Item To All Specialist in database -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
				$data['style'] = 'portal.css'; 
				$data['page']='menu';
				$data['content_title'] = "Assign All Item to database ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name').' Success';
				$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
				}
			}
			else
			{
			
			$data['title'] = "Assign All Item To Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign All Item To Specialist";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'tools/auto_assign_all_item_to_store/commit';
			}
			$this->load->view('system',$data);
		}
		else
		{
		redirect('core', 'refresh');
		}
	}

	


	
}
