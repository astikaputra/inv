 <div class="container-fluid">
      <div class="row-fluid">
			<div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well"  id="date_range">
			<?php echo form_open($form_request,array('class'=>'form-horizontal'));?>
			<legend><?php echo $content_title; ?></legend>
			
			<button type="button" class="btn" data-toggle="collapse" data-target="#get_transaction">Get Radiologi Transaction</button> 	
			<div id="get_transaction" class="collapse">
			<legend></legend>
				<div class="control-group" id="start-date">
				<label class="control-label" >Insert Start Date : </label>
				<div class="controls">
				<input type="text" name="startdate" value="" id="dpd1" placeholder="Start Date">
				</div>
				</div>
				<div class="control-group" id="end-date">
				<label class="control-label" >Insert End Date : </label>
					<div class="controls">
						<input type="text" name="enddate" value="" id="dpd2" placeholder="End Date">
					<span class="help-block">* The longer time span affect the duration of the information that will be displayed.</span>
				
					</div>
				
				</div>
				<?php
				if($this->session->userdata('userrole')=='finance')
					{
					?>
			
				<div class="control-group">
				<label class="control-label" >Report Type :</label>
					<div class="controls">
						<select name="ReportType">
						<option value="screen" class="checkbox-inline">Screen Format</option>
						<option value="excel" class="checkbox-inline">Excel Format </option>
						</select>
					</div>
				</div>
				<?php }?>
					
			<br />
	   		<button type="submit" class="btn btn-primary" onClick="load_progress();">Get Radiologi Transaction</button>
			</div>
			
	    </div>
		<?php echo form_close();?>
	  </div>
	    <div class="row">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
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
