<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audit_trails extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('audit_trails_model');
			  $this->load->helper('array','file');
	
	}
	
	function index()
	{
		redirect('core', 'refresh');
	}
	
	function radiology($record_id)
	{
		if($record_id != '')
		{
		$data['overide_log'] = $this->audit_trails_model->get_audit_trails('InfPacs','InfHIS_DoctorRadCode',$record_id);
		$this->load->view('component/audit_trails',$data);
		}
		else
		{
		redirect('core', 'refresh');
		}
	}
	
	

	

}
