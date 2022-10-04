<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inventory_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_report_model');
        $this->load->model('sys_model');
        $this->load->model('restreport_model');
        $this->load->helper('array');
    }

    function index()
    {
        if ($this->session->userdata('db_name')) {

            //$data['sub_modul'] = $this->sys_model->get_submodul('30');
            $data['title'] = "Hospital Information :: Generate Inventory Report " . $this->
                session->userdata('hospital_name');
            $data['page'] = 'menu';
            $data['style'] = 'portal.css';
            $data['content_title'] = "Generate Inventory Report";
            $data['content'] = 'moduls/invreport/inventory_home';
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

    function item_tracker_filter()
    {
        $data['title'] = "Item Tracker  -> Medicos Support Tools :: " . $this->config->
            item('company_name') . " ";
        $data['items_data'] = null;
        $data['page'] = 'datatable';
        $data['style'] = 'portal.css';
        $data['content_title'] = "ITEM TRACKER";
        $data['button_action'] = 'inventory_report/trace/';
        $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
        $data['content'] = 'moduls/invreport/item_tracker_filter';
        $this->load->view('system', $data);
    }

    function item_tracker_lookup() //MST 10
    {
        $keyword = $this->input->post('keyword');
        $data['title'] = "Item Tracker  -> Medicos Support Tools :: " . $this->config->
            item('company_name') . " ";
        if ($keyword) {
            $data['items_data'] = $this->item_model->get_item_tracking($keyword);
        } else {
            $data['items_data'] = null;
        }
        $data['page'] = 'datatable';
        $data['style'] = 'portal.css';
        $data['content_title'] = "ITEM TRACKER";
        $data['button_action'] = 'inventory_report/item_trace/';
        $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
        $data['content'] = 'moduls/invreport/item_tracker';
        $this->load->view('system', $data);
    }

    function lookup_json($keyword) //MST 10
    {
        $this->benchmark->mark('code_start');
        if ($keyword) {
            $data = $this->item_model->get_item_tracking($keyword);
        } else {
            $data = null;
        }
        $arr_data = array();
        foreach ($data as $items) {
            $arr_data['items'][] = array('item' => array(
                    'name_value' => $items->NameValue,
                    'uom_buy' => $items->uom_buy,
                    'uom_sell' => $items->uom_sell,
                    'is_formularium' => $items->IsFormularium,
                    'record_status' => $items->RecordStatus));
        }
        print json_encode($arr_data);
        $this->benchmark->mark('code_end');
        echo $this->benchmark->elapsed_time('code_start', 'code_end');
    }


    function item_trace($item_id = null)
    {
        $data['item_name'] = $this->item_model->get_item_detail($item_id);
        $data['item_grn'] = $this->item_model->get_item_grn($item_id);
        $data['item_price'] = $this->item_model->get_item_price($item_id);
        $data['item_stock'] = $this->item_model->get_item_stock($item_id);
        $data['item_specialist'] = $this->item_model->get_item_specialist($item_id);
        $data['item_store'] = $this->item_model->get_item_mapping_store($item_id);
        $data['item_po'] = $this->item_model->get_item_po($item_id);
        $data['item_pr'] = $this->item_model->get_item_pr($item_id);
        $data['item_order_price'] = $this->item_model->get_item_order_price($item_id);
        $this->load->view('moduls/invreport/data_tab', $data);
    }

    function moving_stock_report_filter()
    {
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Stock Report -> Medicos Support Tools :: " . $this->config->
                item('company_name') . " ";
            $data['items_data'] = null;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "inventory_report/get_moving_stock_data";
            $data['content_title'] = "Slow Moving Stock Report";
            //$data['button_action']='medicine_consume/lookup/';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/invreport/stock_slow_moving_report_front';
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

    function get_moving_stock_data()
    {
        if ($this->session->userdata('db_name') && ($this->input->post('zerofilterdata') !=
            '')) {
            $startdate = '';
            $endate = '';
            $zerostate = '';
            $daterange = $this->input->post('optionsRadiosDaterange');
            $zerofilterdata = $this->input->post('zerofilterdata');
            if ($daterange == 'last3month') {

                $startdate = date('Y-m-d', strtotime("-3 month"));
                $enddate = date("Y-m-d");
            } else {
                $startdate = $this->input->post('startdate');
                $endate = $this->input->post('enddate');
            }
            if ($zerofilterdata == 'withzerostock') {
                $zerostate = true;
            } else {
                $zerostate = false;
            }
            ob_start('ob_gzhandler');
            $datalist['aaData'] = $this->restreport_model->get_slow_moving_stock($startdate,
                $endate, $zerostate);
            echo json_encode($datalist, JSON_UNESCAPED_UNICODE);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }
    }

    function get_expire_item_filter()
    {
        if ($this->session->userdata('db_name')) {
            $data['title'] = "Item Expire Report -> Medicos Support Tools :: " . $this->
                config->item('company_name') . " ";
            $data['items_data'] = null;
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = "inventory_report/expire_dashboard";
            $data['content_title'] = "Item Expire Report";
            //$data['button_action']='medicine_consume/lookup/';
            $data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
            $data['content'] = 'moduls/invreport/item_expire_report_filter';
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

    function get_expire_item()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('d-m-Y');

        if ($this->session->userdata('db_name') && ($this->input->post('zerofilterdata') !=
            '')) {
            $startdate = '';
            $endate = '';
            $inverpage = $this->input->post('optionsRadiosDaterange');
            $invertype = $this->input->post('zerofilterdata');

            $data['optionsRadiosDaterange'] = $inverpage;
            $data['zerofilterdata'] = $invertype;

            if ($inverpage == 'last3month' && $invertype == 'withzerostock') {
                // $dateend = date('d', $date);
                $startdate = '1970-01-01';
                $endate = date("Y-m-d");

                ob_start('ob_gzhandler');
                $datalist['aaData'] = $this->inventory_report_model->get_name_item_expire($startdate,
                    $endate, $code_item);
                echo json_encode($datalist, JSON_UNESCAPED_UNICODE);

                //$data['expired_items'] = $this->inventory_report_model->get_name_item_expire($startdate,$dateend,$code_item);
                //$data['content'] = 'moduls/invreport/marketing_all_service_report';
            } else
                if ($inverpage == 'last3month' && $invertype == 'withoutzerostock') {
                    //$dateend = date('d', $date);
                    $startdate = '1970-01-01';
                    $endate = date("Y-m-d");

                    ob_start('ob_gzhandler');
                    $datalist['aaData'] = $this->inventory_report_model->get_store_item_expire($startdate,
                        $endate, $store_code);
                    echo json_encode($datalist, JSON_UNESCAPED_UNICODE);

                    //$data['expired_items'] = $this->inventory_report_model->get_store_item_expire($startdate,$dateend,$store_item);
                    //$data['content'] = 'moduls/invreport/marketing_spes_service_report';
                } else
                    if ($inverpage == 'customrange' && $invertype == 'withzerostock') {
                        $startdate = $this->input->post('startdate');
                        $enddate = $this->input->post('enddate');

                        $data['startdate'] = $startdate;
                        $data['enddate'] = $enddate;

                        ob_start('ob_gzhandler');
                        $datalist['aaData'] = $this->inventory_report_model->get_name_item_expire($startdate,
                            $endate, $code_item);
                        echo json_encode($datalist, JSON_UNESCAPED_UNICODE);

                        //$data['expired_items'] = $this->inventory_report_model->get_name_item_expire($startdate,$dateend,$code_item);
                        //$data['content'] = 'moduls/invreport/marketing_spes_service_report';
                    } else
                        if ($inverpage == 'customrange' && $invertype == 'withoutzerostock') {
                            $startdate = $this->input->post('startdate');
                            $enddate = $this->input->post('enddate');

                            $data['startdate'] = $startdate;
                            $data['enddate'] = $enddate;

                            ob_start('ob_gzhandler');
                            $datalist['aaData'] = $this->inventory_report_model->get_store_item_expire($startdate,
                                $endate, $store_code);
                            echo json_encode($datalist, JSON_UNESCAPED_UNICODE);

                            //$data['expired_items'] = $this->inventory_report_model->get_store_item_expire($startdate,$dateend,$store_item);
                            //$data['content'] = 'moduls/invreport/marketing_spes_service_report';
                        }

            //$data['title'] = "Hospital Information :: List Of Item Expire ".$this->session->userdata('hospital_name');
            //$data['page'] = 'datatable';
            //$data['style'] = 'portal.css';
            //$data['form_request'] = 'inventory_report/get_expire_item';
            //$data['content_title'] = "List Of Expire Item";
            //$data['content'] = 'markreport/marketing_all_service_report';
            // $this -> load -> view('system', $data);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }
        }
    }


    function get_name_item_expired_data($startdate = null, $enddate = null)
        //  return json data
    {
        if ($this->session->userdata('db_name')) {
            $data['expdata'] = $this->inventory_report_model->get_all_expire($startdate, $enddate);
            $this->load->view('moduls/invreport/exped_name_json', $data);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }

    }

    function get_store_item_expired_data($startdate = null, $enddate = null)
        // return json data
    {
        if ($this->session->userdata('db_name')) {
            $data['expdata'] = $this->inventory_report_model->get_all_expire($startdate, $enddate);
            $this->load->view('moduls/invreport/exped_store_json', $data);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }

    }


    function get_name_item_expiring_data($startdate = null, $enddate = null)
        // return json data
    {
        if ($this->session->userdata('db_name')) {
            $data['expdata'] = $this->inventory_report_model->get_all_expire($startdate, $enddate);
            $this->load->view('moduls/invreport/expig_name_json', $data);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }

    }

    function get_store_item_expiring_data($startdate = null, $enddate = null)
        // return json data
    {
        if ($this->session->userdata('db_name')) {
            $data['expdata'] = $this->inventory_report_model->get_all_expire($startdate, $enddate);
            $this->load->view('moduls/invreport/expig_store_json', $data);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }

    }

    function expire_dashboard()
    {
        if ($this->session->userdata('db_name')) {
            $startdate = '';
            $enddate = '';
            $inverpage = $this->input->post('optionsRadiosDaterange');
            $invertype = $this->input->post('zerofilterdata');

            if ($inverpage == 'last3month' && $invertype == 'withzerostock') {
                //				$datestart = '1970-01-01';
                //				$dateend = date("Y-m-d");

                $data['startdate'] = "1970-01-01";
                $data['enddate'] = date("Y-m-d");
                $data['exp_page'] = 'item_expired';
                $data['exp_title'] = 'List All Expired Items Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                    '<br />' . $this->session->userdata('hospital_name');
            } else
                if ($inverpage == 'last3month' && $invertype == 'withoutzerostock') {
                    //				$datestart = '1970-01-01';
                    //				$dateend = date("Y-m-d");

                    $data['startdate'] = "1970-01-01";
                    $data['enddate'] = date("Y-m-d");
                    $data['exp_page'] = 'store_expired';
                    $data['exp_title'] = 'List All Expired Items Until ' . date('d-m-Y', strtotime($data['enddate'])) .
                        '<br />' . $this->session->userdata('hospital_name');
                } else
                    if ($inverpage == 'customrange' && $invertype == 'withzerostock') {
                        $data['startdate'] = $this->input->post('startdate');
                        $data['enddate'] = $this->input->post('enddate');

                        $data['exp_page'] = 'item_expiring';
                        $data['exp_title'] = 'List All Expiring Items Between ' . date('d-m-Y',
                            strtotime($data['startdate'])) . ' to ' . date('d-m-Y', strtotime($data['enddate'])) .
                            '<br />' . $this->session->userdata('hospital_name');
                    } else
                        if ($inverpage == 'customrange' && $invertype == 'withoutzerostock') {
                            $data['startdate'] = $this->input->post('startdate');
                            $data['enddate'] = $this->input->post('enddate');

                            $data['exp_page'] = 'store_expiring';
                            $data['exp_title'] = 'List All Expiring Items Between ' . date('d-m-Y',
                                strtotime($data['startdate'])) . ' to ' . date('d-m-Y', strtotime($data['enddate'])) .
                                '<br />' . $this->session->userdata('hospital_name');
                        } else {
                            redirect('emr_info', 'refresh');
                        }

                        $data['title'] = "Hospital Information :: Item Expire Report - " . $this->
                            session->userdata('hospital_name');
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['content_title'] = "Item Expire Report";
            $data['content'] = 'moduls/invreport/expire_dashboard';
            $this->load->view('system', $data);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }
    }

    function all_store_stock_filter()
    {
		$datestart = $this->input->post('startdate');
		$dateend = $this->input->post('enddate');
	    
		$data['store_list'] = $this->inventory_report_model->get_list_store();
	
        if ($this->session->userdata('db_name')) 
		{
            $data['title'] = "Hospital Information :: Generate Inventory Report " . $this->session->userdata('hospital_name');
			if($datestart)
			{$data['stock_data'] = $this->inventory_report_model->get_all_store_stock($datestart,$dateend);}
			else
			{$data['stock_data'] = NULL;}
            $data['service_data'] = null;
            $data['page'] = 'menu';
            $data['style'] = 'portal.css';
            $data['form_request'] = 'inventory_report/store_stock_dashboard';
            $data['content_title'] = "Generate Store Stock Report";
			$data['button_action']='tools';
            $data['content'] = 'moduls/invreport/store_stock_filter';
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
    
    function store_stock_dashboard($startdate = null, $enddate = null, $storecode =0)
    {
       // $data['store_list'] = $this->inventory_report_model->get_list_store();

        if ($this->session->userdata('db_name'))
		{
            $datestart = $this->input->post('startdate');
            $dateend = $this->input->post('enddate');
            $markpage = $this->input->post('storecode');
           
		    $data['startdate'] = $datestart;
            $data['enddate'] = $dateend;
            $data['storecode'] = $markpage;

            if ($markpage == 0) 
			{
                //$data['list_all_service_radiology'] = $this->inventory_report_model->get_allrad_service_report($datestart, $dateend);
                $data['list_all_store_stock'] = $this->inventory_report_model->get_all_store_stock($datestart, $dateend);
                $data['stock_page'] = "all_stores";
            } 
			else
			{
                $data['list_spec_store_stock'] = $this->inventory_report_model->get_spes_store_stock($datestart, $dateend, $markpage);
                $data['stock_page'] = "spes_store";
            }

            $data['title'] = "Hospital Information :: List Of Store Stock " . $this->session->userdata('hospital_name');
            $data['page'] = 'datatable';
            $data['style'] = 'portal.css';
            $data['form_request'] = 'inventory_report/store_stock_dashboard';
            $data['content_title'] = "List Of Store Stock Report";
			$data['button_action']='tools';
            $data['content'] = 'moduls/invreport/store_stock_report';
            $this->load->view('system', $data);
        } else {
            if ($this->session->userdata('username')) {
                redirect('tools', 'refresh');
            } else {
                $this->session->sess_destroy();
                redirect('core', 'refresh');
            }

        }
    }
    
   	function slow_moving_stock_filter()
	{
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Stock Report -> Medicos Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "inventory_report/slow_moving_stock_dashboard";
			$data['content_title'] = "Slow Moving Stock Report";
			//$data['button_action']='medicine_consume/lookup/';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'moduls/invreport/stock_slow_moving_report_front'; 
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
     
	function slow_moving_stock_dashboard() 
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
