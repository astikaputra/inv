 <div class="container-fluid">

      <div class="row-fluid">

      <div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well" id="date_range">
			 <div class="span4"><img class="medicos_header_logo" src="<?php echo base_url() .
'assets/template/images/medicos.png'; ?>" alt="Medical Information Solution"></div>
			 <div class="span4"></div>
			 <div class="span4"><p class="hospital_logo"><img src="<?php echo base_url() .
'assets/template/icon/logo.png'; ?>" alt="Siloam Hospitals"></p></div>

			<legend id="toplegend"><?php echo $content_title; ?> </legend>
			<br />
			 <div class="control-group">
			 <a href="<?php $button_action; ?>" class="btn btn-primary" style="display:none;z-index:2; align:right; position: fixed; top: 7em; right: 45px;" id="searchdataagain">Change Report</a>

			<?php if ($pharmacy_page == "consumption_report") { ?>								
            <table class="table table-bordered" id="finance_docgrid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill Date</th>	
												  <th>Prescription</th>
												  <th>Barcode</th>
												  <th>Item Code</th>
												  <th>Item Name</th>
												  <th>Perpation Form</th>
												  <th>Qty</th>
												  <th>UOM Sales</th>
												  <th>Patient Name</th>
												  <th>Patient Address</th>
												  <th>Doctor Name</th>
												  <th>Doctor Address</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
    foreach ($revenue_all_data as $revenues) {
        $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->PoDate)); ?></td>
										<td><?php echo $revenues->PoNumber; ?></td>
										<td><?php echo $revenues->GRNNumber; ?></td>
										<td><?php echo $revenues->itemcode; ?></td>
										<td><?php echo $revenues->ItemName; ?></td>
										<td><?php echo $revenues->ItemCategory; ?></td>
										<td><?php echo $revenues->itemcode; ?></td>										
										<td><?php echo date('d-m-Y H:i:s', strtotime($revenues->
        RegistrationTime)); ?></th>
										<td><?php echo $revenues->patientName; ?></td>
										<td><?php echo $revenues->gender; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->birthdate)); ?></td>
										<td><?php echo $revenues->age; ?></td>
										<td><?php echo $revenues->Address; ?></td>
										<td><?php echo $revenues->IdentityCardTypes; ?></td>
										<td><?php echo $revenues->Nationality; ?></td>
										<td><?php echo $revenues->LOB; ?></td>
										<td><?php echo $revenues->AxdoctorCode; ?></td>
										<td><?php echo $revenues->DoctorName; ?></td>
										<td><?php echo $revenues->ReferingDoctor; ?></td>
										<td><?php echo $revenues->SubSpecialistName; ?></td>
										<td><?php echo $revenues->specialistName; ?></td>
										<td><?php echo $revenues->GroupSpecialistName; ?></td>
										<td><?php echo $revenues->ROOM; ?></td>
										<td><?php echo $revenues->MarginClass; ?></td>
										<td><?php echo $revenues->Itemcode; ?></td>
										<td><?php echo $revenues->ServiceCode; ?></td>
										<td><?php echo $revenues->DescName; ?></td>
										<td><?php echo $revenues->LOSName; ?></td>
										<td><?php echo $revenues->Qty; ?></td>
										<td><?php echo $revenues->ItemPrice; ?></td>
										<td><?php echo $revenues->BillAmount; ?></td>
										<td><?php echo $revenues->PayerAmount; ?></td>
										<td><?php echo $revenues->DoctorFee; ?></td>
										<td><?php echo $revenues->Discount; ?></td>
										<td><?php echo $revenues->PayerName; ?></td>	
										<td><?php echo $revenues->payertype; ?></td>
										<td><?php echo $revenues->PaymentMethod; ?></td>
										<td><?php echo $revenues->Status; ?></td>
										<td><?php echo $revenues->isretail; ?></td>
										<td><?php echo $revenues->triage; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->Admitdate)); ?></td>
										<td><?php echo $revenues->PaymentStatus; ?></td>										
										<?php } ?>
										</tbody>
										
								</table>

			<?php } else
    if ($pharmacy_page == "purchase_report") { ?>
								<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill Date</th>	
												  <th>Bill No.</th>
												  <th>Patient Name</th>
												  <th>Item Code</th>
												  <th>Description</th>
												  <th>Amount Bill (Rp.)</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
        foreach ($prodia_revenue_data as $revenues) {
            $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->BillDate)); ?></td>
										<td><?php echo $revenues->BillNo; ?></td>
										<td><?php echo $revenues->patientName; ?></td>
										<td><?php echo $revenues->Itemcode; ?></td>
										<td><?php echo $revenues->DescName; ?></td>
										<td><?php echo number_format($revenues->BILLAMOUNT, 0, ',', '.'); ?></td>
										<?php } ?>
										</tbody>
										
								</table>

<?php } else
    if ($pharmacy_page == "po_drugmed_rep") { ?>
								<table class="table table-bordered" id="finance_docgrid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>PO Date</th>	
												  <th>PO No.</th>
												  <th>GRN No.</th>
												  <th>Item Code</th>
												  <th>Barcode</th>
												  <th>Item Name</th>
												  <th>Order Qty</th>
												  <th>UOM Buy</th>	
												  <th>Receipt Qty</th>
												  <th>Conversion</th>
												  <th>Uom Sell</th>
												  <th>HNA</th>
												  <th>Discount</th>
												  <th>VAT</th>
												  <th>Purchase Price</th>
												  <th>Total Purchase</th>
												  <th>Vendor</th>
												  <th>Manufacturer</th>												  													  
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
        foreach ($po_drugmedsup_data as $po_drugmed) {
            $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date('d-m-Y', strtotime($po_drugmed->PoDate)); ?></td>
										<td><?php echo $po_drugmed->PONumber; ?></td>
										<td><?php echo $po_drugmed->GRNNumber; ?></td>
										<td><?php echo $po_drugmed->itemcode; ?></td>
										<td><?php echo $po_drugmed->BarCode; ?></td>
										<td><?php echo $po_drugmed->ItemName; ?></td>
										<td><?php echo $po_drugmed->Qty_Order; ?></td>
										<td><?php echo $po_drugmed->UOMBuy; ?></td>
										<td><?php echo $po_drugmed->QTY_Receipt; ?></td>
										<td><?php echo $po_drugmed->Conversion; ?></td>
										<td><?php echo $po_drugmed->UomSell; ?></td>
										<td><?php echo $po_drugmed->HNA; ?></td>
										<td><?php echo $po_drugmed->Discount; ?></td>
										<td><?php echo $po_drugmed->VAT; ?></td>
										<td><?php echo number_format($po_drugmed->PurchasePrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($po_drugmed->totalPurchase, 0, ',', '.'); ?></td>
										<td><?php echo $po_drugmed->Vendor; ?></td>
										<td><?php echo $po_drugmed->Manufacturer; ?></td>
										<?php } ?>
										</tbody>
										
								</table>
<?php } else
    if ($pharmacy_page == "stock_drugmed_all") { ?>
								<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Item Code</th>	
												  <th>Item Name</th>
												  <th>Category</th>	
												  <?php foreach($get_list_store as $store_list) { ?>
												  <th><?php echo $store_list->StoreName; ?></th>	  
												</tr>
											 </thead>
										<tbody>
										<?php  $i = 0;
        foreach ($item_list as $item_data) {
			$i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $item_data->ItemCode; ?></td>
										<td><?php echo $item_data->ItemName; ?></td>
										<td><?php echo $item_data->Categories; ?></td>
										<?php foreach($this->inventory_report_model->get_stock_drugmed_detail($item_data->ItemId,$store_list->StoreId) as $stock_per_store) { ?>
										<td><?php echo $stock_per_store->QtyOnHand; ?></td>
										<?php } ?>
										</tr>
										<?php } } ?>
										</tbody>
										
								</table>
								
<?php } else
    if ($pharmacy_page == "stock_drugmed_spec") { ?>
								<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Item Code</th>	
												  <th>Item Name</th>
												  <th>Category</th>												  
												  <?php foreach($get_list_store as $store_list) { ?>
												  <th><?php echo $store_list->StoreName; ?></th>
												  <?php } ?>
												</tr>
											 </thead>
										<tbody>
										<?php  $i = 0;
        foreach ($stock_data as $stock_phms) {
			$i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $stock_phms->ItemCode; ?></td>
										<td><?php echo $stock_phms->ItemName; ?></td>
										<td><?php echo $stock_phms->Categories; ?></td>
										<td><?php echo $stock_phms->QtyOnHand; ?></td>
										</tr>
										<?php } ?>
										</tbody>
										
								</table>
								
<?php } else
    if ($pharmacy_page == "sales_phms_rep") { ?>
								<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill No.</th>	
												  <th>Barcode</th>
												  <th>Prescription / IMR No.</th>
												  <th>Item Code</th>
												  <th>Item Name</th>
												  <th>Qty</th>
												  <th>UOM Sales</th>
												  <th>Purchase Price</th>
												  <th>Total Purchase Price</th>
												  <th>Selling Price</th>
												  <th>Total Selling Price</th>
												  <th>Class</th>
												  <th>Identity</th>
												  <th>Retail</th>
												  <th>Site</th>											  													  
												</tr>
											 </thead>
										<tbody>
										<?php  $i = 0;
        foreach ($sales_phms_data as $sales_phms) {
			$i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $sales_phms->billno; ?></td>
										<td><?php echo $sales_phms->Barcode; ?></td>
										<td><?php echo $sales_phms->prescription; ?></td>
										<td><?php echo $sales_phms->itemcode; ?></td>
										<td><?php echo $sales_phms->ItemName; ?></td>
										<td><?php echo $sales_phms->Qty; ?></td>
										<td><?php echo $sales_phms->UomSales; ?></td>
										<td><?php echo number_format($sales_phms->PurchasePrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($sales_phms->TotalPurchasePrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($sales_phms->SellingPrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($sales_phms->TotalSellingPrice, 0, ',', '.'); ?></td>
										<td><?php echo $sales_phms->MarginClass; ?></td>	
										<td><?php echo $sales_phms->IdentityCardTypes; ?></td>
										<td><?php echo $sales_phms->isretail; ?></td>
										<td><?php echo $sales_phms->Site; ?></td>
										</tr>
										<?php } ?>
										</tbody>
										
								</table>

<?php } else
    if ($pharmacy_page == "sales_phms_doc_rep") { ?>
								<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Doctor No.</th>	
												  <th>Doctor Name</th>
												  <th>Prescription / IMR No.</th>
												  <th>Item Code</th>
												  <th>Item Name</th>
												  <th>Qty</th>
												  <th>UOM Sales</th>
												  <th>Purchase Price</th>
												  <th>Total Purchase Price</th>
												  <th>Selling Price</th>
												  <th>Total Selling Price</th>
												  <th>Class</th>
												  <th>Identity</th>
												  <th>Retail</th>
												  <th>Site</th>													  													  
												</tr>
											 </thead>
										<tbody>
										<?php  $i = 0;
        foreach ($sales_phms_data as $sales_phms_doc) {
             $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $sales_phms_doc->DoctorName; ?></td>
										<td><?php echo $sales_phms_doc->prescription; ?></td>
										<td><?php echo $sales_phms_doc->itemcode; ?></td>
										<td><?php echo $sales_phms_doc->ItemName; ?></td>
										<td><?php echo $sales_phms_doc->Qty; ?></td>
										<td><?php echo $sales_phms_doc->UomSales; ?></td>
										<td><?php echo number_format($sales_phms_doc->PurchasePrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($sales_phms_doc->TotalPurchasePrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($sales_phms_doc->SellingPrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($sales_phms_doc->TotalSellingPrice, 0, ',', '.'); ?></td>
										<td><?php echo $sales_phms_doc->MarginClass; ?></td>	
										<td><?php echo $sales_phms_doc->IdentityCardTypes; ?></td>
										<td><?php echo $sales_phms_doc->isretail; ?></td>
										<td><?php echo $sales_phms_doc->Site; ?></td>
										<td><?php echo $sales_phms_doc->Manufacture; ?></td>
										</tr>
										<?php } ?>
										</tbody>
										
								</table>

			<?php } else if ($pharmacy_page == "prescript_full_rep") { ?>								
            <table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>Bill Date</th>	
												  <th>Patient Name</th>
												  <th>Doctor Name</th>
												  <th>Prescription</th>
												  <th>Item Code</th>
												  <th>Item Name</th>
												  <th>Qty Prescribed</th>
												  <th>Qty</th>
												  <th>Purchase Price</th>
												  <th>Total Purchase Order</th>
												  <th>Selling Price</th>
												  <th>Total Selling Price</th>
												  <th>Margin Class</th>
												  <th>Identity Card Types</th>
												  <th>Is Retail</th>
												  <th>Site</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
    foreach ($prescription_data as $prescription_pag) {
        $i++; ?>
										<tr>						
										<td><?php echo date('d-m-Y', strtotime($prescription_pag->billdate)); ?></td>
										<td><?php echo $prescription_pag->patientName; ?></td>
										<td><?php echo $prescription_pag->DoctorName; ?></td>
										<td><?php echo $prescription_pag->prescription; ?></td>
										<td><?php echo $prescription_pag->itemcode; ?></td>
										<td><?php echo $prescription_pag->ItemName; ?></td>										
										<td><?php echo $prescription_pag->QtyofDrugsPrescribed; ?></td>
										<td><?php echo $prescription_pag->QtyofDrugsFulfilled; ?></td>
										<td><?php echo $prescription_pag->PurchasePrice; ?></td>
										<td><?php echo $prescription_pag->TotalPurchaseOrder; ?></td>
										<td><?php echo $prescription_pag->SellingPrice; ?></td>
										<td><?php echo $prescription_pag->TotalSellingPrice; ?></td>
										<td><?php echo $prescription_pag->MarginClass; ?></td>
										<td><?php echo $prescription_pag->IdentityCardTypes; ?></td>
										<td><?php echo $prescription_pag->isretail; ?></td>
										<td><?php echo $prescription_pag->site; ?></td>
										</tr>
										<?php } ?>
										</tbody>
								</table>

			<?php } else if ($pharmacy_page == "po_emergency_rep") { ?>								
            <table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>Bill Date</th>	
												  <th>PO No.</th>
												  <th>Item Name</th>
												  <th>Qty</th>
												  <th>UOM Purchase</th>
												  <th>Conversion</th>
												  <th>UOM Sales</th>
												  <th>HnA</th>
												  <th>Discount</th>
												  <th>PPn</th>
												  <th>Purchase Price</th>
												  <th>Total Pruchase Price</th>
												  <th>Vendor</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
    foreach ($po_emergency_data as $po_emer_dat) {
        $i++; ?>
										<tr>						
										<td><?php echo date('d-m-Y', strtotime($po_emer_dat->PoDate)); ?></td>
										<td><?php echo $po_emer_dat->PONumber; ?></td>
										<td><?php echo $po_emer_dat->ItemName; ?></td>
										<td><?php echo $po_emer_dat->QTY_Receipt; ?></td>
										<td><?php echo $po_emer_dat->UOMBuy; ?></td>
										<td><?php echo $po_emer_dat->Conversion; ?></td>										
										<td><?php echo $po_emer_dat->UomSell; ?></td>
										<td><?php echo $po_emer_dat->HNA; ?></td>
										<td><?php echo $po_emer_dat->Discount; ?></td>
										<td><?php echo $po_emer_dat->VAT; ?></td>
										<td><?php echo $po_emer_dat->PurchasePrice; ?></td>
										<td><?php echo $po_emer_dat->totalPurchase; ?></td>
										<td><?php echo $po_emer_dat->SuppName; ?></td>
										</tr>
										<?php } ?>
										</tbody>
								</table>	

			<?php } else if ($pharmacy_page == "phms_expire_rep") { ?>								
            <table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>	
												  <th>Barcode</th>
												  <th>Item Code</th>
												  <th>Item Name</th>
												  <th>Purchase Date</th>
												  <th>ExpiredDate</th>
												  <th>Qty On Hand</th>
												  <th>Purchase Price</th>
												  <th>Total Purchase Price</th>
												  <th>Store Name</th>
												  <th>UOM Sell</th>
												  <th>Supplier Name</th>
												  <th>Manufactures</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
    foreach ($phms_expired_data as $po_emer_dat) {
        $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $po_emer_dat->BarCode; ?></td>
										<td><?php echo $po_emer_dat->itemcode; ?></td>
										<td><?php echo $po_emer_dat->ItemName; ?></td>
										<td><?php echo $po_emer_dat->podate; ?></td>		
										<td><?php echo date('d-m-Y', strtotime($po_emer_dat->ExpiredDate)); ?></td>								
										<td><?php echo $po_emer_dat->QtyOnHand; ?></td>
										<td><?php echo number_format($po_emer_dat->PurchasePrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($po_emer_dat->TotalPurchase, 0, ',', '.'); ?></td>										
										<td><?php echo $po_emer_dat->storeName; ?></td>
										<td><?php echo $po_emer_dat->UomSell; ?></td>
										<td><?php echo $po_emer_dat->SuppName; ?></td>
										<td><?php echo $po_emer_dat->Manufactures; ?></td>
										</tr>
										<?php } ?>
										</tbody>
								</table>	


<?php }  else //Consumables
    if ($pharmacy_page == "consumables") { ?>	

	<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill Date</th>
												  <th>Prescription No.</th>
												  <th>Barcode</th>
												  <th>Item Code</th>
												  <th>Item Name</th>
												  <th>Qty</th>
												  <th>UOMSales</th>
												  <th>Patient Name</th>	
												  <th>Doctor Name</th>								  													  
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
        foreach ($consumables_data as $consumables) {
            $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $consumables->billdate; ?></td>
										<td><?php echo $consumables->Prescription; ?></td>
										<td><?php echo $consumables->Barcode; ?></td>
										<td><?php echo $consumables->itemcode; ?></td>
										<td><?php echo $consumables->ItemName; ?></td>
										<td><?php echo $consumables->Qty; ?></td>										
										<td><?php echo $consumables->UoMSales; ?></td>
										<td><?php echo $consumables->patientName; ?></td>	
										<td><?php echo $consumables->DoctorName; ?></td>											
										</tr>
										<?php } ?>
										</tbody>
										
								</table>
<?php } else //Narcotic
    if ($pharmacy_page == "narcotic") { ?>	

	<table class="table table-bordered" id="finance_docgrid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Date</th>	
												  <th>Prescription/IMR No</th>
												  <th>Barcode No</th>
												  <th>ItemCode</th>
												  <th>Item Name</th>
												  <th>Prepartion Form</th>
												  <th>Quantity</th>
												  <th>UoM Sales</th>	
												  <th>Patient Name</th>
												  <th>Patient Address</th>												  													  
												  <th>Doctor's Name</th>												  													  
												  <th>Doctor's Address</th>												  													  
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
        foreach ($narcotic_data as $narcotic) {
            $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $narcotic->billdate; ?></td>
										<td><?php echo $narcotic->Prescription; ?></td>
										<td><?php echo $narcotic->Barcode; ?></td>
										<td><?php echo $narcotic->itemcode; ?></td>
										<td><?php echo $narcotic->ItemName; ?></td>
										<td><?php echo $narcotic->preparationform; ?></td>
										<td><?php echo $narcotic->Qty; ?></td>
										<td><?php echo $narcotic->UoMSales; ?></td>
										<td><?php echo $narcotic->patientName; ?></td>
										<td><?php echo $narcotic->PatientAdress; ?></td>
										<td><?php echo $narcotic->DoctorName; ?></td>
										<td><?php echo $narcotic->doctorAddress; ?></td>
										<?php } ?>
										</tbody>
										
								</table>
<?php } else //Requisition
    if ($pharmacy_page == "requisition") { ?>	

	<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Requested Date</th>	
												  <th>Original Site</th>
												  <th>Site Requested</th>
												  <th>Barcode No</th>
												  <th>ItemCode</th>
												  <th>Item Name</th>
												  <th>Qty Requested</th>
												  <th>Qty Fulfilled</th>	
												  <th>UoM Sales</th>
												  <th> PurchasePricePerItem</th>												  													  
												  <th>TotalPurchase</th>											  													  
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
        foreach ($requisition_data as $requisition) {
            $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $requisition->RequestDate; ?></td>
										<td><?php echo $requisition->OriginalSite; ?></td>
										<td><?php echo $requisition->SiteRequested; ?></td>
										<td><?php echo $requisition->Barcode; ?></td>
										<td><?php echo $requisition->itemcode; ?></td>
										<td><?php echo $requisition->ItemName; ?></td>
										<td><?php echo $requisition->QtyRequested; ?></td>
										<td><?php echo $requisition->QtyFulfilled; ?></td>
										<td><?php echo $requisition->UoMSales; ?></td>
										<td><?php echo $requisition->PurchasePricePerItem; ?></td>
										<td><?php echo $requisition->TotalPurchasePrice; ?></td>
										<?php } ?>
										</tbody>
										
								</table>
<?php }?>																						
</div>

<script>
 $(document).ready(function() {
 
 	TableTools.DEFAULTS.aButtons = [
							"copy",
							"print",
							{
								"sExtends":    "collection",
								"sButtonText": 'Save <span class="caret" />',
								"aButtons":    [ "csv", "xls",
								{
								"sExtends": "pdf",
								"sPdfOrientation": "landscape"
								}
								]
							}
						];
						
    TableTools.DEFAULTS.sSwfPath = "<?php echo $this->config->item('template') .
'TableTools'; ?>/media/swf/copy_csv_xls_pdf.swf";

	var financerep = $('#finance_grid').dataTable({
							"aLengthMenu": [[10, 35, 35, 55, 80,10, 35, 10, 100, -1], [10, 35, 35, 55, 80,10, 35, 10, 100,"All"]],
							"iDisplayLength": 10,
							"sPaginationType": "full_numbers",
							"bAutoWidth": false,
							"sDom": '<"top"i>rt<"bottom"flp><"clear">',
							"sDom": "<T<'span2'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
							"oTableTools": {
							"aButtons": [ "copy","print",
							{
							"sExtends":    "collection",
							"sButtonText": "Save",
							"aButtons":    [ "pdf" ]
							}							
							]
							}
							} );
	
	var finance_docrep = $('#finance_docgrid').dataTable({
							"aLengthMenu": [[-1,25, 50], ["All",25, 50]],							
							"iDisplayLength": 10,
							"sPaginationType": "full_numbers",
							"sScrollY": "400px",
							"sScrollX": "96%",
							"bScrollCollapse": true,
							"bAutoWidth": false,
							"sDom": '<"top"i>rt<"bottom"flp><"clear">',
							"sDom": "<T<'span2'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
							"oTableTools": {
							"aButtons": [ "copy","print",
							{
							"sExtends":    "collection",
							"sButtonText": "Save",
							"aButtons":    [ "pdf" ]
							}							
							]
							}
							} );
    						

	var finance_revenue = $("#finance_revenue_detail").dataTable( {
					"aLengthMenu": [[10,25, 50,100,-1], [10,25,50,100,"All"]],
					"iDisplayLength": 10,
					"sPaginationType": "full_numbers",
					"sScrollY": "400px",
					"sScrollX": "96%",
					"bScrollCollapse": true,
					"bAutoWidth": false,
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli',							
					"oTableTools": {
					"aButtons": [ "copy","print",
							{
							"sExtends":    "collection",
							"sButtonText": "Save",
							"aButtons":    [ "pdf" ]
							}							
							]
							}					
					} ).columnFilter({ sPlaceHolder: "head",
					aoColumns: [ { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },
                                 { type: "select", values: [ 'OPD', 'IPD', 'ETC', 'MCU']},
								 { type: "text" },{ type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },{ type: "number-range" },
								 { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" }

								   
						]
					
					});
    
	});
	
	$("#searchdataagain").show("slow");
	
</script>