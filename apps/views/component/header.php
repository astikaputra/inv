<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Script Created By
	Tri Ismardiko Widyawan 
	tri.ismardiko@gmail.com/tri.ismardiko@simedika.com
	page rendered on {elapsed_time} seconds
	-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Medicos Support Tools">
<meta name="keywords" content="Medicos Support Tools">
<meta name="author" content="Tri Ismardiko Widyawan Chiputera Arief Luqman Hakim Yohanes Ronald Agnetius Sengkey">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-Equiv="Pragma" Content="no-cache">
    <meta http-Equiv="Expires" Content="0">
    <!-- Bootstrap -->
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/bootstrap.css" rel="stylesheet" media="screen">
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/TableTools.css" rel="stylesheet" media="screen">
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/datepicker.css" rel="stylesheet" media="screen">
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/datepicker.css" rel="stylesheet" media="screen">
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"></script>

<script src="<?php echo $this->config->item('template').'bootstrap/';?>js/bootstrap-transition.js"></script>
  <!-- Preloader -->
<link href="<?php echo $this->config->item('template').'css/';?>preloader.css" rel="stylesheet" media="screen">
<title><?php echo $title;?></title>

<link href="<?php echo $this->config->item('template').'css/'.$style;?>" rel="stylesheet" type="text/css" />

<?php 
if(isset($page) == 'datatable')
{?>
<style type="text/css" title="currentStyle">
		
			@import "<?php echo $this->config->item('template').'bootstrap/';?>css/data_table.css";
			div.table_Wrapper { border:10px solid blue; }
</style>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
    $('#allpatient').change(function(){
        if(this.checked)
           	$('#start-date').fadeOut('slow');
            $('#end-date').fadeOut('slow');			
        else
			$('#start-date').fadeIn('slow');
            $('#end-date').fadeIn('slow');

    });
});
</script>
<style type='text/css'>
	#waiting{
		position:fixed;
		z-index:7000;
		width:100%;
		height:800px;
		background:white;
		opacity:0.6;
		display:none;
		text-align:center;
	}
	#waiting-inside{
		position:absolute;
		z-index:7000;
		width:98%;
		top:0;
		bottom:0;
		background:white;
		opacity:0.6;
		display:none;
		text-align:center;
	}
	#datatable_info,.dataTables_filter{
		color:white;
	}
</style>
	<script src="<?php echo $this->config->item('template').'js/';?>jquery.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $this->config->item('template').'bootstrap/';?>js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $this->config->item('template').'bootstrap/';?>js/jquery.dataTables.columnFilter.js"></script>
	<script src="<?php echo $this->config->item('template').'TableTools/';?>media/js/TableTools.min.js"></script>
	<script src="<?php echo $this->config->item('template').'TableTools/';?>media/js/ZeroClipboard.js"></script>
    <script src="<?php echo $this->config->item('template').'js/';?>FixedHeader.min.js"></script>
	<script src="<?php echo $this->config->item('template').'js/';?>highcharts.js"></script>
	<script src="<?php echo $this->config->item('template').'js/';?>jquery.highchartTable-min.js"></script> 
</head>
<body>
<div id='waiting'><img src='<?php echo base_url();?>/assets/loading_big.gif' style='width:70px;margin:250px auto;'/></div>
<div>
</div>     
	 <!-- Script Customized By
	Arief Luqman Hakim 
	arief88luqman@gmail.com/arief.luqman@simedika.com
	+628888034831
	-->
	 <!-- Script Front end By
	Yohanes Ronald Agnetius Sengkey 
	agnetiuslee@gmail.com/agnetiuslee@yahoo.com
	+6285710926769
	-->