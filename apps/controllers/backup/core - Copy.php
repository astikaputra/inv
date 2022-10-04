<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller {

	public function index()
	{
		$data['title'] = "MedicOS Support Tools: ".$this->config->item('company_name');
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
	

	
	function login($hospitalid=NULL,$server_type=NULL,$userid=NULL,$dept=NULL,$url=NULL)
	{		$status = 0;
			$uname =	$this->input->post('username');
			$pass =		$this->input->post('password');
		//----------Autologin----------------------------//
			if($hospitalid=='SHDP')
			{
			$uname =	'user-shdp';
				if(stristr($server_type,'uat') == TRUE)
				{
				$uname = 'user-uat-shdp';	
				}
				else if(stristr($server_type,'dev') == TRUE)
				{
				$uname = 'user-dev';	
				}
			$pass = 'password';
			$status = TRUE;
			}
			else if($hospitalid=='SHTS')
			{
			$uname =	'user-shts';
				if(stristr($server_type,'uat') == TRUE)
				{
				$uname = 'user-uat-shts';	
				}
				else if(stristr($server_type,'dev') == TRUE)
				{
				$uname = 'user-dev';	
				}
				//	Departement Check only in shts
					//radiology department
					if(stristr($dept,'rad')== TRUE){
						$uname = 'radiology.shts';
					}

			$pass = 'password';
			$status = TRUE;
			}
			else
			{
			
			/*
			$key = 'siloam';
			$pass = $this->encrypt->encode($pass, $key);
			*/
			
			$status = $this->sys_model->check_login($uname,$pass);	
			}
	
			//----------End Auto Login ----------------------//
			if($status == TRUE)
			{
			$sesdata = array(
                   'username'  => sha1(md5($this->input->post('username'))),
				   'user'  => $this->sys_model->get_data_user($uname)->username,
				   'logged_in' => TRUE,
				   'HISUser' => $userid,
				   'HUId'=>$hospitalid,
				   'url_target'=>$url
               );
			$this->session->set_userdata($sesdata);
			$this->sys_model->set_online($uname);	
			if($userid==NULL)
			{$userid = $this->sys_model->get_data_user($uname)->username;}			
			//logging activity to system
				$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '2',
				   'requested_by' => $userid.' from IP '.$this->input->ip_address()
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
				   'requested_by' => 'self '.$this->input->ip_address()
					);
				$this->sys_model->logging($logs);	
				
	$this->sys_model->set_offline($this->session->userdata('user'));	
	$this->session->sess_destroy();
	$data['title'] = "MedicOS Support Tools: ".$this->config->item('company_name');
		$data['page']='login';
		$data['message'] = 'Medicos Support Tools';
		$data['style'] = 'login.css'; 
		$data['content'] = 'login/login'; 
		$this->load->view('system',$data);
	}
	
	function select_database()
	{



		if($this->session->userdata('username'))
		{

			if(($this->sys_model->get_conection_number())==1)
			{
				$db_id=$this->sys_model->get_conection_list()->row()->connection_id;
				$sesdata = array(
				'hospital_id'  => $this->sys_model->get_auth_db($db_id)->hospital_id,
                'db_host'  => $this->sys_model->get_auth_db($db_id)->ip_address,
				'db_user'  => $this->sys_model->get_auth_db($db_id)->username,
				'db_password' => $this->sys_model->get_auth_db($db_id)->password,
				'payer_id' => $this->sys_model->get_hospital_name($this->sys_model->get_auth_db($db_id)->hospital_id)->employee_payer_id,
				'hospital_name' => $this->sys_model->get_hospital_name($this->sys_model->get_auth_db($db_id)->hospital_id)->real_hospital_name,
				'db_name' => $this->sys_model->get_auth_db($db_id)->database_name,
				'env_type' => $this->sys_model->get_auth_db($db_id)->database_type);
				$this->session->set_userdata($sesdata);

//				redirect('core/check_user_roles', 'refresh');
				redirect('tools', 'refresh');
			}
			else if(($this->sys_model->get_conection_number())>=2)
			{
			$sesdata = array(
                'db_host'  => '',
				'db_user'  => '',
				'db_password' => '',
				'db_name' => '');
				$this->session->unset_userdata($sesdata);
			$data['list_db'] = $this->sys_model->get_conection_list()->result();
			$data['title'] = "Selecting Database -> MedicOS Support Tools :: ".$this->config->item('company_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['message'] = "Welcome".$this->session->userdata('user');
			$data['content'] = 'main_app/select_database'; 
			$this->load->view('system',$data);
			}		
			
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
			if($this->session->userdata('db_host')=='')
			{
			$db_id = $this->input->post('db');
				$sesdata = array(
				'hospital_id'  => $this->sys_model->get_auth_db($db_id)->hospital_id,
                'db_host'  => $this->sys_model->get_auth_db($db_id)->ip_address,
				'db_user'  => $this->sys_model->get_auth_db($db_id)->username,
				'db_password' => $this->sys_model->get_auth_db($db_id)->password,
				'payer_id' => $this->sys_model->get_hospital_name($this->sys_model->get_auth_db($db_id)->hospital_id)->employee_payer_id,
				'hospital_name' => $this->sys_model->get_hospital_name($this->sys_model->get_auth_db($db_id)->hospital_id)->real_hospital_name,
				'db_name' => $this->sys_model->get_auth_db($db_id)->database_name,
				'env_type' => $this->sys_model->get_auth_db($db_id)->database_type);				
				$this->session->set_userdata($sesdata);
				redirect('tools', 'refresh');
			}
			else
			{
				redirect('tools', 'refresh');
			}
		}
		else
		{	
			redirect('core', 'refresh');	
		}
	}
	
	function check_user_roles(){

		if($this->session->userdata('username'))
		{			
		$roles = $this->sys_model->get_user_role($this->session->userdata('HISUser'))->Roles;
	
		if($roles != '')
			{
			 $sessiondata = $this->session->userdata('user');
			//----------------------------------Mapping Users---------------------------------------/
			if(stristr($this->session->userdata('HUId'),'shdp') == TRUE)
				{
					if($roles=='admin-hospital')
						{
						$sessiondata = 'it-shdp';
						}
					else if($roles=='mr-staff')
						{
						$sessiondata =  'mr-shdp';
						}
					else if($roles=='Management')
						{
							if(stristr($this->session->userdata('HISUser'),'finance')== TRUE)
								{
								$sessiondata = 'finance-shts';
								$roles  = 'finance';								
								}
							else
								{$sessiondata = 'management-shdp';}
						}
					else if($roles=='HOD-RADIOLOGY')
						{

							$sessiondata = 'shdp-hod-radiology';								
						}
					else
						{
						$sessiondata = $this->session->userdata('user');
						}
				}
			else if(stristr($this->session->userdata('HUId'),'shts')== TRUE)
				{
					if($roles=='admin-hospital')
						{
						$sessiondata = 'it-shts';
						}
					else if($roles=='mr-staff')
						{
						$sessiondata =  'mr-shts';
						}
					else if($roles=='Management')
						{
							if(stristr($this->session->userdata('HISUser'),'Finance') == TRUE)
								{
								$sessiondata = 'finance-shts';
								$roles  = 'finance';	
								}
							else
								{$sessiondata = 'management-shts';}
						}
					else if($roles=='HOD-RADIOLOGY')
						{
						$sessiondata = 'shts-hod-radiology';								
						}
					else
						{
						if(stristr($this->session->userdata('HISUser'),'.rad')==TRUE)
							{
							$sessiondata = 'shts-rad';
							}
						else
							{
							$sessiondata = $this->session->userdata('user');
							}
						}
				
				}

				$sesdata = array('user'  => $sessiondata,
								 'userrole'  => $roles);
				$this->session->set_userdata($sesdata);
			}
			else
			{
				$sesdata = array('userrole'  => 'no_roles');
				$this->session->set_userdata($sesdata);

			}
				
				if($this->session->userdata('url_target') != '')
					{ redirect($this->session->userdata('url_target'));}
				else
					{ redirect('tools', 'refresh'); }		
		}
		else
		{	

			//redirect('core', 'refresh');	
			redirect('tools', 'refresh');	
		}
	
		

		}

	//---------------------------------------mysql----------------------------------
	function _encrypt_pass($post_array){
	
	echo $current_pass;
	if($post_array['password'] == $current_pass)
		{$post_array['password'] =  $this->sys_model->get_current_password($post_array['user_id']);}
	else
		{$post_array['password'] =  md5($post_array['password']);}
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
				$crud->callback_before_insert(array($this,'encrypt_password_callback'));
				$crud->callback_before_update(array($this,'encrypt_password_callback'));
				$crud->callback_edit_field('password',array($this,'decrypt_password_callback'));
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
				$crud->required_fields('modul_name','modul_description','modul_url','modul_show','modul_category_id');
				$crud->set_relation('modul_category_id', 'mst_tools_category',  "{category_id} - {category_name}");
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
				$crud->order_by('timestamp','desc');
				$crud->set_subject('Activity Log');
				$output = $crud->render();
				$data['content_title']='MST Log Activity'; 
				$data['content'] = 'main_app/sys_config';
				$data['page']='data';
				}

			else if($config_option == 'alert')
				{
				$crud = new grocery_CRUD();
				$crud->set_table('mst_system_alert');
				$crud->set_theme('flexigrid');
				$crud->required_fields('hospital_id','connection_id','alert_modul','mail_to','cc_to');
				$crud->set_relation('hospital_id','mst_hospital',"{hospital_id} - {real_hospital_name}");
				$crud->set_relation('connection_id','mst_database_connection',"{hospital_id} | {ip_address} | {database_name} | {database_type}");
				$crud->set_subject('Alert System');
				$output = $crud->render();
				$data['content_title']='MST Log Activity'; 
				$data['content'] = 'main_app/sys_config';
				$data['page']='data';
				}


			else if($config_option == 'category')
				{
				$crud = new grocery_CRUD();
				$crud->set_table('inv_category');
				$crud->set_theme('flexigrid');
				$crud->required_fields('cat_name');
				$crud->set_subject('Category Items');
				$output = $crud->render();
				$data['content_title']='Category Items'; 
				$data['content'] = 'main_app/category';
				$data['page']='data';
				}

			else if($config_option == 'location')
				{
				$crud = new grocery_CRUD();
				$crud->set_table('inv_locations');
				$crud->set_theme('flexigrid');
				$crud->required_fields('location_name', 'floor');
				$crud->set_subject('Locations Items');
				$output = $crud->render();
				$data['content_title']='Locations Items'; 
				$data['content'] = 'main_app/category';
				$data['page']='data';
				}

			else if($config_option == 'asset')
				{
				$crud = new grocery_CRUD();
				$crud->set_table('inv_items');
				$crud->set_theme('flexigrid');
				$crud->required_fields('inv_code','id_cat','inv_name','sn','inv_status');
				$crud->set_subject(' Asset Management');
				$crud->set_relation('id_cat','inv_category',"{id_cat} - {cat_name}");
				//$crud->set_relation('id_loc','inv_locations',"{id_loc} - {loc_name}");				
				$crud->field_type('inv_status', 'dropdown',  array('1' => 'Active', '0' => 'Inactive'));
				$output = $crud->render();
				$data['content_title']='Master Asset Management'; 
				$data['content'] = 'main_app/category';
				$data['page']='data';
				}

				else if($config_option == 'mapping')
				{

				$crud = new grocery_CRUD();
				$crud->set_table('inv_mapping');
				$crud->set_theme('flexigrid');
				$crud->required_fields('map_code','map_name','asset_assign');
				$crud->columns('map_code','map_name');
				//$crud->set_relation('inv_loc','inv_locations',"{id_loc} - {loc_name}");
				$crud->set_subject('Asset Mapping');
				// $crud->field_type('active', 'dropdown',  array('1' => 'Active', '0' => 'Inactive'));
				// $crud->field_type('is_online', 'dropdown',  array('1' => 'Online', '0' => 'Offline'));
				$crud->fields('map_code','map_name','asset_assign'); 
				//$crud->set_relation_n_n('database_assign', 'mst_user_assign_database', 'mst_database_connection', 'user_id','connection_id' ,  "{hospital_id} - {ip_address} - {database_name}");
				//$crud->set_relation_n_n('tools_assign', 'mst_user_assign_modul', 'mst_tools', 'user_id','modul_id','modul_name','priority');
				$crud->set_relation_n_n('asset_assign', 'inv_assign', 'inv_items', 'map_id','inv_id','inv_name','seq');
				$output = $crud->render();
				$data['content_title']='Asset Mapping'; 
				$data['content'] = 'main_app/category';
				$data['page']='data';
				}

				// else if($config_option == 'inv_assign')
				// {
				// $crud = new grocery_CRUD();
				// $crud->set_table('inv_assign');
				// $crud->set_theme('flexigrid');
				// $crud->required_fields('map_id','inv_id');
				// $crud->set_relation('map_id','inv_mapping',"{map_id} - {map_name}");
				// $crud->set_relation('inv_id','inv_items',"{inv_name}");
				// $crud->set_subject('Asset Assignment');
				// $output = $crud->render();
				// $data['content_title']='Asset Assignment'; 
				// $data['content'] = 'main_app/category';
				// $data['page']='data';
				// }

			else
				{
				redirect('tools', 'refresh');
				}
			$data['title'] = "System Config -> Inventory Tools :: ".$this->config->item('company_name')." ";
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
				
		}
		else
		{
		redirect('core', 'refresh');
		}
	}


	function encrypt_password_callback($post_array, $primary_key = null)
		{
		$this->load->library('encrypt');
		$key = 'siloam';
		$post_array['password'] = $this->encrypt->encode($post_array['password'], $key);
		return $post_array;
		}

	function decrypt_password_callback($value)
		{
		$this->load->library('encrypt');
		$key = 'siloam';
		$decrypted_password = $this->encrypt->decode($value, $key);
		return "<input type='password' name='password' value='$decrypted_password' />";
		}
		
	function update_system()
		{
			$path_directory = getcwd();
			$cmd ="svn update $path_directory";
			$output = shell_exec($cmd);
			echo "<pre>$output</pre>";
			
		
		}

	
}