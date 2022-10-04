 <div class="container-fluid">

      <div class="row-fluid">

      <div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well"  id="date_range">
			 <div class="span4"><img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution"></div>
			 <div class="span4"></div>
			 <div class="span4"><p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p></div>
			
			<legend id="toplegend"><?php echo $content_title; ?> </legend>
			 <?php echo form_open($form_request,array('class'=>'form-horizontal','id'=>'formsearch'));?>

			<?php echo form_close();?>
			<br />
			
			 <div class="control-group">

								<table class="table table-bordered" id="cashier_datbl"  >
											<thead>
												<tr>
												  <th>Action</th>	
												  <th>MR Number</th>
												  <th>Reg Number</th>
												  <th>Identity Payment</th>
												  <th>Admit Date</th>
												  <th>Patient Name</th>
												  <th>Class Detail</th>
												  <th>Amount Deposit (Rp.)</th>
												  <th>Amount Used (Rp.)</th>
												  <th>Remaining (Rp.)</th>
												</tr>
											 </thead>
										<tbody>
										<?php foreach($deposit_list as $deposits) 
										{?>
										<tr>
										<td><a href="<?php echo base_url();?><?php echo $button_action;?><?php echo $deposits->RegId; ?>" data-target="#patientModal" role="button" data-toggle="modal" class="btn btn-mini btn-primary">trace</a> || 
										<a href="<?php echo base_url();?><?php echo $button_export;?><?php echo $deposits->RegId; ?>" data-target="#exportModal" role="button" data-toggle="modal"  class="btn btn-mini btn-info">Export</a></td>
										<td><?php echo $deposits->MRNum; ?></td>
										<td><?php echo $deposits->RegNum;?></td>
										<td><?php echo $deposits->IdentityType;?></td>
										<td><?php echo date('d-m-Y',strtotime($deposits->AdmitDate));?></td>
										<td><?php echo $deposits->PatientName;?></td>
										<td><b><?php echo $deposits->Class; ?></b>- Room : <?php echo $deposits->RoomName; ?><br />
										Bed No. :<?php echo $deposits->BedName; ?></td>
										<td><?php echo number_format($deposits->AmmountDeposit, 0, ',', '.') ;?></td>
										<td><?php echo number_format($deposits->AmmountUsed, 0, ',', '.') ;?></td>
										<td><?php echo number_format($deposits->Remaining, 0, ',', '.') ;?></td>
										<?php } ?>
										</tbody>
								</table>
			
			 </div>
	   
	    </div>
		  	<div class="row" align="right">
	  		<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
			</div>
	  </div>
			
</div>

<!-- Modal -->
<div class="modal hide fade" style="width:70%; margin: 0 0 0 -35%; " id="patientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h3 class="modal-title"><img src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution"></h3>

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

<!-- Modal -->
<div class="modal hide fade" style="width:70%; margin: 0 0 0 -35%; " id="exportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h3 class="modal-title"><img src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution"></h3>

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