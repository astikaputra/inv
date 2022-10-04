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
           		 ["<?php echo clean($items->MedicalRecordNumber);?>",
				 "<?php echo clean($items->RegistrationCode);?>",
				 "<?php echo clean($items->PatientName);?>",
                 "<?php echo clean($items->Birthplace);?>,<?php echo date('d M Y',strtotime($items->Birthdate));?>",
				 "<?php echo clean($items->Age);?>",
				 "<?php echo clean($items->Gender);?>",
				 "<?php echo clean($items->BloodType);?>",
				 "<?php echo clean($items->Weight);?>",
				 "<?php echo clean($items->Height);?>",
				 "<?php echo clean($items->IdentityType);?>",
				 "<?php echo clean($items->IdentityCardbNumber);?>",
                 "<?php echo clean($items->Address);?>",
                 "<?php echo clean($items->PhoneNumber);?>/<?php echo clean($items->Fax);?>",
                 "<?php echo clean($items->City);?>",
                 "<?php echo clean($items->Province);?>",
                 "<?php echo clean($items->Country);?>",
                 "<?php echo clean($items->Ethnic);?>",
                 "<?php echo clean($items->Religion);?>",
                 "<?php echo clean($items->Marital);?>",
                 "<?php echo clean($items->Occupation);?>",
                 "<?php echo clean($items->Education);?>",
                 "<?php echo clean($items->RegistrationTime);?>",
                 "<?php echo clean($items->RegisteredBy);?>",                    
                 "<?php echo clean($items->PatientsDescription);?>",                  
                 "<?php echo clean($items->PayerInstitution);?>",
                 "<?php echo clean($items->PayerCategory);?>",
                 "<?php echo date('d M Y',strtotime($items->RegistrationTime));?>",
                 "<?php echo clean($items->LOB);?>",
                 "<?php echo clean($items->Triage);?>",
			     "<?php echo clean($items->DoctorsCode);?>",
				 "<?php echo clean($items->DoctorName);?>",
				 "<?php echo clean($items->Position);?>",
                 "<?php echo clean($items->SpecialistGroup);?>",
                 "<?php echo clean($items->Specialist);?>",
                 "<?php echo clean($items->SubSpecialist);?>",
                 "<?php echo clean($items->AdmissionDiagnosis);?>",
                 "<?php echo clean($items->DoctorNoteDiagnose);?>",
                 "<?php echo clean($items->DoctorNoteDiagnoseICDCode);?>",
                 "<?php echo clean($items->DoctorNoteICDCode);?>",
                 "<?php echo clean($items->DoctorNoteICDName);?>",                  
                 "<?php echo clean($items->Classes);?>",                                                                       
                 "<?php echo clean($items->Wards);?><?php echo clean($items->Floor);?>",
                 "<?php echo clean($items->Rooms);?>",
                 "<?php echo clean($items->Beds);?>",                    
                 "<?php echo clean($items->Bedtypes);?>",
                 "<?php echo clean($items->FromDate);?>", 
                 "<?php echo clean($items->ToDate);?>",                    
                 "<?php echo clean($items->LengthOfStay);?>",
                 "<?php echo clean($items->CloseDate);?>"
                ]
			<?php $i++;}?>
] }