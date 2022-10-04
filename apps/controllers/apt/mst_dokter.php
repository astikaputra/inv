<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mst_dokter extends CI_Controller {

function index()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('flexigrid');
			$crud->set_table('mst_dokter');
			$crud->set_subject('Master Dokter');
			$crud->required_fields('dok_name');
			$crud->columns('dok_name','addrss','phone','email','status');

			$output = $crud->render();

			$this->load->view('example',$output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	}