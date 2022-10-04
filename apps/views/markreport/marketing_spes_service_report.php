 <style>.container-fluid
{
background-color:#fff;
}</style>
 <div class="container-fluid">

			<h3>
			Marketing Report Periode Between <?php echo date('d-m-Y',strtotime($startdate));?> Until <?php echo date('d-m-Y',strtotime($enddate));?>
			</h3>
			<h4>Radiology Service Details : <?php echo $radiology_service_detail->ItemServiceName; ?> (<?php echo $radiology_service_detail->ItemServiceCode; ?>)</h4>
			<br />
			
			<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Order Date</th><th>Registration No</th><th>Patient Name</th><th>Cell-phone No</th><th>Email</th><th>Medical Record</th><th>DOB</th><th>Gender</th><th>Doctor Name</th><th>Notes</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0;
			  foreach($list_spesific_radiology as $items) 
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
				<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
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
