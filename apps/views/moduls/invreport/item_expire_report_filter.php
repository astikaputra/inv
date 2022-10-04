 <div class="container-fluid">

      <div class="row-fluid">

      <div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well"  id="date_range">
			 <div class="span4"><img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution"></div>
			 <div class="span4"></div>
			 <div class="span4"><p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p></div>
			
			<legend id="toplegend"><?php echo $content_title; ?> </legend>
			 <?php echo form_open($form_request,array('class'=>'form-horizontal','id'=>'formsearch'));?>

			  <div class="control-group">
				<label class="control-label" for="datarange">Data Range</label>
				<div class="controls">
							<label class="radio">
							<input type="radio" name="optionsRadiosDaterange" id="datarange1" value="last3month" onclick="changetext(this)" >
								Expired Item
							</label>
							<label class="radio">
								<input type="radio" name="optionsRadiosDaterange" id="datarange2" value="customrange" onclick="changetext(this)">
								Expiring Item
							</label>
				</div>
			  </div>
			  <div class="control-group" id="custom_range" style="display:none;">
				<label class="control-label" for="CustomRangeStartdate">Start Date</label>
				<div class="controls"> <input type="text" name="startdate" class="span3" value="" id="dfd1" required placeholder="Start Date"></p></div>
				<label class="control-label" for="CustomRangeEndDater">End Date</label>
				<div class="controls"> <input type="text" name="enddate" class="span3" value="" id="dfd2" required placeholder="End Date"></p></div>
			  </div>
				<div class="control-group" id="filterzerodata" style="display:none;">
				
					<div class="controls">
					 <legend><small>Filter Data Format</small></legend>
						<label class="radio">
							<input type="radio" name="zerofilterdata" id="optionsRadios1" value="withzerostock">
								By Item Name
							</label>
							<label class="radio">
								<input type="radio" name="zerofilterdata" id="optionsRadios2" value="withoutzerostock">
								By Store Name
						</label>
					<br />
					<br />					
					<button type="submit" class="btn btn-primary" onClick="load_progress();">Get The Patient Information</button>		

				</div>
			</div>
			<?php echo form_close();?>
			<br />
			
			 <div class="control-group" id="reportdata" style="display:none;">
						<legend><?php echo $content_title; ?> | <a href="#" class="btn btn-primary" style="display:none" id="searchdataagain">Search Again</a> </legend>
						<?php echo $startdate;?>
							<div class="well" >
								<table class="table table-striped table-bordered" id="reportdatatable"  >
											<thead>
												<tr>
												  <th>Barcode</th>	
												  <th>GRN Number</th>
												  <th>Item Code</th>
												  <th>Item Name</th>
												  <th>Expiry Date</th>
												  <th>Supplier</th>
												  <th>Qty Expire</th>
												  <th>UOM Sell</th>
												</tr>
											 </thead>
										<tbody></tbody>
								</table>
							</div>
			
			 </div>
	   
		<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		<div class="row" align="right">
	  
		</div>
	    </div>
	
	  </div>
</div>
<script>
$(function(){
    
$('input:radio[name="optionsRadiosDaterange"]').change(
                        function(){
							$("#reportdata").hide("slow");
                            if ($(this).is(':checked') && $(this).val() == 'last3month') {
								$("#custom_range").hide("slow");	
								$("#filterzerodata").show("slow");		
								$("#dfd1").prop("required", false);
								$("#dfd2").prop("required", false);
								$("#dfd1").val('');
								$("#dfd2").val('');
							} 
							else
							{	
								$("#custom_range").show("slow");	
								$("#filterzerodata").show("slow");	
								$("#dfd1").prop("required", true);
								$("#dfd2").prop("required", true);	
								$("#dfd1").focus();
							}
                        }
                    );

$("#searchdataagain").click(
					function(){
							$('#reportdatatable').dataTable().fnClearTable();
							$("#reportdata").hide("slow");
							$("#formsearch").show("slow");
							$("#toplegend").show("slow");
							$("#searchdataagain").hide("slow");
							event.preventDefault();
						}
					);
					
});
</script>