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
								Last 3 Month
							</label>
							<label class="radio">
								<input type="radio" name="optionsRadiosDaterange" id="datarange2" value="customrange" onclick="changetext(this)">
								Custom Date Range
							</label>
				</div>
			  </div>
			  <div class="control-group" id="custom_range" style="display:none;">
				<label class="control-label" for="CustomRangeStartdate">Start Date</label>
				<div class="controls"> <input type="text" name="startdate" class="span3" value="" id="dpd1" required placeholder="Start Date"></p></div>
				<label class="control-label" for="CustomRangeEndDater">End Date</label>
				<div class="controls"> <input type="text" name="enddate" class="span3" value="" id="dpd2" required placeholder="End Date"></p></div>
			  </div>
				<div class="control-group" id="filterzerodata" style="display:none;">
				
					<div class="controls">
					 <legend><small>Filter Data</small></legend>
						<label class="radio">
							<input type="radio" name="zerofilterdata" id="optionsRadios1" value="withzerostock">
								With 0 Stock In Hand
							</label>
							<label class="radio">
								<input type="radio" name="zerofilterdata" id="optionsRadios2" value="withoutzerostock">
								Without 0 Stock In Hand
						</label>
							
					  <input type="submit" name="paramsubmit" value="Get Data" class="btn"></input>
				</div>
			</div>
			<?php echo form_close();?>
			<br />
			
			 <div class="control-group" id="reportdata" style="display:none;">
						<legend><?php echo $content_title; ?> | <a href="#" class="btn btn-primary" style="display:none" id="searchdataagain">Search Again</a> </legend>
						
							<div class="well" >
								<table class="table table-striped table-bordered" id="reportdatatable"  >
											<thead>
												<tr>
												  <th>Item Code</th>	
												  <th>Item Name</th>
												  <th>Categories</th>
												  <th>Store Name</th>
												  <th>Stock On Hand</th>
												  <th>Unit Cost</th>
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
								$("#dpd1").prop("required", false);
								$("#dpd2").prop("required", false);
								$("#dpd1").val('');
								$("#dpd2").val('');
							} 
							else
							{	
								$("#custom_range").show("slow");	
								$("#filterzerodata").show("slow");	
								$("#dpd1").prop("required", true);
								$("#dpd2").prop("required", true);	
								$("#dpd1").focus();
							}
                        }
                    );
					
$("form").submit(
					function(){
							var reportrange =  $("input:radio[name=optionsRadiosDaterange]:checked" ).val();
							var zerofilter = $("input:radio[name=zerofilterdata]:checked" ).val();
							var startdaterange = this['startdate'].value;
							var enddaterange = this['enddate'].value;
							$("#formsearch").hide("slow");
							$("#toplegend").hide("slow");
							$("#searchdataagain").show("slow");
							$("#reportdata").show("slow");
							var slowmovingstock = $('#reportdatatable').dataTable({
							"aLengthMenu": [[10,25, 50,100,-1], [10,25,50,100,"All"]],
							"iDisplayLength": 100,
							  "aoColumns": [
											{ "mData": "ItemCode"},
											{ "mData": "ItemName"},
											{ "mData": "Categories"},
											{ "mData": "StoreName"},
											{ "mData": "StockOnHand"},
											{ "mData": "UnitCost"}
										 ],
							"sAjaxSource":  $(this).attr('action'),
							"bDestroy": true,
							"bProcessing":true,
							"sPaginationType": "full_numbers",
							"bAutoWidth": false,
							"sDom": '<"top"i>rt<"bottom"flp><"clear">',
							"sDom": 'T<"clear">pfrtli',
							"fnServerData": function ( sSource, aoData, fnCallback, oSettings) {

							   aoData.push( { "name": "optionsRadiosDaterange", "value": reportrange },
											{ "name": "zerofilterdata", "value": zerofilter } ,
											{ "name": "startdate", "value": startdaterange } ,
											{ "name": "enddate", "value": enddaterange} 
											);
							   oSettings.jqXHR = $.ajax({
											"dataType": 'json',
											"type": "POST",
											"url": sSource,
											"data": aoData,
											"success": fnCallback
										  });
							}
							});
							$("#reportdatatable").css("width","100%");
							
                            event.preventDefault();
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