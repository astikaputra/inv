

<div class="container-fluid">
<h3>Nurse Dashboard</h3>
<div class="row well">
<p class="dashboard_header">
<img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">

<img class="hospital_logo" src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals">
</p>

<table class="table table-striped" >
        <thead>
                <tr>
                  <th>Patient Name</th> <th>MR Number</th><th>Doctor Name </th><th>Diagnose</th><th>Room</th><th>Bed Name</th><th>Bed Status</th><th>Class</th><th>Ward/Floor</th><th>Admit Date</th>
                </tr>
              </thead>
              <tbody>
			<?php foreach($listbedstatus as $items) 
			  {?>
                <tr>
                  <td><b><?php echo $items->PatientName;?></b></td>
				  <td><b><?php echo $items->MedicalRecordNumber;?></b></td>
                  <td><?php 
				  foreach($this->dashboard_info->get_doctorrel($items->RegId) as $doctor)
				  {
				  if($doctor->DoctorStatus=='(Primary)')
				  {
				  echo '<b>'.$doctor->DoctorName.' '.$doctor->DoctorStatus.'.</b> <br />';
				  }
				  else
				  {
				   echo '<small><i>'.$doctor->DoctorName.' '.$doctor->DoctorStatus.'.</i></small><br />';
				  }
				  }
				  ?></td>
				  <td><a class='btn btn-danger disabled'><?php echo $items->Diagnosis;?></a></td>
				  <td><?php echo $items->RoomName;?></td>
				  <td><?php echo $items->BedName;?></td>
				  <td><a class=' <?php if($items->BedStatus=='Vacant')
											{echo 'btn btn-success disabled';}
										else if($items->BedStatus=='Alloted Not Occupied')
											{echo 'btn btn-warning disabled';}
										else if($items->BedStatus=='Released Not Vacated')
											{echo 'btn btn-inverse disabled';}
										else if($items->BedStatus=='Occupied')
											{echo 'btn btn-primary disabled';}
											?>'><?php echo $items->BedStatus;?></a></td>
				  <td>
				
				  <div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion2" href="<?php echo '#history'.$items->AdmisionId;?>">
						<span class="badge badge-info"><?php echo $items->DAY;?> <i class="icon-arrow-right"></i> <?php echo $items->Class;?></span>
						</a>
					</div>
						<div id="<?php echo 'history'.$items->AdmisionId;?>" class="accordion-body collapse">
							<div class="accordion-inner">
				<?php
				  foreach($this->dashboard_info->get_historical_class($items->AdmisionId) as $class)
				  {
					echo '<center><i class="icon-arrow-up"></i><br /><br /><span class="label label-info"> <span class="badge badge-inverse"><b>'.$class->Classes.'</b></span> '.date('d M y H:i:s',strtotime($class->FromDate)).'<br/>'.$class->DAY.'</span></center><br />';
				  }
				  ?>
							</div>
						</div>
					</div>
				  </td>
				  <td><b><?php echo $items->WardName;?></b><br /><?php echo $items->Floor;?></td>
                   <td><?php echo date('d M Y H:i:s',strtotime($items->AdmitDate));?></td>
                </tr> 
			<?php }?>
			</tbody>
    </table>
  
  </div>
  <div class="row">
			<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>
			
  </div>
 </div>


