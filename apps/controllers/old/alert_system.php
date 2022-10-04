<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alert_system extends CI_Controller {
	 function __construct()
    {
    parent::__construct();
	$this->load->model('alert_model');
	$this->load->model('sys_model');
	$this->load->helper('array','file');
	$this->load->library("excel");
	$config['protocol'] = 'smtp'; // mail, sendmail, or smtp    The mail sending protocol.
    $config['smtp_host'] = '10.0.0.111'; // SMTP Server Address.
    $config['smtp_user'] = ''; // SMTP Username.
    $config['smtp_pass'] = ''; // SMTP Password.
    $config['smtp_port'] = '25'; // SMTP Port.
    $config['smtp_timeout'] = '60'; // SMTP Timeout (in seconds).
    $config['wordwrap'] = FALSE; // TRUE or FALSE (boolean)    Enable word-wrap.
    $config['wrapchars'] = 76; // Character count to wrap at.
    $config['mailtype'] = 'html'; // text or html Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don't have any relative links or relative image paths otherwise they will not work.
    $config['charset'] = 'utf-8'; // Character set (utf-8, iso-8859-1, etc.).
    $config['validate'] = FALSE; // TRUE or FALSE (boolean)    Whether to validate the email address.
    $config['priority'] = 1; // 1, 2, 3, 4, 5    Email Priority. 1 = highest. 5 = lowest. 3 = normal.
    $config['crlf'] = "\r\n"; // "\r\n" or "\n" or "\r" Newline character. (Use "\r\n" to comply with RFC 822).
    $config['newline'] = "\r\n"; // "\r\n" or "\n" or "\r"    Newline character. (Use "\r\n" to comply with RFC 822).
    $config['bcc_batch_mode'] = FALSE; // TRUE or FALSE (boolean)    Enable BCC Batch Mode.
    $config['bcc_batch_size'] = 200; // Number of emails in each BCC batch.
    $this->load->library('email');
    $this->email->initialize($config);
	}
	
	function index()
	{
    $this->load->view('component/autoclose');
	}
	
	
	function stock_alert($hospital_id = NULL,$item_types = NULL )
	{
	date_default_timezone_set('Asia/Jakarta');
	if($hospital_id != NULL)
	{
	$sent_to = $this->sys_model->get_email_for_alert('stock_alert',$hospital_id);
	$db_id = $sent_to->connection_id;
	//
	$sesdata = array(
				'hospital_id'  => $this->sys_model->get_auth_db($db_id)->hospital_id,
                'db_host'  => $this->sys_model->get_auth_db($db_id)->ip_address,
				'db_user'  => $this->sys_model->get_auth_db($db_id)->username,
				'db_password' => $this->sys_model->get_auth_db($db_id)->password,
				'payer_id' => $this->sys_model->get_hospital_name($this->sys_model->get_auth_db($db_id)->hospital_id)->employee_payer_id,
				'hospital_name' => $this->sys_model->get_hospital_name($this->sys_model->get_auth_db($db_id)->hospital_id)->real_hospital_name,
				'db_name' => $this->sys_model->get_auth_db($db_id)->database_name);
				$this->session->set_userdata($sesdata);
	//
	$attachment_path = $this->_create_stock_alert_file($hospital_id,$item_types);
	$this->email->from('medicos.alert@siloamhospitals.com', 'MedicOS Centric Stock Alert System');
    $this->email->reply_to('tri.ismardiko@simedika.com', 'HelpDesk Simedika');
	$this->email->to($sent_to->mail_to);
	$this->email->cc($sent_to->cc_to); 
	$this->email->subject("MedicOS Centric Stock Alert($item_types) $hospital_id at ".date('d M y H:m:s',time()));
	$this->email->attach($attachment_path);
	$this->email->message("This Attachment contain the information about Item Stock (".$item_types.") At or Under Minimum Level in ".$this->session->userdata('hospital_name').' '.date('d-m-y',time()));
    if ( ! $this->email->send()){
       echo 'error! <br />';
	   $logs = array(
                   'user_id'  => 'System Alert',
				   'modul_id'  => '1',
				   'requested_by' => 'System Alert '.'Unable Sending Email Stock Alert To '.$sent_to->mail_to.' AND '.$sent_to->cc_to.' For Hospital '.$this->session->userdata('hospital_name')
					);
			$this->sys_model->logging($logs);
        // Generate error
    }
	 $logs = array(
                   'user_id'  => 'System Alert',
				   'modul_id'  => '1',
				   'requested_by' => 'System Alert '.'SUCCESS Sending Email Stock Alert To '.$sent_to->mail_to.' AND '.$sent_to->cc_to.' For '.$this->session->userdata('hospital_name')
					);
			$this->sys_model->logging($logs);
			$this->load->view('component/autoclose');
	
	}
	else
	{
	$this->load->view('component/autoclose');	
	}
	
	}
	
	function _create_stock_alert_file($hospital_id=NULL,$item_types=NULL)
	{
	$this->excel->setActiveSheetIndex(0);
    $data = $this->alert_model->get_stock_alert($item_types)->result();
    $this->excel->stream('stock_alert_'.$item_types.'_'.$hospital_id.'.xls',$data);
	$path = "assets/uploads/document";
	$attachment_path = "$path/stock_alert_".$item_types."_".$hospital_id.".xls";
	return $attachment_path;
	}
	
	function monthly_opd_patient_report($hospital_id = NULL)
	{
	date_default_timezone_set('Asia/Jakarta');
	$date = date('d-m-Y');
	if (date('d') != 01)
	{
	$this->load->view('component/autoclose');
	}
	else
	{
	
	$lastmonth = strtotime ( '-1 day' , strtotime ( $date ) ) ;  
	$month=date('m',$lastmonth);
	$year = date('Y',$lastmonth);
	
	if($hospital_id != NULL)
	{
	$sent_to = $this->sys_model->get_email_for_alert('monthly_opd_patient_report',$hospital_id);
	$db_id = $sent_to->connection_id;
	//
	$sesdata = array(
				'hospital_id'  => $this->sys_model->get_auth_db($db_id)->hospital_id,
                'db_host'  => $this->sys_model->get_auth_db($db_id)->ip_address,
				'db_user'  => $this->sys_model->get_auth_db($db_id)->username,
				'db_password' => $this->sys_model->get_auth_db($db_id)->password,
				'payer_id' => $this->sys_model->get_hospital_name($this->sys_model->get_auth_db($db_id)->hospital_id)->employee_payer_id,
				'hospital_name' => $this->sys_model->get_hospital_name($this->sys_model->get_auth_db($db_id)->hospital_id)->real_hospital_name,
				'db_name' => $this->sys_model->get_auth_db($db_id)->database_name);
				$this->session->set_userdata($sesdata);
	//
	$attachment_path = $this->_create_opd_patient_report_file($hospital_id, $month, $year);
	$this->email->from('medicos.alert@siloamhospitals.com', 'MedicOS Centric Patient Report System');
    $this->email->reply_to('arief.luqman@simedika.com', 'HelpDesk Simedika');
	$this->email->to($sent_to->mail_to);
	$this->email->cc($sent_to->cc_to); 
	$this->email->subject("MedicOS Centric Monthly Patient Report $hospital_id at $month of $year ");
	$this->email->attach($attachment_path);
	$this->email->message("This Attachment contain the information about Patient Report in ".$this->session->userdata('hospital_name')." at $month of $year");
    if (!$this->email->send()){
       echo 'error! <br />';
	   $logs = array(
                   'user_id'  => 'System Alert',
				   'modul_id'  => '1',
				   'requested_by' => 'System Alert '.'Unable Sending Email Monthly Patient Report To '.$sent_to->mail_to.' AND '.$sent_to->cc_to.' For Hospital '.$this->session->userdata('hospital_name')
					);
			$this->sys_model->logging($logs);
        // Generate error
    }
	 $logs = array(
                   'user_id'  => 'System Alert',
				   'modul_id'  => '1',
				   'requested_by' => 'System Alert '.'SUCCESS Sending Email Monthly Patient Report To '.$sent_to->mail_to.' AND '.$sent_to->cc_to.' For '.$this->session->userdata('hospital_name')
					);
			$this->sys_model->logging($logs);
			$this->load->view('component/autoclose');
	
	}
	else
	{
	$this->load->view('component/autoclose');	
	}
	
	}
	}
	
	function _create_opd_patient_report_file($hospital_id=NULL, $month, $year)
	{	
	$payer_id = $this->session->userdata('payer_id');
	$this->excel->setActiveSheetIndex(0);
    $data = $this->alert_model->get_monthly_opdpatient($payer_id,$month,$year)->result();
    $this->excel->stream('monthly_opd_patient_report_'.$hospital_id.'_'.$month.'_'.$year.'.xls',$data);
	$path = "assets/uploads/document";
	$attachment_path = "$path/monthly_opd_patient_report_".$hospital_id."_".$month."_".$year.".xls";
	return $attachment_path;
	}
	
	function monthly_ipd_patient_report($hospital_id = NULL)
	{
	date_default_timezone_set('Asia/Jakarta');
	$date = date('d-m-Y');
		if (date('d') != 01)
	{
	$this->load->view('component/autoclose');
	}
	else
	{
	
	$lastmonth = strtotime ( '-1 day' , strtotime ( $date ) ) ;  
	$month=date('m',$lastmonth);
	$year = date('Y',$lastmonth);
	
	if($hospital_id != NULL)
	{
	$sent_to = $this->sys_model->get_email_for_alert('monthly_ipd_patient_report',$hospital_id);
	$db_id = $sent_to->connection_id;
	//
	$sesdata = array(
				'hospital_id'  => $this->sys_model->get_auth_db($db_id)->hospital_id,
                'db_host'  => $this->sys_model->get_auth_db($db_id)->ip_address,
				'db_user'  => $this->sys_model->get_auth_db($db_id)->username,
				'db_password' => $this->sys_model->get_auth_db($db_id)->password,
				'payer_id' => $this->sys_model->get_hospital_name($this->sys_model->get_auth_db($db_id)->hospital_id)->employee_payer_id,
				'hospital_name' => $this->sys_model->get_hospital_name($this->sys_model->get_auth_db($db_id)->hospital_id)->real_hospital_name,
				'db_name' => $this->sys_model->get_auth_db($db_id)->database_name);
				$this->session->set_userdata($sesdata);
	//
	$attachment_path = $this->_create_ipd_patient_report_file($hospital_id, $month, $year);
	$this->email->from('medicos.alert@siloamhospitals.com', 'MedicOS Centric Patient Report System');
    $this->email->reply_to('krisbyan22@gmail.com', 'HelpDesk Simedika');
	$this->email->to($sent_to->mail_to);
	$this->email->cc($sent_to->cc_to); 
	$this->email->subject("MedicOS Centric Monthly Patient Report $hospital_id at $month of $year ");
	$this->email->attach($attachment_path);
	$this->email->message("This Attachment contain the information about Patient Report in ".$this->session->userdata('hospital_name')." at $month of $year");
    if (!$this->email->send()){
       echo 'error! <br />';
	   $logs = array(
                   'user_id'  => 'System Alert',
				   'modul_id'  => '1',
				   'requested_by' => 'System Alert '.'Unable Sending Email Monthly Patient Report To '.$sent_to->mail_to.' AND '.$sent_to->cc_to.' For Hospital '.$this->session->userdata('hospital_name')
					);
			$this->sys_model->logging($logs);
        // Generate error
    }
	 $logs = array(
                   'user_id'  => 'System Alert',
				   'modul_id'  => '1',
				   'requested_by' => 'System Alert '.'SUCCESS Sending Email Monthly Patient Report To '.$sent_to->mail_to.' AND '.$sent_to->cc_to.' For '.$this->session->userdata('hospital_name')
					);
			$this->sys_model->logging($logs);
			$this->load->view('component/autoclose');
	
	}
	else
	{
	$this->load->view('component/autoclose');	
	}
	
	}
	}
	
	function _create_ipd_patient_report_file($hospital_id=NULL, $month, $year)
	{	
	//$payer_id = $this->session->userdata('payer_id');
	$this->excel->setActiveSheetIndex(0);
    $data = $this->alert_model->get_monthly_ipdpatient($month,$year)->result();
    $this->excel->stream('monthly_ipd_patient_report_'.$hospital_id.'_'.$month.'_'.$year.'.xls',$data);
	$path = "assets/uploads/document";
	$attachment_path = "$path/monthly_ipd_patient_report_".$hospital_id."_".$month."_".$year.".xls";
	return $attachment_path;
    }
	
	
}
