<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Report_to_excel extends CI_Controller 
{ 
	 function __construct()
    {
              parent::__construct();
			  $this->load->database();
			  $this->load->model('reportdoctor_model');
			  $this->load->helper('array');
    }
	
    function index()
    {                        
        $data['dokter'] = $this->reportdoctor_model->get_daily_doctor();
        $this->load->view('report_prot/format/master_doctor_report', $data);     
    }
}