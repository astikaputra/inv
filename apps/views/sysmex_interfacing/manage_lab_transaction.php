 <div class="container-fluid">
      <div class="row-fluid">
			<div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well"  id="date_range">
	
			<legend><?php echo $content_title; ?></legend>
			<table class="table table-bordered" id="manage_sysmex">
			<thead>
                <tr>
                  <th>Order Date</th><th>Item Service Code</th><th>Item Service Name</th><th>Doctor Lab Code & Doctor Lab Name</th><th>Create Date</th><th>Action</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($list_transaction as $items) 
			  {?>
                <tr>
                  <td><?php echo $items->OrderDate;?></td>
                  <td><?php echo $items->ItemServiceCode;?></td>
				  <td><small><?php echo $items->ItemServiceName;?></small></td>
				  <td><?php 
							if($items->InfHIS_DoctorLabCode != '')
								{echo '<b>'.$items->InfHIS_DoctorLabCode.'</b> | '.$items->InfHIS_DoctorLabName.'<br />';
								 echo 'Revised From ('.$items->InfSysmex_DoctorLabCode.') |'.$items->InfSysmex_DoctorLabName;
								 }
							else
								{
								 echo '<b>'.$items->InfSysmex_DoctorLabCode.'</b>  '.$items->InfSysmex_DoctorLabName;
								}?></td>
				  <td><?php if($items->InfSysmex_DoctorLabCreatedDate != NULL){echo date('d M Y',strtotime($items->InfSysmex_DoctorLabCreatedDate));}?></td>	
				  <td><a data="<?php echo $items->InfSysmexOrderDetailsId; ?>" class="btn btn-primary <?php if($items->InfHIS_DoctorLabCode != ''){echo 'btn-success';} else{echo 'btn-primary';}?> doctor_correct" id="<?php echo $items->InfSysmexOrderDetailsId ?>"onclick="this.href='javascript:void(0)';this.disabled=1">Correcting Doctor</a></td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
			
			
			<button type="button" class="btn" data-toggle="collapse" data-target="#get_transaction">Get Lab Transaction</button> 
			<div id="get_transaction" class="collapse">
				<?php echo form_open($form_request,array('class'=>'form-horizontal'));?>
			<legend>Get Lab Transaction</legend>
				<div class="control-group" id="start-date">
				<label class="control-label" >Insert Start Date : </label>
				<div class="controls">
				<input type="text" name="startdate" value="" id="dpd1" placeholder="Start Date">
				</div>
				</div>
				<div class="control-group" id="end-date">
				<label class="control-label" >Insert End Date : </label>
					<div class="controls">
						<input type="text" name="enddate" value="" id="dpd2" placeholder="End Date">
					<span class="help-block">* The longer time span affect the duration of the information that will be displayed.</span>
				
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
	   		<button type="submit" class="btn btn-primary" onClick="load_progress();">Get Lab Transaction</button>
			</div>
			
	    </div>

	  </div>
	    <div class="row">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		</div>
	
</div>
<div id="myModal" class="modal hide fade" style="width: 500px; " tabindex="-1" role="dialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
			<legend>Doctor Lab Correction</legend>
	</div>
	<div class="modal-body">
	<form id="myForm" method="post">
          <input type="hidden" value="hello" id="myField">
           </form>
	<?php echo form_open($form_correcting_doctor,array('class'=>'form-horizontal'));?>
	<input type="hidden" name="trans_id" id="trans_id" value="">
      <select name="corrected_doctor">
	  <?php 
	  foreach($list_doctor_sysmex->result() as $doctor)
	  {?>
		<option value="<?php echo $doctor->Code;?>"><?php echo $doctor->Name;?></option>
	<?php } ?>
	</select>
	<input type="submit" class="btn btn-primary" value="Save Changes">
	</form>
	</div>
	<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
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
