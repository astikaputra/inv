<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;" />
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<meta name="description" content="Medicos Support Tools">
<meta name="keywords" content="Medicos Support Tools">
<meta name="author" content="Yohanes Ronald Agnetius Sengkey">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-Equiv="Pragma" Content="no-cache">
<meta http-Equiv="Expires" Content="0">
    <!-- Bootstrap -->
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/bootstrap.css" rel="stylesheet" media="screen">
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/TableTools.css" rel="stylesheet" media="screen">
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/datepicker.css" rel="stylesheet" media="screen">
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
	<link rel="shortcut icon" href="../favicon.ico"> 
		<link rel="stylesheet" type="text/css" href="assets/main_tools/css/default.css" />
		<link rel="stylesheet" type="text/css" href="assets/main_tools/css/component.css" />
		<script src="assets/main_tools/js/modernizr.custom.js"></script>
</head>
	 <!-- Script By
	Yohanes Ronald Agnetius Sengkey 
	agnetiuslee@gmail.com/agnetiuslee@yahoo.com
	+6285710926769
	-->