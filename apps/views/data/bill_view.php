 
   <div class="container-fluid">
      <div class="row-fluid">
        <h3> <?php echo $content_title; ?> </h3>
      <div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
      </div>	
	<div class="well">
			   <?php echo form_open($button_action,array('class'=>'form-search'));?>
			<p class="text-center">Insert Name / Medical Record Number : <br />
            <br />
            <input type="text" name="keyword" class="span3 search-query" value="" required placeholder="Name Or Medical Record Number"></p>
			<br />
            <div style="text-align: center;">
	   		<button type="submit" class="btn btn-large btn-primary" >Search</button>
            </div>
	  
			<?php echo form_close();?>
		
		<?php 
		if(isset($patient_data))
		{
		?>
	 <div class="row-fluid">
	 <br />
	 <img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">
	 <p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
	<table class="table table-striped table-bordered" >
	<thead>
		<tr>
			<th>Action</th><th>MR Number</th><th>Patients Name</th><th>Registration Code</th><th>Registration Time</th><th>Created By</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($patient_data as $items) 
			  {?>
            <tr>
			<td><a href="<?php echo base_url();?><?php echo $button_detail_action;?><?php echo $items->Id; ?>" data-target="#traceModal" role="button" data-toggle="modal" class="btn btn-mini btn-primary">trace</a></td>
			<td><?php echo $items->MedicalRecordNumber;?></td>
			<td><?php echo $items->PatientName;?></td>
			<td><?php echo $items->RegCode;?></td>
			<td><?php echo $items->RegistrationTime;?></td>
			<td><?php echo $items->CreatedBy;?></td>
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

<!-- Modal -->
<div class="modal hide fade" style="width:70%; margin: 0 0 0 -35%;" id="traceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <center><h3 class="modal-title"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></h3></center>
            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
