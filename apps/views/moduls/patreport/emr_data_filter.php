 <div class="container-fluid">

      <div class="row-fluid">
			<div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" style="width: 0%;"></div>
		</div>	
			<div class="well"  id="date_range">
			<?php echo form_open($form_request,array('class'=>'form-horizontal'));?>
			<legend><?php echo $content_title; ?></legend>
				<div class="control-group">
				<label class="control-label" >Select Data</label>
				<div class="controls">
				<label class="checkbox">
					<input name="allpatient" type="checkbox" id="allpatient"> All Patient Data
				</label>
				<span class="help-block">* Select all the data affect the duration of the information that will be displayed.</span>
				</div>
				</div>
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
					</div>
				</div>
				<div class="control-group" id="end-date">
				<label class="control-label" >Line Of Business(LOB) :</label>
					<div class="controls">
						<label class="checkbox-inline">	<input type="checkbox" id="inlineCheckbox1" value="option1"> OPD </label>
						<label class="checkbox-inline"> <input type="checkbox" id="inlineCheckbox2" value="option2"> IPD </label>
						<label class="checkbox-inline"> <input type="checkbox" id="inlineCheckbox3" value="option3"> ETC </label>
						<label class="checkbox-inline"> <input type="checkbox" id="inlineCheckbox3" value="option3"> MCU </label>
					</div>
				</div>
				<div class="control-group" id="end-date">
				<label class="control-label" >Data Type :</label>
					<div class="controls">
						<label class="checkbox-inline">	<input type="radio" id="inlineCheckbox1" name="datatype" value="option1"> Patient Only </label>
						<label class="checkbox-inline"> <input type="radio" id="inlineCheckbox2" name="datatype" value="option2"> Patient With all transaction </label>
					</div>
				</div>
						
			<br />
	   		<button type="submit" class="btn btn-primary" onClick="load_progress();">Get The Patient Information</button>
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
