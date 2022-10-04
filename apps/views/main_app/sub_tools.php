 <style type='text/css'>
 img.hoverImages {
	margin:16px;
	-webkit-transition: margin 0.5s ease-out;
    -moz-transition: margin 0.5s ease-out;
    -o-transition: margin 0.5s ease-out;
}
 
img.hoverImages:hover {
	cursor:pointer;
    margin-top: 12px;
	margin-bottom: 12px;
}
	  
.fade {
  opacity: 0;
  -webkit-transition: opacity 0.15s linear;
  -moz-transition: opacity 0.15s linear;
  -o-transition: opacity 0.15s linear;
  transition: opacity 0.15s linear;
}

.fade.in {
  opacity: 1;
}  

a {
  color: #0088cc;
  text-decoration: none;
    -webkit-transition: text-shadow 0.2s linear;
    -moz-transition: text-shadow 0.2s linear;
    -ms-transition: text-shadow 0.2s linear;
    -o-transition: text-shadow 0.2s linear;
    transition: text-shadow 0.2s linear;
}

a:hover,
a:focus {
  color: #005580;
  text-decoration:;
  text-shadow: 0 0 10px rgba(0, 255, 255, 0.6);
}

 </style>
 <br />
 <br />
<body>
 <div class="container-fluid">
	  <center>
	  	 <?php foreach($modul as $tools)
	  {
	  ?>


	  <div class="span2 menu">
		<!-- <a href="<?php //echo base_url().$tools->modul_url;?>" class="to_modal"> -->
		<a href="<?php echo $tools->modul_url;?>" target="_blank" class="to_modal">
		<img class="wobble-horizontal" src="<?php echo $this->config->item('template').'icon/'.$tools->modul_icon;?>" alt="<?php echo $tools->modul_description;?>" style="max-width:50%;" />
		  <p><b><?php echo $tools->modul_name;?></b></p>
        </a>
      </div>
	  </center>
       <?php 
	   }
	   ?>
	 <!--  <center>
		<div class="span2 menu">
		  <a href="<?php echo base_url();?>core/logout" class="to_modal">
		  <img src="<?php echo $this->config->item('template').'icon/';?>logout.png" alt="<?php echo $tools->modul_description;?>" style="max-width:50%;" />
          <p><b>Change User</b></p>
		  </a>
        </div>        
	-->	</center>
			<div class="span4 pull-right">
				<div id="myAlert" class="alert alert-dismissible alert-info">
				      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>You are Connected To :</strong> <?php echo $this->session->userdata('hospital_name').' ON '. $this->session->userdata('env_type').' Environment';?>
				</div>
			</div>
 </div>
 <div class="row-fluid pull-right">
	   <div class="span12 back">
		<?php if(isset($parent_page))
			{?>
			<a href="<?php echo base_url().$parent_page;?>" class="btn btn-inverse">Back to the previous page</a>
			<?php }?>
			&nbsp;&nbsp;
			<a href="<?php echo base_url();?>tools" class="btn btn-success">Return to main menu</a>
		</div>
		</div>	
</body>
</html>

<script>
function showAlert(){
  $("#myAlert").addClass("in")
}
</script>

