
									<ul class="thumbnails">
									  <li class="span4">
										<div class="thumbnail">
										 <div class="caption">
											<h3>Purchase Request</h3>
										<table class="table">
										  <thead>
											<tr>
											  <th>Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total PR</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/pr/'.$startdate.'/'.$enddate, number_format($total_pr),array('title' => 'Get PR Detail'));?></td></tr>
													<tr><td>Total Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/itempr/'.$startdate.'/'.$enddate, number_format($total_pr_item),array('title' => 'Get Item PR Detail'));?></td></tr>
													<tr><td>Total Item Quantity</td><td><?php echo anchor('medicos_transaction_dashboard/get_details/itempr/'.$startdate.'/'.$enddate, number_format($total_pr_item_qty),array('title' => 'Get PR Detail'));?></td></tr>
												</tbody>
										</table>
										  </div>
										</div>
									  </li>
									  <li class="span4">
										<div class="thumbnail">
										  <div class="caption">
											<h3>Purchase Request Auto</h3>
											<table class="table">
											<thead>
											<tr>
											  <th>Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total PR</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/pr_auto/'.$startdate.'/'.$enddate, number_format($total_pr_auto),array('title' => 'Get PR Auto Detail'));?></td></tr>
													<tr><td>Total Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/pr_auto/'.$startdate.'/'.$enddate, number_format($total_pr_auto_item),array('title' => 'Get PR Auto Detail'));?></td></tr>
													<tr><td>Total Item Quantity</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/pr_auto/'.$startdate.'/'.$enddate, number_format($total_pr_auto_item_qty),array('title' => 'Get PR Auto Detail'));?></td></tr>
												</tbody>
											</table>
											</div>
										</div>
									  </li>
									  <li class="span4">
										<div class="thumbnail">
										  <div class="caption">
											<h3>Purchase Order</h3>
										<table class="table">
											<thead>
											<tr>
											  <th>Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total PO Multiple PR</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_multiple_pr/'.$startdate.'/'.$enddate, number_format($total_po_from_multiple_pr),array('title' => 'Get PO FROM Multiple PR'));?></td></tr>
													<tr><td>Total PO Single PR</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_single_pr/'.$startdate.'/'.$enddate, number_format($total_po_from_single_pr),array('title' => 'Get PO FROM Single PR'));?></td></tr>
													<tr><td>Total Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_item/'.$startdate.'/'.$enddate, number_format($total_po_item),array('title' => 'Total PO Item'));?></td></tr>
													<tr><td>Total ItemQty</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_item_qty/'.$startdate.'/'.$enddate, number_format($total_po_item_qty),array('title' => 'Total QTY PO Item'));?></td></tr>
													<tr><td>Total Supplier</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_supplier/'.$startdate.'/'.$enddate, number_format($total_po_supplier),array('title' => 'Total PO Supplier'));?></td></tr>
													<tr><td>Total Amount</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_amount/'.$startdate.'/'.$enddate,'Rp '.number_format($total_po_amount),array('title' => 'Total PO Supplier'));?></td></tr>
												
												</tbody>
											</table>
										</div>
										</div>
									  </li>
									</ul>
							</div>
							
							<div class="row-fluid">
									<ul class="thumbnails">
									  <li class="span4">
										<div class="thumbnail">
										 <div class="caption">
											<h3>PO Without PR</h3>
												<table class="table">
											<thead>
											<tr>
											  <th>Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total PO Without PR</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_without_pr/'.$startdate.'/'.$enddate, number_format($total_po_without_pr),array('title' => 'Total PO Without PR'));?></td></tr>
													<tr><td>Total PO Without PR Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_without_pr_item/'.$startdate.'/'.$enddate, number_format($total_po_without_pr_item),array('title' => 'Total PO Without PRItem'));?></td></tr>
													<tr><td>Total PO Without PR ItemQty</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_without_pr_item_qty/'.$startdate.'/'.$enddate, number_format($total_po_without_pr_item_qty),array('title' => 'Total QTY PO Without PR Item'));?></td></tr>
													<tr><td>Total PO Without PR Supplier</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_without_pr_supplier/'.$startdate.'/'.$enddate, number_format($total_po_without_pr_supplier),array('title' => 'Total PO Without PR Supplier'));?></td></tr>
													<tr><td>Total PO Without PR Amount</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_without_pr_amount/'.$startdate.'/'.$enddate,'Rp '.number_format($total_po_without_pr_amount),array('title' => 'Total PO Without PR Amount'));?></td></tr>
												
												</tbody>
											</table>
											</div>
										</div>
									  </li>
									  <li class="span4">
										<div class="thumbnail">
										   <div class="caption">
											<h3>PO Consignment</h3>
												<table class="table">
											<thead>
											<tr>
											  <th>Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total PO Consignment PR</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_consignment/'.$startdate.'/'.$enddate, number_format($total_po_consignment),array('title' => 'Total PO Consignment'));?></td></tr>
													<tr><td>Total PO Consignment PR Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_consignment_item/'.$startdate.'/'.$enddate, number_format($total_po_consignment_totalitem),array('title' => 'Total PO Consignment'));?></td></tr>
													<tr><td>Total PO Consignment PR ItemQty</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_consignment_item_qty/'.$startdate.'/'.$enddate, number_format($total_po_consignment_totalitem_qty),array('title' => 'Total QTY PO Consignment'));?></td></tr>
													<tr><td>Total PO Consignment PR Amount</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/po_consignment_amount/'.$startdate.'/'.$enddate,'Rp '.number_format($total_po_consignment_total_amount),array('title' => 'Total Amount PO Consignment'));?></td></tr>
											</tbody>
											</table>
											</div>
										</div>
									  </li>
									  <li class="span4">
										<div class="thumbnail">
										  <div class="caption">
											<h3>Good Receive Notes</h3>
												<table class="table">
											<thead>
											<tr>
											  <th>Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total GRN</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/grn/'.$startdate.'/'.$enddate, number_format($total_grn),array('title' => 'Total Good Receipt Note'));?></td></tr>
													<tr><td>Total GRN Partial</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/grn_partial/'.$startdate.'/'.$enddate, number_format($total_grn_partial),array('title' => 'Total GRN Partial'));?></td></tr>
													<tr><td>Total GRN Bonus</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/grn_bonus/'.$startdate.'/'.$enddate, number_format($total_grn_bonus),array('title' => 'Total GRN Bonus'));?></td></tr>
													<tr><td>Total GRN Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/grn_item/'.$startdate.'/'.$enddate, number_format($total_grn_totalitem),array('title' => 'Total GRN Item'));?></td></tr>
													<tr><td>Total GRN Quantity</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/grn_quantity/'.$startdate.'/'.$enddate, number_format($total_grn_totalqty),array('title' => 'Total GRN Quantity'));?></td></tr>
													<tr><td>Total GRN Supplier</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/grn_supplier/'.$startdate.'/'.$enddate, number_format($total_grn_supplier),array('title' => 'Grn Supplier'));?></td></tr>
													<tr><td>Total GRN Stock</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/grn_stock/'.$startdate.'/'.$enddate, number_format($total_qty_stock),array('title' => 'GRN Stock Card '));?></td></tr>
											</tbody>
											</table>
											</div>
										</div>
									  </li>
									</ul>
							</div>
							
							<div class="row-fluid">
									<ul class="thumbnails">
									  <li class="span4">
										<div class="thumbnail">
										 <div class="caption">
											<h3>Retun To Vendor</h3>
											<table class="table">
											<thead>
											<tr>
											  <th>Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total RTV Transaction</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/rtv/'.$startdate.'/'.$enddate, number_format($total_rtv),array('title' => 'Total Return To Vendor Transaction'));?></td></tr>
													<tr><td>Total RTV Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/rtv_item/'.$startdate.'/'.$enddate, number_format($total_rtv_item),array('title' => 'Total Item Return'));?></td></tr>
													<tr><td>Total RTV Item Quantity</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/rtv_item_qty/'.$startdate.'/'.$enddate, number_format($total_rtv_item_qty),array('title' => 'Total QTY Item Return'));?></td></tr>
													<tr><td>Total RTV Supplier</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/rtv_supplier/'.$startdate.'/'.$enddate,number_format($total_rtv_supplier),array('title' => 'Total Supplier '));?></td></tr>
												</tbody>
											</table>
											</div>
										</div>
									  </li>
									  <li class="span4">
										<div class="thumbnail">
										   <div class="caption">
											<h3>Stock Requisition</h3>
												<table class="table">
											<thead>
											<tr>
											  <th>Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total Stock Requisition</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/sr/'.$startdate.'/'.$enddate, number_format($total_sr),array('title' => 'Total Stock Requisition'));?></td></tr>
													<tr><td>Total Store</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/sr_store/'.$startdate.'/'.$enddate, number_format($total_store_request),array('title' => 'Total Store Request'));?></td></tr>
													<tr><td>Total SR Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/sr_item/'.$startdate.'/'.$enddate, number_format($total_sr_item),array('title' => 'Total Item On SR'));?></td></tr>
													<tr><td>Total SR Item Quantitity</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/sr_item_qty/'.$startdate.'/'.$enddate, number_format($total_sr_item_qty),array('title' => 'Total QTY Item Stock Requisition'));?></td></tr>
													</tbody>
											</table>
											</div>
										</div>
									  </li>
									  <li class="span4">
										<div class="thumbnail">
										  <div class="caption">
											<h3>Transfer Out/IN</h3>
											<table class="table">
											<thead>
											<tr>
											  <th>Transfer Out Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total Transfer Out</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/transfer_out/'.$startdate.'/'.$enddate, number_format($total_to),array('title' => 'Total Transfer Out Transaction'));?></td></tr>
													<tr><td>Total Store</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/to_store/'.$startdate.'/'.$enddate, number_format($total_to_stores),array('title' => 'Total Store Transfer Out'));?></td></tr>
													<tr><td>Total Item Transfer Out</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/to_item/'.$startdate.'/'.$enddate, number_format($total_to_item),array('title' => 'Total Transfer Out Item'));?></td></tr>
													<tr><td>Total Item Transfer Out Qty</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/to_item_qty/'.$startdate.'/'.$enddate, number_format($total_to_item_qty),array('title' => 'Total Quantity Transfer Out'));?></td></tr>
												</tbody>
											</table>
											
											<table class="table">
											<thead>
											<tr>
											  <th>Transfer IN Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total Transfer In</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/transfer_in/'.$startdate.'/'.$enddate, number_format($total_ti),array('title' => 'Total Transfer IN Transaction'));?></td></tr>
													<tr><td>Total Store</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/ti_store/'.$startdate.'/'.$enddate, number_format($total_ti_stores),array('title' => 'Total Store Transfer IN'));?></td></tr>
													<tr><td>Total Item Transfer In</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/ti_item/'.$startdate.'/'.$enddate, number_format($total_ti_item),array('title' => 'Total Transfer IN Item'));?></td></tr>
													<tr><td>Total Item Transfer In Qty</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/ti_item_qty/'.$startdate.'/'.$enddate, number_format($total_ti_item_qty),array('title' => 'Total Quantity Transfer IN'));?></td></tr>
												</tbody>
											</table>
											
											</div>
										</div>
									  </li>
									</ul>
							</div>
							
							<div class="row-fluid">
									<ul class="thumbnails">
									  <li class="span4">
										<div class="thumbnail">
										 <div class="caption">
											<h3>Stock Adjustment</h3>
											<table class="table">
											<thead>
											<tr>
											  <th>Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total Adjustment</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment/'.$startdate.'/'.$enddate, number_format($total_adjustment),array('title' => 'Total Adjustment Transaction'));?></td></tr>
													<tr><td>Total Adjustment Stores</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_store/'.$startdate.'/'.$enddate, number_format($total_adjustment_stores),array('title' => 'Total Adjustment Store'));?></td></tr>
													<tr><td>Total Adjustment Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_item/'.$startdate.'/'.$enddate, number_format($total_adjustment_item),array('title' => 'Total Adjustment Item'));?></td></tr>
													<tr><td>Total Adjustment Item Quantity</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_item_qty/'.$startdate.'/'.$enddate, number_format($total_adjustment_item_qty),array('title' => 'Total Adjustment Item Qty'));?></td></tr>
												</tbody>
											</table>
											</div>
										</div>
									  </li>
									  <li class="span4">
										<div class="thumbnail">
										   <div class="caption">
											<h3>Non Chargeable</h3>
											<table class="table">
											<thead>
											<tr>
											  <th>Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total Non Chargeable Regular</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment/'.$startdate.'/'.$enddate, number_format($total_adjustment_regular),array('title' => 'Total Adjustment Non Chargeable Regular Transaction'));?></td></tr>
													<tr><td>Total Non Chargeable Regular Stores</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_store/'.$startdate.'/'.$enddate, number_format($total_adjustment_regular),array('title' => 'Total Adjustment Non Chargeable Regular Store'));?></td></tr>
													<tr><td>Total Non Chargeable Regular Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_item/'.$startdate.'/'.$enddate, number_format($total_adjustment_regular_item),array('title' => 'Total Adjustment Non Chargeable Regular Item'));?></td></tr>
													<tr><td>Total Non Chargeable Regular Item Quantity</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_item_qty/'.$startdate.'/'.$enddate, number_format($total_adjustment_regular_item_qty),array('title' => 'Total Adjustment Non Chargeable Regular Item Qty'));?></td></tr>
													<tr><td>Total Non Chargeable Damage</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment/'.$startdate.'/'.$enddate, number_format($total_adjustment_damage),array('title' => 'Total Adjustment Non Chargeable Damage Transaction'));?></td></tr>
													<tr><td>Total Non Chargeable Damage Stores</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_store/'.$startdate.'/'.$enddate, number_format($total_adjustment_damage),array('title' => 'Total Adjustment Non Chargeable Damage Store'));?></td></tr>
													<tr><td>Total Non Chargeable Damage Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_item/'.$startdate.'/'.$enddate, number_format($total_adjustment_damage_item),array('title' => 'Total Adjustment Non Chargeable Damage Item'));?></td></tr>
													<tr><td>Total Non Chargeable Damage Item Quantity</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_item_qty/'.$startdate.'/'.$enddate, number_format($total_adjustment_damage_item_qty),array('title' => 'Total Adjustment Non Chargeable Damage Item Qty'));?></td></tr>
												</tbody>
											</table>
										</div>
										</div>
									  </li>
									  <li class="span4">
										<div class="thumbnail">
										  <div class="caption">
											<h3>Indirect Chargeable</h3>
											<table class="table">
											<thead>
											<tr>
											  <th>Validate Items</th>
											  <th>Value</th>
											</tr>
											</thead>
												<tbody>
													<tr><td>Total Indirect Chargeable Transaction</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment/'.$startdate.'/'.$enddate, number_format($total_adjustment_indirect),array('title' => 'Total Adjustment Indirect Chargeable Consumption Transaction'));?></td></tr>
													<tr><td>Total Indirect Chargeable Damage Stores</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_store/'.$startdate.'/'.$enddate, number_format($total_adjustment_indirect),array('title' => 'Total Adjustment Indirect Chargeable Consumption Store'));?></td></tr>
													<tr><td>Total Indirect Chargeable Damage Item</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_item/'.$startdate.'/'.$enddate, number_format($total_adjustment_indirect_item),array('title' => 'Total Adjustment Indirect Chargeable Consumption Item'));?></td></tr>
													<tr><td>Total Indirect Chargeable Damage Item Quantity</td><td><?php  echo anchor('medicos_transaction_dashboard/get_details/adjustment_item_qty/'.$startdate.'/'.$enddate, number_format($total_adjustment_indirect_item_qty),array('title' => 'Total Adjustment Indirect Chargeable Consumption Item Qty'));?></td></tr>
												</tbody>
											</table>
											</div>
										</div>
									  </li>
									</ul>
							