<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends CI_Controller {
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
//---------------------------Tools ID = 5 (MST 1 Set All Item to all Location) ----------------------------


	function auto_assign_all_item_to_store($execute=NULL) 
	{
		if($this->sys_model->security(5) == true)
		{
			if($execute == "commit")
				{	
					
				$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '5',
				   'requested_by' => $this->input->post('user_requested').' to database '.$this->session->userdata('db_name')
					);
			$this->sys_model->logging($logs);
			
				if($this->mst_model->auto_assign_item_to_store()==1)
				{	
			$data['back_to_list'] = 'tools/auto_assign_all_item_to_store/list_data';
			$data['content'] = 'component/success_info'; 
			$data['title'] = "Assign All Item To All Store in database -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign All Item to Store On database ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name').' Success';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
				}
			}
			else
			{
			
			$data['title'] = "Assign All Item To Store -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign All Item To Store";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'tools/auto_assign_all_item_to_store/commit';
			}
			$this->load->view('system',$data);
			//$this->output->cache(1);
		}
		else
		{
		redirect('core', 'refresh');
		}
	}
	
// ----------------------------------------------- MST 2 Set one item to all Locations ---------------------------
	
	
	function assign_item_to_store($execute=NULL,$item_id=NULL) 
	{
		if($this->sys_model->security(6) == true)
		{
			$data['title'] = "Assign One Item To Store  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($execute=='assign')
			{
			if(!$this->session->userdata('user_request'))
					{
					redirect('tools/assign_item_to_store', 'refresh');
					}	
				if($item_id != '')
					{	
					
					$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '6',
				   'requested_by' => $this->session->userdata('user_request').' assign item '.$item_id.' to all store in database '.$this->session->userdata('db_name')
					);
					$this->sys_model->logging($logs);
					if($this->mst_model->assign_item_to_store($item_id)==1)
						{
						$data['back_to_list'] = 'tools/assign_item_to_store/list_data';
						$data['content'] = 'component/success_info'; 
						$data['title'] = "Assign One Item To All Store  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
						$data['style'] = 'portal.css'; 
						$data['page']='menu';
						$data['content_title'] = " Assign Item $item_id to all store in database ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name').' Success';
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
					redirect('tools/assign_item_to_store', 'refresh');
					}
			$data['items_data'] = $this->mst_model->get_item();
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['button_action']='tools/assign_item_to_store/assign/';
			$data['content_title'] = "Assign One Item To All Store";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/item_data'; 
			
			}
			else
			{
			$data['title'] = "Assign One Item To Store  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign One Item To All Store";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'tools/assign_item_to_store/list_data';
			
			}
			$this->load->view('system',$data);
			//$this->output->cache(1);
		}
		else
		{
		redirect('tools', 'refresh');
		}
	}
	
// ----------------------------------------------- MST 2 Auto Asign one item to all Specialist ---------------------------

		
	function one_item_to_specialist($execute=NULL,$item_id=NULL) 
	{
		if($this->sys_model->security(7) == true)
		{
			$data['title'] = "Assign One Item To All Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($execute=='assign')
			{
			if(!$this->session->userdata('user_request'))
					{
					redirect('tools/assign_item_to_specialist', 'refresh');
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
						$data['back_to_list'] = 'tools/one_item_to_specialist/list_data';
						$data['content'] = 'component/success_info'; 
						$data['title'] = "Assign One Item To All Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
						$data['style'] = 'portal.css'; 
						$data['page']='menu';
						$data['content_title'] = " Assign Item $item_id to all Specialist in database ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name').' Success';
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
					redirect('tools/assign_item_to_specialist', 'refresh');
					}
			$data['items_data'] = $this->mst_model->get_item();
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Assign One Item To All specialist";
			$data['button_action']='tools/one_item_to_specialist/assign/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/item_data'; 
			
			}
			else
			{
			$data['title'] = "Assign One Item To Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign One Item To All Specialist";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'tools/one_item_to_specialist/list_data';
			}
			$this->load->view('system',$data);
			//$this->output->cache(1);
			}
		else
		{
		redirect('tools', 'refresh');
		}
	}
	
	
// ----------------------------------------------- MST 4 Auto Asign All item to all Specialist ---------------------------
	
	function auto_assign_all_item_to_specialist($execute=NULL) 
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
				$data['back_to_list'] = 'tools/auto_assign_all_item_to_specialist/list_data';
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
			
			$data['title'] = "Assign All Item To All Specialist  -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign All Item To Specialist";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'tools/auto_assign_all_item_to_store/commit';
			}
			$this->load->view('system',$data);
			//$this->output->cache(1);
		}
		else
		{
		redirect('core', 'refresh');
		}
	}

	
	
	

	
}
