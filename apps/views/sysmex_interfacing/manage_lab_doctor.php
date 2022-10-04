 <div class="container-fluid">
      <div class="row-fluid">
			<div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well"  id="date_range">
	
			<legend><?php echo $content_title; ?></legend>
			<table class="table table-striped dttbl">
			<thead>
                <tr>
                  <th>Doctor Code</th><th>Name</th><th>Specialist Name</th><th>Sub Specialist</th><th>Clinic Name</th><th>Item Service Sub Category Name</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($doctor_lab->result() as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->Code;?></td>
                  <td><?php echo $items->Name;?></td>
				  <td><?php echo $items->SpecialistName;?></td>
				  <td><?php echo $items->SubSpecialistName;?></td>
				  <td><?php echo $items->ItemServiceRootName;?></td>	
				  <td><?php echo $items->ItemServiceGSSubCategoryName;?></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
			
			
			<button type="button" class="btn" data-toggle="collapse" data-target="#get_transaction">Add New Lab Doctor</button> 
			<div id="get_transaction" class="collapse">
			<legend>Add new Doctor Lab</legend>
				<?php echo form_open($form_request,array('class'=>'form-horizontal'));?>
				<div class="control-group" id="start-date">
				<label class="control-label" >Doctor Name : </label>
				<div class="controls">
				<select name="doctor">
				<?php foreach($doctor_list->result() as $doctor)
				{?>
				<option value ='<?php echo $doctor->CodeValue;?>'><?php echo $doctor->DoctorName;?></option>
				<?php 
				}
				?>
				</select>
				</div>
				</div>
				<div class="control-group" id="end-date">
				<label class="control-label" >Service Name : </label>
					<div class="controls">
						<select name="service">
				<?php foreach($service->result() as $itemservice)
				{?>
				<option value ='<?php echo $itemservice->CodeValue;?>'><?php echo $itemservice->NameValue;?></option>
				<?php 
				}
				?>
				</select>
				
					</div>
				
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
				
					
			<br />
	   		<button type="submit"  onClick="load_progress();">Add Doctor</button>
			</div>
			
	    </div>

	  </div>
	    <div class="row">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		</div>
	
</div>
<div id="myModal" class="modal hide fade" style="width: 1100px; margin: 0 0 0 -550px; " tabindex="-1" role="dialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
			<legend>Manage Doctor Lab</legend>
	</div>
	<div class="modal-body">
	  <div id='waiting-inside'><img src='<?php echo base_url();?>/assets/loading_big.gif' style='width:70px;margin:180px auto;'/></div>
      <iframe src="" style="zoom:0.60" width="90%" height="640" frameborder="0" >
	  </iframe>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal">OK</button>
	</div>
</div>
