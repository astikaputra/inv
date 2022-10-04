 <div class="container-fluid">

      <div class="row-fluid">
					<h3> <?php echo $content_title; ?> </h3>
      <div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well"  id="date_range">
			<img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">
			<p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
			<br />
			<br />
			<br />
			<br />
			<?php echo form_open($form_request,array('name'=>'revenue_report','id'=>'revenue_report_form'));?>
			<center>
			<p>Insert Start Date : <input type="text" name="startdate" class="span3" value="" id="dpd1" required placeholder="Start Date"></p>
			<p>Insert End Date : <input type="text" name="enddate" class="span3" value="" id="dpd2" placeholder="End Date"></p>

			<button type="button" class="btn" data-toggle="collapse" data-target="#get_finance_rep">LOB/LOS Filter</button>
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
			
			
			<span style="display:none;" id="email_address" class="info">
			<hr />
			Span of more than 7 days will result in a very large report. we will generate this report and send the report link via email, please enter your email address on email field below.
			<br/> <input type="email" name="email" class="span3" value="" id="email" placeholder="email">
			</span>
            </center>
			
			<br />
	   		<center><button type="submit" class="btn btn-primary" onClick="load_progress();">Generate Report</button></center>
		<div class="row" align="right">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		</div>
	    </div>
		<?php echo form_close();?>
	  </div>
</div>
<script >
function load_progress()
{
if($('#dpd1').val()=='')
{
alert('Please Input Start Date');
location.reload();
}
var link = document.getElementById('date_range');
link.style.visibility = 'hidden';
var progressbar = document.getElementById('progressbar');
progressbar.style.display = 'inline';
var $progresswidth = $('.row');
var progress = setInterval(function(){
    var $bar = $('.bar');
    if ($bar.width()>=$progresswidth.width() ) {
        clearInterval(progress);
        $('.progress').removeClass('active');
    } else {
        $bar.width($bar.width()+47);
    }
    $bar.text(($bar.width()/$progresswidth.width()*100)+5 + "%");
}, 4000);
}

</script>
   <script type="text/javascript">
		
				$(function(){
					$('#dpd2').datepicker().on('changeDate',function(ev){
							var d1 = $('#dpd1').val();
							var d2 = $('#dpd2').val();
							var last_url = $("#revenue_report_form").attr('action');
							var diff = Math.floor(( Date.parse(d2) - Date.parse(d1) ) / 86400000);
								if(diff > 7)
								{
									alert('Span of more than 7 days will result in a very large report. we will generate this report and send the report link via email, please enter your email address on email field below');
									$("#email_address").show('slow');
									$("#email").prop('required',true);									
									$("#revenue_report_form").prop("action",'<?php echo base_url().'export_report/send_excel_link_report/'.$hospital_id.'/'; ?>'+ d1+'/'+ d2);
								}
								else
								{
									$("#email_address").hide('slow');
								}
							
						
							});		
					});
			
		
					
	
		
		
    </script>