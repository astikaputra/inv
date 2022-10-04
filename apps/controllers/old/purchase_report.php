<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_model');
        $this->load->model('sys_model');
        $this->load->helper('array');
    }

    function index()
    {

        if ($this->session->userdata('db_name')) {
            //$data['sub_modul'] = $this->sys_model->get_submodul('15');
            $data['title'] = "Generate Purchase Report -> Medicos Support Tools :: " . $this->
                config->item('company_name') . " ";
            $data['page'] = 'menu';
            $data['style'] = 'portal.css';
            $data['content_title'] = "Generate Purchase Report";
            $data['content'] = 'moduls/purreport/purchase_home';
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

    //Get Report Of Patient Discharge Report By Filter
    function purchase_report_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');

      //  $data['los_list'] = $this->finance_model->get_los();

        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Monthly Purchase Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['revenue_data'] = null;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "purchase_report/purchase_dashboard";
            $data['content_title'] = "Generate Monthly Purchase Report";
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

            $data['content'] = 'moduls/purreport/purchase_report_dashboard';
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

    function purchase_dashboard()
    {
        if ($this->session->userdata('db_name') && ($this->input->post('transaction_type') != '')) {
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

			if($trans_type == 'purchase_report')
			{
                $data['datasource'] = base_url() . 'purchase_report/get_purchase_report_data/' . $startdate .
                    '/' . $enddate;
				$this->load->view('moduls/purreport/datacontainer/purchase_dashboard', $data);
            } 
			elseif ($trans_type == 'consumption_report')
			{
				$data['datasource'] = base_url() . 'purchase_report/get_consumption_report_data/' . $startdate .
                    '/' . $enddate;
				$this->load->view('moduls/purreport/datacontainer/consumption_dashboard', $data);
            } 
			else 
			{
                echo 'Report For Hospital Finance Report Not Yet Developed';
            }

        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }
    }

    function get_purchase_report_data($startdate, $enddate)
    {
        if ($this->session->userdata('db_name')) {
            ob_start('ob_gzhandler');
            $data['aaData'] = $this->purchase_model->get_purchasing_data($startdate, $enddate);
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

    function get_consumption_report_data($startdate, $enddate)
    {
        if ($this->session->userdata('db_name')) {
            ob_start('ob_gzhandler');
            $data['aaData'] = $this->purchase_model->get_comsumption_data($startdate, $enddate);
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
