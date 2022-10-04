 <div class="container-fluid">

      <div class="row-fluid">
					<h3> <?php echo $content_title; ?> </h3>

      <div class="progress progress-striped active" style="display:none;" id="progressbar">
        <div class="bar" role="progressbar" style="width: 0%;"></div>
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
			<center>
			<button type="button" class="btn" data-toggle="collapse" data-target="#get_finance_rep">Option Filter</button>
			</center>
				<br />
				<center>
				<div id="get_finance_rep" class="collapse">
                <div class="dropdown">
			     <label class="control-label" for="lob_filter" > Filter By Report Type : </label>
			     <select class="selectpicker form-control" id="transfill" name="transaction_type" data-live-search="true">
                 <option value="outstanding_report" selected="selected">Outstanding Report</option>
			     <!--<option value="deposit_report">Deposit Report</option>
                 <option value="refund_deposit_report">Refund Desposit Report</option>-->
			     </select>
                </div>
                </div>
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
$(".input-group.date").datepicker({ autoclose: true, todayHighlight: true });

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
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'All Service'
            });

            // $('.selectpicker').selectpicker('hide');
        });
    </script>