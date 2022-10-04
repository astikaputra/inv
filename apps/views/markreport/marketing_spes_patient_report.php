 <style>.container-fluid
{
background-color:#fff;
}
</style>
 <div class="container-fluid">

 			<h3>
			Marketing All Data Patient Of <?php echo $this->session->userdata('hospital_name');?> Report
			</h3>
			<h4>Identity Card Type : <?php echo $detail_cardide->IdentityType; ?></h4>
			<br />
			
			<table class="table table-bordered" id="marketing_patient_data">
			<thead>
                <tr>
                  <th>No</th><th>Patient Name</th><th>Address</th><th>Cities</th><th>Email</th><th>Phone Number</th><th>Nationality</th><th>Created On</th><th>Modified On</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i=0;
			  foreach($spes_nationality_report as $items) 
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


