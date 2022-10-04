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
							<input type="radio" name="optionsRadiosDaterange" id="datarange1" value="today" onclick="changetext(this)" >
								<?php echo date('l jS F Y',now());?>
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
			<button type="button" class="btn" data-toggle="collapse" data-target="#get_finance_rep">Optional Filter</button>
				<br />
				<br />
				<div id="get_finance_rep" class="collapse">
                <div class="dropdown">
			     <label class="control-label" for="lob_filter" > Filter By LOB : </label>
			     <select class="selectpicker form-control" id="lob_filter" name="lob" data-live-search="true">
                 <option value="All" selected="selected">All LOB</option>
			     <option value="OPD">OPD</option>
                 <option value="IPD">IPD</option>
                 <option value="ETC">ETC</option>
                 <option value="MCU">MCU</option>
			     </select>
                </div>
				<br />
                <div class="dropdown">
			     <label class="control-label" for="los_filter" > Filter By LOS : </label>
			     <select class="selectpicker form-control" id="los_filter" name="los" data-live-search="true">
			     <option value="All" selected="selected">All LOS</option>
				    <?php foreach($los_list as $loses): ?>
				    <option value="<?php echo $loses->LOSName; ?>" ><?php echo $loses->LOSName; ?></option>	
				    <?php endforeach; ?>
			     </select>
                </div>
                </div>
				</div>
			</div>
			<center>
			<input type="submit" name="paramsubmit" value="Get Data" class="btn btn-primary"></input>
			</center>
			<?php echo form_close();?>
			<br />

			 <div class="control-group" id="reportdata" style="display:none;">
						<legend><?php echo $content_title; ?> | <a href="#" class="btn btn-primary" style="display:none" id="searchdataagain">Search Again</a> </legend>
						
					<div class="row-fluid" id="dashboard_data">		
							<table class="table table-striped table-bordered" id="reportdatatable"  >
											<thead>
												<tr>
												  <th>No.</th>
												  <th>Bill Date</th>	
												  <th>Bill Create Date</th>
												  <th>Bill No.</th>
												  <th>Reg. No.</th>
												  <th>Reg.Time</th>
												  <th>Patient Name</th>
												  <th>Sex</th>
												  <th>Birthdate</th>
												  <th>Age</th>
												  <th>Address</th>
												  <th>ID Types</th>
												  <th>Nationality</th>
												  <th>LOB</th>
												  <th>Doctor Code</th>
												  <th>Doctor Name</th>
												  <th>Ref. Doctor</th>
												  <th>Sub. Specialist</th>
												  <th>Specialist</th>
												  <th>Group Specialist</th>
												  <th>Room</th>
												  <th>Class</th>
												  <th>Item Code</th>
												  <th>Service Code</th>
												  <th>Service Name</th>
												  <th>Service LOS</th>
												  <th>Qty</th>
												  <th>Item Price</th>
												  <th>Bill Amount</th>
												  <th>Payer Amount</th>
												  <th>Doctor Fee</th>
												  <th>Discount</th>
												  <th>Payer Name</th>
												  <th>PayerType</th>
												  <th>Payment Method</th>
												  <th>Status</th>
												  <th>Is Retail</th>
												  <th>Triage</th>
												  <th>Admit Date</th>
												  <th>PaymentStatus</th>
												</tr>
											 </thead>
										<tbody></tbody>
								</table>
							</div>
					</div>	
			 </div>			
			
		<div class="row" align="right">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		</div>
	    </div>

	  </div>
</div>
<script>
$(function(){
    
$('input:radio[name="optionsRadiosDaterange"]').change(
                        function(){
							$("#reportdata").hide("slow");
                            if ($(this).is(':checked') && $(this).val() == 'today') {
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
					function(event){
							$( "#dashboard_data").empty();	
							var dashboardname = '';
							var startdaterange = this['startdate'].value;
							var enddaterange = this['enddate'].value;
							var lob_type = $("select:selectpicker[name=lob]:selected" ).val();
							var los_type = $("select:selectpicker[name=los]:selected" ).val();
							if(report_type == 'All')
								{ dashboardname = 'All LOB'; }
							else if(report_type == 'OPD')
								{ dashboardname	= 'OPD LOB';}
							else if(report_type == 'IPD')
								{ dashboardname	= 'IPD LOB';}
							else if(report_type == 'ETC')
								{ dashboardname	= 'ETC LOB';}
							else if(report_type == 'MCU')
								{ dashboardname	= 'MCU LOB';}
							if(startdaterange == '')
							{
							startdaterange = '<?php echo date('Y-m-d',now());?>';
							enddaterange = '<?php echo date('Y-m-d',now());?>';
							}							
							var url = $(this).attr('action');
							var posting = $.post(url,$("#formsearch").serialize());
							$("#waiting").show("slow");
							$("#dashboard_legend").html('');
							$("#dashboard_legend").append("<?php echo $content_title; ?> | "+dashboardname+" from "+startdaterange+" to "+enddaterange);
							posting.done(function(data){
									  $("#waiting").hide();
									  $( "#dashboard_data").empty().append(data);
									  });
									  
							$("#formsearch").hide("slow");
							$("#toplegend").hide("slow");
							$("#searchdataagain").show("slow");
							$("#reportdata").show("slow");
							$("#searchdataagain").show("slow");							

							
                            event.preventDefault();
						}
					);

$("#searchdataagain").click(
					function(event){
							$("#reportdata").hide("slow");
							$("#formsearch").show("slow");
							$("#toplegend").show("slow");
							$("#searchdataagain").hide("slow");
							event.preventDefault();
						}
					);
					
});
</script>

   <script type="text/javascript">
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'All Service'
            });

            // $('.selectpicker').selectpicker('hide');
        });
    </script>