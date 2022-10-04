 <div class="container-fluid">

      <div class="row-fluid">

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
			<div class="control-group" id="filterreport" style="display:none;">
			<label class="control-label" for="Selecting Doctor">Order Type</label>
					<div class="controls">
						<label class="radio">
						  <input type="radio" name="ordertype" id="ordertype" data="All" value="all" checked>
							All
						</label>	
						<label class="radio">
						  <input type="radio" name="ordertype" id="ordertype" data="RETAIL" value="RETAIL">
							RETAIL
						</label>	
						<label class="radio">
						  <input type="radio" name="ordertype" id="ordertype" data="REGULAR" value="REGULAR" >
							REGULAR
						</label>	
					</div>
			<label class="control-label" for="Selecting Doctor">Select Doctor Name</label>
					<div class="controls">	
						<label class="radio">
						  <input type="radio" name="doctorcode" id="doctorcode" data="All Doctor" value="all" checked>
							All Doctor
						</label>	
						<?php 
						foreach($rad_doctor as $doctor)
							{
							?>
						<label class="radio">
						  <input type="radio" name="doctorcode" id="doctorcode" data="<?php echo $doctor->Name;?>" value="<?php echo $doctor->Code;?>">
							<?php echo $doctor->Name;?>
						</label>
						<?php 
						}
						?>					  
					</div>

			</div>
			<input type="submit" name="paramsubmit" value="Get Data" class="btn"></input>
			<?php echo form_close();?>
			<br />
			
			 <div class="control-group" id="reportdata" style="display:none;">
				<legend id="dashboard_legend"></legend>
					<a href="#" class="btn btn-primary" style="display:none; align:right; position: fixed; top: 7em; right: 45px;z-index:10;" id="searchdataagain">Change Date Parameter</a>
					<div class="row-fluid" id="dashboard_data" style="display:none";>		
					</div>		
			  </div>
	   
		<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
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
								$("#filterreport").show("slow");		
								$("#dpd1").prop("required", false);
								$("#dpd2").prop("required", false);
								$("#dpd1").val('');
								$("#dpd2").val('');
							} 
							else
							{	
								$("#custom_range").show("slow");	
								$("#filterreport").show("slow");	
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
							var doctorname = $("input:radio[name=doctorcode]:checked" ).attr('data');
							var ordertype = $("input:radio[name=ordertype]:checked" ).attr('data');
				
							if(startdaterange == '')
							{
							startdaterange = '<?php echo date('Y-m-d',now());?>';
							enddaterange = '<?php echo date('Y-m-d',now());?>';
							}							
							var url = $(this).attr('action');
							var posting = $.post(url,$("#formsearch").serialize());
							$("#waiting").show("slow");
							$("#dashboard_legend").html('');
							$("#dashboard_legend").append("<?php echo $content_title; ?> | ["+ordertype+" Transaction] By <strong>"+ doctorname +"</strong> from "+startdaterange+" to "+enddaterange);
							posting.done(function(data){
									  $("#waiting").hide();
									  $( "#dashboard_data").empty().append(data);
									  $( "#dashboard_data").show("slow");
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