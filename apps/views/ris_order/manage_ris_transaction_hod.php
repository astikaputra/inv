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
                  <th>MR No</th><th>Reg No</th><th>Patient Name</th><th>Item Service Code</th><th>Item Service Name</th><th>Reported By</th><th>Reported Date</th><th>FO Validation</th><th>Action</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($list_transaction as $items) 
			  {?>
                <tr <?php 
				echo 'id="trid'.$items->RecID.'"';
				if($items->RIS_ReportCreatedBy == '')
				{
					echo '';
				}
				else
				{
					if(($items->DoctorFee_IsPaid == 0) && ($items->DoctorFee_IsApproved == 1))
					{
					echo 'class="info"';
					}
					else if((($items->DoctorFee_PaidBy != '') && ($items->DoctorFee_IsApproved == 0)) && ($items->DoctorFee_PaidBy != ''))
					{
					echo 'class="warning"';
					}
					else if(($items->DoctorFee_IsPaid == 1) && ($items->DoctorFee_IsApproved == 1))
					{
					echo 'class="success"';
					}		
					else if(($items->DoctorFee_IsPaid == 0) && ($items->DoctorFee_IsApproved == 0))
					{
					echo '';
					}
				}
				?>
				>
				  <td><?php echo $items->PatientMRNo;?></td>
				  <td><?php echo $items->RegistrationNo;?></td>
                  <td><b><?php echo $items->PatientFullName;?></b><br /></td>
                  <td><?php echo $items->ItemServiceCode;?></td>
				  <td><small><?php echo $items->ItemServiceName;?></small></td>
				  <td><?php 
							if($items->InfHIS_DoctorRadCode != '')
								{?>
								<a href="<?php echo base_url().'audit_trails/radiology/'.$items->RecID;?>" class="btn btn-primary <?php if($items->InfHIS_DoctorRadCode != ''){echo 'btn-success';} else{echo 'btn-primary';}?> audit_trails_correction" data-target="#audit_trails_modal" role="button" data-toggle="modal" id="<?php echo $items->RecID ?>"><?php 	echo '<b>'.$items->InfHIS_DoctorRadCode.' | '.$items->InfHIS_DoctorRadName.' </b>'.'<small>(Revised)</small>';	?></a>
								<?php }
							else
								{?>
								<?php 
								if($items->PhysicianPerformingCode == '')
								{
								echo '<center> Not Yet Reported </center>';	
								}
								else
								{
								echo '<b>'.$items->PhysicianPerformingCode.' | '.$items->PhysicianPerformingName.'</b>  ';	
								}
								?>
								<?php 
								}?></td>
				  <td><?php if($items->RIS_ReportCreatedDate != NULL)
				  {echo date('d/m/Y  H:i:s',strtotime($items->RIS_ReportCreatedDate));}?>
				  </td>	
				  <td><?php if($items->InfHIS_ReportCheck == '1')
					{
					echo '<center><i class="icon-ok fo_validation" data-toggle="tooltip"  data-placement="left" title="Already Checked by FO"></i></center>';
					}
					else
					{
					echo '<center><i class="icon-remove fo_validation" data-toggle="tooltip"  data-placement="left" title="Not Yet Checked By FO"></i></center>';
					}
				  ?>
				  </td>	
				  <td>
				 <div class="btn-group " >
					<a class="actionbtn btn dropdown-toggle <?php if(($items->DoctorFee_IsApproved == '1') OR (($items->RIS_ReportCreatedBy) == '') ){echo 'btn disabled';}else{echo 'btn-primary';}?>" data-toggle="dropdown" href="#" id="approvalaction<?php echo $items->RecID;?>" data-toggle="tooltip" 
				<?php 
				if($items->RIS_ReportCreatedBy == '')
				{
					echo 'title="Not Yet Reported By Doctor"';
				}
				else
				{
					if(($items->DoctorFee_IsPaid == 0) && ($items->DoctorFee_IsApproved == 1))
					{
					echo 'title="Approved and already sent to Finance"';
					}
					else if((($items->DoctorFee_PaidBy != '') && ($items->DoctorFee_IsApproved == 0)) && ($items->DoctorFee_PaidBy != ''))
					{
					echo 'title="Finance Need Validation"';
					}
					else if(($items->DoctorFee_IsPaid == 1) && ($items->DoctorFee_IsApproved == 1))
					{
					echo 'title="Approved and paid by Finance"';
					}		
					else if(($items->DoctorFee_IsPaid == 0) && ($items->DoctorFee_IsApproved == 0))
					{
					echo 'title="Need Correcting Or Approval"';
					}
				}
					?>
					data-placement="left"
					>
						Action 	
					<span class="caret"></span><span class="icon-pencil icon-white"></span>
					</a>
						<ul class="dropdown-menu" style="margin-left:-80px;">
							<li><a data="<?php echo base_url();?>manage_ris_order/proving_doctor_correction/" id="<?php echo $items->RecID; ?>" class="approvedbutton" ><span class="icon-ok"></span> Approved</a></li>
							<li><a data="<?php echo $items->RecID; ?>" doctorcode="<?php echo $items->PhysicianPerformingCode; ?>" class="doctor_correct" id="<?php echo $items->RecID ?>"onclick="this.href='javascript:void(0)';this.disabled=1"><span class="icon-user"></span> Correcting Doctor</a></li>
						</ul>
				  </div>
				  </td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
			
			
			<button type="button" class="btn" data-toggle="collapse" data-target="#get_transaction">Get Radiology Transaction</button> 
			<div id="get_transaction" class="collapse">
				<?php echo form_open($form_request,array('class'=>'form-horizontal'));?>
			<legend>Get Radiology Transaction</legend>
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
	   		<button type="submit" class="btn btn-primary" onClick="load_progress();">Get Radiology Transaction</button>
			</div>
			
	    </div>

	  </div>
	    <div class="row">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		</div>
	
</div>


<!-- Modal for audit trails-->
<div class="modal hide fade" style="width: 1100px; margin: 0 0 0 -550px; " id="audit_trails_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h3 class="modal-title">Doctor Corection - Audit Trails <img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></h3>
            </div>
            <div class="modal-body">		  
			<center><img src='<?php echo base_url();?>/assets/loading_big.gif' style='width:70px;margin:180px auto;'/></center>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div id="myModal" class="modal hide fade" style="width: 500px; " tabindex="-1" role="dialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
			<legend>Doctor Radiologi Correction</legend>
	</div>
	<div class="modal-body">
	<form id="myForm" method="post">
          <input type="hidden" value="hello" id="myField">
           </form>
	<?php echo form_open($form_correcting_doctor,array('class'=>'form-horizontal'));?>
	<input type="hidden" name="trans_id" id="trans_id" value="">
      <select name="corrected_doctor" id="doctorcorrection">
	  <option></option>
	  <?php 
	  foreach($list_doctor_ris->result() as $doctor)
	  {?>
		
		<option id='doctorcode<?php echo $doctor->Code;?>' value="<?php echo $doctor->Code;?>"><?php echo $doctor->Name;?></option>
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
