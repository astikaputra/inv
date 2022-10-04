<?php
date_default_timezone_set('Asia/Jakarta');
$timestamp = date('d-M-Y H:i:s',time());
?>
Stock Alert, Date: <?php echo date('d M Y,',time());?> &nbsp Time <?php echo date('H:i:s',time()); ?>
<table class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Item Code</th>
                  <th>Item Name</th>
				  <th>UOM</th>
                  <th>Current SOH</th>
				  <th>Min Stock</th>
				  <th>Max Stock</th>
				  <th>Purchase Price</th>
				  <th>Distributor</th>
				  <th>Manufacture</th>
                </tr>
              </thead>
              <tbody>
			  <?php $i = 0;
				foreach($list_item as $item)
				{ $i++;
				?>
				<tr>
				  <td><?php echo $i; ?></td>
                  <td><?php echo $item->ItemCode; ?></td>
                  <td><?php echo $item->ItemName; ?></td>
				  <td><?php echo $item->SellUom; ?></td>
				  <td><?php if(($item->QtyOnHand) == ($item->MinValue))
				  {echo '<a class="btn btn-warning disabled" title="Stock On Hand">'.$item->QtyOnHand.'</a>';}
				  else
				  {echo '<a class="btn btn-inverse disabled" title="Stock On Hand">'.$item->QtyOnHand.'</a>';} ?></td>
				  <td><?php echo '<a class="btn btn-warning disabled" title="Minimum Stock">'.$item->MinValue.'</a>'; ?></td>
				  <td><?php echo '<a class="btn btn-primary disabled" title="Maximum Stock">'.$item->MaxValue.'</a>'; ?></td>
				  <td>Rp <?php echo round($item->OrderPrice); ?></td>
				  <td><?php echo $item->Supplier; ?></td>
				  <td><?php if($item->Manufacture == 'UNDEFINED') {echo '';}else {echo $item->Manufacture; }  ?></td>
                </tr>
				<?php }?>
           	 </tbody>
  </table>
