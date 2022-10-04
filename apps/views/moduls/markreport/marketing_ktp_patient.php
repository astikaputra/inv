{ "aaData": [
<?php 
function clean($word)
{
$cleanstring =  trim(preg_replace('/[^a-zA-Z0-9-:]/',' ', $word));
return $cleanstring;
}
$i=0;
foreach($all_ktp_report as $items) 
			  {if($i>0){echo', ';}?>
			  [	 
			  	"<?php echo $i;?>",
				 "<?php echo $items->PatientName;?>",
				 "<?php echo $items->Address;?>",
				 "<?php echo $items->Cities;?>",
                 "<?php echo $items->Email;?>",
                 "<?php echo $items->Nationality;?>",
				 "<?php echo $items->CreatedOn;?>",
				 "<?php echo $items->ModifiedOn;?>"                           
               ]
			<?php $i++;}?>
] }