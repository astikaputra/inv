<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('mst_model');
			  $data['title'] = "Application Project: ".$this->session->userdata('hospital_name');
    }
	
	public function index()
	{
		
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Connected To ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name')." |  Application Project :: ".$this->session->userdata('hospital_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['modul'] = $this->sys_model->get_modul();
			$data['catcode'] = $this->sys_model->get_cat_id();
			//$data['all_modul'] = $this->sys_model->get_modul();
			//$data['spec_modul'] = $this->sys_model->get_sort_modul();
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['message'] = "Selamat Datang".$this->session->userdata('user');
			$data['content'] = 'main_app/tools'; 
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
	
		public function sub_tools()
	{
		
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Connected To ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name')." |  Application Project :: ".$this->session->userdata('hospital_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['modul'] = $this->sys_model->get_sub_modul();
			$data['catcode'] = $this->sys_model->get_cat_id();
			//$data['all_modul'] = $this->sys_model->get_modul();
			//$data['spec_modul'] = $this->sys_model->get_sort_modul();
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['message'] = "Selamat Datang".$this->session->userdata('user');
			$data['content'] = 'main_app/sub_tools'; 
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

	public function sub_tools1()
	{
		
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Connected To ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name')." |  Application Project :: ".$this->session->userdata('hospital_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['modul'] = $this->sys_model->get_sub_modul1();
			$data['catcode'] = $this->sys_model->get_cat_id();
			//$data['all_modul'] = $this->sys_model->get_modul();
			//$data['spec_modul'] = $this->sys_model->get_sort_modul();
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['message'] = "Selamat Datang".$this->session->userdata('user');
			$data['content'] = 'main_app/sub_tools'; 
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
			$data['title'] = "Assign All Item To All Store in database -> Application Project :: ".$this->session->userdata('hospital_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign All Item to Store On database ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name').' Success';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
				}
			}
			else
			{
			
			$data['title'] = "Assign All Item To Store -> Application Project :: ".$this->session->userdata('hospital_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign All Item To Store";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'tools/auto_assign_all_item_to_store/commit';
			$sesdata = array('user_request'  => '');
			$this->session->unset_userdata($sesdata);
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
			$data['title'] = "Assign One Item To Store  -> Application Project :: ".$this->session->userdata('hospital_name')." ";
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
						$data['title'] = "Assign One Item To All Store  -> Application Project :: ".$this->session->userdata('hospital_name')." ";
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

			if(!$this->session->userdata('user_request'))
					{
					if($this->input->post('user_requested'))
						{
						$sesdata = array('user_request'  => $this->input->post('user_requested'));
						$this->session->set_userdata($sesdata);
						redirect('tools/assign_item_to_store/list_data', 'refresh');
						}
					else
						{
						redirect('tools/assign_item_to_store', 'refresh');
						}
					}
			else
			{
			$keyword = $this->input->post('keyword');
			$data['title'] = "Assign Item To Store -> Application Project :: ".$this->session->userdata('hospital_name')." ";
				if($keyword)
					{$data['items_data'] = $this->mst_model->get_item($keyword);}
				else
					{$data['items_data'] = NULL;}
			$data['page']='datatable';
			$data['form_search_action']='tools/assign_item_to_store/list_data';
			$data['style'] = 'portal.css';
			$data['button_action']='tools/assign_item_to_store/assign/';
			//$data['item_store'] = $this->mst_model->check_item_mapping_store($items->CodeValue);
			$data['content_title'] = "Assign One Item To All Store";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/invreport/item_data'; 
			}
			}
			else
			{
			$data['title'] = "Assign One Item To Store  -> Application Project :: ".$this->session->userdata('hospital_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign One Item To All Store";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'tools/assign_item_to_store/list_data';
			$sesdata = array('user_request'  => '');
			$this->session->unset_userdata($sesdata);
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
			$data['title'] = "Assign One Item To All Specialist  -> Application Project :: ".$this->session->userdata('hospital_name')." ";
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
						$data['title'] = "Assign One Item To All Specialist  -> Application Project :: ".$this->session->userdata('hospital_name')." ";
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
			
			if(!$this->session->userdata('user_request'))
					{
					if($this->input->post('user_requested'))
						{
						$sesdata = array('user_request'  => $this->input->post('user_requested'));
						$this->session->set_userdata($sesdata);
						redirect('tools/one_item_to_specialist/list_data', 'refresh');
						}
					else
						{
						redirect('tools/one_item_to_specialist', 'refresh');
						}
					}
			else
			{
			$keyword = $this->input->post('keyword');
				
			if($keyword)
					{$data['items_data'] = $this->mst_model->get_item($keyword);}
				else
					{$data['items_data'] = NULL;}
			$data['page']='datatable';
			$data['form_search_action']='tools/one_item_to_specialist/list_data';
			$data['style'] = 'portal.css'; 
			$data['button_action']='tools/one_item_to_specialist/assign/';
			$data['content_title'] = "Assign One Item To All Specialist";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/item_data'; 
			}
			}
			else
			{
			$data['title'] = "Assign One Item To Specialist  -> Application Project :: ".$this->session->userdata('hospital_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['content_title'] = "Assign One Item To All Specialist";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/insert_user_requested'; 
			$data['form_request'] = 'tools/one_item_to_specialist/list_data';
			$sesdata = array('user_request'  => '');
			$this->session->unset_userdata($sesdata);
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
				$data['title'] = "Assign All Item To All Specialist in database -> Application Project :: ".$this->session->userdata('hospital_name')." ";
				$data['style'] = 'portal.css'; 
				$data['page']='menu';
				$data['content_title'] = "Assign All Item to database ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name').' Success';
				$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
				}
			}
			else
			{
			
			$data['title'] = "Assign All Item To All Specialist  -> Application Project :: ".$this->session->userdata('hospital_name')." ";
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
	

	function print_mpdf() 
	{
	$this->load->library('mpdf');
	$this->mpdf->SetHeader('<p>kepala</p>');
	$this->mpdf->WriteHTML('<p>Hello There</p>');
	$this->mpdf->SetFooter('<p>ekor</p>');
	$this->mpdf->Output();
	$this->load->view('system',$data);
	
}

}
