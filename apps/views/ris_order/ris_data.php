 
			<table class="table table-striped">
			  <thead>
                <tr>
                  <th>Patient MRN</th><th>Patient FullName</th><th>Study Description</th><th>Study Date</th><th>Report Date</th><th>Report By</th><th>Action</th>
                </tr>
              </thead>
              <tbody>
              		<?php 
              		foreach ($ris_undefined_data as $ris) {
              			$doctordata = $this->ris_interfacing->matching_doctor(get_firstname($ris->SignedOffBy));
              		?>
              		<tr>
              			<td><?php echo $ris->PatientMRNo;?></td>
              			<td><?php echo $ris->PatientFullName;?></td>
              			<td><?php echo $ris->StudyDescription;?></td>
              			<td><?php echo $ris->StudyDate;?></td>
              			<td><?php echo $ris->ReportDateTime;?></td>
              			<td><?php echo $doctordata->PhysicianPerformingName;?></td>
              			<td>
              				<?php 
              				$hiddendata  = array('rec_id' => $recid,
              									 'studyiud' => $ris->studyInstanceUid,
              									 'studydate' => $ris->StudyDate,
              									 'AccessionNo' => $ris->AccessionNo,
              									 'TechnicalNote' => $ris->TechnicalNotes,
              									 'ReportDate' => $ris->ReportDateTime,
              									 'doctorcode' => trim($doctordata->PhysicianPerformingCode),
              									 'doctorname' => $doctordata->PhysicianPerformingName,
              									 'doctoremail' => $doctordata->PhysicianPerformingEmail
              									  );
              				echo form_open('manage_ris_order/save_doctor_correction',"",$hiddendata);
              				?>
              					<input type="submit" name="studymatchingsubmit" value="Select This Record" class="btn btn-primary">
              				<?php
              				echo form_close();
              				?>
              			</td>

              		</tr>

              	<?php
              		}

              		?>

              </tbody>

			</table>

<?php 
function get_firstname($name){
	$namearr = explode('.', $name);
	return $namearr[0];
}

?>
