<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Patient_report extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('patientreport_model');
			  $this->load->model('patient_his_model');
			  $this->load->model('bill_model');
			  $this->load->model('sys_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
	
			if($this->session->userdata('db_name'))
		{	
			//$data['sub_modul'] = $this->sys_model->get_submodul('15');
			$data['title'] = "Generate Patient Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['page']='menu';
			$data['style'] = 'portal.css';
			$data['content_title'] = "Generate Patient Report";
			$data['content'] = 'moduls/patreport/patient_home'; 
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
	
	// Get List Patient Report by filter
	function daily_patient_report_filter()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Generate Patient Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "patient_report/daily_patient_report";
			$data['content_title'] = "Generate Patient Report";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/patreport/patient_report_filter'; 
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
	
	function daily_patient_report() 
	{		
		if($this->session->userdata('db_name') && $this->input->post('startdate'))
		{	
			$datestart = $this->input->post('startdate');
			$dateend = $this->input->post('enddate');
			$payer_id = $this->session->userdata('payer_id');
			$data['title'] = "Generate Patient Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['startdate'] = $datestart;
			$data['enddate'] = $dateend;
			$data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->userdata('hospital_id'))->real_hospital_name;
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			//-------------------------load report data total patient-----------------------------------/
			$data['total_patient']= $this->patientreport_model->count_all_patient($datestart,$dateend);
			$data['total_patient_opd']= $this->patientreport_model->count_all_patient($datestart,$dateend,'OPD');
			$data['total_patient_ipd']= $this->patientreport_model->count_all_patient($datestart,$dateend,'IPD');
			$data['total_patient_etc']= $this->patientreport_model->count_all_patient($datestart,$dateend,'ETC');
			$data['total_patient_mcu']= $this->patientreport_model->count_all_patient($datestart,$dateend,'MCU');
			//-------------------------load report data detail patient per department-----------------------------------/
			//--------------opd-----------
			$data['active_patient_opd'] = $this->patientreport_model->get_active_patient($datestart,$dateend,'OPD');
			$data['closed_patient_opd'] = $this->patientreport_model->get_closed_patient($datestart,$dateend,'OPD');
			$data['canceled_patient_opd'] = $this->patientreport_model->get_canceled_patient($datestart,$dateend,'OPD');
			//--------------opd-----------
			$data['active_patient_ipd'] = $this->patientreport_model->get_active_patient($datestart,$dateend,'IPD');
			$data['closed_patient_ipd'] = $this->patientreport_model->get_closed_patient($datestart,$dateend,'IPD');
			$data['canceled_patient_ipd'] = $this->patientreport_model->get_canceled_patient($datestart,$dateend,'IPD');
			//--------------etc-----------
			$data['active_patient_etc'] = $this->patientreport_model->get_active_patient($datestart,$dateend,'ETC');
			$data['closed_patient_etc'] = $this->patientreport_model->get_closed_patient($datestart,$dateend,'ETC');
			$data['canceled_patient_etc'] = $this->patientreport_model->get_canceled_patient($datestart,$dateend,'ETC');
			//--------------mcu-----------
			$data['active_patient_mcu'] = $this->patientreport_model->get_active_patient($datestart,$dateend,'MCU');
			$data['closed_patient_mcu'] = $this->patientreport_model->get_closed_patient($datestart,$dateend,'MCU');
			$data['canceled_patient_mcu'] = $this->patientreport_model->get_canceled_patient($datestart,$dateend,'MCU');
			
			$data['retail_patient'] = $this->patientreport_model->get_retail_patient($datestart,$dateend,'Retail');
			//$data['discharge_patient'] = $this->patientreport_model->get_patient_discharge($month,$year);
			
			$data['form_request'] = "daily_report/show";
			$data['content_title'] = "Generate Patient Report";
			$data['button_action']='bill_check/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'report/patient_report'; 
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
	
	// Get data history report by filter
	function patient_history_filter()
	{		
			$keyword = $this->input->post('keyword');
			$data['payer_id']= $this->session->userdata('payer_id');
			if($this->session->userdata('db_name'))
		{
			$data['title'] = "Hospital Information :: Patient History Dashboard ".$this->session->userdata('hospital_name');
			if($keyword)
			{$data['pathisdata'] = $this->patient_his_model->get_patient_tracking($keyword);}
			else
			{$data['pathisdata'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['button_action']='patient_report/patient_trace/';
			$data['form_request'] = 'patient_report/patient_history/';
			$data['content_title'] = "Filter Data For Patient History";
			$data['pathis_title']='Patient History Details Of '.$this->input->post('mrnorpn').'<br />'.$this->session->userdata('hospital_name');
			$data['content'] = 'moduls/patreport/patient_history_filter'; 
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
	
	function patient_history()
    {
 		if($this->session->userdata('db_name') && $this->input->post('mrnorpn'))
		{
		$payer_id = $this->session->userdata('payer_id');
		$medcornum = $this->input->post('mrnorpn');
		$patient_name = $this->input->post('mrnorpn');
		$data['mrnorpn'] = $medcornum;
		$data['mrnorpn'] = $patient_name;
		$data['page']='datatable';
		$data['style'] = 'portal.css'; 
		
		$data['pathis_page']='patient_single_his';
		$data['title'] = "Patient History -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
		$data['pathis_title']='Patient History Details Of '.$this->input->post('mrnorpn').'<br />'.$this->session->userdata('hospital_name');
		$data['pathisdata'] = NULL;
	
		//$data['form_request'] = "patient_history/patient_his_dashboard";
		$data['content_title'] = "Patients History Report";
		$data['button_action']='patient_report/patient_trace/';
		
		$data['detailsdata'] = $this->patient_his_model->get_identity_details($payer_id, $medcornum, $patient_name);
		$data['pathisdata'] = $this->patient_his_model->get_patient_history($payer_id, $medcornum, $patient_name);
		$data['hisdata'] = $this->patient_his_model->get_patient_tracking($payer_id, $medcornum, $patient_name);

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
	
	function lookup_patient_json($keyword)
	{		
			$this->benchmark->mark('code_start');
			if($keyword)
			{$data= $this->patient_his_model->get_patient_tracking($keyword);}
			else
			{$data= NULL;}
			$arr_data=array();
			foreach($data as $patients){
				$arr_data['patients'][]=array('patienthis'=>array('mr_number'=>$patients->MedicalRecordNumber,'patient_name'=>$patients->PatientName,'doctor_name'=>$patients->DoctorName,'reg_code'=>$patients->RegistrationCode,'reg_time'=>$patients->RegistrationTime));
			}
			print json_encode($arr_data);
			$this->benchmark->mark('code_end');
			echo $this->benchmark->elapsed_time('code_start', 'code_end');
	}
	
	function patient_trace($patient_id=NULL)
	{
		$data['pathis_title'] = 'Patients History Details Of '.$this->input->post('keyword').'<br />'.$this->session->userdata('hospital_name');
		//$data['payer_id']= $this->session->userdata('payer_id');
		//$data['hisdata'] = $this->patient_his_model->get_patient_tracking($patient_id);
		$data['hisdata'] = $this->patient_his_model->get_patient_list($patient_id);
		$data['patientname'] = $this->patient_his_model->get_identity_details($patient_id);
		
		$this->load->view('data/data_his_tab',$data);
    }
	
	//Get Report Of Patient Discharge Report By Filter
	function patient_discharge_report_filter()
	{
			$keyword = $this->input->post('startdate');
			//$keyword = $this->input->post('repmoyr');
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Generate Daily Patient Discharge Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($keyword)
			{$data['discharge_data'] = $this->patientreport_model->get_patient_discharge($datestart,$dateend);}
			else
			{$data['discharge_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "patient_report/patient_dicharge_report";
			$data['content_title'] = "Generate Daily Patient Discharge Report";
			$data['button_action']='patient_report/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/patreport/patient_discharge_filter'; 
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
	
	function patient_dicharge_report() 
	{		
		if($this->session->userdata('db_name') && $this->input->post('startdate'))
		{	
			$datestart = $this->input->post('startdate');
			$dateend = $this->input->post('enddate');
			//$monthyear = $this->input->post('repmoyr');
            //$payer_id = $this->session->userdata('payer_id');
			$data['title'] = "Generate Daily Patient Discharge Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            $data['startdate'] = $datestart;
			$data['enddate'] = $dateend;
			//$data['repmoyr'] = $monthyear;
			$data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			
			$data['discharge_data'] = $this->patientreport_model->get_patient_discharge($datestart,$dateend);
			$data['discharge_data_10'] = $this->patientreport_model->get_patient_discharge10($datestart,$dateend);
			//$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);
            
            $data['form_request'] = "patient_discharge/patient_dicharge_report";
			$data['content_title'] = "Generate Daily Patient Discharge Report";
			//$data['button_action']='patient_discharge/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/patreport/patient_discharge';
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
	
	function set_status_registration_filter()
	{
			$data['title'] = "Set Status Registation -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Manage Patient Registration Status";
			$data['button_action']='patient_report/status_registration_lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/patreport/registration_status_filter'; 
			$this->load->view('system',$data);
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
	
	function deactivate_reg($reg_id=NULL)
	{
	
		$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '13',
				   'requested_by' => $this->input->post('user_requested').' deactivate Registration id= '.$reg_id.' to database '.$this->session->userdata('db_name')
					);
			$this->sys_model->logging($logs);
		if($this->bill_model->set_deactivate_billing($reg_id))
		{
		}
		
		echo "0";
	}
	function activate_reg($reg_id=NULL)
	{
	
		$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '13',
				   'requested_by' => $this->input->post('user_requested').' activate Registration id= '.$reg_id.' to database '.$this->session->userdata('db_name')
					);
			$this->sys_model->logging($logs);
		if($this->bill_model->set_activate_billing($reg_id))
		{
		}
		
		echo "1";
	}
	
	function get_ipd_report_filter()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Hospital Information :: IPD Dashboard ".$this->session->userdata('hospital_name');
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['linkto'] = "ipd_dashboard";
			$data['content_title'] = "Select Hospital Floors / Ward";
			$data['list_floor_row'] = $this->patientreport_model->get_floor_row();;
			//$data['list_floor'] = $this->patientreport_model->get_floor();
			//$data['list_ward'] = $this->patientreport_model->get_ward();
			$data['list_ward_row'] = $this->patientreport_model->get_ward_row();
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/patreport/selecting_hospital_floor'; 
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
	
	function ipd_dashboard($floor_id=NULL,$ward=NULL) 
	{		
		if($this->session->userdata('db_name'))
		{	
			//$payer_id = $this->session->userdata('payer_id');
			if($floor_id==NULL)
			{
			redirect('patient_report/get_ipd_report_filter', 'refresh');
			}
			else
			{
				if($ward!=NULL)
				{
				//$data['ipd_page'] = "ward";
                $data['listbedstatus'] = $this->dashboard_info->get_list_bed($floor_id,$ward);	
				//$data['listbedstatus'] = $this->patientreport_model->get_list_bed($floor_id,$ward);
				}
				else
				{
				//$data['ipd_page'] = "floor";
                $data['listbedstatus'] = $this->patientreport_model->get_list_bed($floor_id);
				//$data['listbedstatus']= $this->patientreport_model->get_list_bed($floor_id);
				}
			}
			$data['title'] = "Hospital Information :: IPD Patient List - ".$this->session->userdata('hospital_name');
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "IPD Patient List";
			$data['content'] = 'moduls/patreport/ipd_dashboard'; 
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
	
	function get_floor_ipd_patient_data($floor_id=NULL) //  return json data
	{
	if($this->session->userdata('db_name'))
		{
		ob_start('ob_gzhandler');
		$data['ipddata']= $this->patientreport_model->get_list_bed($floor_id);
		//$data['expdata']= $this->inventory_report_model->get_all_expire($startdate,$enddate);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		//$this->load->view('moduls/patreport/ipd_patient_json',$data);
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

	function get_ward_ipd_patient_data($floor_id=NULL,$ward_id=NULL) //  return json data
	{
	if($this->session->userdata('db_name'))
		{
		ob_start('ob_gzhandler');
		$data['ipddata']= $this->patientreport_model->get_list_bed($floor_id,$ward);
		//$data['expdata']= $this->inventory_report_model->get_all_expire($startdate,$enddate);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		//$this->load->view('moduls/patreport/ipd_patient_json',$data);
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
	
	//Get Report Of Daily Data Sheet Patient Report By Filter
	function patient_data_sheet_report_filter()
	{
			$keyword = $this->input->post('startdate');
			//$keyword = $this->input->post('repmoyr');
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Generate Daily Patient Data Sheet Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($keyword)
			{$data['patient_sheet_data'] = $this->patientreport_model->get_patient_data_sheet($datestart,$dateend);}
			else
			{$data['patient_sheet_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "patient_report/patient_data_sheet_report";
			$data['content_title'] = "Generate Daily Patient Data Sheet Report";
			//$data['button_action']='patient_report/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/patreport/patient_report_filter'; 
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
	
	function patient_data_sheet_report() 
	{		
		if($this->session->userdata('db_name') && $this->input->post('startdate'))
		{	
			$datestart = $this->input->post('startdate');
			$dateend = $this->input->post('enddate');

            //$payer_id = $this->session->userdata('payer_id');
			$data['title'] = "Generate Daily Patient Discharge Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            $data['startdate'] = $datestart;
			$data['enddate'] = $dateend;

			$data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			
			$data['patient_sheet_data'] = $this->patientreport_model->get_patient_data_sheet($datestart,$dateend);           
            
            $data['form_request'] = "patient_report/patient_dicharge_report";
			$data['content_title'] = "Generate Daily Patient Discharge Report";
			//$data['button_action']='patient_discharge/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/patreport/patient_data_sheet';
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

	// Get Daily List Employee MCU Report by filter
	function daily_employee_clinic_filter()
	{
			if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Generate Daily Employee MCU Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			
			//$data['employee_mcu_report'] = $this->patientreport_model->get_employee_mcu($payer_id,$datestart,$dateend);

			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "patient_report/employee_clinic_report";
			$data['content_title'] = "Generate Daily Clinic Employees Report";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/patreport/patient_report_filter'; 
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

	function employee_clinic_report() 
	{		
		if($this->session->userdata('db_name') && $this->input->post('startdate'))
		{	
			$datestart = $this->input->post('startdate');
			$dateend = $this->input->post('enddate');

            $payer_id = $this->session->userdata('payer_id');
			$data['title'] = "Generate Daily Clinic Employees Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
            $data['startdate'] = $datestart;
			$data['enddate'] = $dateend;

			$data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
			$data['page'] ='datatable';
			$data['style'] = 'portal.css'; 
			
			$data['clinic_employee_report'] = $this->patientreport_model->get_employee_clinic($payer_id,$datestart,$dateend);
			//$data['employee_mcu_data'] = $this->patientreport_model->get_employee_mcu($payer_id,$datestart,$dateend);
            
            $data['form_request'] = "patient_report/employee_clinic_report";
			$data['content_title'] = "Generate Daily Employee MCU Report";
			//$data['button_action']='patient_discharge/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/patreport/clinic_employee_report';
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

	function get_clinic_employee_data($payer_id=NULL,$startdate,$enddate) //  return json data
	{
	if($this->session->userdata('db_name'))
		{
		ob_start('ob_gzhandler');
		$data['employee_clinic_data']= $this->patientreport_model->get_employee_clinic($payer_id,$startdate,$enddate);
		//$data['expdata']= $this->inventory_report_model->get_all_expire($startdate,$enddate);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		//$this->load->view('moduls/patreport/ipd_patient_json',$data);
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

   	function nutrition_dashboard()
	{
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = " Daily Nutrition Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['deposit_list'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			//$data['button_action'] = "cashier_report/get_details/";
			//$data['form_request'] = "cashier_report/get_details";			
			$data['content_title'] = "Daily Nutrition Report";
			$data['detail_title']='Daily Nutrition Report'.'<br />'.$this->session->userdata('hospital_name');
		
			$data['nutrition_list'] = $this->patientreport_model->get_list_bed();
			//$data['depositdata'] = $this->cashier_report_model->get_deposit_detail_list($regid);
			//$data['depositdetail'] = $this->cashier_report_model->get_deposit_detail($regid);
			//ob_start('ob_gzhandler');
			//$datalist['aaData']=$this->cashier_report_model->get_deposit_report();
			//echo json_encode($datalist,JSON_UNESCAPED_UNICODE);
			
			//$data['button_action']='medicine_consume/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/patreport/nutrition_dashboard'; 
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


}