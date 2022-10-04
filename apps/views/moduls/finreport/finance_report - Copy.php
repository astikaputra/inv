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

			<?php if ($finance_page == "revenue_all") { ?>								
            <table class="table table-bordered" id="finance_docgrid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill Date</th>	
												  <th>Bill Create Date</th>
												  <th>Bill No.</th>
												  <th>Reg. No.</th>
												  <th>Reg.Time</th>
												  <th>Patient Name</th>
												  <th>Sex</th>
												  <th>Birthdate</th>
												  <th>Age</th>
												  <th>Address</th>
												  <th>ID Types</th>
												  <th>Nationality</th>
												  <th>LOB</th>
												  <th>Doctor Code</th>
												  <th>Doctor Name</th>
												  <th>Ref. Doctor</th>
												  <th>Sub. Specialist</th>
												  <th>Specialist</th>
												  <th>Group Specialist</th>
												  <th>Room</th>
												  <th>Class</th>
												  <th>Item Code</th>
												  <th>Service Code</th>
												  <th>Service Name</th>
												  <th>Service LOS</th>
												  <th>Qty</th>
												  <th>Item Price</th>
												  <th>Bill Amount</th>
												  <th>Payer Amount</th>
												  <th>Doctor Fee</th>
												  <th>Discount</th>
												  <th>Payer Name</th>
												  <th>PayerType</th>
												  <th>Payment Method</th>
												  <th>Status</th>
												  <th>Is Retail</th>
												  <th>Triage</th>
												  <th>Admit Date</th>
												  <th>PaymentStatus</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
    foreach ($revenue_all_data as $revenues) {
        $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->billdate)); ?></td>
										<td><?php echo date('d-m-Y H:i:s', strtotime($revenues->
        Billcreateddate)); ?></td>
										<td><?php echo $revenues->BillNo; ?></td>
										<td><?php echo $revenues->RegistCode; ?></td>
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
										<td><?php echo number_format($revenues->ItemPrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->BillAmount, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->PayerAmount, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->DoctorFee, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->Discount, 0, ',', '.'); ?></td>
										<td><?php echo $revenues->PayerName; ?></td>	
										<td><?php echo $revenues->PayerType; ?></td>
										<td><?php echo $revenues->PaymentMethod; ?></td>
										<td><?php echo $revenues->Status; ?></td>
										<td><?php echo $revenues->IsRetail; ?></td>
										<td><?php echo $revenues->Triage; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->AdmitDate)); ?></td>
										<td><?php echo $revenues->PaymentStatus; ?></td>										
										<?php } ?>
										</tbody>
										
								</table>
	<?php } else
    if ($finance_page == "revenue_lob") { ?>								
            <table class="table table-bordered" id="finance_docgrid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill Date</th>	
												  <th>Bill Create Date</th>
												  <th>Bill No.</th>
												  <th>Reg. No.</th>
												  <th>Reg.Time</th>
												  <th>Patient Name</th>
												  <th>Sex</th>
												  <th>Birthdate</th>
												  <th>Age</th>
												  <th>Address</th>
												  <th>ID Types</th>
												  <th>Nationality</th>
												  <th>LOB</th>
												  <th>Doctor Code</th>
												  <th>Doctor Name</th>
												  <th>Ref. Doctor</th>
												  <th>Sub. Specialist</th>
												  <th>Specialist</th>
												  <th>Group Specialist</th>
												  <th>Room</th>
												  <th>Class</th>
												  <th>Item Code</th>
												  <th>Service Code</th>
												  <th>Service Name</th>
												  <th>Service LOS</th>
												  <th>Qty</th>
												  <th>Item Price</th>
												  <th>Bill Amount</th>
												  <th>Payer Amount</th>
												  <th>Doctor Fee</th>
												  <th>Discount</th>
												  <th>Payer Name</th>
												  <th>PayerType</th>
												  <th>Payment Method</th>
												  <th>Status</th>
												  <th>Is Retail</th>
												  <th>Triage</th>
												  <th>Admit Date</th>
												  <th>PaymentStatus</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
    foreach ($revenue_lob_data as $revenues) {
        $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->billdate)); ?></td>
										<td><?php echo date('d-m-Y H:i:s', strtotime($revenues->
        Billcreateddate)); ?></td>
										<td><?php echo $revenues->BillNo; ?></td>
										<td><?php echo $revenues->RegistCode; ?></td>
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
										<td><?php echo number_format($revenues->ItemPrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->BillAmount, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->PayerAmount, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->DoctorFee, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->Discount, 0, ',', '.'); ?></td>
										<td><?php echo $revenues->PayerName; ?></td>	
										<td><?php echo $revenues->PayerType; ?></td>
										<td><?php echo $revenues->PaymentMethod; ?></td>
										<td><?php echo $revenues->Status; ?></td>
										<td><?php echo $revenues->IsRetail; ?></td>
										<td><?php echo $revenues->Triage; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->AdmitDate)); ?></td>
										<td><?php echo $revenues->PaymentStatus; ?></td>										
										<?php } ?>
										</tbody>
										
								</table>
       	<?php } else
    if ($finance_page == "revenue_los") { ?>								
            <table class="table table-bordered" id="finance_docgrid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill Date</th>	
												  <th>Bill Create Date</th>
												  <th>Bill No.</th>
												  <th>Reg. No.</th>
												  <th>Reg.Time</th>
												  <th>Patient Name</th>
												  <th>Sex</th>
												  <th>Birthdate</th>
												  <th>Age</th>
												  <th>Address</th>
												  <th>ID Types</th>
												  <th>Nationality</th>
												  <th>LOB</th>
												  <th>Doctor Code</th>
												  <th>Doctor Name</th>
												  <th>Ref. Doctor</th>
												  <th>Sub. Specialist</th>
												  <th>Specialist</th>
												  <th>Group Specialist</th>
												  <th>Room</th>
												  <th>Class</th>
												  <th>Item Code</th>
												  <th>Service Code</th>
												  <th>Service Name</th>
												  <th>Service LOS</th>
												  <th>Qty</th>
												  <th>Item Price</th>
												  <th>Bill Amount</th>
												  <th>Payer Amount</th>
												  <th>Doctor Fee</th>
												  <th>Discount</th>
												  <th>Payer Name</th>
												  <th>PayerType</th>
												  <th>Payment Method</th>
												  <th>Status</th>
												  <th>Is Retail</th>
												  <th>Triage</th>
												  <th>Admit Date</th>
												  <th>PaymentStatus</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
    foreach ($revenue_los_data as $revenues) {
        $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->billdate)); ?></td>
										<td><?php echo date('d-m-Y H:i:s', strtotime($revenues->
        Billcreateddate)); ?></td>
										<td><?php echo $revenues->BillNo; ?></td>
										<td><?php echo $revenues->RegistCode; ?></td>
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
										<td><?php echo number_format($revenues->ItemPrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->BillAmount, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->PayerAmount, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->DoctorFee, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->Discount, 0, ',', '.'); ?></td>
										<td><?php echo $revenues->PayerName; ?></td>	
										<td><?php echo $revenues->PayerType; ?></td>
										<td><?php echo $revenues->PaymentMethod; ?></td>
										<td><?php echo $revenues->Status; ?></td>
										<td><?php echo $revenues->IsRetail; ?></td>
										<td><?php echo $revenues->Triage; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->AdmitDate)); ?></td>
										<td><?php echo $revenues->PaymentStatus; ?></td>										
										<?php } ?>
										</tbody>
										
								</table>
       	<?php } else
    if ($finance_page == "revenue_spes") { ?>								
            <table class="table table-bordered" id="finance_docgrid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill Date</th>	
												  <th>Bill Create Date</th>
												  <th>Bill No.</th>
												  <th>Reg. No.</th>
												  <th>Reg.Time</th>
												  <th>Patient Name</th>
												  <th>Sex</th>
												  <th>Birthdate</th>
												  <th>Age</th>
												  <th>Address</th>
												  <th>ID Types</th>
												  <th>Nationality</th>
												  <th>LOB</th>
												  <th>Doctor Code</th>
												  <th>Doctor Name</th>
												  <th>Ref. Doctor</th>
												  <th>Sub. Specialist</th>
												  <th>Specialist</th>
												  <th>Group Specialist</th>
												  <th>Room</th>
												  <th>Class</th>
												  <th>Item Code</th>
												  <th>Service Code</th>
												  <th>Service Name</th>
												  <th>Service LOS</th>
												  <th>Qty</th>
												  <th>Item Price</th>
												  <th>Bill Amount</th>
												  <th>Payer Amount</th>
												  <th>Doctor Fee</th>
												  <th>Discount</th>
												  <th>Payer Name</th>
												  <th>PayerType</th>
												  <th>Payment Method</th>
												  <th>Status</th>
												  <th>Is Retail</th>
												  <th>Triage</th>
												  <th>Admit Date</th>
												  <th>PaymentStatus</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
    foreach ($revenue_spes_data as $revenues) {
        $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->billdate)); ?></td>
										<td><?php echo date('d-m-Y H:i:s', strtotime($revenues->
        Billcreateddate)); ?></td>
										<td><?php echo $revenues->BillNo; ?></td>
										<td><?php echo $revenues->RegistCode; ?></td>
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
										<td><?php echo number_format($revenues->ItemPrice, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->BillAmount, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->PayerAmount, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->DoctorFee, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->Discount, 0, ',', '.'); ?></td>
										<td><?php echo $revenues->PayerName; ?></td>	
										<td><?php echo $revenues->PayerType; ?></td>
										<td><?php echo $revenues->PaymentMethod; ?></td>
										<td><?php echo $revenues->Status; ?></td>
										<td><?php echo $revenues->IsRetail; ?></td>
										<td><?php echo $revenues->Triage; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->AdmitDate)); ?></td>
										<td><?php echo $revenues->PaymentStatus; ?></td>										
										<?php } ?>
										</tbody>
										
								</table>
			<?php } else
    if ($finance_page == "revenue_prodia") { ?>
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
        if ($finance_page == "material_cost_drugs") { ?>
								<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill Date</th>
												  <th>Transaction Date</th>	
												  <th>MR Number</th>
												  <th>Registration No.</th>
												  <th>Biling No.</th>
												  <th>Patient Name</th>
												  <th>Doctor Name</th>
												  <th>Item Code</th>
												  <th>Item Desc</th>
												  <th>Quantity</th>
												  <th>UoM</th>
												  <th>Cost / UoM</th>
												  <th>Total Cost</th>
												  <th>Total Revenue</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
            foreach ($material_cost_data as $revenues) {
                $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->billdate)); ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->UpdatedDate)); ?></td>
										<td><?php echo $revenues->medicalrecordnumber; ?></td>
										<td><?php echo $revenues->RegNo; ?></td>
										<td><?php echo $revenues->BilNo; ?></td>
										<td><?php echo $revenues->patientname; ?></td>
										<td><?php echo $revenues->doctorname; ?></td>
										<td><?php echo $revenues->Itemcode; ?></td>
										<td><?php echo $revenues->ItemName; ?></td>		
										<td><?php echo $revenues->qty; ?></td>
										<td><?php echo $revenues->UoM; ?></td>
										<td><?php echo number_format($revenues->ItemCostUom, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->TotalCost, 0, ',', '.'); ?></td>										
										<td><?php echo number_format($revenues->TotalRevenue, 0, ',', '.'); ?></td>
										<?php } ?>
										</tbody>
										
								</table>
			 <?php } else
            if ($finance_page == "medical_cost_supplies") { ?>
			 								<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill Date</th>
												  <th>Transaction Date</th>	
												  <th>MR Number</th>
												  <th>Registration No.</th>
												  <th>Biling No.</th>
												  <th>Patient Name</th>
												  <th>Doctor Name</th>
												  <th>Item Code</th>
												  <th>Item Desc</th>
												  <th>Quantity</th>
												  <th>UoM</th>
												  <th>Cost / UoM</th>
												  <th>Total Cost</th>
												  <th>Total Revenue</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
                foreach ($medical_cost_data as $revenues) {
                    $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->billdate)); ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->UpdateDate)); ?></td>
										<td><?php echo $revenues->medicalrecordnumber; ?></td>
										<td><?php echo $revenues->RegNo; ?></td>
										<td><?php echo $revenues->BilNo; ?></td>
										<td><?php echo $revenues->patientname; ?></td>
										<td><?php echo $revenues->doctorname; ?></td>
										<td><?php echo $revenues->Itemcode; ?></td>
										<td><?php echo $revenues->ItemName; ?></td>		
										<td><?php echo $revenues->qty; ?></td>
										<td><?php echo $revenues->UoM; ?></td>
										<td><?php echo number_format($revenues->ItemCostUom, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->TotalCost, 0, ',', '.'); ?></td>										
										<td><?php echo number_format($revenues->TotalRevenue, 0, ',', '.'); ?></td>
										<?php } ?>
										</tbody>
										
								</table>
			<?php } else
                if ($finance_page == "non_chargeable_items") { ?>
		 								<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Record Number</th>
												  <th>Store Name</th>	
												  <th>Record Date</th>
												  <th>Barcode</th>
												  <th>Item Name</th>
												  <th>Quantity</th>
												  <th>UOM</th>
												  <th>Amount (Rp.)</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
                    foreach ($non_chargeable_data as $revenues) {
                        $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $revenues->RecordNumber; ?></td>
										<td><?php echo $revenues->NameValue; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->RecordDate)); ?></td>
										<td><?php echo $revenues->barcode; ?></td>
										<td><?php echo $revenues->ItemName; ?></td>
										<td><?php echo $revenues->Qty; ?></td>
										<td><?php echo $revenues->UOM; ?></td>
										<td><?php echo number_format($revenues->Amount, 0, ',', '.'); ?></td>
										<?php } ?>
										</tbody>
										
								</table>
			<?php } else
                    if ($finance_page == "doctor_fee") { ?>
		 								<table class="table table-bordered" id="finance_docgrid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Registration No.</th>
												  <th>Bill Date</th>	
												  <th>Bill No.</th>
												  <th>Doctor Code</th>
												  <th>Doctor Name</th>
												  <th>Specialization</th>
												  <th>Time</th>
												  <th>LOB</th>
												  <th>Class</th>
												  <th>Room</th>
												  <th>Patient Name</th>
												  <th>Item Code</th>
												  <th>Service Item</th>
												  <th>Total Material</th>
												  <th>Total Doctor Fee</th>
												  <th>Total All</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
                        foreach ($doctor_fee_data as $revenues) {
                            $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $revenues->registcode; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->billdate)); ?></td>
										<td><?php echo $revenues->billno; ?></td>
										<td><?php echo $revenues->axdoctorcode; ?></td>
										<td><?php echo $revenues->DoctorName; ?></td>
										<td><?php echo $revenues->specialistname; ?></td>
										<td><?php echo date('H:i:s', strtotime($revenues->createddate)); ?></td>
										<td><?php echo $revenues->LOB; ?></td>
										<td><?php echo $revenues->marginclass; ?></td>
										<td><?php echo $revenues->ROOM; ?></td>
										<td><?php echo $revenues->patientname; ?></td>
										<td><?php echo $revenues->servicecode; ?></td>
										<td><?php echo $revenues->servicename; ?></td>								
										<td><?php echo number_format($revenues->TOTALMaterialCost, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->TOTALDoctorFee, 0, ',', '.'); ?></td>
										<td><?php echo number_format($revenues->Total, 0, ',', '.'); ?></td>
										<?php } ?>
										</tbody>
										
								</table>
			<?php } else
                        if ($finance_page == "revenue_summary") { ?>	
		 								<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Patient Name.</th>
												  <th>Registration Code</th>	
												  <th>Bill No.</th>
												  <th>Bill Date</th>
												  <th>Ammount</th>
												  <th>Payment Method</th>
												  <th>Payer Type</th>
												  <th>Payer Name</th>
												  <th>Bill Status</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
                            foreach ($doctor_fee_data as $revenues) {
                                $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $revenues->patientName; ?></td>
										<td><?php echo $revenues->RegistCode; ?></td>
										<td><?php echo $revenues->BillNo; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->billdate)); ?></td>
										<td><?php echo number_format($revenues->Amount, 0, ',', '.'); ?></td>
										<td><?php echo $revenues->PaymentMethod; ?></td>
										<td><?php echo $revenues->payertype; ?></td>
										<td><?php echo $revenues->Payername; ?></td>
										<td><?php echo $revenues->BillStatus; ?></td>							
										<?php } ?>
										</tbody>
										
								</table>	
			<?php } else
                        if ($finance_page == "room_clasify") { ?>	
		 								<table class="table table-bordered" id="finance_grid"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Patient Name.</th>
												  <th>Registration Code</th>	
												  <th>Bill No.</th>
												  <th>Bill Date</th>
												  <th>Ammount</th>
												  <th>Payment Method</th>
												  <th>Payer Type</th>
												  <th>Payer Name</th>
												  <th>Bill Status</th>
												</tr>
											 </thead>
										<tbody>
										<?php $i = 0;
                            foreach ($room_clasify_data as $revenues) {
                                $i++; ?>
										<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $revenues->patientName; ?></td>
										<td><?php echo $revenues->RegistCode; ?></td>
										<td><?php echo $revenues->BillNo; ?></td>
										<td><?php echo date('d-m-Y', strtotime($revenues->billdate)); ?></td>
										<td><?php echo number_format($revenues->Amount, 0, ',', '.'); ?></td>
										<td><?php echo $revenues->PaymentMethod; ?></td>
										<td><?php echo $revenues->payertype; ?></td>
										<td><?php echo $revenues->Payername; ?></td>
										<td><?php echo $revenues->BillStatus; ?></td>							
										<?php } ?>
										</tbody>
										
								</table>	
								
			<?php } ?>
			 </div>
	   
	    </div>
		  	<div class="row" align="right">
	  		<a href="<?php echo base_url() . 'tools'; ?>" class="btn btn-success">Back To Main Menu</a>
			</div>
	  </div>
			
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