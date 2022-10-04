<div class="container-fluid">
<h3>Doctors Report From <?php echo date('d M Y',strtotime($startdate)); ?> Until <?php echo date('d M Y',strtotime($enddate));?> </h3>
<div class="well">

<div class="accordion" id="datadoctor">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn btn-primary" data-toggle="collapse" data-parent="#datadoctor" href="#summary">
         <b>Summary</b>
      </a>
    </div>
    <div id="summary" class="accordion-body collapse in">
      <div class="accordion-inner">
	  <div class="row-fluid">
		<div class="span6">
		<h4><?php echo $hospital_name;?> Doctors Summary Report </h4>
		<div class="alert alert-info">
		<h4>Total Doctor Visit To All Patient : <?php echo $total_doctor;?> Visits</h4>
		<br />
			<div class="progress progress-info progress-striped">
				OPD <div class="bar" style="width: <?php echo $total_doctor_opd/($total_doctor+1)*100;?>%;"><?php echo $total_doctor_opd;?> Visits</div>
			</div>
			<div class="progress progress-success progress-striped">
				IPD <div class="bar" style="width: <?php echo $total_doctor_ipd/($total_doctor+1)*100;?>%;"><?php echo $total_doctor_ipd;?> Visits</div>
			</div>
			<div class="progress progress-warning progress-striped">
				ETC<div class="bar" style="width: <?php echo $total_doctor_etc/($total_doctor+1)*100;?>%;"><?php echo $total_doctor_etc;?> Visits</div>
			</div>
			<div class="progress progress-striped">
				MCU<div class="bar" style="width: <?php echo $total_doctor_mcu/($total_doctor+1)*100;?>%;"><?php echo $total_doctor_mcu;?> Visits</div>
			</div>
        <br />
        <h4>Doctor Visits To New Patient Summary</h4>
		<br />
			<div class="progress progress-info progress-striped">
				OPD <div class="bar" style="width: <?php echo $totalnew_patient_opd/($total_new_patient+1)*100;?>%;"><?php echo $totalnew_patient_opd;?> Patient Visits</div>
			</div>
			<div class="progress progress-success progress-striped">
				IPD <div class="bar" style="width: <?php echo $totalnew_patient_ipd/($total_new_patient+1)*100;?>%;"><?php echo $totalnew_patient_ipd;?> Patient Visits</div>
			</div>			
			<div class="progress progress-warning progress-striped">
				ETC<div class="bar" style="width: <?php echo $totalnew_patient_etc/($total_new_patient+1)*100;?>%;"><?php echo $totalnew_patient_etc;?> Patient Visits</div>
			</div>
			<div class="progress progress-striped">
				MCU<div class="bar" style="width: <?php echo $totalnew_patient_mcu/($total_new_patient+1)*100;?>%;"><?php echo $totalnew_patient_mcu;?> Patient Visits</div>
			</div>
        <br />
		<h4>Doctor Visits To Old Patient Summary</h4>
		<br />
			<div class="progress progress-info progress-striped">
				OPD <div class="bar" style="width: <?php echo $totalold_patient_opd/($total_old_patient+1)*100;?>%;"><?php echo $totalold_patient_opd;?> Patient Visits</div>
			</div>
			<div class="progress progress-success progress-striped">
				IPD <div class="bar" style="width: <?php echo $totalold_patient_ipd/($total_old_patient+1)*100;?>%;"><?php echo $totalold_patient_ipd;?> Patient Visits</div>
			</div>	
			<div class="progress progress-warning progress-striped">
				ETC<div class="bar" style="width: <?php echo $totalold_patient_etc/($total_old_patient+1)*100;?>%;"><?php echo $totalold_patient_etc;?> Patient Visits</div>
			</div>
			<div class="progress progress-striped">
				MCU<div class="bar" style="width: <?php echo $totalold_patient_mcu/($total_old_patient+1)*100;?>%;"><?php echo $totalold_patient_mcu;?> Patient Visits</div>
			</div>

		</div>
        </div>

		<!-- Detailed Data-->
		<div class="span6">
        <h4 style="text-align: center;">Top 10 Doctor Visits</h4>
            <table class="table table-bordered" >
            <thead>
		  <tr>
			<th>Doctor Name</th><th>Total Visits</th>
          </tr>
	       </thead>
	       <tbody>
            <?php                 
            foreach($top_10_doctor as $top_10)
            {
            echo '<tr>';                                
            echo '<td>'.$top_10->DoctorName.'</td>';
            echo '<td>'.$top_10->TotalPatient.'</td>';
            echo '</tr>';                                
            };?>
            </tbody>
            </table>
		</div>
		
     	<div class="span6">
        <h4 style="text-align: center;">Top 10 General Practitioner Doctor Visits</h4>
            <table class="table table-bordered" >
            <thead>
		  <tr>
			<th>Doctor Name</th><th>Total Visits</th>
          </tr>
	       </thead>
	       <tbody>
            <?php                 
            foreach($top_10_doctor_general as $top_10_gen)
            {
            echo '<tr>';                                
            echo '<td>'.$top_10_gen->DoctorName.'</td>';
            echo '<td>'.$top_10_gen->TotalPatient.'</td>';
            echo '</tr>';                                
            };?>
            </tbody>
            </table>
		</div>   
        </div>
        </div>
        </div>
        </div>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle btn btn-info" data-toggle="collapse" data-parent="#summary" href="#totalvisits">
        <b>Detail Total Doctor Visit By LOB</b>
      </a>
    </div>
    <div id="totalvisits" class="accordion-body collapse">
      <div class="accordion-inner">
<div class="row-fluid">     
<div class="span12">

<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#daily1" data-toggle="tab">Daily OPD Total Patient Visit</a></li>
	<li><a href="#daily2" data-toggle="tab">Daily IPD Total Patient Visit</a></li>
    <li><a href="#daily3" data-toggle="tab">Daily ETC Total Patient Visit</a></li>
    <li><a href="#daily4" data-toggle="tab">Daily MCU Total Patient Visit</a></li>
  </ul>

 <div class="tab-content">
    <div id="daily1" class="tab-pane active">
    <table class="table table-striped table-bordered" >
        <thead>
		<tr>
			<th>Doctor Name</th><th>LOB</th><th>Specialist Group</th><th>Specialist</th><th>Sub Specialist</th><th>Total Patient</th>
		</tr>
	</thead>
	<tbody>
   <?php $total_patient = 0;                 
    foreach($doctor_opd->result() as $opd_total)
    {
	$total_patient = $total_patient+$opd_total->TotalPatient;
    echo '<tr>';                                
    echo '<td><b>'.$opd_total->DoctorName.'</b></td>';
    echo '<td>'.$opd_total->LOB.'</td>';
    echo '<td>'.$opd_total->SpecialistGroup.'</td>';
    echo '<td>'.$opd_total->Specialist.'</td>';
    echo '<td>'.$opd_total->SubSpecialist.'</td>';
    echo '<td>'.$opd_total->TotalPatient.'</td>';
    echo '</tr>';                                
    };?>
    <br />
    <tr class="active"><td style="font-size: 20px;"><b>Total Visits</b></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-size: 20px;"><b><?php echo $total_patient;?></b></td>
    </tr>
	</tbody>
</table>
</div>

  <div id="daily2" class="tab-pane">
    <table class="table table-striped table-bordered" >
        <thead>
		<tr>
			<th>Doctor Name</th><th>LOB</th><th>Specialist Group</th><th>Specialist</th><th>Sub Specialist</th><th>Total Patient</th>
		</tr>
	</thead>
	<tbody>
   <?php $total_patient = 0;                 
    foreach($doctor_ipd->result() as $ipd_total)
    {
	$total_patient = $total_patient+$ipd_total->TotalPatient;
    echo '<tr>';                                
    echo '<td><b>'.$ipd_total->DoctorName.'</b></td>';
    echo '<td>'.$ipd_total->LOB.'</td>';
    echo '<td>'.$ipd_total->SpecialistGroup.'</td>';
    echo '<td>'.$ipd_total->Specialist.'</td>';
    echo '<td>'.$ipd_total->SubSpecialist.'</td>';
    echo '<td>'.$ipd_total->TotalPatient.'</td>';
    echo '</tr>';                                
    };?>
    <br />
    <tr class="active"><td style="font-size: 20px;"><b>Total Visits</b></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-size: 20px;"><b><?php echo $total_patient;?></b></td>
    </tr>
	</tbody>
</table>
</div>

<div id="daily3" class="tab-pane">
<table class="table table-striped table-bordered" >
        <thead>
		<tr>
			<th>Doctor Name</th><th>LOB</th><th>Specialist Group</th><th>Specialist</th><th>Sub Specialist</th><th>Total Patient</th>
		</tr>
	</thead>
              <tbody> 
   <?php $total_patient = 0;                 
    foreach($doctor_etc->result() as $etc_total)
    {
	$total_patient = $total_patient+$etc_total->TotalPatient;
    echo '<tr>';                                
    echo '<td><b>'.$etc_total->DoctorName.'</b></td>';
    echo '<td>'.$etc_total->LOB.'</td>';
    echo '<td>'.$etc_total->SpecialistGroup.'</td>';
    echo '<td>'.$etc_total->Specialist.'</td>';
    echo '<td>'.$etc_total->SubSpecialist.'</td>';    
    echo '<td>'.$etc_total->TotalPatient.'</td>';
    echo '</tr>';                                
    };?>
    <tr class="active"><td style="font-size: 20px;"><b>Total Visits</b></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-size: 20px;"><b><?php echo $total_patient;?></td>
    </tr>
			</tbody>
            </table>       
</div>

<div id="daily4" class="tab-pane">
<table class="table table-striped table-bordered" >
        <thead>
		<tr>
			<th>Doctor Name</th><th>LOB</th><th>Specialist Group</th><th>Specialist</th><th>Sub Specialist</th><th>Total Patient</th>
		</tr>
	</thead>
              <tbody> 
   <?php $total_patient = 0;                 
    foreach($doctor_mcu->result() as $mcu_total)
    {
	$total_patient = $total_patient+$mcu_total->TotalPatient;
    echo '<tr>';                                
    echo '<td><b>'.$mcu_total->DoctorName.'</b></td>';
    echo '<td>'.$mcu_total->LOB.'</td>';
    echo '<td>'.$mcu_total->SpecialistGroup.'</td>';
    echo '<td>'.$mcu_total->Specialist.'</td>';
    echo '<td>'.$mcu_total->SubSpecialist.'</td>'; 
    echo '<td>'.$mcu_total->TotalPatient.'</td>';
    echo '</tr>';                                
    };?>
    <tr class="active"><td style="font-size: 20px;"><b>Total Visits</b></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-size: 20px;"><b><?php echo $total_patient;?></b></td>
    </tr>
			</tbody>
            </table>       
</div>

</div>

</div>
</div>
</div>
</div>
</div>
</div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle btn btn-warning" data-toggle="collapse" data-parent="#summary" href="#dailyreg">
        <b>Detail Total Doctor Visit By Patient Registration</b>
      </a>
    </div>
    <div id="dailyreg" class="accordion-body collapse">
      <div class="accordion-inner">     
<div class="row-fluid">     
<div class="span12">

<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#daily11" data-toggle="tab">Daily OPD Patient Detail</a></li>
	<li><a href="#daily12" data-toggle="tab">Daily IPD Patient Detail</a></li>
    <li><a href="#daily13" data-toggle="tab">Daily ETC Patient Detail</a></li>
    <li><a href="#daily14" data-toggle="tab">Daily MCU Patient Detail</a></li>
  </ul>

 <div class="tab-content">
<div id="daily11" class="tab-pane active">
<table class="table table-striped table-bordered" >
        <thead>
		<tr>
			<th>Registration Number</th><th>MR Number</th><th>Patient Name</th><th>LOB</th><th>Gender</th><th>Age</th><th>Patients Type</th><th>Patients Class</th><th>SubSpecialist</th><th>DoctorName</th><th>Diagnosis</th><th>Registration Time</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($opd_patient_detail as $opd_patient) 
			  {?>
              <tr>
              <td><?php echo $opd_patient->RegistrationCode;?></td>
              <td><?php echo $opd_patient->MedicalRecordNumber;?></td>
              <td><?php echo $opd_patient->PatientName;?></td>
              <td><?php echo $opd_patient->LOB;?></td>
              <td><?php echo $opd_patient->Gender;?></td>
              <td><?php echo $opd_patient->Age;?></td>
              <td><a class='<?php if($opd_patient->PatientsDescription=='New Patient')
											{echo 'btn btn-primary disabled';}
										else if($opd_patient->PatientsDescription=='Old Patient')
											{echo 'btn btn-inverse disabled';}
											?>'><?php echo $opd_patient->PatientsDescription;?></a></td>
             <td><?php echo $opd_patient->PatientsCategory;?></td>
             <td><?php echo $opd_patient->SubSpecialist;?></td>
             <td><b><?php echo $opd_patient->DoctorName;?></b></td>
             <td><?php echo $opd_patient->AdmissionDiagnosis;?></td>
	         <td><?php echo date('d-m-Y H:i:s',strtotime($opd_patient->RegistrationTime));?></td>
            </tr>                                
    <?php }?>
	</tbody>
</table>
</div>

    <div id="daily12" class="tab-pane">
<table class="table table-striped table-bordered" >
        <thead>
		<tr>
			<th>Registration Number</th><th>MR Number</th><th>Patient Name</th><th>LOB</th><th>Gender</th><th>Age</th><th>Patients Type</th><th>Patients Class</th><th>SubSpecialist</th><th>DoctorName</th><th>Diagnosis</th><th>Create Date</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($ipd_patient_detail as $ipd_patient) 
			  {?>
              <tr>
              <td><?php echo $ipd_patient->RegistrationCode;?></td>
              <td><?php echo $ipd_patient->MedicalRecordNumber;?></td>
              <td><?php echo $ipd_patient->PatientName;?></td>
              <td><?php echo $ipd_patient->LOB;?></td>
              <td><?php echo $ipd_patient->Gender;?></td>
              <td><?php echo $ipd_patient->Age;?></td>
              <td><a class='<?php if($ipd_patient->PatientsDescription=='New Patient')
											{echo 'btn btn-primary disabled';}
										else if($ipd_patient->PatientsDescription=='Old Patient')
											{echo 'btn btn-inverse disabled';}
											?>'><?php echo $ipd_patient->PatientsDescription;?></a></td>
                <td><?php echo $ipd_patient->PatientsCategory;?></td>
    <td><?php echo $ipd_patient->SubSpecialist;?></td>
    <td><b><?php echo $ipd_patient->DoctorName;?></b></td>
    <td><?php echo $ipd_patient->AdmissionDiagnosis;?></td>
	<td><?php echo date('d-m-Y H:i:s',strtotime($ipd_patient->CreatedDate));?></td>	
    </tr>                                
    <?php }?>
	</tbody>
</table>
</div>

    <div id="daily13" class="tab-pane">
<table class="table table-striped table-bordered" >
        <thead>
		<tr>
			<th>Registration Number</th><th>MR Number</th><th>Patient Name</th><th>LOB</th><th>Gender</th><th>Age</th><th>Patients Type</th><th>Patients Class</th><th>SubSpecialist</th><th>DoctorName</th><th>Diagnosis</th><th>Registration Time</th>
		</tr>
	</thead>
	<tbody>
    <?php foreach($etc_patient_detail as $etc_patient) 
			  {?>
              <tr>
              <td><?php echo $etc_patient->RegistrationCode;?></td>
              <td><?php echo $etc_patient->MedicalRecordNumber;?></td>
              <td><?php echo $etc_patient->PatientName;?></td>
              <td><?php echo $etc_patient->LOB;?></td>
              <td><?php echo $etc_patient->Gender;?></td>
              <td><?php echo $etc_patient->Age;?></td>
              <td><a class='<?php if($etc_patient->PatientsDescription=='New Patient')
											{echo 'btn btn-primary disabled';}
										else if($etc_patient->PatientsDescription=='Old Patient')
											{echo 'btn btn-inverse disabled';}
											?>'><?php echo $etc_patient->PatientsDescription;?></a></td>
                <td><?php echo $etc_patient->PatientsCategory;?></td>
    <td><?php echo $etc_patient->SubSpecialist;?></td>
    <td><b><?php echo $etc_patient->DoctorName;?></b></td>
    <td><?php echo $etc_patient->AdmissionDiagnosis;?></td>
	<td><?php echo date('d-m-Y H:i:s',strtotime($etc_patient->RegistrationTime));?></td>
    </tr>                                
    <?php }?>
	</tbody>
</table>
</div>

    <div id="daily14" class="tab-pane">
<table class="table table-striped table-bordered" >
        <thead>
		<tr>
			<th>Registration Number</th><th>MR Number</th><th>Patient Name</th><th>LOB</th><th>Gender</th><th>Age</th><th>Patients Type</th><th>Patients Class</th><th>SubSpecialist</th><th>DoctorName</th><th>Package Name</th><th>Registration Time</th>
		</tr>
	</thead>
	<tbody>
    <?php foreach($mcu_patient_detail as $mcu_patient) 
			  {?>
              <tr>
              <td><?php echo $mcu_patient->RegistrationCode;?></td>
              <td><?php echo $mcu_patient->MedicalRecordNumber;?></td>
              <td><?php echo $mcu_patient->PatientName;?></td>
              <td><?php echo $mcu_patient->LOB;?></td>
              <td><?php echo $mcu_patient->Gender;?></td>
              <td><?php echo $mcu_patient->Age;?></td>
              <td><a class='<?php if($mcu_patient->PatientsDescription=='New Patient')
											{echo 'btn btn-primary disabled';}
										else if($mcu_patient->PatientsDescription=='Old Patient')
											{echo 'btn btn-inverse disabled';}
											?>'><?php echo $mcu_patient->PatientsDescription;?></a></td>
                <td><?php echo $mcu_patient->PatientsCategory;?></td>
    <td><?php echo $mcu_patient->SubSpecialist;?></td>
    <td><b><?php echo $mcu_patient->DoctorName;?></b></td>
    <td><?php echo $mcu_patient->Package;?></td>
	<td><?php echo date('d-m-Y H:i:s',strtotime($mcu_patient->RegistrationTime));?></td>
    </tr>                                
    <?php }?>
	</tbody>
</table>
</div>

</div>

</div>

</div>
</div>
</div>
</div>
</div>		

</div> 
</div>
<div class="span12 back pull-right">
	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Kembali Ke Menu Utama</a>
</div>