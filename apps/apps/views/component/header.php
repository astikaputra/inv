<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Script Created By
	Tri Ismardiko Widyawan 
	tri.ismardiko@gmail.com/tri.ismardiko@simedika.com
	+628881053478 +628979222742
	page rendered on {elapsed_time} seconds
	-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Medicos Support Tools">
<meta name="keywords" content="Medicos Support Tools">
<meta name="author" content="Tri Ismardiko Widyawan tri.ismardiko@gmail.com">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-Equiv="Pragma" Content="no-cache">
    <meta http-Equiv="Expires" Content="0">
    <!-- Bootstrap -->
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="<?php echo $this->config->item('template').'bootstrap/';?>js/bootstrap-transition.js"></script>
  <!-- Preloader -->
<link href="<?php echo $this->config->item('template').'css/';?>preloader.css" rel="stylesheet" media="screen">
<title><?php echo $title;?></title>
<script type="text/javascript" language="javascript">
var rotate = 1;
function hide_preloader() { //DOM
var rotate = 0;
$("#preloader").fadeOut(1000);
}
$(document).ready(function(){

	
var screen_ht = $(window).height();
var preloader_ht = 10;
var padding =(screen_ht/2)-preloader_ht;


$("#preloader").css("padding-top",padding+"px");
	function anim(){ $("#preloader_image").animate({left:'-1400px'}, 8000,
	function(){ $("#preloader_image").animate({left:'0px'}, 5000 ); if(rotate==1){ anim();}  } );
	}
	anim();
	
});

</script>
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
var frameSrc = "/login";

$('#openBtn').click(function(){
    $('#myModal').on('show', function () {

        $('iframe').attr("src",frameSrc);
      
	});
    $('#myModal').modal({show:true})
});
</script>
</head>
<body onload="hide_preloader();">

<div id="preloader">Transfering Data
<div><img src="<?php echo $this->config->item('template').'images/';?>loading.jpg" id="preloader_image" ></div>
</div> <!-- #preloader -->