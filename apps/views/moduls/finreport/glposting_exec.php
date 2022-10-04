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
			<p>Insert Start Date : <input type="text" name="startdate" class="span3" value="" id="dpd1" required placeholder="Start Date"></p>
			<p>Insert End Date : <input type="text" name="enddate" class="span3" value="" id="dpd2" placeholder="End Date"></p>
			</center>
			
			<br />
	   		<center><button type="submit"  class="btn btn-primary" >Execute Procedure</button></center>
		<div class="row" align="right">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		</div>
	    </div>
		<?php echo form_close();?>
	  </div>
</div>

<!-- Modal -->
<div class="modal hide fade" style="width:70%; margin: 0 0 0 -35%;" id="traceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <center><h3 class="modal-title"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"><?php echo $content_title;?></h3></center>
            </div>
            <div class="modal-body"><div class="te">
			<h4><?php echo $text_confirm;?></h4>
			<p id="custom_result" style="display:none;">

			</p>
			</div></div>
            <div class="modal-footer">
				<a type="submit" class="btn btn-primary" data-dismiss="modal" data="<?php echo base_url();?><?php echo $button_action;?>">Execute</a>
                <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


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