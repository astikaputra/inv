 <div class="container-fluid">
      <div class="row-fluid">
        <h3> <?php echo $content_title; ?> </h3>
      <div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
      </div>	
			<div class="well">
			   <?php echo form_open($form_request,array('class'=>'form-search'));?>
			<p class="text-center">Insert Name / Medical Record Number : <br />
            <br />
            <input type="text" name="keyword" class="span3 search-query" value="" required placeholder="Name Or Medical Record Number"></p>
			<br />
            <div style="text-align: center;">
	   		<button type="submit" class="btn btn-large btn-primary" >Search</button>
            </div>
	  
			<?php echo form_close();?>
		<?php 
		if(isset($pathisdata))
		{
		?>
	 <div class="row-fluid">
	 <br />
	 <img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">
	 <p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
	<table class="table table-striped table-bordered" >
	<thead>
                <tr>
				  <th>Reg Code</th>	
				  <th>Medical Record Number</th>
                  <th>Patient Name</th>
				  <th>Class</th>
				  <th>Action</th>
                </tr>
	</thead>
	<tbody>
	<?php foreach($pathisdata as $his_patient) 
			  {?>
            <tr>
			<td><?php echo $his_patient->RegCode;?></td>
			<td><?php echo $his_patient->MedicalRecordNumber;?></td>
			<td><?php echo $his_patient->PatientName;?></td>
			<td><?php echo $his_patient->PricelistClass;?></td>
			<td><a data="<?php echo $his_patient->PricelistClassId; ?>" class="btn btn-mini btn-primary openBtn change_class" id="<?php echo $his_patient->RegId; ?>" onclick="this.href='javascript:void(0)';this.disabled=1">Change Class</a></td>
			</tr>
	<?php } ?>
	</tbody>
</table>
	</div>
	<?php 
		}
	?>
		<div class="row" align="right">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		</div>	
</div>

</div>
</div>
		
<div id="myModal" class="modal hide fade" style="width: 500px; " tabindex="-1" role="dialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
			<legend>Change Class Patient</legend>
	</div>
	<div class="modal-body">
	<?php echo form_open($form_change_class,array('class'=>'form-horizontal'));?>
	<input type="hidden" name="class_first" id="class_first" value="">
	<input type="hidden" name="reg_id" id="reg_id" value="">
      <select name="class_id">
	  <?php 
	  foreach($list_patient_class as $class)
	  {?>
		<option value="<?php echo $class->id;?>"><?php echo $class->Class;?></option>
	<?php } ?>
	</select>
	<input type="submit" class="btn btn-primary" value="Save Changes">
	</form>
	</div>
	<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>