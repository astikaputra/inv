<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_report extends CI_Controller {
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('bill_model');
			  $this->load->helper('array');
    }
	
	function index()
	{
	
			if($this->session->userdata('db_name'))
		{	
			$data['sub_modul'] = $this->sys_model->get_submodul('15');
			$data['title'] = "Generate Bill Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['page']='menu';
			$data['style'] = 'portal.css';
			$data['content_title'] = "Generate Patient Report";
			$data['limit_database'] = ini_set('max_execution_time', 0);
			$data['content'] = 'moduls/billreport/bill_home'; 
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
	function lob_bill_report_filter()
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
			$data['button_action']='bill_controllers/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/closed_registration'; 
			$this->load->view('system',$data);
	}
	
	//Get List Patient 
	function lob_bill_report()
	{
			$keyword = $this->input->post('keyword');
			$data['title'] = "Bill Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			if($keyword)
			{$data['bill_data'] = $this->bill_model->get_bill($keyword);}
			else
			{$data['items_data'] = NULL;}
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['content_title'] = "Manage Patient Registration Status";
			$data['button_action']='bill_controllers/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'data/closed_registration'; 
			$this->load->view('system',$data);
	}
	
    //Get Report Of Patient Discharge Report By Filter
    function get_bill_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');

      //  $data['los_list'] = $this->finance_model->get_los();

        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily Bill Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['revenue_data'] = null;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "bill_report/bill_report_dashboard";
            $data['content_title'] = "Generate Daily Bill Report";
            //$data['button_action']='finance_report/lookup/';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));

            if ($this->agent->is_browser()) {
                $agent = $this->agent->browser() . ' ' . $this->agent->version();
            } elseif ($this->agent->is_mobile()) {
                $agent = $this->agent->mobile();
            } else {
                $agent = 'Unidentified User Agent';
            }

            $browser = $this->agent->browser();
            $browser_version = $this->agent->version();
            $os = $this->agent->platform();

            //$zone (frontend / admin / members)
            $modul = $this->uri->segment(1); //modules
            $function = $this->uri->segment(2); //modules/functions
            //$item = $this->uri->segment(3); //modules/functions/34
            $session = $this->session->userdata('session_id');
            $ip = $this->session->userdata('ip_address');
            $uid = $this->sys_model->get_data_user($this->session->userdata('user'))->
                user_id; //if user is logged in
            $uname = $this->sys_model->get_data_user($this->session->userdata('user'))->
                real_name; //if user is logged in
            $user_agent = $this->session->userdata('user_agent');

            $logs_stat = array(
                'modul_name' => $modul,
                'sub_modul_name' => $function,
                'session_id' => $session,
                'ip_add' => $ip,
                'user_id' => $uid,
                'username' => $uname,
                'user_agent' => $user_agent,
                'browser_name' => $browser,
                'browser_version' => $browser_version,
                'os_version' => $os,
                'agent' => $agent);
            $this->sys_model->log_stat($logs_stat);

            $data['content'] = 'moduls/billreport/bill_report_filter';
            $this->load->view('system', $data);
        } else {
            if ($this->session->userdata('username')) {
                redirect('core/select_database', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }

    }

    function bill_report_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            $billpage = $this->input->post('transaction_type');

            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
			$data['limit_database'] = ini_set('max_execution_time', 0);
            $data['transaction_type'] = $billpage;

            if ($billpage == "outstanding_report") {
                $data['billing_page'] = "revenue_all";
                $data['content_title'] = 'Generate Outstanding Bill Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
                $data['outstanding_data'] = $this->bill_model->get_outstanding_bill($datestart, $dateend);
            } elseif ($billpage == "deposit_report") {
                $data['billing_page'] = "revenue_lob";
                $data['content_title'] = 'Generate Deposit Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
                $data['deposit_data'] = $this->bill_model->get_deposit_bill($datestart, $dateend);
            } elseif ($billpage == "refund_deposit_report") {
                $data['billing_page'] = "revenue_los";
                $data['content_title'] = 'Generate Refund Deposit Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
                $data['refund_deposit_data'] = $this->bill_model->get_refund_deposit($datestart, $dateend);
            } else {
              
            }

            $data['title'] = "Generate Daily Bill Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] = 'Generate Daily Bill Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
            $data['button_action'] = base_url() . 'bill_report/get_bill_filter/';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['content'] = 'moduls/billreport/bill_report';
            $this->load->view('system', $data);
            unset($data);
			
			
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }

    }


    function bill_report_dashboard_copy()
    {
        if ($this->session->userdata('db_name')) {
            $startdate = '';
            $enddate = '';
            $daterange = $this->input->post('optionsRadiosDaterange');
			$trans_type = $this->input->post('transaction_type');

            if ($daterange == 'today') {
                $startdate = date('Y-m-d', now());
                $enddate = date("Y-m-d", now());
            } else {
                $startdate = $this->input->post('startdate');
                $enddate = $this->input->post('enddate');
            }
            $data['startdate'] = $startdate;
            $data['enddate'] = $enddate;

			if($transaction_type == 'outstanding_report')
			{
				$data['outstanding_list'] = $this->bill_model->get_outstanding_bill($startdate, $enddate);
                //$data['datasource'] = base_url() . 'bill_report/get_outstanding_report_data/' . $startdate .
                    '/' . $enddate;
				$this->load->view('moduls/billreport/datacontainer/outstanding_dashboard', $data);
            } 
			elseif ($trans_type == 'deposit_report')
			{
            	$data['deposit_list'] = $this->bill_model->get_deposit_bill($startdate, $enddate);
				//$data['datasource'] = base_url() . 'bill_report/get_deposit_report_data/' . $startdate .
                    '/' . $enddate;
				$this->load->view('moduls/billreport/datacontainer/deposit_dashboard', $data);
            } 
            elseif ($trans_type == 'refund_deposit_report')
			{
            	$data['refund_deposit_list'] = $this->bill_model->get_refund_deposit($startdate, $enddate);
				//$data['datasource'] = base_url() . 'bill_report/get_refund_deposit_report_data/' . $startdate .
                    '/' . $enddate;
				$this->load->view('moduls/billreport/datacontainer/refund_deposit_dashboard', $data);
            } 
			else 
			{
                echo 'Report For Hospital Finance Report Not Yet Developed';
            }

            $data['title'] = "Generate Daily Bill Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            $data['form_request'] = "bill_report/bill_report_dashboard";
            $data['content_title'] = 'Generate Daily Bill Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['content'] = 'moduls/billreport/datacontainer/bill_report_dashboard';
            $this->load->view('system', $data);
            unset($data);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }
    }

    function get_outstanding_report_data($startdate, $enddate)
    {
        if ($this->session->userdata('db_name')) {
            ob_start('ob_gzhandler');
            $data['aaData'] = $this->bill_model->get_outstanding_bill($startdate, $enddate);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }
        }
    }

    function get_deposit_report_data($startdate, $enddate)
    {
        if ($this->session->userdata('db_name')) {
            ob_start('ob_gzhandler');
            $data['aaData'] = $this->bill_model->get_deposit_bill($startdate, $enddate);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }
        }
    }

    function get_refund_deposit_report_data($startdate, $enddate)
    {
        if ($this->session->userdata('db_name')) {
            ob_start('ob_gzhandler');
            $data['aaData'] = $this->bill_model->get_refund_deposit($startdate, $enddate);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }
        }
    }

}	