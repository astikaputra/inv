<div class="container-fluid">
<p class="medicos_header_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
<h3><?php echo $pathis_title;?></h3>
<div class="row-fluid well">
<table class="table table-striped table-bordered" >
        <thead>
                <tr>
				  <th>Action</th>	
				  <th>PatientName</th>
                  <th>Registration Code</th>
				  <th>Registration Time</th>
				  <th>Doctor Name</th>
                </tr>
              </thead>
              <tbody>
			<?php foreach($pathisdata as $his_patient) 
			  {?>
              <tr>
			  <td><a data="<?php echo base_url();?><?php echo $button_action;?><?php echo $his_patient->MedicalRecordNumber.'/'.time(); ?>" class="btn btn-mini btn-primary openBtn" data-toggle="modal" data-target="#modal" id="<?php echo $pathisdata->Id; ?>" >trace</a></td>
			  <td><?php echo $his_patient->PatientName;?></td>
			  <td><?php echo $his_patient->RegistrationCode;?></td>
              <td><?php echo date('d-m-Y H:i:s',strtotime($his_patient->RegistrationTime));?></td>
              <td><?php echo $his_patient->DoctorName;?></td>
			<?php } ?>
			</tbody>
    </table>
</div>
<div class="row">
	    <div class="span12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>
</div>
</div>


<div id="modal" class="modal hide fade" tabindex="-1">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>List Details</h3>
  </div>
	<div class="modal-body">
	  <div id='waiting-inside'><img src='<?php echo base_url();?>/assets/loading_big.gif' style='width:70px;margin:180px auto;'/></div>
      <iframe src="" style="zoom:0.60" width="99.6%" height="700" frameborder="0">
	  </iframe>
	
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn">Close</button>
  </div>
</div>
</div>
<script>
$('#modal').on('show', function () {
      $('.modal-body',this).css({width:'auto',height:'auto', 'max-height':'100%'});
});

$('#modal').modal().css(
                {
                    width: 'auto',
                    'margin-top': function () {
                        return -($(this).height() / 2);
                    },
                    'margin-left': function () {
                        return -($(this).width() / 2);
                    }
                })
</script>