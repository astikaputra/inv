{ "aaData": [
<?php 
function clean($word)
{
$cleanstring =  trim(preg_replace('/[^a-zA-Z0-9-:]/',' ', $word));
return $cleanstring;
}
$i=0;
foreach($expdata as $items) 
			  {if($i>0){echo', ';} $i++;?>
           		 [
				 "<?php echo $i;?>",
				 "<?php echo clean($items->BatchBarcode);?>",
				 "<?php echo clean($items->CodeValue);?>",
				 "<?php echo clean($items->StoreName);?>",
				 "<?php echo date('d M Y',strtotime($items->ExpDate));?>",
                 "<?php echo clean($items->SuppName);?>",
				 "<?php echo clean($items->QtyOnBatch);?>",
				 "<?php echo clean($items->SellUom);?>",
				 "<?php echo clean($items->CostValuePerItem);?>"				 
                ]
			<?php }?>
] }