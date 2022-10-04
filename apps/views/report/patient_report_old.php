

<div class="container-fluid">
<h3>Patient Report From <?php echo date('d M Y',strtotime($startdate)); ?> Until <?php echo date('d M Y',strtotime($enddate));?> </h3>
<div class="row well">

<div class="accordion" id="datapatient">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn btn-primary" data-toggle="collapse" data-parent="#datapatient" href="#summary">
         <b>Summary</b>
      </a>
    </div>
    <div id="summary" class="accordion-body collapse in">
      <div class="accordion-inner">
	  <div class="row-fluid">
		<div class="span6">
		<h4><?php echo $hospital_name;?> Patients Summary Report </h4>
		<div class="alert alert-info">
		<h4>Total Patients Registration : <?php echo $total_patient;?> Patients</h4>
		<br />
			<div class="progress">
				OPD <div class="bar" style="width: <?php echo $total_patient_opd/($total_patient+1)*100;?>%;"><?php echo $total_patient_opd;?>  Patients</div>
			</div>
			<div class="progress">
				IPD<div class="bar" style="width: <?php echo $total_patient_ipd/($total_patient+1)*100;?>%;"> <?php echo $total_patient_ipd;?>  Patients</div>
			</div>
			<div class="progress">
				ETC<div class="bar" style="width: <?php echo $total_patient_etc/($total_patient+1)*100;?>%;"><?php echo $total_patient_etc;?>  Patients</div>
			</div>
			<div class="progress">
				MCU<div class="bar" style="width: <?php echo $total_patient_mcu/($total_patient+1)*100;?>%;"><?php echo $total_patient_mcu;?> Patients</div>
			</div>
		</div>
		</div>
		<!-- Detailed Data-->
		<div class="span6">
			<div class="tabbable tabs-left">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#pane1" data-toggle="tab">OPD</a></li>
				<li><a href="#pane2" data-toggle="tab">IPD</a></li>
				<li><a href="#pane3" data-toggle="tab">ETC</a></li>
				<li><a href="#pane4" data-toggle="tab">MCU</a></li>
			</ul>
			<div class="tab-content">
				<div id="pane1" class="tab-pane active">
					<h4>Out Patient Departement</h4>
				<div class="alert alert-info">
					Total Registration : <?php echo $total_patient_opd;?> Patients
				</div>
				<div class="progress progress-info">
				<div class="bar" style="width: <?php echo $active_patient_opd->num_rows()/($total_patient_opd+1)*100;?>%"> <?php echo $active_patient_opd->num_rows();?>  Active Patient </div>
				</div>
				<div class="progress progress-success">
					<div class="bar" style="width: <?php echo $closed_patient_opd->num_rows()/($total_patient_opd+1)*100;?>%"> <?php echo $closed_patient_opd->num_rows();?> Closed Patient  </div>
				</div>
				<div class="progress progress-danger">
				<div class="bar" style="width: <?php echo $canceled_patient_opd->num_rows()/($total_patient_opd+1)*100;?>%"> <?php echo $canceled_patient_opd->num_rows();?> Canceled Patient  </div>
				</div>
				</div>
			<div id="pane2" class="tab-pane">
				<h4>In Patient Departement</h4>
								<div class="alert alert-info">
					Total Registration : <?php echo $total_patient_ipd;?> Patients
				</div>
				<div class="progress progress-info">
				<div class="bar" style="width: <?php echo $active_patient_ipd->num_rows()/($total_patient_ipd+1)*100;?>%"> <?php echo $active_patient_ipd->num_rows();?> Active Patient </div>
				</div>
				<div class="progress progress-success">
					<div class="bar" style="width: <?php echo $closed_patient_ipd->num_rows()/($total_patient_ipd+1)*100;?>%">  <?php echo $closed_patient_ipd->num_rows();?> Closed Patient </div>
				</div>
				<div class="progress progress-danger">
				<div class="bar" style="width: <?php echo $canceled_patient_ipd->num_rows()/($total_patient_ipd+1)*100;?>%"> <?php echo $canceled_patient_ipd->num_rows();?> Canceled Patient </div>
				</div>
			</div>
			<div id="pane3" class="tab-pane">
				<h4>Emergency and Trauma Center</h4>
				<div class="alert alert-info">
					Total Registration : <?php echo $total_patient_etc;?> Patients
				</div>
				<div class="progress progress-info">
				<div class="bar" style="width: <?php echo $active_patient_etc->num_rows()/($total_patient_etc+1)*100;?>%"> <?php echo $active_patient_etc->num_rows();?> Active Patient </div>
				</div>
				<div class="progress progress-success">
					<div class="bar" style="width: <?php echo $closed_patient_etc->num_rows()/($total_patient_etc+1)*100;?>%">  <?php echo $closed_patient_etc->num_rows();?> Closed Patient </div>
				</div>
				<div class="progress progress-danger">
				<div class="bar" style="width: <?php echo $canceled_patient_etc->num_rows()/($total_patient_etc+1)*100;?>%"> <?php echo $canceled_patient_etc->num_rows();?> Canceled Patient </div>
				</div>
			</div>
			<div id="pane4" class="tab-pane">
				<h4>Medical Check Up</h4>
				<div class="alert alert-info">
					Total Registration : <?php echo $total_patient_mcu;?> Patients
				</div>
				<div class="progress progress-info">
				<div class="bar" style="width: <?php echo $active_patient_mcu->num_rows()/($total_patient_mcu+1)*100;?>%"> <?php echo $active_patient_mcu->num_rows();?> Active Patient </div>
				</div>
				<div class="progress progress-success">
					<div class="bar" style="width: <?php echo $closed_patient_mcu->num_rows()/($total_patient_mcu+1)*100;?>%">  <?php echo $closed_patient_mcu->num_rows();?> Closed Patient </div>
				</div>
				<div class="progress progress-danger">
				<div class="bar" style="width: <?php echo $canceled_patient_mcu->num_rows()/($total_patient_mcu+1)*100;?>%"> <?php echo $canceled_patient_mcu->num_rows();?> Canceled Patient </div>
				</div>
			</div>
			</div><!-- /.tab-content -->
		</div><!-- /.tabbable -->
		</div>
	</div>
      </div>
  </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn btn-primary" data-toggle="collapse" data-parent="#summary" href="#activepatient">
         <b>Active Patients</b>
      </a>
    </div>
    <div id="activepatient" class="accordion-body collapse">
      <div class="accordion-inner">
         <div class="row-fluid">
			<div class="span12">
			<!-- Data Tab-->
				<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#patientactiveopd" data-toggle="tab">Out Patient Departement (OPD)</a></li>
    <li><a href="#patientactiveipd" data-toggle="tab">In Patient Departement (IPD)</a></li>
    <li><a href="#patientactiveetc" data-toggle="tab">Emergency and Trauma Center(ETC)</a></li>
    <li><a href="#patientactivemcu" data-toggle="tab">Medical Check Up (MCU)</a></li>
  </ul>
  <div class="tab-content">
    <div id="patientactiveopd" class="tab-pane active">
	<table class="table table-striped">
        <thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($active_patient_opd->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
    </table>
    </div>
    <div id="patientactiveipd" class="tab-pane">
		<table class="table table-striped">
		<thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($active_patient_ipd->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
            </table>
    </div>
    <div id="patientactiveetc" class="tab-pane">
			<table class="table table-striped">
			<thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($active_patient_etc->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
            </table>
    </div>
    <div id="patientactivemcu" class="tab-pane">
      <table class="table table-striped">
	  <thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($active_patient_mcu->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
            </table>
    </div>
  </div><!-- /.tab-content -->
</div><!-- /.tabbable -->
			<!-- End Data Tab-->
			</div>
		 </div>
      </div>
  </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle btn btn-success" data-toggle="collapse" data-parent="#summary" href="#closedpatients">
        <b>Closed Patients </b>
      </a>
    </div>
    <div id="closedpatients" class="accordion-body collapse">
      <div class="accordion-inner">
        <div class="row-fluid">
			<div class="span12">
			<!-- Data Tab-->
				<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#patientaclosedopd" data-toggle="tab">Out Patient Departement (OPD)</a></li>
    <li><a href="#patientaclosedipd" data-toggle="tab">In Patient Departement (IPD)</a></li>
    <li><a href="#patientaclosedetc" data-toggle="tab">Emergency and Trauma Center(ETC)</a></li>
    <li><a href="#patientaclosedmcu" data-toggle="tab">Medical Check Up (MCU)</a></li>
  </ul>
  <div class="tab-content">
    <div id="patientaclosedopd" class="tab-pane active">
<table class="table table-striped">
        <thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($closed_patient_opd->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
    </table>
    </div>
    <div id="patientaclosedipd" class="tab-pane">
<table class="table table-striped">
        <thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($closed_patient_ipd->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
    </table>
    </div>
    <div id="patientaclosedetc" class="tab-pane">
<table class="table table-striped">
        <thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($closed_patient_etc->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
    </table>
    </div>
    <div id="patientaclosedmcu" class="tab-pane">
<table class="table table-striped">
        <thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($closed_patient_mcu->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
    </table>
    </div>
  </div><!-- /.tab-content -->
</div><!-- /.tabbable -->
			<!-- End Data Tab-->
			</div>
		 </div>
      </div>
    </div>
  </div>
    <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle btn btn-danger" data-toggle="collapse" data-parent="#summary" href="#canceledpatients">
        <b>Canceled Patients </b>
      </a>
    </div>
    <div id="canceledpatients" class="accordion-body collapse">
      <div class="accordion-inner">
        <div class="row-fluid">
			<div class="span12">
			<!-- Data Tab-->
				<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#patientacanceledopd" data-toggle="tab">Out Patient Departement (OPD)</a></li>
    <li><a href="#patientacanceledipd" data-toggle="tab">In Patient Departement (IPD)</a></li>
    <li><a href="#patientacanceledetc" data-toggle="tab">Emergency and Trauma Center(ETC)</a></li>
    <li><a href="#patientacanceledmcu" data-toggle="tab">Medical Check Up (MCU)</a></li>
  </ul>
  <div class="tab-content">
    <div id="patientacanceledopd" class="tab-pane active">
<table class="table table-striped">
        <thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($canceled_patient_opd->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
    </table>
    </div>
    <div id="patientacanceledipd" class="tab-pane">
<table class="table table-striped">
        <thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($canceled_patient_ipd->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
    </table>
    </div>
    <div id="patientacanceledetc" class="tab-pane">
<table class="table table-striped">
        <thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($canceled_patient_etc->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
    </table>
    </div>
    <div id="patientacanceledmcu" class="tab-pane">
<table class="table table-striped">
        <thead>
                <tr>
                  <th>Registration Code</th><th>MR Number</th><th>LOB</th><th>Patient Name</th><th>Genders</th><th>DateRegistration</th><th>TimeRegistration</th><th>TotalBill</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($canceled_patient_mcu->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->RegistrationCode;?></td>
                  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->Lob;?></td>
				  <td><?php echo $items->PatientsName;?></td>
				  <td><?php echo $items->Genders;?></td>
				  <td><?php echo date('d M Y',strtotime($items->DateRegistration));?></td>
				  <td><?php echo $items->TimeRegistration;?></td>
                  <td><?php echo $items->TotalBill;?></td>
                </tr>
			<?php }?>
			</tbody>
    </table>
    </div>
  </div><!-- /.tab-content -->
</div><!-- /.tabbable -->
			<!-- End Data Tab-->
			</div>
		 </div>
      </div>
    </div>
  </div>
  <div class="row">
	    <div class="span12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Kembali Ke Menu Utama</a>
		</div>
			
			</div>
 </div>


