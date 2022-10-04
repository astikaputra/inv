<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Stock_report extends CI_Controller 
{ 
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('item_model');
              $this->load->model('sys_model');
			  $this->load->model('restreport_model');
			  $this->load->helper('array');
    }
    
   	function index()
	{
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Stock Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "stock_report/get_data";
			$data['content_title'] = "Slow Moving Stock Report";
			//$data['button_action']='medicine_consume/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'main_app/stock_slow_moving_report_front'; 
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
   
    
	function get_data() 
	{		
		if($this->session->userdata('db_name') && ($this->input->post('zerofilterdata') != '') )
		{	
			$startdate = '';
			$endate = '';
			$zerostate = '';
			$daterange = $this->input->post('optionsRadiosDaterange');
			$zerofilterdata = $this->input->post('zerofilterdata');
			if($daterange == 'last3month')
				{
			
				$startdate = date('Y-m-d', strtotime("-3 month"));
				$enddate = date("Y-m-d");
				}
			else
				{
				$startdate = $this->input->post('startdate');
				$endate = $this->input->post('enddate');
				}
			if($zerofilterdata == 'withzerostock')
				{
					$zerostate =  TRUE;
				}
			else
				{
					$zerostate = FALSE;
				}
			ob_start('ob_gzhandler');
			$datalist['aaData']=$this->restreport_model->get_slow_moving_stock($startdate,$endate,$zerostate);
			echo json_encode($datalist,JSON_UNESCAPED_UNICODE);
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
	
}