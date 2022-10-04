 <div class="container-fluid">
      <div class="row-fluid">
			<div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well"  id="date_range">
	
			<legend><?php echo $content_title; ?></legend>



			
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
	
			<br />
	   		<button type="submit" class="btn btn-primary" onClick="load_progress();">Get Radiology Transaction</button>
			</div>

			<table class="table table-bordered" id="manage_sysmex">
			<thead>
                <tr>
                  <th>MR No</th><th>Reg No</th><th>Patient Name</th><th>Order Date</th><th>Item Service Name</th><th>Reported By</th><th>Reported Date</th><th>Action</th>
                </tr>
              </thead>
              <tbody>
			  <?php foreach($list_transaction as $items) 
			  {?>
                <tr>
				  <td><?php echo $items->PatientMRNo;?></td>
				  <td><?php echo $items->RegistrationNo;?></td>
                  <td><b><?php echo $items->PatientFullName;?></b><br /></td>
                  <td><?php echo $items->OrderDate;?></td>
				  <td><small><?php echo $items->ItemServiceName;?></small></td>
				  <td><?php  if($items->PhysicianPerformingCode == '')
								{
								echo '<center> Not Yet Reported </center>';	
								}
								else
								{
								echo '<b>'.$items->PhysicianPerformingCode.' | '.$items->PhysicianPerformingName.'</b>  ';	
								}
								?>
							</td>
				  <td><?php if($items->RIS_ReportCreatedDate != NULL)
				  {echo date('d/m/Y  H:i:s',strtotime($items->RIS_ReportCreatedDate));}?>
				  </td>	
				  <td>
					<a class="btn btn-primary study_matching disabled" patientdata="<?php echo get_firstname($items->PatientFullName); ?>" recordid="<?php echo $items->RecID; ?>" itemservice="<?php echo $items->ItemServiceName;?>" orderdate="<?php echo $items->OrderDate;?>" patientmrn="<?php echo $items->PatientMRNo;?>" patientname="<?php echo $items->PatientFullName;?>" physician ="<?php echo $this->session->userdata('HISUser');?>" role="button" data-toggle="modal"><i class="icon-ok-circle icon-white"></i> Study Matching</a>
				  </td>
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


<!-- Modal for Study Matching Data-->
<div class="modal hide fade" style="width: 1100px; margin: 0 0 0 -550px; " id="study_matching_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               <center><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals">
               	<hr />
               	<h3>Radiology Study Matching </h3> 
               	<hr/>
               	</center>
               	<div class="breadcrumb" id="detail_data"></div>
               

            </div>
            <div class="modal-body">		  
				<div id="loading_data" style="display:none"><center><img src='<?php echo base_url();?>/assets/loading_big.gif' style='width:70px;margin:180px auto;'/></center></div>
					<div class="modal_content">
						
					</div>
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

<script type="text/javascript">

	$(".study_matching").click(
			function(){
				var patientname = $(this).attr("patientdata");
				var recid = $(this).attr("recordid");
				var mrn = $(this).attr("patientmrn"); 
				var PatientFullName = $(this).attr("patientname");
				var itemservice = $(this).attr("itemservice");
				var orderdate = $(this).attr("orderdate");
				var physician = $(this).attr("physician");
				var datainfo = '<b>Patient Name :</b>'+PatientFullName+' | <b>Service Name : </b>'+itemservice+' | <b>Order Date : </b>'+orderdate+'';
				var url = "<?php echo base_url();?>manage_ris_order/load_ris_data/"+patientname+"/"+recid+"/"+physician;
				  $("#detail_data").empty().append(datainfo);
				  $('#study_matching_modal').modal('show');
				  $('#loading_data').show();
				$.get(url, function( data ) {					
				  $( ".modal_content").empty().append(data);
				  $('#loading_data').hide();
				});
			});

	


</script>

<?php 
function get_firstname($name){
	$namearr = explode( ' ', $name );
		if(strlen($namearr[0]) <= 3)
		{return $namearr[1];}
		else
		{return $namearr[0];}
		
}

?>