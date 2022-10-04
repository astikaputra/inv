    
	<script src="<?php echo $this->config->item('template').'bootstrap/';?>js/bootstrap.min.js"></script>
	<script src="<?php echo $this->config->item('template').'bootstrap/';?>js/bootstrap-datepicker.js"></script>
	<script src="<?php echo $this->config->item('template').'bootstrap/';?>js/bootstrap-tooltip.js"></script>
	<script src="<?php echo $this->config->item('template').'bootstrap/';?>js/mydp.js"></script>  
	<script src="<?php echo $this->config->item('template').'bootstrap/';?>js/normaldp.js"></script>   
	<script src="<?php echo $this->config->item('template').'bootstrap/';?>js/tw_datepicker.js"></script> 
	<script src="<?php echo $this->config->item('template').'bootstrap/';?>js/datepicker.js"></script> 
	<script src="<?php echo $this->config->item('template').'bootstrap/';?>js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" charset="utf-8">
	
			$(document).ready(function() {
	TableTools.DEFAULTS.aButtons = [
							"copy",
							"print",
							{
								"sExtends":    "collection",
								"sButtonText": 'Save <span class="caret" />',
								"aButtons":    [ "csv", "xls",
								{
								"sExtends": "pdf",
								"sPdfOrientation": "landscape"
								}
								]
							}
						];
    TableTools.DEFAULTS.sSwfPath = "<?php echo $this->config->item('template').'TableTools';?>/media/swf/copy_csv_xls_pdf.swf";
 
	var oTable = $(".table-striped").dataTable({
					"aLengthMenu": [[-1,25, 50], ["All",25, 50]],
					"iDisplayLength": 10,
					"sPaginationType": "full_numbers",
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli'

					});

	var LOSTable = $("#monthly_los_grid").dataTable({
					"aLengthMenu": [[10,25, 50,100,-1], [10,25,50,100,"All"]],
					"iDisplayLength": 25,
					"sPaginationType": "full_numbers",
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli'	,
					"aoColumnDefs": [
					{ "bSortable": false, "aTargets": [0] }]
					});
	
	$('.sorting, .sorting_asc, .sorting_desc').dblclick(function() {
    oTable.fnSort([]);
    return false;
					});
	
	var EmrTable = $("#medical_record_grid").dataTable( {
					"aLengthMenu": [[10,25, 50,100,-1], [10,25,50,100,"All"]],
					"iDisplayLength": 25,
					"sPaginationType": "full_numbers",
					"sAjaxSource": '<?php echo base_url().'emr_info/get_emr_data/'.$start_date.'/'.$end_date;?>',
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli'	
					} ).columnFilter({ sPlaceHolder: "head:after"});
					
			
	var PatientRegEMR = $("#medical_record_unique_patient_reg").dataTable( {
					"aLengthMenu": [[10,25, 50,100,-1], [10,25,50,100,"All"]],
					"iDisplayLength": 10,
					"sPaginationType": "full_numbers",
					"sAjaxSource": '<?php echo base_url().'emr_info/get_emr_patientreg/'.$start_date.'/'.$end_date;?>',
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli'					
					} ).columnFilter({ sPlaceHolder: "head:after",
					aoColumns: [ { type: "text" },{ type: "text" },
                                 { type: "select", values: [ 'OPD', 'IPD', 'ETC', 'MCU']},
								 { type: "text" },{ type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },{ type: "number-range" },
								 { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" }

								   
						]
					
					});
			
	var PatientEMR = $("#medical_record_unique_patient").dataTable( {
					"aLengthMenu": [[10,25, 50,100,-1], [10,25,50,100,"All"]],
					"iDisplayLength": 10,
					"sPaginationType": "full_numbers",
					"sAjaxSource": '<?php echo base_url().'emr_info/get_emr_patient';?>',
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli'					
					} ).columnFilter({ sPlaceHolder: "head:after",
					aoColumns: [ { type: "text" },{ type: "text" },
								 { type: "text" },{ type: "number-range" },
								 { type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },
								 { type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" },{ type: "text" }	   
						]});

	var MarkPatient = $("#marketing_patient_data").dataTable( {
					"aLengthMenu": [[-1,25, 50], ["All",25, 50]],
					"iDisplayLength": 25,
					"sPaginationType": "full_numbers",
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli',
					"bRetrieve": true				
					} );					
						
	var PatientDischarge = $("#medical_record_discharge_patient").dataTable( {
					"aLengthMenu": [[10,25, 50,100,-1], [10,25,50,100,"All"]],
					"iDisplayLength": 10,
					"sPaginationType": "full_numbers",
					"sAjaxSource": '<?php echo base_url().'emr_info/get_discharge_patient/'.$start_date.'/'.$end_date;?>',
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli'					
					} ).columnFilter({ sPlaceHolder: "head:after"});
	
	var laborder = $("#manage_sysmex").dataTable( {
					"aLengthMenu": [[10,25, 50,100,-1], [10,25,50,100,"All"]],
					"iDisplayLength":-1,
					"sPaginationType": "full_numbers",
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli',
					"bSortClasses": false,
					"bStateSave": true,
					"oLanguage": {
						"sZeroRecords": "No Transaction to display"
						}							
					} );
	
	var manage_ris_finance = $("#manage_ris_finance").dataTable(  {
					"aLengthMenu": [[10,25, 50,100,-1], [10,25,50,100,"All"]],
					"iDisplayLength":-1,
					"sPaginationType": "full_numbers",
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli'	,
					"bSortClasses": false,
					"bStateSave": true,
					"oLanguage": {
						"sZeroRecords": "No Transaction to display"
						}							
					});
					
	var laborder = $("#manage_class").dataTable( {
					"aLengthMenu": [[10,25, 50,100,-1], [10,25,50,100,"All"]],
					"iDisplayLength": 10,
					"sPaginationType": "full_numbers",
					"sDom": '<"top"i>rt<"bottom"flp><"clear">',
					"sDom": 'T<"clear">pfrtli',
					"bStateSave": true			
					} );
	
	var cashier_repo = $('#cashier_datbl').dataTable({
							"aLengthMenu": [[10, 25, 25, 20, 50,100, 50, -1], [10, 25, 25, 20, 50,100, 50,"All"]],
							"iDisplayLength": 10,
							"sPaginationType": "full_numbers",
							"bAutoWidth": false,
							"sDom": '<"top"i>rt<"bottom"flp><"clear">',
							"sDom": "<T<'span2'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
							"oTableTools": {
							"aButtons": [ "print" ]
							}
							} );
	
	});
</script>
<?php 
if(isset($page) == 'datatable')
{?>
	<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
$(".recordstatus").click(function(){
	var kirim=$(this).attr('data');
	var ids=$(this).attr('id');
	$.ajaxSetup ({  
    cache: false  
	});
	$("#waiting").fadeIn(100);
	$.get(kirim,{language: "php", version: 5},function(result){
		if(result=='1'){
			$('#'+ids).attr('class','btn btn-mini btn-success recordstatus');
			$('#'+ids).attr('data','<?php echo base_url();?>item_modify/deactivate_item/'+ids.substr(3)+'/<?php echo time();?>');
			
			$('#'+ids).html('Active');
		}else{
			$('#'+ids).attr('class','btn btn-mini btn-inverse recordstatus');
			$('#'+ids).html('Not Active');
			$('#'+ids).attr('data','<?php echo base_url();?>item_modify/activate_item/'+ids.substr(3)+'/<?php echo time();?>');
		}
		$("#waiting").fadeOut(100);
		},"html"
		);
});

$(".approvedbutton").click(function(){
	var kirim=$(this).attr('data');
	var ids=$(this).attr('id');
	$.ajaxSetup ({  
    cache: false  
	});
	$("#waiting").fadeIn(100);
	$.post(kirim,{trans_id: ids},function(result){
		if(result=='1'){
			$('#approvalaction'+ids).attr('class','btn dropdown-toggle btn disabled');
			$('#approvalaction'+ids).attr('title',"Approved and Already Sent to Finance");
			$('#trid'+ids).attr('class','info');
		}
		$("#waiting").fadeOut(100);
		},"html"
		);
});

$(".checktransbutton").click(function(){
	var kirim=$(this).attr('data');
	var ids=$(this).attr('id');
	$.ajaxSetup ({  
    cache: false  
	});
	$("#waiting").fadeIn(100);
	$.post(kirim,{trans_id: ids},function(result){
		if(result=='checked'){
			$('#recordchecking'+ids).attr('class','btn btn-success dropdown-toggle');
			$('#recordchecking'+ids).attr('title',"Transaction Already Checked");
			$('#trid'+ids).attr('class','info');			
		}
		$("#waiting").fadeOut(100);
		},"html"
		);
});

$(".doctorfeepaidbutton").click(function(){
	var kirim=$(this).attr('data');
	var ids=$(this).attr('transid');
	$.ajaxSetup ({  
    cache: false  
	});
	$("#waiting").fadeIn(100);
	$.post(kirim,{trans_id: ids},function(result){
		if(result=='paid'){
			$('#paid'+ids).html('<span class="icon-briefcase"></span> Cancel Payment');
			$('#doctorfee'+ids).html('Paid');
			$('#paid'+ids).attr('data','<?php echo base_url();?>manage_ris_order/transaction_unpaid/');
			$('#trid'+ids).attr('class','success');
			
		}
		else{
			$('#paid'+ids).html('<span class="icon-briefcase"></span> Pay Doctor Fee');
			$('#doctorfee'+ids).html('Unpaid');
			$('#paid'+ids).attr('data','<?php echo base_url();?>manage_ris_order/transaction_paid/');
			$('#trid'+ids).attr('class','warning');
		}
		$("#waiting").fadeOut(100);
		},"html"
		);
});

$(".unlockbutton").click(function(){
	var kirim=$(this).attr('data');
	var ids=$(this).attr('transid');
	$.ajaxSetup ({  
    cache: false  
	});
	$("#waiting").fadeIn(100);
	$.post(kirim,{trans_id: ids},function(result){
		if(result=='1'){
			$('#paid'+ids).hide();
			$('#trid'+ids).attr('class','info disabled');
			$('#approval'+ids).attr('class','btn dropdown-toggle btn-primary disabled');
			$('#unlock'+ids).attr('data','');
			$('#unlock'+ids).html('Contact HOD to revise the transaction');
		}
		
		$("#waiting").fadeOut(100);
		},"html"
		);
});
			
$(".formularium").click(function(){
	var kirim=$(this).attr('data');
	var ids=$(this).attr('id');
	$.ajaxSetup ({  
    cache: false  
	});
	$("#waiting").fadeIn(100);
	$.get(kirim,{language: "php", version: 5},function(result){
		if(result=='1'){
			$('#'+ids).attr('class','btn btn-mini btn-success formularium');
			$('#'+ids).attr('data','<?php echo base_url();?>item_modify/deactivate_formularium/'+ids.substr(3)+'/<?php echo time();?>');
			$('#'+ids).html('YES');
		}else{
			$('#'+ids).attr('class','btn btn-mini btn-inverse formularium');
			$('#'+ids).html('NO');
			$('#'+ids).attr('data','<?php echo base_url();?>item_modify/activate_formularium/'+ids.substr(3)+'/<?php echo time();?>');
		}
		$("#waiting").fadeOut(100);
		},"html"
		);
});

		 });
                  
		</script>
<script type="text/javascript">

$('.openBtn').click(function(){
	var frameSrc = $(this).attr('data');
	$('#waiting-inside').fadeIn();
   $('#myModal').on('show', function () {
			$('iframe').load(function(){$('#waiting-inside').fadeOut();}).attr("src",frameSrc);
      });
    $('#myModal').modal({show:true})
	
});

$(document).ready(function(){
    setTimeout(function() {
      $('#myModal').fadeIn(200);
    }, 30000); // milliseconds
});

</script>

<script type="text/javascript">

$('.doctor_correct').click(function(){
	$("#doctorcorrection option").show();
	var transaction = $(this).attr('data');
	var hidedoctor = $(this).attr('doctorcode');
	$("#doctorcorrection option[value="+hidedoctor+"]").hide();
	$('#waiting-inside').fadeIn();
   $('#myModal').on('show', function () {
			$('#trans_id').attr("value",transaction);
		});
    $('#myModal').modal({show:true})
	
});

$('.change_class').click(function(){
	var transaction = $(this).attr('data');
	var classid = $(this).attr('id');
	$('#waiting-inside').fadeIn();
   $('#myModal').on('show', function () {
			$('#class_first').attr("value",transaction);
			$('#reg_id').attr("value",classid);
      });
    $('#myModal').modal({show:true})
	
});

$('.actionbtn').tooltip();
$('.fo_validation').tooltip();


$(document).ready(function(){
    setTimeout(function() {
      $('#myModal').fadeIn(200);
    }, 30000); // milliseconds
});
</script>

<script type="text/javascript">
$('#patientModal').on('hidden', function () {
$('#waiting-inside').fadeIn();
$(this).removeData('modal');
});

$('#traceModal').on('hidden', function () {
$('#waiting-inside').fadeIn();
$(this).removeData('modal');
});

$('#audit_trails_modal').on('hidden', function () {
$('#waiting-inside').fadeIn();
$(this).removeData('modal');
});
</script>
<script>
$(".btn-mini").click(function() {
  $(".modal-body").empty();
  $(".modal-body").append( "<center><img src='<?php echo base_url();?>/assets/loading_big.gif' title='loading'></center>" );
});
</script>
<?php } ?>

<?php 
if($page=='data')
{
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; }?>
<script type="text/javascript">
$(document).ready(function() {
    $("body").css("display", "none");
    $("body").fadeIn(50);
       
    function redirectPage() {
        window.location = linkLocation;
    }
});
</script>
<?php 
if($page=='login')
{?>
 <script src="<?php echo $this->config->item('template').'bootstrap/';?>js/backstretch.min.js"></script>
 <script>
 jQuery(document).ready(function($) {

	$.backstretch([
      "<?php echo base_url();?>assets/template/images/portal.jpg", 
	  "<?php echo base_url();?>assets/template/images/3.jpg",
	  "<?php echo base_url();?>assets/template/images/bg-bokeh.jpg",
	  "<?php echo base_url();?>assets/template/images/bokeh2.jpg",
	  "<?php echo base_url();?>assets/template/images/bokeh3.jpg",
  	], {duration: 2000, fade: 6000});
		
});
 </script>

<?php }?>

<!--<div class="row-fluid footer_navigation">
  <div class="span4">...</div>
  <div class="span8">...</div>
</div> -->
</body>
</html>
	<!-- Script Copyright By
	Tri Ismardiko Widyawan 
	tri.ismardiko@gmail.com/tri.ismardiko@simedika.com
	08881053478 08979222742
	page rendered on {elapsed_time} second
	-->