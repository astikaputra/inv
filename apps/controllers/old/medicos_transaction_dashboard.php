<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Medicos_transaction_dashboard extends CI_Controller 
{ 
	 function __construct()
    {
              parent::__construct();
			  $this->load->model('medicosinfo_model');
			  $this->load->model('medicos_monitor_model');
              $this->load->model('sys_model');
			  $this->load->helper('array');
    }
    
  	function index()
	{
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "MedicOS Transaction Dashboard | MedicOS Support Tools :: ".$this->config->item('company_name')." ";
			$data['items_data'] = NULL;
			$data['page']='datatable';
			$data['style'] = 'portal.css'; 
			$data['form_request'] = "medicos_transaction_dashboard/get_data";
			$data['content_title'] = "MedicOS Transaction Dashboard";
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['content'] = 'hospitalinfo/medicos_transaction_dashboard'; 
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
		if($this->session->userdata('db_name') && ($this->input->post('transaction_type') != '') )
		{	
			$startdate = '';
			$enddate = '';
			$daterange = $this->input->post('optionsRadiosDaterange');
			$trans_type = $this->input->post('transaction_type');
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
			if($trans_type == 'inventory_transaction')
				{
					// 1. Purchase Requisition Data 
						$pr_data =$this->medicosinfo_model->get_purchase_request_data($startdate,$enddate);
						$data['total_pr'] = element('total_pr',$pr_data);
						$data['total_pr_item'] = element('total_item_pr',$pr_data);
						$data['total_pr_item_qty'] = element('total_item_pr_qty',$pr_data);
					// 2. Purchase Requisition Auto Data
						$pr_auto_data =$this->medicosinfo_model->get_purchase_request_auto_data($startdate,$enddate);
						$data['total_pr_auto'] = element('total_pr_auto',$pr_auto_data);
						$data['total_pr_auto_item'] = element('total_item_pr_auto',$pr_auto_data);
						$data['total_pr_auto_item_qty'] = element('total_item_pr_auto_qty',$pr_auto_data);
					// 3. Purchase Order
						$purchase_order_data = $this->medicosinfo_model->get_purchase_order_data($startdate,$enddate);
						$data['total_po_from_multiple_pr'] = element('total_po_multiple_pr',$purchase_order_data);
						$data['total_po_from_single_pr'] = element('total_po_single_pr',$purchase_order_data);
						$data['total_po_supplier'] = element('total_po_supplier',$purchase_order_data);
						$data['total_po_item'] = element('total_item',$purchase_order_data);
						$data['total_po_item_qty'] = element('total_item_qty',$purchase_order_data);
						$data['total_po_amount'] = element('total_amount',$purchase_order_data);
					// 4. Purchase Order Without PR
						$data['total_po_without_pr'] = element('total_po_without_pr',$purchase_order_data);
						$data['total_po_without_pr_item'] = element('total_po_without_pr_item',$purchase_order_data);
						$data['total_po_without_pr_supplier'] = element('total_po_without_pr_supplier',$purchase_order_data);
						$data['total_po_without_pr_item_qty'] = element('total_po_without_pr_item_qty',$purchase_order_data);
						$data['total_po_without_pr_amount'] = element('total_po_without_pr_amount',$purchase_order_data);
					// 5. Purchase Order Consignment
						$data['total_po_consignment'] = element('total_po_consignment',$purchase_order_data);
						$data['total_po_consignment_totalitem'] = element('total_po_consignment_totalitem',$purchase_order_data);
						$data['total_po_consignment_totalitem_qty'] = element('total_po_consignment_totalitem_qty',$purchase_order_data);
						$data['total_po_consignment_total_amount'] = element('total_po_consignment_totalitem_qty',$purchase_order_data);
					// 6. Good Receive Notes
						$good_receive_notes = $this->medicosinfo_model->get_good_receive_notes_data($startdate,$enddate);
						$data['total_grn']=element('total_grn',$good_receive_notes);
						$data['total_grn_partial']= element('total_grn_partial',$good_receive_notes);
						$data['total_grn_bonus']= element('total_grn_bonus',$good_receive_notes);	
						$data['total_grn_totalitem']= element('total_grn_totalitem',$good_receive_notes);
						$data['total_grn_totalqty']= element('total_grn_totalqty',$good_receive_notes);
						$data['total_grn_supplier']= element('total_grn_supplier',$good_receive_notes);
						$data['total_qty_stock']= element('total_qty_stock',$good_receive_notes);
					// 7. Return To Vendor
						$return_to_vendor = $this->medicosinfo_model->get_return_to_vendor_data($startdate,$enddate);
						$data['total_rtv'] = element('total_rtv',$return_to_vendor);
						$data['total_rtv_item'] = element('total_rtv_item',$return_to_vendor);
						$data['total_rtv_item_qty'] = element('total_rtv_item',$return_to_vendor);
						$data['total_rtv_supplier'] = element('total_rtv_supplier',$return_to_vendor);
					// 8. Stock Requisition
						$stock_requisition = $this->medicosinfo_model->get_stock_requisition_data($startdate,$enddate);
						$data['total_sr'] = element('total_sr',$stock_requisition);
						$data['total_store_request'] = element('total_store_request',$stock_requisition);
						$data['total_sr_item'] = element('total_sr_item',$stock_requisition);
						$data['total_sr_item_qty'] = element('total_sr_item_qty',$stock_requisition);
					// 9. Stock Transfer
						$stock_transfer = $this->medicosinfo_model->get_data_transfer_stock($startdate,$enddate);
						//-- Transfer Out
						$data['total_to'] = element('total_to',$stock_transfer);
						$data['total_to_stores'] = element('total_to_stores',$stock_transfer);
						$data['total_to_item'] = element('total_to_item',$stock_transfer);
						$data['total_to_item_qty'] = element('total_to_item_qty',$stock_transfer);
						//-- Transfer IN
						$data['total_ti'] = element('total_ti',$stock_transfer);
						$data['total_ti_stores'] = element('total_ti_stores',$stock_transfer);
						$data['total_ti_item'] = element('total_ti_item',$stock_transfer);
						$data['total_ti_item_qty'] = element('total_ti_item_qty',$stock_transfer);
					// 10. Stock Adjustment
						$stock_adjustment = $this->medicosinfo_model->get_adjustment_data($startdate,$enddate);
						$data['total_adjustment'] = element('total_adjustment',$stock_adjustment);
						$data['total_adjustment_stores'] = element('total_adjustment_stores',$stock_adjustment);
						$data['total_adjustment_item'] = element('total_adjustment_item',$stock_adjustment);
						$data['total_adjustment_item_qty'] = element('total_adjustment_item_qty',$stock_adjustment);

					// 11. Non Chargeable
						$data['total_adjustment_regular'] = element('total_adjustment_regular',$stock_adjustment);
						$data['total_adjustment_regular_item'] = element('total_adjustment_regular_item',$stock_adjustment);
						$data['total_adjustment_regular_item_qty'] = element('total_adjustment_regular_item_qty',$stock_adjustment);
						$data['total_adjustment_damage'] = element('total_adjustment_damage',$stock_adjustment);
						$data['total_adjustment_damage_item'] = element('total_adjustment_damage_item',$stock_adjustment);
						$data['total_adjustment_damage_item_qty'] = element('total_adjustment_damage_item_qty',$stock_adjustment);

					// 12. Indirect ChargeAble
						$data['total_adjustment_indirect'] = element('total_adjustment_indirect',$stock_adjustment);
						$data['total_adjustment_indirect_item'] = element('total_adjustment_indirect_item',$stock_adjustment);
						$data['total_adjustment_indirect_item_qty'] = element('total_adjustment_indirect_item_qty',$stock_adjustment);	
					
					
					$this->load->view('hospitalinfo/datacontainer/inventory_transaction_dashboard',$data);
					//$this->output->enable_profiler(TRUE);
	
				}
			else if($trans_type == 'patient_transaction_tat')
				{
					$data['datasource'] = base_url().'medicos_transaction_dashboard/get_tat_reg_data/'.$startdate.'/'.$enddate;
					$this->load->view('hospitalinfo/datacontainer/transaction_tat',$data);
					
				}
			else
				{	
					if($startdate == $enddate)
					{
					$startdate =   date('Y-m-d', strtotime("-1 days"));
					}
					$data['lob_throughput'] = $this->medicos_monitor_model->get_throughput_by_lob($startdate,$enddate);
					$this->load->view('hospitalinfo/datacontainer/hospitals_transaction_dashboard',$data);
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
	
	
	function get_tat_reg_data($startdate,$enddate)
	{
	if($this->session->userdata('db_name'))
		{
			ob_start('ob_gzhandler');
			$data['aaData'] = $this->medicos_monitor_model->get_patient_transaction($startdate,$enddate);
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
	
	function get_patient_reg_data($startdate,$enddate)
	{
		if($this->session->userdata('db_name'))
		{
			ob_start('ob_gzhandler');
			$data['OPD'] = $this->medicos_monitor_model->get_throughput_by_lob('OPD',$startdate,$enddate);
			$data['IPD'] = $this->medicos_monitor_model->get_throughput_by_lob('IPD',$startdate,$enddate);
			$data['ETC'] = $this->medicos_monitor_model->get_throughput_by_lob('ETC',$startdate,$enddate);
			$data['MCU'] = $this->medicos_monitor_model->get_throughput_by_lob('MCU',$startdate,$enddate);

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
	
	private function _generate_chartkick_line_data($category,$data) //only two column
		{
				$databuffer = '';
				$i=1;
			foreach($data as $itemdata)
				{
				$dataelement = '["'.$i.'":'.$itemdata["TotalPatient"].'],';
				$databuffer = $databuffer.$dataelement;	
					$i++;				
				}
			return substr_replace($databuffer ,"",-1);
	
		}
	
	function get_details($objectname,$startdate,$enddate)
	{
	
	
	}
	
}