{ "aaData": [
<?php
function clean($word)
{
$cleanstring =  trim(preg_replace('/[^a-zA-Z0-9-:@]/',' ', $word));
return $cleanstring;
} 
$i=0;
foreach($emrdata as $items) 
			  {if($i>0){echo', ';}?>
           		 [
                 "<?php echo clean($items->MedicalRecordNumber);?>",
				 "<?php echo clean($items->PatientName);?>",
                 "<?php echo clean($items->Birthplace);?>,<?php echo date('d M Y',strtotime($items->Birthdate));?>",
				 "<?php echo clean($items->Age);?>",
				 "<?php echo clean($items->AgeDetail);?>",
				 "<?php echo clean($items->Gender);?>",
				 "<?php echo clean($items->BloodType);?>",
				 "<?php echo clean($items->Weight);?>",
				 "<?php echo clean($items->Height);?>",
				 "<?php echo clean($items->IdentityType);?>",
				 "<?php echo clean($items->IdentityCardbNumber);?>",
				 "<?php echo clean($items->Email);?>",
                 "<?php echo clean($items->Address);?>",
				 "<?php echo clean($items->Address2);?>",
                 "<?php echo clean($items->PhoneNumber);?>/<?php echo $items->Fax;?>",
				 "<?php echo clean($items->PhoneNumber2);?>",
                 "<?php echo clean($items->City);?>",
                 "<?php echo clean($items->Province);?>",
                 "<?php echo clean($items->Country);?>",
                 "<?php echo clean($items->Ethnic);?>",
                 "<?php echo clean($items->Religion);?>",
                 "<?php echo clean($items->Marital);?>",
                 "<?php echo clean($items->Occupation);?>",
                 "<?php echo clean($items->Education);?>",                                   
                 "<?php echo clean($items->PayerInstitution);?>",
                 "<?php echo clean($items->PayerCategory);?>",
                 "<?php echo clean($items->CreatedByOn);?>"
                 ]
			<?php $i++;}?>
] }