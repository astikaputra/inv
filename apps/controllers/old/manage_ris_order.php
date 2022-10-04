<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_ris_order extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('ris_interfacing');
			  $this->load->model('sys_model');
			  $this->load->helper('array');
			  $this->load->library("excel");
    }
	
	function index()
	{
		if($this->session->userdata('db_name'))
		{	
			if($this->sys_model->security(25) == true)
			{
			$data['title'] = "Hospital Information :: Manage Radiologi Order   ".$this->session->userdata('hospital_name');
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = 'manage_ris_order/list_transaction';
			$data['content_title'] = "Manage Radiologi Order";
			$data['content'] = 'ris_order/manage_order'; 
				$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id.' ('.$this->session->userdata('HISUser').')',
				   'modul_id'  => '25',
				   'requested_by' => $this->session->userdata('HISUser').' from IP '.$this->input->ip_address()
					);
				$this->sys_model->logging($logs);	

			$this->load->view('system',$data);
			}
			else
			{
			redirect('core', 'refresh');
			}
			
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
	
	// Get List Transaction by input or by url
	
	function list_transaction($startdate=NULL,$enddate=NULL)
	{
		if($this->session->userdata('db_name'))
		{	
		
			//$roles =  $this->session->userdata('userrole');
		
			//$roles =  'finance';
			//$roles =  'hod-radiology';
			$roles = 'fo-rad';
		
			if($this->sys_model->security(25) != true)
			{
			redirect('core', 'refresh');
			}
		
			if($startdate == NULL)
			{
			$startdate= $this->input->post('startdate');
			$enddate= $this->input->post('enddate');
			}
			if($this->input->post('ReportType')=='excel')
				{
					redirect('manage_ris_order/generate_excel_report_doctor_fee/'.$startdate.'/'.$enddate, 'refresh');
				}
			else
				{
			
			$url_param = array('ris_list_param' => "$startdate/$enddate");
			$this->session->set_userdata($url_param);
			$data['title'] = "Hospital Information :: List Of Radiologi Transaction ".$this->session->userdata('hospital_name');
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = 'manage_ris_order/list_transaction';
			$data['form_correcting_doctor'] = 'manage_ris_order/save_doctor_correction';
			$data['content_title'] = "Radiology Study Matching";
			$data['button_action'] = 'manage_ris_order/doctor_correction/';
			if(stristr($roles,'finance')==TRUE)
			{
			$data['content'] = 'ris_order/manage_ris_transaction_finance'; 
			}
			else if(stristr($roles,'hod-radiology')==TRUE)
			{
			$data['content'] = 'ris_order/manage_ris_transaction_hod'; 
			}
			else 
			{
			$data['content'] = 'ris_order/manage_ris_transaction'; 
			}
			
			$data['list_doctor_ris'] =  $this->ris_interfacing->lookup_ris_doctor();
			$data['list_transaction'] = $this->ris_interfacing->get_ris_transaction($startdate,$enddate,$roles);
			// save logs
					$logs = array(
		           'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id.' ('.$this->session->userdata('HISUser').')',
				   'modul_id'  => '25',
				   'requested_by' => $this->session->userdata('HISUser').' from IP '.$this->input->ip_address().'Generate Radiologi Data From '.$startdate.'to'.$enddate
					);
					$this->sys_model->logging($logs);	

			$this->load->view('system',$data);
			 //$this->output->enable_profiler(TRUE);
				}
			
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

	function load_ris_data($paramname=NULL,$recordid=NULL,$physicianname,$orderdate)
	{
		if($this->session->userdata('db_name'))
		{	
			if($this->sys_model->security(25) != true)
			{
			redirect('core', 'refresh');
			}
		
			$data['ris_undefined_data'] = $this->ris_interfacing->get_ris_undefinedtrans($paramname,$physicianname,substr($orderdate,0,10));
			$data['recid'] = $recordid;
			$this->load->view('ris_order/ris_data',$data);
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

	
	function save_doctor_correction()
	{
		if($this->sys_model->security(25) == false)
			{
			redirect('core', 'refresh');
			}
			
		if($this->session->userdata('db_name'))
		{	
				//$doctor_code = $this->input->post('corrected_doctor');
				$trans_id = $this->input->post('rec_id');
				$postdata = array('OrderStatus' => 'COMPLETED' , 
								  'StudyInstanceUID' =>$this->input->post('studyiud') , 
								  'StudyDate' => $this->input->post('studydate'),  
								  'AccessionNo' => $this->input->post('AccessionNo') ,  
								  'TechnicalNotes' => $this->input->post('TechnicalNote') ,
								  'PhysicianPerformingCode' => $this->input->post('doctorcode'),  
								  'PhysicianPerformingName' => $this->input->post('doctorname'), 
								  'PhysicianPerformingEmail' => $this->input->post('doctoremail') 
								);

				$this->ris_interfacing->overide_doctor_transaction($postdata,$trans_id);
				// save logs

					$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id.' ('.$this->session->userdata('HISUser').')',
				   'modul_id'  => '25',
				   'requested_by' => $this->session->userdata('HISUser').' from IP '.$this->input->ip_address().'Overide Data'.$trans_id
					);
				$this->sys_model->logging($logs);	

				redirect('manage_ris_order/list_transaction/'.$this->session->userdata('ris_list_param'), 'refresh');
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
	/*
	
	function proving_doctor_correction()
	{
		if($this->sys_model->security(25) == false)
			{
			redirect('core', 'refresh');
			}
			
		if($this->session->userdata('db_name'))
		{	
				$trans_id = $this->input->post('trans_id');
				$status = $this->ris_interfacing->transaction_approved($trans_id);
				echo $status;
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
	
		//this function only front office department can used.
	
	function transaction_checked()
	{
		if($this->sys_model->security(25) == false)
			{
			redirect('core', 'refresh');
			}
				
		if($this->session->userdata('db_name'))
		{	
				$trans_id = $this->input->post('trans_id');
				$status = $this->ris_interfacing->transaction_checked($trans_id);
				if($status==1)
				{echo 'checked';}
				else
				{echo 'unchecked';}
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
	*/
	
	/*
	function approving_all()
	{
	if($this->sys_model->security(25) == false)
			{
			redirect('core', 'refresh');
			}
			
		if($this->session->userdata('db_name'))
		{	
				$doctor_code = $this->input->post('corrected_doctor');
				$trans_id = $this->input->post('trans_id');
				$this->ris_interfacing->overide_doctor_transaction($doctor_code,$trans_id);
				redirect('manage_ris_order/list_transaction/'.$this->session->userdata('ris_list_param'), 'refresh');
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
	
	*/
	
	//this function only finance department can used.
	/*
	function transaction_paid()
	{
		if($this->sys_model->security(25) == false)
			{
			redirect('core', 'refresh');
			}
		
		/* Check Roles finance
		if(stristr($this->session->userdata('user_roles'),finance == FALSE) 
		{redirect('core', 'refresh');}
			
		if($this->session->userdata('db_name'))
		{	
				$trans_id = $this->input->post('trans_id');
				$status = $this->ris_interfacing->paid_transaction($trans_id);
				if($status==1)
				{echo 'paid';}
				else
				{echo 'unpaid';}
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
	*/

	/*
	
	function transaction_unpaid()
	{
		if($this->sys_model->security(25) == false)
			{
			redirect('core', 'refresh');
			}
		
		/* Check Roles finance
		if(stristr($this->session->userdata('user_roles'),finance == FALSE) 
		{redirect('core', 'refresh');}
			
		if($this->session->userdata('db_name'))
		{	
				$trans_id = $this->input->post('trans_id');
				$status = $this->ris_interfacing->unpaid_transaction($trans_id);
					if($status==1)
				{echo 'unpaid';}
				else
				{echo 'paid';}
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
	
	function unlock_data()
	{
		if($this->sys_model->security(25) == false)
			{
			redirect('core', 'refresh');
			}
		
		/* Check Roles finance
		if(stristr($this->session->userdata('user_roles'),finance == FALSE) 
		{redirect('core', 'refresh');}
			
		if($this->session->userdata('db_name'))
			{	
				$trans_id = $this->input->post('trans_id');
				$status = $this->ris_interfacing->unlock_approval($trans_id);
				echo $status;
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
	*/
	function generate_excel_report_doctor_fee($startdate,$enddate)
	{
		if($this->sys_model->security(25) == false)
			{
			redirect('core', 'refresh');
			}		
		/* Check Roles finance
		if(stristr($this->session->userdata('user_roles'),finance == FALSE) 
		{redirect('core', 'refresh');}*/			
		if($this->session->userdata('db_name'))
			{	
				
				$this->excel->setActiveSheetIndex(0);
				$fee = $this->ris_interfacing->get_doctor_fee($startdate,$enddate)->result();
				$this->excel->force_download('radiology_doctorfee.xls',$fee);
				redirect('manage_ris_order', 'refresh');
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

	function finance_dashboard_radiology()
	{
		if($this->sys_model->security(25) == false)
			{
			redirect('core', 'refresh');
			}	
			$data['title'] = "MedicOS Radiology Transaction Dashboard | MedicOS Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "manage_ris_order/get_radiology_order_summary";
			$data['content_title'] = "MedicOS Radiology Transaction Dashboard";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'ris_order/manage_ris_transaction_finance_dashboard.php'; 
			$this->load->view('system',$data);

	}

	function get_radiology_order_summary()
	{
		if($this->sys_model->security(25) == false)
			{
			redirect('core', 'refresh');
			}	
		if($this->input->post('startdate') != '')
		{
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('enddate');
		}

		$data =  array('all_order_radiology' => $this->ris_interfacing->get_all_order($startdate,$enddate)->num_rows(),
						'completed_order'=> $this->ris_interfacing->get_all_completed_order($startdate,$enddate)->num_rows(),
						'incompleted_order'=> $this->ris_interfacing->get_all_incomplete_order($startdate,$enddate)->num_rows() );



	}

	function radiology_data_service($data_type=NULL)
	{
		if($this->sys_model->security(25) == false)
			{
			redirect('core', 'refresh');
			}	
		if($this->input->post('startdate') != '')
		{
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('enddate');
		}

		if($data_type == 'all_order')
		{
			$data['all_order_radiology'] = $this->ris_interfacing->get_all_order($startdate,$enddate)->result();	
		}
		else if($data_type == 'completed_order')
		{
			$data['completed_order_radiology'] = $this->ris_interfacing->get_all_completed_order($startdate,$enddate)->result();	
		}
		else if($data_type == 'incompleted_order')
		{
			$data['incomplete_order_radiology'] = $this->ris_interfacing->get_all_incomplete_order($startdate,$enddate)->result();
		}	
		else
		{ 	
			$data = 0;
		}

		echo json_encode($data);

	}
	

}