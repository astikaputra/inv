
			<table class="table">
              <thead>
                <tr>
                  <th>#</th>
				  <th>Doctor Radiology Before Revised</th>
				  <th>Doctor Radiology After Revised</th>
			      <th>Revised Date</th>
                  <th>Revised By</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
			  $i = 1;
			  foreach($overide_log as $data)
			  {
			  $currentval = json_decode($data->CurrentValue);
			  $beforeval = json_decode($data->BeforeValue);
			  ?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo ($beforeval->InfHIS_DoctorRadCode == null) ? $beforeval->PhysicianPerformingCode.' | '.$beforeval->PhysicianPerformingName : $beforeval->InfHIS_DoctorRadCode.' | '.$beforeval->InfHIS_DoctorRadName; ?> </td>
				  <td><?php echo $currentval->InfHIS_DoctorRadCode; ?> | <?php echo $currentval->InfHIS_DoctorRadName;?></td>
				  <td><?php echo date('d M Y H:i:s',strtotime($currentval->InfHIS_DoctorRadCreatedDate));?></td> 
                  <td><?php echo $currentval->InfHIS_DoctorRadCreatedBy;?></td>
                </tr>
               <?php $i++;}?>
              </tbody>
            </table>
