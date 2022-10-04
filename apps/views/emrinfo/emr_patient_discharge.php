{ "aaData": [
<?php
function clean($word)
{
$cleanstring =  trim(preg_replace('/[^a-zA-Z0-9-:]/',' ', $word));
return $cleanstring;
} 
$i=0;
foreach($emrdata as $items) 
			  {if($i>0){echo', ';}?>
           		 [
                 "<?php echo clean($items->MedicalRecordNumber);?>",
				 "<?php echo clean($items->RegistrationCode);?>",
				 "<?php echo clean($items->PatientName);?>",
				 "<?php echo clean($items->Classes);?>",
				 "<?php echo date('d M Y h:i:s A',strtotime($items->RegistrationTime));?>",
				 "<?php echo date('d M Y h:i:s A',strtotime($items->ToDate));?>",
				 "<?php echo date('d M Y h:i:s A',strtotime($items->CloseDate));?>",
				 "<?php echo clean($items->LOB);?>",
				 "<?php echo clean($items->PatientsDescription);?>",
				 "<?php echo clean($items->PatientsCategory);?>",
				 "<?php echo clean($items->Birthplace);?>",
				 "<?php echo date('d M Y ',strtotime($items->Birthdate));?>",
				 "<?php echo clean($items->Age);?>",
                 "<?php echo clean($items->Address);?>",
                 "<?php echo clean($items->PhoneNumber);?>/<?php echo $items->Fax;?>",
                 "<?php echo clean($items->Country);?>",
                 "<?php echo clean($items->Ethnic);?>",
                 "<?php echo clean($items->Religion);?>",
                 "<?php echo clean($items->PayerInstitution);?>",
                 "<?php echo clean($items->PayerCategory);?>",
                 "<?php echo clean($items->CreatedByOn);?>"
                 ]
			<?php $i++;}?>
] }