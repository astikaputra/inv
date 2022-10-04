<style>
.container-fluid
{
background-color:#fff;
}
/* tab color */
.nav-tabs>li>a {
  background-color: #666; 
  border-color: #777777;
  color:#fff;
}

/* active tab color */
.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
  color: #fff;
  background-color: #333333;
  border: 1px solid #888888;
}

/* hover tab color */
.nav-tabs>li>a:hover {
  border-color: #000000;
  background-color: #111111;
}

</style>
 <div class="container-fluid">

			<h3>
			Marketing Report Periode Between <?php echo date('d-m-Y',strtotime($startdate));?> Until <?php echo date('d-m-Y',strtotime($enddate));?>
			</h3>
			<br />
			
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#daily1" data-toggle="tab">My Breast USG</a></li>
	<li><a href="#daily2" data-toggle="tab">My Breast Mammography USG</a></li>
	<li><a href="#daily3" data-toggle="tab">My Brain</a></li>
	<li><a href="#daily4" data-toggle="tab">My Cervix (Pap Smear)</a></li>
	<li><a href="#daily5" data-toggle="tab">CT Cardiac</a></li>
	<li><a href="#daily6" data-toggle="tab">CT Calcium Score</a></li>
  </ul>
  
  <div class="tab-content">
    <div id="daily1" class="tab-pane active"> 
			<h4 class="text-left">Radiology Service Name : My Breast USG</h4>
			<br />
			<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Order Date</th><th>Registration No</th><th>Patient Detail</th><th>Cell-phone No</th><th>Email</th><th>Medical Record</th><th>DOB</th><th>Gender</th><th>Doctor Name</th><th>Notes</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0; 
			  foreach($list_mammae_usg as $items) 
			  { $i++; ?>
				<tr>
				 <td><?php echo $i;?></td>
				  <td><?php echo $items->OrderDate;?></td>
				  <td><?php echo $items->RegistrationNo;?></td>
				  <td><b><?php echo $items->PatientFullName;?></b></td>
                  <td><?php echo $items->PatientPhoneMobile;?></td>
                  <td><?php echo $items->Email;?></td>
				  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo date('Y-m-d',strtotime($items->PatientBirthdate));?></td>
				  <td><?php echo $items->PatientGender;?></td>
				  <td><?php echo $items->DoctorName;?></td>
				  <td><?php echo $items->ClinicalNotes;?></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
	</div>
	
	<div id="daily2" class="tab-pane">
		<h4 class="text-left">Radiology Service Name : My Breast Mammography USG</h4>
		<br />
		<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Order Date</th><th>Registration No</th><th>Patient Name</th><th>Cell-phone No</th><th>Email</th><th>Medical Record</th><th>DOB</th><th>Gender</th><th>Doctor Name</th><th>Notes</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0; 
			  foreach($list_package_mammography_usg as $items) 
			  { $i++; ?>
				<tr>
				 <td><?php echo $i;?></td>
				  <td><?php echo $items->OrderDate;?></td>
				  <td><?php echo $items->RegistrationNo;?></td>
				  <td><b><?php echo $items->PatientFullName;?></b></td>
                  <td><?php echo $items->PatientPhoneMobile;?></td>
                  <td><?php echo $items->Email;?></td>
				  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo date('Y-m-d',strtotime($items->PatientBirthdate));?></td>
				  <td><?php echo $items->PatientGender;?></td>
				  <td><?php echo $items->DoctorName;?></td>
				  <td><?php echo $items->ClinicalNotes;?></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
	</div>		
	
	<div id="daily3" class="tab-pane">
		<h4 class="text-left">Radiology Service Name : My Brain</h4>
		<br />
		<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Order Date</th><th>Registration No</th><th>Patient Name</th><th>Cell-phone No</th><th>Email</th><th>Medical Record</th><th>DOB</th><th>Gender</th><th>Doctor Name</th><th>Notes</th><th>Service Detail</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0; 
			  foreach($list_my_brain as $items) 
			  { $i++; ?>
				<tr>
				 <td><?php echo $i;?></td>
				  <td><?php echo $items->OrderDate;?></td>
				  <td><?php echo $items->RegistrationNo;?></td>
				  <td><b><?php echo $items->PatientFullName;?></b></td>
                  <td><?php echo $items->PatientPhoneMobile;?></td>
                  <td><?php echo $items->Email;?></td>
				  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo date('Y-m-d',strtotime($items->PatientBirthdate));?></td>
				  <td><?php echo $items->PatientGender;?></td>
				  <td><?php echo $items->DoctorName;?></td>
				  <td><?php echo $items->ClinicalNotes;?></td>
				  <td><?php echo $items->ItemServiceName;?>(<?php echo $items->ItemServiceCode;?>)</td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
	</div>

	<div id="daily4" class="tab-pane">
		<h4 class="text-left">Radiology Service Name : My Cervix (Pap Smear)</h4>
		<br />
		<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Order Date</th><th>Patient Name</th><th>Cell-phone No</th><th>Email</th><th>Medical Record</th><th>DOB</th><th>Gender</th><th>Doctor Name</th><th>Notes</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0; 
			  foreach($list_pap_smear as $items) 
			  { $i++; ?>
				<tr>
				 <td><?php echo $i;?></td>
				  <td><?php echo $items->Date;?></td>
				  <td><b><?php echo $items->PatientName;?></b></td>
                  <td><?php echo $items->PhoneNumber;?></td>
                  <td><?php echo $items->Email;?></td>
				  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo date('Y-m-d',strtotime($items->Birthdate));?></td>
				  <td><?php echo $items->Gender;?></td>
				  <td><?php echo $items->Doctor;?></td>
				  <td></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
	</div>	

	<div id="daily5" class="tab-pane">
		<h4 class="text-left">Radiology Service Name : CT Cardiac</h4>
		<br />
		<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Order Date</th><th>Registration No</th><th>Patient No</th><th>Cell-phone No</th><th>Email</th><th>Medical Record</th><th>DOB</th><th>Gender</th><th>Doctor Name</th><th>Notes</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0; 
			  foreach($list_ct_cardiag_coroner as $items) 
			  { $i++; ?>
				<tr>
				 <td><?php echo $i;?></td>
				  <td><?php echo $items->OrderDate;?></td>
				  <td><?php echo $items->RegistrationNo;?></td>
				  <td><b><?php echo $items->PatientFullName;?></b></td>
                  <td><?php echo $items->PatientPhoneMobile;?></td>
                  <td><?php echo $items->Email;?></td>
				  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo date('Y-m-d',strtotime($items->PatientBirthdate));?></td>
				  <td><?php echo $items->PatientGender;?></td>
				  <td><?php echo $items->DoctorName;?></td>
				  <td><?php echo $items->ClinicalNotes;?></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
	</div>

	<div id="daily6" class="tab-pane">
		<h4 class="text-left">Radiology Service Name : CT Calcium Score</h4>
		<br />
		<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Order Date</th><th>Registration No</th><th>Patient Name</th><th>Cell-phone No</th><th>Email</th><th>Medical Record</th><th>DOB</th><th>Gender</th><th>Doctor Name</th><th>Notes</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0; 
			  foreach($list_ct_calcium_scoring as $items) 
			  { $i++; ?>
				<tr>
				 <td><?php echo $i;?></td>
				  <td><?php echo $items->OrderDate;?></td>
				  <td><?php echo $items->RegistrationNo;?></td>
				  <td><b><?php echo $items->PatientFullName;?></b></td>
                  <td><?php echo $items->PatientPhoneMobile;?></td>
                  <td><?php echo $items->Email;?></td>
				  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo date('Y-m-d',strtotime($items->PatientBirthdate));?></td>
				  <td><?php echo $items->PatientGender;?></td>
				  <td><?php echo $items->DoctorName;?></td>
				  <td><?php echo $items->ClinicalNotes;?></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
	</div>		
				<!--
				<div class="control-group">
				<label class="control-label" >Line Of Business(LOB) :</label>
					<div class="controls">
						<label class="checkbox-inline">	<input type="checkbox" id="inlineCheckbox1" value="option1"> OPD </label>
						<label class="checkbox-inline"> <input type="checkbox" id="inlineCheckbox2" value="option2"> IPD </label>
						<label class="checkbox-inline"> <input type="checkbox" id="inlineCheckbox3" value="option3"> ETC </label>
						<label class="checkbox-inline"> <input type="checkbox" id="inlineCheckbox3" value="option3"> MCU </label>
					</div>
				</div>
				-->	

	<div class="row">
	    <div class="span12 back">
				<a href="<?php echo base_url().'marketing_report/';?>" class="btn btn-success">Back To Filter</a>
		</div>
	</div>
		
	    </div>		
</div>
</div>
<script >
function load_progress()
{
if($('#dpd1').val()=='')
{
alert('Please Input Start Date');
location.reload();
}
var link = document.getElementById('date_range');
link.style.visibility = 'hidden';
var progressbar = document.getElementById('progressbar');
progressbar.style.display = 'inline';
var $progresswidth = $('.row');
var progress = setInterval(function(){
    var $bar = $('.bar');
    if ($bar.width()>=$progresswidth.width() ) {
        clearInterval(progress);
        $('.progress').removeClass('active');
    } else {
        $bar.width($bar.width()+47);
    }
    $bar.text(($bar.width()/$progresswidth.width()*100)+5 + "%");
}, 4000);
}




</script>
