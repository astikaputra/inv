 <div class="container-fluid">
      <div class="row-fluid">
			<div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well"  id="date_range">
	
			<legend><?php echo $content_title; ?></legend>
			<table class="table table-bordered" id="manage_ris_finance" >
			<thead>
                <tr>
                  <th>MR No</th>
				  <th>Reg No</th>
				  <th>Patient Name</th>
				  <th>Item Service Code</th>
				  <th>Item Service Name</th>
				  <th>Doctor Radiology </th>
				  <th>Create Date</th>
				  <th>Patient Bill Status</th>
				  <th>Doctor Fee Payment Status</th>
				  <th>Action</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($list_transaction as $items) 
			  {?>
                <tr id="trid<?php echo $items->RecID; ?>" <?php if($items->DoctorFee_IsPaid == 1){echo 'class="success"';}else{echo 'class="warning"';}?>>
				  <td><?php echo $items->PatientMRNo;?></td>
				  <td><?php echo $items->RegistrationNo;?></td>
                  <td><b><?php echo $items->PatientFullName;?></b><br /></td>
                  <td><?php echo $items->ItemServiceCode;?></td>
				  <td><small><?php echo $items->ItemServiceName;?></small></td>
				  <td><?php 
							if($items->InfHIS_DoctorRadCode != '')
								{?>
								<?php 	echo '<b>'.$items->InfHIS_DoctorRadCode.' | '.$items->InfHIS_DoctorRadName.' </b>';	?>
								<?php }
							else
								{?>
								<?php 	echo '<b>'.$items->PhysicianPerformingCode.' | '.$items->PhysicianPerformingName.'</b>  ';	?>
								
								
								<?php 
								}?></td>
				  <td><?php if($items->RIS_ReportCreatedDate != NULL){echo date('d/m/Y  H:i:s',strtotime($items->RIS_ReportCreatedDate));}?></td>	
				  <td><?php echo $items->BillStatus; ?></td>	
				  <td id="doctorfee<?php echo $items->RecID; ?>"><?php if($items->DoctorFee_IsPaid == 1)
							{
							echo 'Paid';
							}else{
							echo 'Unpaid';
							} ?>
						</td>	
				  <td>
				 <div class="btn-group" >
					<a class="btn dropdown-toggle btn-primary" data-toggle="dropdown" id="approval<?php echo $items->RecID; ?>" >
						Action 
						<span class="caret"></span><span class="icon-pencil icon-white"></span>
					</a>
						<ul class="dropdown-menu" style="margin-left:-70px;">
							<li><a data="<?php echo base_url();?>
							<?php if($items->DoctorFee_IsPaid == 1)
							{
							echo 'manage_ris_order/transaction_unpaid/';
							}else{
							echo 'manage_ris_order/transaction_paid/';
							} ?>
							" id="paid<?php echo $items->RecID; ?>" transid="<?php echo $items->RecID; ?>" class="doctorfeepaidbutton " ><span class="icon-briefcase"></span> 
							<?php if($items->DoctorFee_IsPaid == 1)
							{
							echo 'Cancel Payment';
							}else{
							echo 'Pay DoctorFee';
							} ?>
							</a></li>
							<li><a data="<?php echo base_url();?>manage_ris_order/unlock_data/" id="unlock<?php echo $items->RecID; ?>" transid="<?php echo $items->RecID; ?>" class="unlockbutton" ><span class="icon-lock"></span> Unlock Data</a></li>
						</ul>
				  </div>
				  </td>
				 </tr>
			<?php }?>
			</tbody>
		</table>
			
			<a href="<?php echo base_url().'manage_ris_order/generate_excel_report_doctor_fee/'.$this->session->userdata('ris_list_param');?>" id="generate_doctorfee" class="btn btn-primary" data-loading-text="Loading..." onClick="void()" rel="<?php echo base_url().'manage_ris_order/generate_excel_report_doctor_fee/'.$this->session->userdata('ris_list_param');?>">Generate Excel Report</a>
			
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

<iframe id="downloaderpage" src="" style="visibility:hidden">
</iframe>
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
      <select name="corrected_doctor">
	  <?php 
	  foreach($list_doctor_ris->result() as $doctor)
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
