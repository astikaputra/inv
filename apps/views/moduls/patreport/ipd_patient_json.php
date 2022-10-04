{ "aaData": [
<?php 
function clean($word)
{
$cleanstring =  trim(preg_replace('/[^a-zA-Z0-9-:]/',' ', $word));
return $cleanstring;
}
$i=0;
foreach($ipddata as $items) 
			  {if($i>0){echo', ';} $i++;?>
           		 [
				 "<?php echo $i;?>",
				 "<?php echo $items->PatientName;?>,<?php echo $items->MedicalRecordNumber;?>",
				 "<?php echo clean($items->Diagnosis);?>",
				 "<?php echo clean($items->RoomName);?>",
				 "<?php echo clean($items->BedName);?>",				 
				 "<?php echo clean($items->WardName);?>",
				 "<?php echo date('d M Y',strtotime($items->AdmitDate));?>"
                ]
			<?php }?>
] }