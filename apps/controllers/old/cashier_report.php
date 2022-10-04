<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Cashier_report extends CI_Controller 
{ 
	 function __construct()
    {
              parent::__construct();
              $this->load->model('sys_model');
			  $this->load->model('cashier_report_model');
			  $this->load->helper('array');
			  $this->load->helper('csv');
    }
    
	function index()
	{
	
			if($this->session->userdata('db_name'))
		{	
			//$data['sub_modul'] = $this->sys_model->get_submodul('36');
			$data['title'] = "Cashier Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['page']='menu';
			$data['style'] = 'portal.css';
			$data['content_title'] = "Cashier Report";
			$data['content'] = 'moduls/cashreport/cashier_home'; 
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
	
   	function deposit_report_filter()
	{
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = " Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['deposit_list'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['button_action'] = "cashier_report/get_details/";
			$data['button_export'] = 'cashier_report/get_deposit_export/';
			$data['form_request'] = "cashier_report/get_details";			
			$data['content_title'] = "Deposit Report";
			$data['detail_title']='Deposit Details Of IPD'.'<br />'.$this->session->userdata('hospital_name');
		
			$data['deposit_list'] = $this->cashier_report_model->get_deposit_report();
			//$data['depositdata'] = $this->cashier_report_model->get_deposit_detail_list($regid);
			//$data['depositdetail'] = $this->cashier_report_model->get_deposit_detail($regid);
			//ob_start('ob_gzhandler');
			//$datalist['aaData']=$this->cashier_report_model->get_deposit_report();
			//echo json_encode($datalist,JSON_UNESCAPED_UNICODE);
			
			//$data['button_action']='medicine_consume/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/cashreport/deposit_report_front'; 
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
   
   	function cashier_detail()
    {
 		if($this->session->userdata('db_name') && $this->input->post('mrnorpn'))
		{
		//$payer_id = $this->session->userdata('payer_id');
		//$medcornum = $this->input->post('mrnorpn');
		//$patient_name = $this->input->post('mrnorpn');
		//$data['mrnorpn'] = $medcornum;
		//$data['mrnorpn'] = $patient_name;
		$data['page']='datatable';
		$data['style'] = 'portal.css'; 
		
		$data['pathis_page']='patient_single_his';
		$data['title'] = "Deposit Report Details -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
		$data['detail_title']='Deposit Details Of IPD'.'<br />'.$this->session->userdata('hospital_name');
		$data['depositdata'] = NULL;
	
		//$data['form_request'] = "patient_history/patient_his_dashboard";
		$data['content_title'] = "Deposit Report";
		$data['button_action']='cashier_report/get_details/';
		$data['button_export'] = 'cashier_report/get_deposit_export/';
		
		$data['depositdata'] = $this->cashier_report_model->get_deposit_detail_list($regid);
		$data['depositdetail'] = $this->cashier_report_model->get_deposit_detail($regid);
		//$data['hisdata'] = $this->patient_his_model->get_patient_tracking($payer_id, $medcornum, $patient_name);

		$data['content'] = 'moduls/patreport/patient_history'; 
		$this->load->view('system',$data);
		}
	   else
		{
			if($this->session->userdata('username'))
			{
			redirect('tools', 'refresh');
			}
			else
			{
			$this->session->sess_destroy();
			redirect('core', 'refresh');
			}	
		}
    }
   
    
	function get_details($regid=NULL)
	{
		$data['detail_title']='Charge Details '.$this->session->userdata('hospital_name');
		//$data['payer_id']= $this->session->userdata('payer_id');
		//$data['hisdata'] = $this->patient_his_model->get_patient_tracking($patient_id);
		$data['depositdata'] = $this->cashier_report_model->get_deposit_detail_list($regid);
		$data['depositdetail'] = $this->cashier_report_model->get_deposit_detail($regid);
		$data['depositlog'] = $this->cashier_report_model->get_deposit_log($regid);
		
		
		$this->load->view('moduls/cashreport/deposit_detail',$data);
	}
	
	function get_deposit_export($regid=NULL)
    {          
  
       $depositexport =  $this->cashier_report_model->get_deposit_log_export($regid);
       //echo json_encode($patientdata);
       query_to_csv($depositexport,TRUE,'assets/uploads/document/depositlog_'.$regid.'.csv');

        echo anchor('assets/uploads/document/depositlog_'.$regid.'.csv','Download CSV File Here',array('class' => 'btn btn-primary glyphicon glyphicon-download'));
    }
	
}