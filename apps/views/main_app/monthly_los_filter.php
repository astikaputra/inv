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
			<?php echo form_open($form_request);?>
			<center>
			<p>Choose Report Year : <input type="text" name="repyear" class="span3" value="" id="dyr1" required placeholder="Year Of"></p>
			</center>
			<br />
			<button type="button" class="btn" data-toggle="collapse" data-target="#get_filter">Get Report Filter</button> 
			<div id="get_filter" class="collapse">
			<div class="control-group" id="end-date">
			<br />
				<label class="control-label" >Filter By Group :</label>
					<div class="controls">
						<label class="checkbox-inline"><input type="radio" id="inlineCheckbox1" name="datatype" value="visit"> Transaction </label>
						<label class="checkbox-inline"><input type="radio" id="inlineCheckbox2" name="datatype" value="registration"> Registration </label>
					</div>
					<br />
					<br />
					<button type="submit" class="btn btn-primary" onClick="load_progress();">Generate Report</button>
			</div>
			</div>
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
if($('#dyr1').val()=='')
{
alert('Please Input Report Year');
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