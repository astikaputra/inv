<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Radiology_report extends CI_Controller 
{ 
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('ris_interfacing');
			  $this->load->model('radiology_report_model');
    }
    
  	function index()
	{
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "MedicOS Radiology Transaction Dashboard | MedicOS Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['rad_doctor'] = $this->ris_interfacing->lookup_ris_doctor()->result();
			$data['form_request'] = "radiology_report/generate_report";
			$data['content_title'] = "MedicOS Radiology Throughput Report";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'report/radiology_report'; 
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
	
	function generate_report()
	{
	if($this->session->userdata('db_name') && ($this->input->post('doctorcode') != '') )
		{	
			$startdate = '';
			$enddate = '';
			$daterange = $this->input->post('optionsRadiosDaterange');
			if($daterange == 'today')
				{
			
				$startdate = date('Y-m-d',now());
				$enddate = date("Y-m-d",now());
				}
			else
				{
				$startdate = $this->input->post('startdate');
				$enddate = $this->input->post('enddate');
				}
		
			$doctor_code = $this->input->post('doctorcode');
			$order_type = $this->input->post('ordertype');
			$data['service_group'] = $this->radiology_report_model->get_service_group($startdate,$enddate);
			$data['datasource'] = base_url().'radiology_report/get_report_data/'.$startdate.'/'.$enddate.'/'.$doctor_code.'/'.$order_type;
			$this->load->view('report/radiology_report_detail',$data);

			
		}
	
	}
	
	function get_report_data($startdate,$enddate,$doctor_code,$ordertype)
	{
		if($this->session->userdata('db_name'))
		{	
			$data_post['startdate'] = $startdate;
			$data_post['enddate'] = $enddate;
			$data_post['doctor_code'] = $doctor_code;
			$data_post['order_type'] = $ordertype;
			$data['aaData'] = $this->radiology_report_model->get_radiology_throughput_dashboard($data_post);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
			
		}
			
	}
	
	function status_registration_lookup() //MST 13
	{		
			$keyword = $this->input->post('keyword');
			$data['title'] = "Bill -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($keyword)
			{$data['bill_data'] = $this->bill_model->get_bill($keyword);}
			else
			{$data['items_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Manage Patient Registration Status";
			$data['button_action']='patient_report/status_registration_lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/patreport/patient_status_registration'; 
			$this->load->view('system',$data);
	}
	
	function get_manual_radiology_report()
	{
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Manual Set Radiology Order | MedicOS Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "radiology_report/get_data";
			$data['content_title'] = "Manage Manual Radiology Order";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/radreport/radiology_dashboard'; 
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
		if($this->session->userdata('db_name') && ($this->input->post('keyword') != '') )
		{	
			$startdate = '';
			$enddate = '';
			$daterange = $this->input->post('optionsRadiosDaterange');
			$regcode = $this->input->post('keyword');
			if($daterange == 'today')
				{
			
				$startdate = date('Y-m-d',now());
				$enddate = date("Y-m-d",now());
				}
			else
				{
				$startdate = $this->input->post('startdate');
				$enddate = $this->input->post('enddate');
				}
			$data['startdate'] = $startdate;
			$data['enddate'] = $enddate;
			//$data['radiology_report'] = $this->radiology_report_model->get_radiology_manual($startdate,$enddate,$regcode);
			if($regcode != '')
				{
					$data['datasource'] = base_url().'radiology_report/get_manual_radiology_data/'.$startdate.'/'.$enddate.'/'.$regcode;
					$this->load->view('moduls/radreport/datacontainer/radiology_correction_order',$data);
				}
			else
				{	
					$this->load->view('moduls/radreport/radiology_dashboard',$data); 
				}
			
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
	
	function get_manual_radiology_data($startdate,$enddate,$regcode)
	{
	if($this->session->userdata('db_name'))
		{
			ob_start('ob_gzhandler');
			$data['aaData'] = $this->radiology_report_model->get_radiology_manual($startdate,$enddate,$regcode);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
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
	
	function deactivate_order($reg_id=NULL)
	{
	
		$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '53',
				   'requested_by' => $this->input->post('user_requested').' deactivate Registration id= '.$reg_id.' to database '.$this->session->userdata('db_name')
					);
			$this->sys_model->logging($logs);
		if($this->radiology_report_model->set_deactivate_order($reg_id))
		{
		}
		
		echo "0";
	}

	function activate_order($StatesId=NULL)
	{
		if($this->session->userdata('db_name'))
		{	
		//$doctor_code = $this->input->post('corrected_doctor');
		$StatesId = $this->uri->segment(3);
		$postdata = array('OrderStatus' => '1');

				$this->radiology_report_model->set_activate_order($postdata,$StatesId);
				// save logs

					$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id.' ('.$this->session->userdata('HISUser').')',
				   'modul_id'  => '53',
				   'requested_by' => $this->session->userdata('HISUser').' from IP '.$this->input->ip_address().' Overide Radiology Order QueueState On ID '.$StatesId
					);
				$this->sys_model->logging($logs);

				//echo "Radiology Service Ordered Successfully";

				//$data['message'] = "Radiology Service Ordered Successfully";
				//$data['page']='datatable';
				//$data['style'] = 'portal.css'; 
				//$data['content'] = 'moduls/radreport/datacontainer/success_form'; 
				//$this->load->view('system',$data);

				//$this->load->view('moduls/radreport/datacontainer/success_form',$data); 

				redirect('radiology_report/get_manual_radiology_report/', 'refresh');
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

	
		//$logs = array(
        //           'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
		//		   'modul_id'  => '53',
		//		   'ordered_by' => $this->sys_model->get_data_user($this->session->userdata('user')).' activate queue state id= '.$reg_id.' to database '.$this->session->userdata('db_name')
		//			);
		//	$this->sys_model->logging($logs);
		//if($this->radiology_report_model->set_activate_order($StatesId))
		//{
		//}
		
		
	}
	
}