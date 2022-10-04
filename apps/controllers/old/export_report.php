<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('MAX_EXECUTION_TIME', -1);

class Export_report extends CI_Controller 
{
	function __construct()
	{
        parent::__construct();
        $this->load->model('alert_model');
        $this->load->model('sys_model');
        $this->load->model('finance_model');
        $this->load->helper('array', 'file');
        $this->load->library("excel");
        $config['protocol'] = 'smtp'; // mail, sendmail, or smtp    The mail sending protocol.
        $config['smtp_host'] = '10.0.0.111'; // SMTP Server Address.
        $config['smtp_user'] = ''; // SMTP Username.
        $config['smtp_pass'] = ''; // SMTP Password.
        $config['smtp_port'] = '25'; // SMTP Port.
        $config['smtp_timeout'] = '60'; // SMTP Timeout (in seconds).
        $config['wordwrap'] = false; // TRUE or FALSE (boolean)    Enable word-wrap.
        $config['wrapchars'] = 76; // Character count to wrap at.
        $config['mailtype'] = 'html'; // text or html Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don't have any relative links or relative image paths otherwise they will not work.
        $config['charset'] = 'utf-8'; // Character set (utf-8, iso-8859-1, etc.).
        $config['validate'] = false; // TRUE or FALSE (boolean)    Whether to validate the email address.
        $config['priority'] = 1; // 1, 2, 3, 4, 5    Email Priority. 1 = highest. 5 = lowest. 3 = normal.
        $config['crlf'] = "\r\n"; // "\r\n" or "\n" or "\r" Newline character. (Use "\r\n" to comply with RFC 822).
        $config['newline'] = "\r\n"; // "\r\n" or "\n" or "\r"    Newline character. (Use "\r\n" to comply with RFC 822).
        $config['bcc_batch_mode'] = false; // TRUE or FALSE (boolean)    Enable BCC Batch Mode.
        $config['bcc_batch_size'] = 200; // Number of emails in each BCC batch.
        $this->load->library('email');
        $this->email->initialize($config);
	}

	function index()
	{
         $this->load->view('component/autoclose');
	}

	function send_excel_link_report($hospital_id,$startdate,$enddate)
	{
		date_default_timezone_set('Asia/Jakarta');

        $datestart = $startdate;
        $dateend = $enddate;
        $revlobpage = $this->input->post('lob');
        $revlospage = $this->input->post('los');
        $emaildes = $this->input->post('email');
        $hospital_id = $hospital_id;   

		if ($hospital_id != null) 
		{
			$sent_to = $this->sys_model->get_email_for_alert('send_excel_link_report', $hospital_id);
			//$sent_to = $this->sys_model->get_email_for_alert('stock_alert', $hospital_id);
            //$db_id = $sent_to->connection_id;
            
            //$sesdata = array(
            //   'hospital_id' => $this->sys_model->get_auth_db($db_id)->hospital_id,
            //    'db_host' => $this->sys_model->get_auth_db($db_id)->ip_address,
            //    'db_user' => $this->sys_model->get_auth_db($db_id)->username,
            //    'db_password' => $this->sys_model->get_auth_db($db_id)->password,
            //    'payer_id' => $this->sys_model->get_hospital_name($this->sys_model->get_auth_db
            //        ($db_id)->hospital_id)->employee_payer_id,
            //    'hospital_name' => $this->sys_model->get_hospital_name($this->sys_model->
            //        get_auth_db($db_id)->hospital_id)->real_hospital_name,
            //    'db_name' => $this->sys_model->get_auth_db($db_id)->database_name);

			//$this->session->set_userdata($sesdata);
            //$path = "assets/export/report/finance";
            //$attachment_path = "$path/revenue_finance_report_" . $hospital_id . "_" . $datestart .
            //"_" . $dateend . ".xls";

            if ($revlobpage == "All" && $revlospage == "All") {
            //$data = $this->finance_model->get_revenue($datestart, $dateend);
            //$this->excel->stream('revenue_finance_report_' . $hospital_id . '_' . $datestart .
            //'_' . $dateend . '.xls', $data);
            $path = "assets/uploads/document";
            $attachment_path = "$path/revenue_finance_report_" . $hospital_id . "_" . $datestart .
            "_" . $dateend . ".xls";
            $download_link = base_url() . $attachment_path;

            $path_link = $this->_get_finance_report_file_url($hospital_id, $datestart, $dateend, $revlobpage, $revlospage);

            $this->email->from('medicos.alert@siloamhospitals.com', 'Medicos Centric Monthly Revenue Detail Report System');
            $this->email->reply_to('arief.luqman@simedika.com','Helpdesk Medicos');
            $this->email->to($emaildes);
            //$this->email->cc($sent_to->cc_to);
            $this->email->subject("MedicOS Centric Monthly Revenue Detail Report $hospital_id between ");
            $this->email->message("This email is contain the information about Finance Revenue Detail Report Of " .$this->session->userdata('hospital_name').
                                  "<br /> you can can get the file at '".$download_link."'");

            set_time_limit(0);
            ini_set('memory_limit','-1');
            }
            elseif ($revlobpage != "All" && $revlospage == "All") {
            // $data = $this->finance_model->get_spec_lob_revenue($datestart, $dateend, $revlobpage);
            // $this->excel->stream('revenue_finance_report_' . $hospital_id . '_' . $datestart .
            //'_' . $dateend . '_' . $revlobpage . '.xls', $data);
            $path = "assets/uploads/document";
            $attachment_path = "$path/revenue_finance_report_" . $hospital_id . "_" . $datestart .
            "_" . $dateend . "_" . $revlobpage . ".xls";
            $download_link = base_url() . $attachment_path;

            $path_link = $this->_get_finance_report_file_url($hospital_id, $datestart, $dateend, $revlobpage, $revlospage);

            $this->email->from('medicos.alert@siloamhospitals.com', 'Medicos Centric Monthly Revenue Detail Report System');
            $this->email->reply_to('arief.luqman@simedika.com','Helpdesk Medicos');
            $this->email->to($emaildes);
            //$this->email->cc($sent_to->cc_to);
            $this->email->subject("MedicOS Centric Monthly Revenue Detail Report $hospital_id between ");
            $this->email->message("This email is contain the information about Finance Revenue Detail Report Of " .$this->session->userdata('hospital_name').
                                  "<br /> you can can get the file at '".$download_link."'");

            set_time_limit(0);
            ini_set('memory_limit','-1');
            }
            elseif ($revlobpage == "All" && $revlospage != "All") {
            //$data = $this->finance_model->get_spec_los_revenue($datestart, $dateend, $revlospage);
            //$this->excel->stream('revenue_finance_report_' . $hospital_id . '_' . $datestart .
            //'_' . $dateend . '_' . $revlospage . '.xls', $data);
            $path = "assets/uploads/document";
            $attachment_path = "$path/revenue_finance_report_" . $hospital_id . "_" . $datestart .
            "_" . $dateend . "_" . $revlospage . ".xls";
            $download_link = base_url() . $attachment_path;

            $path_link = $this->_get_finance_report_file_url($hospital_id, $datestart, $dateend, $revlobpage, $revlospage);

            $this->email->from('medicos.alert@siloamhospitals.com', 'Medicos Centric Monthly Revenue Detail Report System');
            $this->email->reply_to('arief.luqman@simedika.com','Helpdesk Medicos');
            $this->email->to($emaildes);
            //$this->email->cc($sent_to->cc_to);
            $this->email->subject("MedicOS Centric Monthly Revenue Detail Report $hospital_id between ");
            $this->email->message("This email is contain the information about Finance Revenue Detail Report Of " .$this->session->userdata('hospital_name').
                                  "<br /> you can can get the file at '".$download_link."'");

            set_time_limit(0);
            ini_set('memory_limit','-1'); 
            }
            else {
            //$data = $this->finance_model->get_spec_revenue($datestart, $dateend, $revlobpage, $revlospage);
            //$this->excel->stream('revenue_finance_report_' . $hospital_id . '_' . $datestart .
            //'_' . $dateend .'_' . $revlobpage . '_' . $revlospage . '.xls', $data);
            $path = "assets/uploads/document";
            $attachment_path = "$path/revenue_finance_report_" . $hospital_id . "_" . $datestart .
            "_" . $dateend . "_" . $revlobpage . "_" . $revlospage . ".xls";
            $download_link = base_url() . $attachment_path;

            $path_link = $this->_get_finance_report_file_url($hospital_id, $datestart, $dateend, $revlobpage, $revlospage);

            $this->email->from('medicos.alert@siloamhospitals.com', 'Medicos Centric Monthly Revenue Detail Report System');
            $this->email->reply_to('arief.luqman@simedika.com','Helpdesk Medicos');
            $this->email->to($emaildes);
            //$this->email->cc($sent_to->cc_to);
            $this->email->subject("MedicOS Centric Monthly Revenue Detail Report $hospital_id between ");
            $this->email->message("This email is contain the information about Finance Revenue Detail Report Of " .$this->session->userdata('hospital_name').
                                  "<br /> you can can get the file at '".$download_link."'");

            set_time_limit(0);
            ini_set('memory_limit','-1'); 
            }     

            //$download_link = base_url() . $attachment_path;
            $path_link = $this->_get_finance_report_file_url($hospital_id, $datestart, $dateend, $revlobpage, $revlospage);

            //$this->email->from('medicos.alert@siloamhospitals.com', 'Medicos Centric Monthly Revenue Detail Report System');
            //$this->email->reply_to('arief.luqman@simedika.com','Helpdesk Medicos');
            //$this->email->to($emaildes);
            //$this->email->cc($sent_to->cc_to);
            //$this->email->subject("MedicOS Centric Monthly Revenue Detail Report $hospital_id between ");
            //$this->email->message("This email is contain the information about Finance Revenue Detail Report Of " .$this->session->userdata('hospital_name').
            //                      "<br /> you can can get the file at '".$download_link."'");
			if (!$this->email->send()) {
                    echo 'error! <br />';
                    $logs = array(
                        'user_id' => 'System Alert',
                        'modul_id' => '1',
                        'requested_by' => 'System Alert ' .
                            'Unable Sending Email Monthly Patient Report To ' . $emaildes .
                            ' For Hospital ' . $this->session->userdata('hospital_name'));
                    $this->sys_model->logging($logs);
                    // Generate error
                }
            $logs = array(
                    'user_id' => 'System Alert',
                    'modul_id' => '1',
                    'requested_by' => 'System Alert ' .
                    'SUCCESS Sending Email Monthly Patient Report To ' . $emaildes . 
                    ' For ' . $this->session->userdata('hospital_name'));
            $this->sys_model->logging($logs);
            $this->load->view('component/notify');
        } else {
         	$this->load->view('component/confirm_page');	
        }
	}

    function _get_finance_report_file_url($hospital_id, $startdate, $enddate, $revlobpage, $revlospage)
    {
        $datestart = $startdate;
        $dateend = $enddate;
        $revlobpage = $this->input->post('lob');
        $revlospage = $this->input->post('los');
        $emaildes = $this->input->post('email');
        $hospital_id = $hospital_id;  

        $this->excel->setActiveSheetIndex(0);

        //$data = $this->finance_model->get_revenue_excel($datestart, $dateend)->result();

        if ($revlobpage == "All" && $revlospage == "All") {
            $data = $this->finance_model->get_revenue($datestart, $dateend);
            $this->excel->stream('revenue_finance_report_' . $hospital_id . '_' . $datestart .
            '_' . $dateend . '.xls', $data);
            $path = "assets/uploads/document";
            $attachment_path = "$path/revenue_finance_report_" . $hospital_id . "_" . $datestart .
            "_" . $dateend . ".xls";
            set_time_limit(0);
            ini_set('memory_limit','-1');
        }
        elseif ($revlobpage != "All" && $revlospage == "All") {
           $data = $this->finance_model->get_spec_lob_revenue($datestart, $dateend, $revlobpage);
           $this->excel->stream('revenue_finance_report_' . $hospital_id . '_' . $datestart .
            '_' . $dateend . '_' . $revlobpage . '.xls', $data);
            $path = "assets/uploads/document";
            $attachment_path = "$path/revenue_finance_report_" . $hospital_id . "_" . $datestart .
            "_" . $dateend . "_" . $revlobpage . ".xls";
            set_time_limit(0);
            ini_set('memory_limit','-1');
        }
        elseif ($revlobpage == "All" && $revlospage != "All") {
            $data = $this->finance_model->get_spec_los_revenue($datestart, $dateend, $revlospage);
           $this->excel->stream('revenue_finance_report_' . $hospital_id . '_' . $datestart .
            '_' . $dateend . '_' . $revlospage . '.xls', $data);
            $path = "assets/uploads/document";
            $attachment_path = "$path/revenue_finance_report_" . $hospital_id . "_" . $datestart .
            "_" . $dateend . "_" . $revlospage . ".xls";
            set_time_limit(0);
            ini_set('memory_limit','-1'); 
        }
        else {
            $data = $this->finance_model->get_spec_revenue($datestart, $dateend, $revlobpage, $revlospage);
            $this->excel->stream('revenue_finance_report_' . $hospital_id . '_' . $datestart .
            '_' . $dateend .'_' . $revlobpage . '_' . $revlospage . '.xls', $data);
            $path = "assets/uploads/document";
            $attachment_path = "$path/revenue_finance_report_" . $hospital_id . "_" . $datestart .
            "_" . $dateend . "_" . $revlobpage . "_" . $revlospage . ".xls";
            set_time_limit(0);
            ini_set('memory_limit','-1'); 
        }     

            set_time_limit(0);
            ini_set('memory_limit','-1');
        return $attachment_path;
    }

}

/* End of file export_report.php */
/* Location: ./application/controllers/export_report.php */