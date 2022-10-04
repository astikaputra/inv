<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finance_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('finance_model');
        $this->load->model('sys_model');
        $this->load->helper('array');
		//$this->load->library('msdb');
		
    }

    function index()
    {

        if ($this->session->userdata('db_name')) {
            //$data['sub_modul'] = $this->sys_model->get_submodul('15');
            $data['title'] = "Generate Finance Report -> Medicos Support Tools :: " . $this->
                config->item('company_name') . " ";
            $data['page'] = 'menu';
            $data['style'] = 'portal.css';
            $data['content_title'] = "Generate Finance Report";
            $data['content'] = 'moduls/finreport/finance_home';
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
    function revenue_report_filter()
    {

        $data['los_list'] = $this->finance_model->get_los();
        $hospital_id = $this->session->userdata('hospital_id');

        $sesdata = array(
        'startdate' => $this->input->post('startdate'),
        'enddate' => $this->input->post('enddate'),
        'lob' => $this->input->post('lob'),
        'los' => $this->input->post('los'),
        'email' => $this->input->post('email'));

        $this->session->set_userdata($sesdata);

        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily Revenue Details Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['revenue_data'] = null;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['hospital_id'] = $hospital_id;
            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] = "Generate Daily Revenue Details Report";
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

            $data['content'] = 'moduls/finreport/finance_revenue_filter';
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

    function revenue_dashboard_copy()
    {
        if ($this->session->userdata('db_name') && ($this->input->post('lob') != '')) {
            $startdate = '';
            $enddate = '';
            $daterange = $this->input->post('optionsRadiosDaterange');
            $revlobpage = $this->input->post('lob');
            $revlospage = $this->input->post('los');

            if ($daterange == 'today') {
                $startdate = date('Y-m-d', now());
                $enddate = date("Y-m-d", now());
            } else {
                $startdate = $this->input->post('startdate');
                $enddate = $this->input->post('enddate');
            }
            $data['startdate'] = $startdate;
            $data['enddate'] = $enddate;
            $data['lob'] = $revlobpage;
            $data['los'] = $revlospage;

            if ($revlobpage == "All" && $revlospage == "All") {
                $data['finance_page'] = "revenue_all";
                $data['datasource'] = base_url() . 'finance_report/get_rev_sum_data/' . $startdate .
                    '/' . $enddate;
            } elseif ($revlobpage != "All" && $revlospage == "All") {
                $data['finance_page'] = "revenue_lob";
                $data['datasource'] = base_url() . 'finance_report/get_rev_spec_lob_data/' . $startdate .
                    '/' . $enddate . '/' . $revlobpage;
            } elseif ($revlobpage == "All" && $revlospage != "All") {
                $data['finance_page'] = "revenue_los";
                $data['datasource'] = base_url() . 'finance_report/get_rev_spec_los_data/' . $startdate .
                    '/' . $enddate . '/' . $revlospage;
            } elseif ($revlobpage != "All" && $revlospage != "All") {
                $data['finance_page'] = "revenue_spes";
                $data['datasource'] = base_url() . 'finance_report/get_rev_spec_data/' . $startdate .
                    '/' . $enddate . '/' . $revlobpage . '/' . $revlospage;
            } else {
                echo 'Report For Hospital Finance Report Not Yet Developed';
            }

            $this->load->view('moduls/finreport/revenue_sum_report', $data);

        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }
    }

    function get_rev_sum_data($startdate, $enddate)
    {
        if ($this->session->userdata('db_name')) {
            ob_start('ob_gzhandler');
            $data['aaData'] = $this->finance_model->get_revenue($datestart, $dateend);
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

    function get_rev_spec_lob_data($startdate, $enddate, $revlobpage)
    {
        if ($this->session->userdata('db_name')) {
            ob_start('ob_gzhandler');
            $data['aaData'] = $this->finance_model->get_spec_lob_revenue($startdate, $enddate,
                $revlobpage);
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

    function get_rev_spec_los_data($startdate, $enddate, $revlospage)
    {
        if ($this->session->userdata('db_name')) {
            ob_start('ob_gzhandler');
            $data['aaData'] = $this->finance_model->get_spec_los_revenue($startdate, $enddate,
                $revlospage);
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

    function get_rev_spec_data($startdate, $enddate, $revlobpage, $revlospage)
    {
        if ($this->session->userdata('db_name')) {
            ob_start('ob_gzhandler');
            $data['aaData'] = $this->finance_model->get_spec_revenue($startdate, $enddate, $revlobpage,
                $revlospage);
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

    function revenue_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            $revlobpage = $this->input->post('lob');
            $revlospage = $this->input->post('los');

            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['lob'] = $revlobpage;
            $data['los'] = $revlospage;

            if ($revlobpage == "All" && $revlospage == "All") {
                $data['finance_page'] = "revenue_all";
                $data['revenue_all_data'] = $this->finance_model->get_revenue($datestart, $dateend);
            } elseif ($revlobpage != "All" && $revlospage == "All") {
                $data['finance_page'] = "revenue_lob";
                $data['revenue_lob_data'] = $this->finance_model->get_spec_lob_revenue($datestart,
                    $dateend, $revlobpage);
            } elseif ($revlobpage == "All" && $revlospage != "All") {
                $data['finance_page'] = "revenue_los";
                $data['revenue_los_data'] = $this->finance_model->get_spec_los_revenue($datestart,
                    $dateend, $revlospage);
            } else {
                $data['finance_page'] = "revenue_spes";
                $data['revenue_spes_data'] = $this->finance_model->get_spec_revenue($datestart,
                    $dateend, $revlobpage, $revlospage);
            }

            $data['title'] = "Generate Daily Revenue Details Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] = 'Generate Daily Revenue Details Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['content'] = 'moduls/finreport/finance_report';
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

    //Get Report Of Patient Discharge Report By Filter
    function prodia_revenue_report_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily Prodia Report -> Medicos Support Tools :: " . $this->
                config->item('company_name') . " ";
            if ($datestart) {
                $data['revenue_data'] = $this->finance_model->get_revenue($datestart, $dateend);
            } else {
                $data['revenue_data'] = null;
            }
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/prodia_revenue_dashboard";
            $data['content_title'] = "Generate Daily Prodia Report";
            $data['button_action'] = 'finance_report/lookup/';
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

            $data['content'] = 'moduls/finreport/finance_report_filter';
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

    function prodia_revenue_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
            $data['title'] = "Generate Daily Prodia Report -> Medicos Support Tools :: " . $this->
                config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';

            $data['finance_page'] = "revenue_prodia";
            $data['prodia_revenue_data'] = $this->finance_model->get_prodia_revenue($datestart,
                $dateend);
            //$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
            //$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);

            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] = 'Generate Daily Prodia Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/finreport/finance_report';
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

    //Get Report Of Patient Discharge Report By Filter
    function material_cost_report_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Material Cost Drugs Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            if ($datestart) {
                $data['material_cost_data'] = $this->finance_model->get_material_cost_drugs($datestart,
                    $dateend);
            } else {
                $data['material_cost_data'] = null;
            }
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/material_cost_dashboard";
            $data['content_title'] = "Generate Daily Material Cost Drugs Report";
            $data['button_action'] = 'finance_report/lookup/';
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

            $data['content'] = 'moduls/finreport/finance_report_filter';
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

    function material_cost_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
            $data['title'] = "Generate Daily Material Cost Drugs Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';

            $data['finance_page'] = "material_cost_drugs";
            $data['material_cost_data'] = $this->finance_model->get_material_cost_drugs($datestart,
                $dateend);
            //$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
            //$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);

            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] = 'Generate Daily Material Cost Drugs Report Between ' .
                date('d-m-Y', strtotime($data['startdate'])) . ' Until ' . date('d-m-Y',
                strtotime($data['enddate'])) . '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/finreport/finance_report';
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

    //Get Report Of Patient Discharge Report By Filter
    function medical_cost_report_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Material Cost Medical Supplies Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            if ($datestart) {
                $data['medical_cost_data'] = $this->finance_model->get_medical_cost_drugs($datestart,
                    $dateend);
            } else {
                $data['medical_cost_data'] = null;
            }
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/medical_cost_dashboard";
            $data['content_title'] = "Generate Daily Material Cost Medical Supplies Report";
            $data['button_action'] = 'finance_report/lookup/';
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

            $data['content'] = 'moduls/finreport/finance_report_filter';
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

    function medical_cost_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
            $data['title'] = "Generate Daily Material Cost Medical Supplies Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';

            $data['finance_page'] = "medical_cost_supplies";
            $data['medical_cost_data'] = $this->finance_model->get_medical_cost_drugs($datestart,
                $dateend);
            //$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
            //$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);

            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] =
                'Generate Daily Material Cost Medical Supplies Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/finreport/finance_report';
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

    //Get Report Of Patient Discharge Report By Filter
    function non_chargeable_report_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily Non Chargeable Item Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            if ($datestart) {
                $data['non_chargeable_data'] = $this->finance_model->get_non_chargeable_items($datestart,
                    $dateend);
            } else {
                $data['non_chargeable_data'] = null;
            }
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/non_chargeable_dashboard";
            $data['content_title'] = "Generate Daily Non Chargeable Item Report";
            $data['button_action'] = 'finance_report/lookup/';
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

            $data['content'] = 'moduls/finreport/finance_report_filter';
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

    function non_chargeable_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
            $data['title'] = "Generate Daily Non Chargeable Item Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';

            $data['finance_page'] = "non_chargeable_items";
            $data['non_chargeable_data'] = $this->finance_model->get_non_chargeable_items($datestart,
                $dateend);
            //$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
            //$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);

            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] = 'Generate Daily Non Chargeable Item Report Between ' .
                date('d-m-Y', strtotime($data['startdate'])) . ' Until ' . date('d-m-Y',
                strtotime($data['enddate'])) . '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/finreport/finance_report';
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

    function doctor_fee_report_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily Doctor Fee Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            if ($datestart) {
                $data['doctor_fee_data'] = $this->finance_model->get_doctor_fee($datestart, $dateend);
            } else {
                $data['doctor_fee_data'] = null;
            }
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/doctor_fee_dashboard";
            $data['content_title'] = "Generate Daily Doctor Fee Report";
            $data['button_action'] = 'finance_report/lookup/';
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

            $data['content'] = 'moduls/finreport/finance_report_filter';
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

    function doctor_fee_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
            $data['title'] = "Generate Daily Doctor Fee Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';

            $data['finance_page'] = "doctor_fee";
            $data['doctor_fee_data'] = $this->finance_model->get_doctor_fee($datestart, $dateend);
            //$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
            //$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);

            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] = 'Generate Daily Doctor Fee Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/finreport/finance_report';
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

    function revenue_summary_report_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily Revenue Summary Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            if ($datestart) {
                $data['doctor_fee_data'] = $this->finance_model->get_revenue_summary($datestart,
                    $dateend);
            } else {
                $data['doctor_fee_data'] = null;
            }
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/revenue_summary_dashboard";
            $data['content_title'] = "Generate Daily Revenue Summary Report";
            $data['button_action'] = 'finance_report/lookup/';
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

            $data['content'] = 'moduls/finreport/finance_report_filter';
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

    function revenue_summary_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
            $data['title'] = "Generate Daily Revenue Summary Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';

            $data['finance_page'] = "revenue_summary";
            $data['revenue_summary_data'] = $this->finance_model->get_revenue_summary($datestart,
                $dateend);
            //$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
            //$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);

            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] = 'Generate Daily Revenue Summary Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/finreport/finance_report';
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

    function room_classify_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily Room Classify Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            if ($datestart) {
                $data['room_clasify_data'] = $this->finance_model->get_clasify_of_room($datestart,
                    $dateend);
            } else {
                $data['room_clasify_data'] = null;
            }
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/room_clasify_dashboard";
            $data['content_title'] = "Generate Daily Room Classify Report";
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

            $data['content'] = 'moduls/finreport/finance_report_filter';
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

    function room_clasify_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
            $data['title'] = "Generate Daily Room Classify Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';

            $data['room_clasify_data'] = $this->finance_model->get_clasify_of_room($datestart,
                $dateend);
            //$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
            //$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);

            $data['finance_page'] = "room_clasify";
            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] = 'Generate Daily Room Classify Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/finreport/finance_report';
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

    function special_equipment_use_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily Equipment Use Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            if ($datestart) {
                $data['special_eq_data'] = $this->finance_model->get_special_equipment_use($datestart,
                    $dateend);
            } else {
                $data['special_eq_data'] = null;
            }
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/special_equipment_use_dashboard";
            $data['content_title'] = "Generate Daily Equipment Use Report";
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

            $data['content'] = 'moduls/finreport/finance_report_filter';
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

    function special_equipment_use_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
            $data['title'] = "Generate Daily Equipment Use Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';

            $data['special_eq_data'] = $this->finance_model->get_special_equipment_use($datestart,
                $dateend);
            //$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
            //$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);

            $data['finance_page'] = "equipment_use";
            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] = 'Generate Daily Equipment Use Report Between ' . date('d-m-Y',
                strtotime($data['startdate'])) . ' Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/finreport/finance_report';
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

    function doctor_craft_group_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily Doctor Craft Group Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            if ($datestart) {
                $data['doctor_craft_data'] = $this->finance_model->get_doctor_craft_group($datestart,
                    $dateend);
            } else {
                $data['doctor_craft_data'] = null;
            }
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/special_equipment_use_dashboard";
            $data['content_title'] = "Generate Daily Doctor Craft Group Report";
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

            $data['content'] = 'moduls/finreport/finance_report_filter';
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

    function doctor_craft_group_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
            $data['title'] = "Generate Daily Doctor Craft Group Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';

            $data['doctor_craft_data'] = $this->finance_model->get_doctor_craft_group($datestart,
                $dateend);
            //$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
            //$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);

            $data['finance_page'] = "doctor_craft_group";
            $data['form_request'] = "finance_report/revenue_dashboard";
            $data['content_title'] = 'Generate Daily Doctor Craft Group Report Between ' .
                date('d-m-Y', strtotime($data['startdate'])) . ' Until ' . date('d-m-Y',
                strtotime($data['enddate'])) . '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/finreport/finance_report';
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
    
    function revenue_troughput_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
		$enddateday = $this->input->post('enddate');
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily Revenue & Troughput By Source Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            if ($datestart) {
                $data['revenue_resource_data'] = $this->finance_model->get_revenue_troughput_source($datestart,
                    $dateend,$enddateday);
            } else {
                $data['revenue_resource_data'] = null;
            }
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/revenue_troughput_dashboard";
            $data['content_title'] = "Generate Daily Revenue & Troughput By Source Report";
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

            $data['content'] = 'moduls/finreport/finance_report_filter';
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

    function revenue_troughput_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
			$enddateday = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
            $data['title'] = "Generate Daily Daily Revenue & Troughput By Source Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';

            $data['revenue_resource_data'] = $this->finance_model->get_revenue_troughput_source($datestart,
                $dateend,$enddateday);
            //$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
            //$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);

            $data['finance_page'] = "revenue_resource";
            $data['form_request'] = "finance_report/revenue_troughput_dashboard";
            $data['content_title'] = 'Generate Daily Daily Revenue & Troughput By Source Report Between ' .
                date('d-m-Y', strtotime($data['startdate'])) . ' Until ' . date('d-m-Y',
                strtotime($data['enddate'])) . '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/finreport/finance_report';
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
	
	function classify_patient_rev_filter()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
		$enddateday = $this->input->post('enddate');
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily Classify Patient Revenue Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            if ($datestart) {
                $data['clasify_patient_rev_data'] = $this->finance_model->get_classify_patient_rev($datestart,
                    $dateend,$enddateday);
            } else {
                $data['clasify_patient_rev_data'] = null;
            }
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/classify_patient_rev_dashboard";
            $data['content_title'] = "Generate Daily Classify Patient Revenue Report";
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

            $data['content'] = 'moduls/finreport/finance_report_filter';
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

    function classify_patient_rev_dashboard()
    {
        if ($this->session->userdata('db_name') && $this->input->post('startdate')) {
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
			$enddateday = $this->input->post('enddate');
            //$payer_id = $this->session->userdata('payer_id');
            $data['title'] = "Generate Daily Daily Classify Patient Revenue Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['hospital_name'] = $this->sys_model->get_hospital_name($this->session->
                userdata('hospital_id'))->real_hospital_name;
            //$data['items_data'] = NULL;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';

            $data['clasify_patient_rev_data'] = $this->finance_model->get_classify_patient_rev($datestart,
                $dateend,$enddateday);
            //$data['medicine_data_retail'] = $this->item_model->get_medicine_consumption_retail($datestart,$dateend);
            //$data['medicine_data_etc'] = $this->item_model->get_medicine_consumsion($datestart,$dateend);

            $data['finance_page'] = "classify_patient_revenue";
            $data['form_request'] = "finance_report/revenue_troughput_dashboard";
            $data['content_title'] = 'Generate Daily Classify Patient Revenue Report Between ' .
                date('d-m-Y', strtotime($data['startdate'])) . ' Until ' . date('d-m-Y',
                strtotime($data['enddate'])) . '';
            $data['button_action'] = 'tools';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/finreport/finance_report';
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
	
	function get_daily_glposting()
    {
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
		//$exec_proc = $this->finance_model->get_glposting();
		
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Generate Daily GL Posting Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            //$data['glposting_data'] = $this->finance_model->get_glposting();
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/glposting_result";
			$data['content_confirm_title'] = 'Comfirmation Execute On' .
            $data['content_title'] = "Execute Daily GL Posting";
			$data['text_confirm'] = "Are you sure execute this procedure ?";
            $data['button_action'] = $this->finance_model->get_glposting($datestart,
                $dateend);
			//$data['action_result'] = $this->finance_model->get_glposting_result();
            //$data['button_action'] = $this->db->query("EXEC sp_glposting()");
			//$data['button_action'] = $this->msdb->output('sp_glposting', array(), 'EXECUTE');
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
			
			
			$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '66',
				   'requested_by' => 'Excute procedure for axapta posting between  '.$datestart.' and '.$dateend 
					);
			$this->sys_model->logging($logs);
					
            $data['content'] = 'moduls/finreport/glposting_exec';
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
	
	function glposting_result()
	{
     if ($this->session->userdata('db_name') && $this->input->post('startdate')) 
		{
        $datestart = $this->input->post('startdate');
        $dateend = $this->input->post('enddate');
		//$exec_proc = $this->finance_model->get_glposting();
		
            $data['title'] = "Generate Daily GL Posting Report -> Medicos Support Tools :: " .
                $this->config->item('company_name') . " ";
            $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            //$data['glposting_data'] = $this->finance_model->get_glposting();
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "finance_report/glposting_result";
			$data['content_confirm_title'] = 'Comfirmation Execute On' .
            $data['content_title'] = "Execute Daily GL Posting";
			$data['text_confirm'] = "Are you sure execute this procedure ?";
            $data['button_action'] = $this->finance_model->get_glposting($datestart,
                $dateend);
			//$data['action_result'] = $this->finance_model->get_glposting_result();
            //$data['button_action'] = $this->db->query("EXEC sp_glposting()");
			//$data['button_action'] = $this->msdb->output('sp_glposting', array(), 'EXECUTE');
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			
			
			$logs = array(
                   'user_id'  => $this->sys_model->get_data_user($this->session->userdata('user'))->user_id,
				   'modul_id'  => '66',
				   'requested_by' => 'Excute procedure for axapta posting between  '.$datestart.' and '.$dateend 
					);
			$this->sys_model->logging($logs);
					
            $data['content'] = 'moduls/finreport/glposting_exec';
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
	
}
