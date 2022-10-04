<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller {

	public function index()
	{
		$data['title'] = "Medicos Support Tools: ".$this->config->item('company_name');
		if($this->session->userdata('username'))
		{	
			redirect('core/select_database', 'refresh');
		}
		else
		{
		$data['page']='login';
		$data['message'] = 'Medicos Support Tools';
		$data['style'] = 'login.css'; 
		$data['content'] = 'login/login'; 
		$this->load->view('system',$data);
		}
		
	}
	

	
	function login()
	{
			$uname =	$this->input->post('username');
			$pass =		md5($this->input->post('password'));
			$status = $this->sys_model->check_login($uname,$pass);	
			if($status > 0)
			{
			$sesdata = array(
                   'username'  => sha1(md5($this->input->post('username'))),
				   'user'  => $this->sys_model->get_data_user($uname)->username,
				   'logged_in' => TRUE
               );
			$this->session->set_userdata($sesdata);
			$this->sys_model->set_online($uname);	
			//logging activity to system
				$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '2',
				   'requested_by' => 'self'
					);
				$this->sys_model->logging($logs);	
			//logging activity to system
			redirect('core', 'refresh');
			}
			else
			{
			$this->session->set_flashdata('error_message', 'Ooops, Password atau Nama User salah');
			redirect('core', 'refresh');
			}
	
	}
	
	function logout()
	{
	$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '3',
				   'requested_by' => 'self'
					);
				$this->sys_model->logging($logs);	
				
	$this->sys_model->set_offline($this->session->userdata('user'));	
	$this->session->sess_destroy();
	redirect('core', 'refresh');
	}
	
	function select_database()
	{
		if($this->session->userdata('username'))
		{
			
			$data['list_db'] = $this->sys_model->get_conection_list();
			$data['title'] = "Selecting Database -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['message'] = "Selamat Datang".$this->session->userdata('user');
			$data['content'] = 'main_app/select_database'; 
			$this->load->view('system',$data);
					
			
		}
		else
		{
		redirect('core', 'refresh');
		}
	}
	
	function set_db()
	{
		if($this->session->userdata('username'))
		{	
			$db_id = $this->input->post('db');
		
				$sesdata = array(
                'db_host'  => $this->sys_model->get_auth_db($db_id)->ip_address,
				'db_user'  => $this->sys_model->get_auth_db($db_id)->username,
				'db_password' => $this->sys_model->get_auth_db($db_id)->password,
				'db_name' => $this->sys_model->get_auth_db($db_id)->database_name);
				$this->session->set_userdata($sesdata);
				redirect('tools', 'refresh');
			
		}
		else
		{	
			redirect('core', 'refresh');	
		}
	}
	
	function _encrypt_pass($post_array){
    $post_array['password'] =  md5($post_array['password']);
    return $post_array;
	}
	
	function sys_config($config_option=NULL)
	{
		if($this->sys_model->security(1) == true)
		{
			$data['style'] = 'portal.css';
			$data['parent_page'] = 'tools';
			
			if($config_option == 'user')
				{
				$crud = new grocery_CRUD();
				$crud->set_table('mst_user');
				$crud->set_theme('flexigrid');
				$crud->required_fields('username','password','real_name','hospital_id','database_assign','tools_assign');
				$crud->columns('username','real_name','hospital_id');
				$crud->set_relation('hospital_id','mst_hospital',"{hospital_id} - {real_hospital_name}");
				$crud->set_subject('MST User Management');
				$crud->field_type('active', 'dropdown',  array('1' => 'Active', '0' => 'Inactive'));
				$crud->field_type('is_online', 'dropdown',  array('1' => 'Online', '0' => 'Offline'));
				$crud->fields('username','password','real_name','hospital_id','contact_number','email_address','active','database_assign','tools_assign');
				$crud->set_relation_n_n('database_assign', 'mst_user_assign_database', 'mst_database_connection', 'user_id','connection_id' ,  "{hospital_id} - {ip_address} - {database_name}");
				$crud->set_relation_n_n('tools_assign', 'mst_user_assign_modul', 'mst_tools', 'user_id','modul_id','modul_name','priority');
				$crud->callback_before_insert(array($this,'_encrypt_pass'));
				$crud->callback_before_update(array($this,'_encrypt_pass'));
				$output = $crud->render();
				$data['content_title']='MST User Management'; 
				$data['content'] = 'main_app/sys_config';
				$data['page']='data';
				}
			else if($config_option == 'hospital')
				{
				$crud = new grocery_CRUD();
				$crud->set_table('mst_hospital');
				$crud->set_theme('flexigrid');
				$crud->required_fields('hospital_id','real_hospital_name','hospital_address');
				$crud->set_subject('MST Master Hospital');
				$output = $crud->render();
				$data['content_title']='MST Master Hospital'; 
				$data['content'] = 'main_app/sys_config';
				$data['page']='data';
				}
			else if($config_option == 'database')
				{
				$crud = new grocery_CRUD();
				$crud->set_table('mst_database_connection');
				$crud->set_theme('flexigrid');
				$crud->required_fields('hospital_id','ip_address','username','password','database_name','database_type');
				$crud->set_subject('MST Master Database Connection');
				$crud->set_relation('hospital_id','mst_hospital',"{hospital_id} - {real_hospital_name}");
				$crud->field_type('database_type', 'dropdown',  array('Production' => 'Production', 'UAT' => 'UAT','Development' => 'Development'));
				$output = $crud->render();
				$data['content_title']='MST master Database Conection'; 
				$data['content'] = 'main_app/sys_config';
				$data['page']='data';
				}
			else if($config_option == 'tools')
				{
				$crud = new grocery_CRUD();
				$crud->set_table('mst_tools');
				$crud->set_theme('flexigrid');
				$crud->required_fields('modul_name','modul_description','modul_url','modul_show');
				$crud->set_subject('MST Master Modul');
				$crud->unset_delete();
				$crud->field_type('modul_show', 'dropdown',  array('1' => 'Show', '0' => 'Hidden'));
				$output = $crud->render();
				$data['content_title']='MST Master Modul'; 
				$data['content'] = 'main_app/sys_config';
				$data['page']='data';
				}
			else if($config_option == 'db_assign')
				{
				$crud = new grocery_CRUD();
				$crud->set_table('mst_user_assign_database');
				$crud->set_theme('flexigrid');
				$crud->required_fields('user_id','connection_id');
				$crud->set_relation('user_id','mst_user',"{hospital_id} - {real_name}");
				$crud->set_relation('connection_id','mst_database_connection',"{hospital_id} | {ip_address} | {database_name} | {database_type}");
				$crud->set_subject('Database Assignment');
				$output = $crud->render();
				$data['content_title']='MST Database Assignment'; 
				$data['content'] = 'main_app/sys_config';
				$data['page']='data';
				}
			else if($config_option == 'modul_assign')
				{
				$crud = new grocery_CRUD();
				$crud->set_table('mst_user_assign_modul');
				$crud->set_theme('flexigrid');
				$crud->required_fields('user_id','modul_id');
				$crud->set_relation('user_id','mst_user',"{hospital_id} - {real_name}");
				$crud->set_relation('modul_id','mst_tools',"{modul_name}");
				$crud->set_subject('Modul Assignment');
				$output = $crud->render();
				$data['content_title']='MST Modul Assignment'; 
				$data['content'] = 'main_app/sys_config';
				$data['page']='data';
				}
			else if($config_option == 'log')
				{
				$crud = new grocery_CRUD();
				$crud->set_table('mst_logs');
				$crud->set_theme('flexigrid');
				$crud->required_fields('user_id','modul_id');
				$crud->set_relation('user_id','mst_user',"{hospital_id} - {real_name}");
				$crud->set_relation('modul_id','mst_tools',"{modul_name}");
				$crud->unset_add();
				$crud->unset_edit();
				$crud->unset_delete();
				$crud->set_subject('Activity Log');
				$output = $crud->render();
				$data['content_title']='MST Log Activity'; 
				$data['content'] = 'main_app/sys_config';
				$data['page']='data';
				}
			else
				{
				redirect('tools', 'refresh');
				}
			$data['title'] = "System Config -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
				
		}
		else
		{
		redirect('core', 'refresh');
		}
	}

	
}
