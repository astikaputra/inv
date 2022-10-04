<div class="container-fluid">
<div class="row-fluid">
			<div class="well">
			 <div class="span4"><img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution"></div>
			 <div class="span4"></div>
			 <div class="span4"><p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p></div>

<h3 class="text-center"><?php echo $exp_title;?></h3>
<div class="table-responsive">
<?php 
if($exp_page == "item_expired")
{
?>
<table class="table table-bordered" id="expired_name_item_grid" >
        <thead>
                <tr>
					<th>No.</th>
					<th>Barcode</th>	
					<th>GRN Number</th>
					<th>Item Code</th>
					<th>Item Name</th>
					<th>Expiry Date</th>
					<th>Supplier</th>
					<th>Qty Expire</th>
					<th>UOM Sell</th>
					<th>Item Base Price</th>
                </tr>
              </thead>
              <tbody>
		
			</tbody>
    </table>
<?php }
else if($exp_page == "store_expired")
{
?>
<table class="table table-bordered" id="expired_store_item_grid" >
        <thead>
                <tr>
					<th>No.</th>
					<th>Barcode</th>	
					<th>GRN Number</th>
					<th>Store Name</th>
					<th>Expiry Date</th>
					<th>Supplier</th>
					<th>Qty Expire</th>
					<th>UOM Sell</th>
					<th>Item Base Price</th>
                </tr>
              </thead>
              <tbody>
		
			</tbody>
    </table>
    <?php }
else if($exp_page == "item_expiring")
{
?>
<table class="table table-bordered" id="expiring_name_item_grid" >
        <thead>
                <tr>
					<th>No.</th>
					<th>Barcode</th>	
					<th>GRN Number</th>
					<th>Item Code</th>
					<th>Item Name</th>
					<th>Expiry Date</th>
					<th>Supplier</th>
					<th>Qty Expire</th>
					<th>UOM Sell</th>
					<th>Item Base Price</th>
                </tr>
              </thead>
              <tbody>
		
			</tbody>
    </table>
<?php
}
else if($exp_page == "store_expiring")
{
?>
<table class="table table-bordered" id="expiring_store_item_grid" >
        <thead>
                <tr>
					<th>No.</th>
					<th>Barcode</th>	
					<th>GRN Number</th>
					<th>Store Name</th>
					<th>Expiry Date</th>
					<th>Supplier</th>
					<th>Qty Expire</th>
					<th>UOM Sell</th>
					<th>Item Base Price</th>
                </tr>
              </thead>
              <tbody>
		
			</tbody>
    </table>
<?php
}
?>
	</div>

  <div class="row">
	    <div class="span12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>	
  </div>
 </div>
 </div>
</div> 

 <script >
 			$(document).ready(function() {
			
					TableTools.DEFAULTS.aButtons = [
							"copy",
							"print",
							{
								"sExtends":    "collection",
								"sButtonText": 'Save <span class="caret" />',
								"aButtons":    [ "csv", "xls",
								{
								"sExtends": "pdf",
								"sPdfOrientation": "landscape"
								}
								]
							}
						];
						
					TableTools.DEFAULTS.sSwfPath = "<?php echo $this->config->item('template').'TableTools';?>/media/swf/copy_csv_xls_pdf.swf";
			
					var ExpedNameTable = $("#expired_name_item_grid").dataTable( {
					"aLengthMenu": [[10, 25, 25, 20, 50,-1], [10, 25, 25, 20, 50,"All"]],
					"iDisplayLength": 10,
					"sPaginationType": "full_numbers",
					"sAjaxSource": '<?php echo base_url().'inventory_report/get_name_item_expired_data/'.$startdate.'/'.$enddate;?>',
					"sDom": "<'row'<'span8'l><'span8'f>r>t<'row'<'span8'i><'span8'p>>",
					"sDom": 'T<"clear">pfrtli'	
					} );
					
					var ExpedStoreTable = $("#expired_store_item_grid").dataTable( {
					"aLengthMenu": [[10, 25, 25, 20, 50,-1], [10, 25, 25, 20, 50,"All"]],
					"iDisplayLength": 10,
					"sPaginationType": "full_numbers",
					"sAjaxSource": '<?php echo base_url().'inventory_report/get_store_item_expired_data/'.$startdate.'/'.$enddate;?>',
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": "<T<'span2'f>r>t<'row-fluid'<'span6'i><'span6'p>>"
					} );
					
					var ExpigNameTable = $("#expiring_name_item_grid").dataTable( {
					"aLengthMenu": [[10, 25, 25, 20, 50,-1], [10, 25, 25, 20, 50,"All"]],
					"iDisplayLength": 10,
					"sPaginationType": "full_numbers",
					"bAutoWidth": false,
					"sAjaxSource": '<?php echo base_url().'inventory_report/get_name_item_expiring_data/'.$startdate.'/'.$enddate;?>',
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli'	
					} );
					
					var ExpigStoreTable = $("#expiring_store_item_grid").dataTable( {
					"aLengthMenu": [[10, 25, 25, 20, 50,-1], [10, 25, 25, 20, 50,"All"]],
					"iDisplayLength": 10,
					"sPaginationType": "full_numbers",
					"bAutoWidth": false,
					"sAjaxSource": '<?php echo base_url().'inventory_report/get_store_item_expiring_data/'.$startdate.'/'.$enddate;?>',
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli'	
					} );
					
					});
 </script>

