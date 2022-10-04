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
			Marketing All Data Patient Of <?php echo $this->session->userdata('hospital_name');?> Report
			</h3>
			<br />
			
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#daily1" data-toggle="tab">KTP</a></li>
	<li><a href="#daily2" data-toggle="tab">SIM</a></li>
	<li><a href="#daily3" data-toggle="tab">Passport</a></li>
	<li><a href="#daily4" data-toggle="tab">KITAS</a></li>
	<li><a href="#daily5" data-toggle="tab">None</a></li>
  </ul>
  
  <div class="tab-content">
    <div id="daily1" class="tab-pane active"> 
			<h4 class="text-left">Identity Card Type : KTP</h4>
			<br />
		<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Patient Name</th><th>Address</th><th>Cities</th><th>Email</th><th>Phone Number</th><th>Nationality</th><th>Created On</th><th>Modified On</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0;
			  foreach($all_ktp_report as $items) 
			  { $i++; ?>
				<tr>
				 <td><?php echo $i;?></td>
				  <td><b><?php echo $items->PatientName;?></b></td>
				  <td><?php echo $items->Address;?></td>
				  <td><?php echo $items->Cities;?></td>
                  <td><?php echo $items->Email;?></td>
				  <td><?php echo $items->PhoneNumber;?></td>
                  <td><?php echo $items->Nationality;?></td>
				  <td><?php echo $items->CreatedOn;?></td>
				  <td><?php echo $items->ModifiedOn;?></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
	</div>
	
	<div id="daily2" class="tab-pane">
		<h4 class="text-left">Identity Card Type : SIM</h4>
		<br />
			<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Patient Name</th><th>Address</th><th>Cities</th><th>Email</th><th>Phone Number</th><th>Nationality</th><th>Created On</th><th>Modified On</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0;
			  foreach($all_sim_report as $items) 
			  { $i++; ?>
				<tr>
				 <td><?php echo $i;?></td>
				  <td><b><?php echo $items->PatientName;?></b></td>
				  <td><?php echo $items->Address;?></td>
				  <td><?php echo $items->Cities;?></td>
                  <td><?php echo $items->Email;?></td>
				  <td><?php echo $items->PhoneNumber;?></td>
                  <td><?php echo $items->Nationality;?></td>
				  <td><?php echo $items->CreatedOn;?></td>
				  <td><?php echo $items->ModifiedOn;?></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
	</div>		
	
	<div id="daily3" class="tab-pane">
		<h4 class="text-left">Identity Card Type : Passport</h4>
		<br />
		<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Patient Name</th><th>Address</th><th>Cities</th><th>Email</th><th>Phone Number</th><th>Nationality</th><th>Created On</th><th>Modified On</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0;
			  foreach($all_pass_report as $items) 
			  { $i++; ?>
				<tr>
				 <td><?php echo $i;?></td>
				  <td><b><?php echo $items->PatientName;?></b></td>
				  <td><?php echo $items->Address;?></td>
				  <td><?php echo $items->Cities;?></td>
                  <td><?php echo $items->Email;?></td>
				  <td><?php echo $items->PhoneNumber;?></td>
                  <td><?php echo $items->Nationality;?></td>
				  <td><?php echo $items->CreatedOn;?></td>
				  <td><?php echo $items->ModifiedOn;?></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
	</div>

	<div id="daily4" class="tab-pane">
		<h4 class="text-left">Identity Card Type : KITAS</h4>
		<br />
		<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Patient Name</th><th>Address</th><th>Cities</th><th>Email</th><th>Phone Number</th><th>Nationality</th><th>Created On</th><th>Modified On</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0;
			  foreach($all_kitas_report as $items) 
			  { $i++; ?>
				<tr>
				 <td><?php echo $i;?></td>
				  <td><b><?php echo $items->PatientName;?></b></td>
				  <td><?php echo $items->Address;?></td>
				  <td><?php echo $items->Cities;?></td>
                  <td><?php echo $items->Email;?></td>
				  <td><?php echo $items->PhoneNumber;?></td>
                  <td><?php echo $items->Nationality;?></td>
				  <td><?php echo $items->CreatedOn;?></td>
				  <td><?php echo $items->ModifiedOn;?></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
	</div>	

	<div id="daily5" class="tab-pane">
		<h4 class="text-left">Identity Card Type : None</h4>
		<br />
		<table class="table table-striped table-bordered">
			<thead>
                <tr>
                  <th>No</th><th>Patient Name</th><th>Address</th><th>Cities</th><th>Email</th><th>Phone Number</th><th>Nationality</th><th>Created On</th><th>Modified On</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0;
			  foreach($all_none_report as $items) 
			  { $i++; ?>
				<tr>
				 <td><?php echo $i;?></td>
				  <td><b><?php echo $items->PatientName;?></b></td>
				  <td><?php echo $items->Address;?></td>
				  <td><?php echo $items->Cities;?></td>
                  <td><?php echo $items->Email;?></td>
				  <td><?php echo $items->PhoneNumber;?></td>
                  <td><?php echo $items->Nationality;?></td>
				  <td><?php echo $items->CreatedOn;?></td>
				  <td><?php echo $items->ModifiedOn;?></td>
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
				<a href="<?php echo base_url().'marketing_patient_report/';?>" class="btn btn-success">Back To Filter</a>
		</div>
	</div>
		
	    </div>		
</div>
</div>
<script >
function load_progress()
{

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