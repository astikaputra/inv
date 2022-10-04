 <div class="container-fluid">
      <div class="row-fluid">
		<div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well"  id="date_range">
	
			<legend><?php echo $content_title; ?></legend>
			<table class="table table-bordered" id="manage_class">
			<thead>
                <tr>
                  <th>MR No</th><th>Reg No</th><th>Patient Name</th><th>Registration Time</th><th>Classes</th><th>Action</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($list_data_registration as $items) 
			  {?>
                <tr>
				  <td><?php echo $items->MedicalRecordNumber;?></td>
				  <td><?php echo $items->RegistrationCode;?></td>
                  <td><b><?php echo $items->PatientName;?></b><br /></td>
                  <td><?php echo date('d-m-Y H:i:s',strtotime($items->RegistrationTime));?></td>
				  <td><?php echo $items->Classes;?></td>
				  <td><a data="<?php echo $items->PatientRegsId; ?>" class="btn btn-mini <?php if($items->PatientRegsId != ''){echo 'btn-success';} else{echo 'btn-primary';}?> classes_correct" id="<?php echo $items->PatientRegsId ?>"onclick="this.href='javascript:void(0)';this.disabled=1">Correcting Class</a></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
			
	    </div>
	  </div>
	    <div class="row">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		</div>
</div>

<div id="myModal" class="modal hide fade" style="width: 500px; " tabindex="-1" role="dialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
			<legend>Patient Classes Correction</legend>
	</div>
	<div class="modal-body">
	<form id="myForm" method="post">
          <input type="hidden" value="hello" id="myField">
           </form>
	<?php echo form_open($form_correcting_classes,array('class'=>'form-horizontal'));?>
	<input type="hidden" name="reg_id" id="reg_id" value="">
      <select name="classes_correct">
	  <?php 
	  foreach($list_patient_class->result() as $classes)
	  {?>
		<option value="<?php echo $classes->Code;?>"><?php echo $classes->Name;?></option>
	<?php } ?>
	</select>
	<input type="submit" class="btn btn-primary" value="Save Changes">
	</form>
	</div>
	<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>

</div>