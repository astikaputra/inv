 <style>
.container-fluid {
  padding-right: 20px;
  padding-left: 20px;
  background-color:#fff;
  *zoom: 1;
}
</style>
 <div class="container-fluid">

      <div class="row-fluid">
		<div class="span12">
			<h3> <?php echo $content_title; ?> </h3>
        </div>
		<hr />
		<div class="span12">
			<?php echo form_open($button_action,array('class'=>'form-search'));?>
			<p class="text-center">Insert Name / Medical Record Number : <br />
            <br />
            <input type="text" name="keyword" class="span3 search-query" value="" required placeholder="Name Or Medical Record Number"></p>
			<br />
            <div style="text-align: center;">
	   		<button type="submit" class="btn btn-large btn-primary" >Search</button>
            </div>
			
			<?php echo form_close();?>
        </div>
		
		<?php 
		if(isset($bill_data))
		{
		?>
	 <div class="row-fluid">
	 <br />
	 <img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">
	 <p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
	<table class="table table-striped table-bordered" >
	<thead>
		<tr>
			<th>Patient Reg Number</th><th>Patient Name</th><th>MR Number</th><th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($bill_data as $items)
		{?>	<tr>
		<td><?php echo $items->patient_reg_no;?></td></td><td><?php echo $items->PatientName;?></td><td><?php echo $items->MedicalRecordNumber;?></td>
		<td>
		<a data="<?php echo base_url();?><?php if($items->RecordStatus == 'Active'){echo 'bill_controllers/deactivate_reg/';}else{echo 'bill_controllers/activate_reg/';}?><?php echo $items->reg_id.'/'.time(); ?>" class="btn btn-mini <?php if($items->RecordStatus == 'Active'){echo 'btn-success';}else{echo 'btn-inverse';}?> recordstatus" id="rs-<?php echo $items->reg_id;?>" ><?php echo $items->RecordStatus;?></a>
		</td>
		
		</tr>
		<?php }?>
	</tbody>
	</table>
		<div class="row" align="right">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		</div>
	</div>
	<?php 
		}
		?>
   </div>
</div>
