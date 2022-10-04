<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_dokter extends CI_Controller {

function index($config_option=NULL)
	{
		if($this->sys_model->security(1) == true)
		{
			$data['style'] = 'portal.css';
			$data['parent_page'] = 'tools';				{
				$crud = new grocery_CRUD();
				$crud->set_table('mst_dokter');
				$crud->set_theme('flexigrid');
				$crud->required_fields('dok_name','address','phone','email','status');
				//$crud->set_relation('hospital_id','mst_hospital',"{hospital_id} - {real_hospital_name}");
				//$crud->set_relation('connection_id','mst_database_connection',"{hospital_id} | {ip_address} | {database_name} | {database_type}");
				$crud->set_subject('Master Dokter');
				$output = $crud->render();
				$data['content_title']='APT Dokter Management'; 
				$data['content'] = 'apt/mst_dokter';
				$data['page']='data';
				}
			else
				{
				redirect('tools', 'refresh');
				}
			//$data['title'] = "System Config -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
		}
    }