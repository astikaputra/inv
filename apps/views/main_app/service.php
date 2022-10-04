<body>
	<div class="container">
		<div class="container-leftbar">
			<div id="logo-medicos">
				<img src="assets/main_tools/images/medicos.png">
			</div>
			<input type="text" id="search-tools" name="search" placeholder="Search Apps" size="50">
			<div class="wrap-nav-tools">
				<ul>
					<li>
						<?php echo anchor('formularium','FORMULARIUM');?>
					</li>
					<li>
						<?php echo anchor('billing','BILLING');?>
					</li>
					<li>
						<?php echo anchor('cashier','CHASIER');?>
					</li>
					<li>
						<?php echo anchor('database','DATABASE');?>
					</li>
					<li>
						<?php echo anchor('patient','PATIENT');?>
					</li>
					<li>
						<?php echo anchor('configuration','CONFIGURATION');?>
					</li>
					<li>
						<?php echo anchor('doctor','DOCTOR');?>
					</li>
					<li>
						<?php echo anchor('report','REPORT');?>
					</li>
					<li>
						<?php echo anchor('medical','MEDICAL');?>
					</li>
					<li>
						<?php echo anchor('item','ITEM');?>
					</li>
					<li>
						<?php echo anchor('drugs','DRUGS');?>
					</li>
					<li>
						<?php echo anchor('dashboard','DASHBOARD');?>
					</li>
					<li>
						<?php echo anchor('medicine','MEDICINE');?>
					</li>
					<li>
						<?php echo anchor('radiologi','RADIOLOGI');?>
					</li>
					<li>
						<?php echo anchor('service','SERVICE');?>
					</li>
				</ul>
			</div>
		</div>
		<div class="wrap-header">
			<div id="wrap-back-button">
				<input type=button value="&#x2190; Back" onCLick="history.back()" id="button-back">
			</div>
		</div>
		<div class="main-content">
	  	 <?php foreach($modul as $tools)
			{
			?>
			
		<center>
<!-- check -->
	 <div class="wrap-modul">
	  <?php
$string = array($tools->modul_name);
foreach($string as $s) {
  if(preg_match("/service/i", $s))
  {
  ?>
  <div class="span2 menu">
	<a class="wobble-horizontal"href="<?php echo base_url().$tools->modul_url;?>" class="to_modal">
	<img  src="assets/template/icon/<?=$s;?>.png?>" 
	alt="<?php echo $tools->modul_description;?>" 
	style="max-width:50%; -webkit-filter: grayscale(10%);" />
	<div class="title-icon">
		  <b style="font-size:0.8em;
						-webkit-font-smoothing: antialiased;
						color:#666;">
						
			<?php echo $s;?>
		</b>
		  </div>
	</a>
	</div>
	
		</div>
<?php
	break;
  }
}
?>
</center>
		
		<?php 
			}
			?>
		<center>
		<div class="span2 menu">
		  <a href="<?php echo base_url();?>core/logout" class="to_modal">
		  <img class="wobble-horizontal" src="<?php echo $this->config->item('template').'icon/';?>logout.png" 
		  alt="<?php echo $tools->modul_description;?>" style="max-width:50%;"/>
          <div class="title-icon">
		  <b style="font-size:0.8em;
						-webkit-font-smoothing: antialiased;
						color:#666;">
						Change User
		</b>
		  </div>
		  </a>
        </div>
		</center>
		<div class="span4 pull-right">
				<div id="myAlert" class="alert alert-dismissible alert-info">
				      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>You are Connected To :</strong> <?php echo $this->session->userdata('hospital_name').' ON '. $this->session->userdata('env_type').' Environment';?>
				</div>
		</div>
		</div>
	</div>
</body>
</html>

<script>
function showAlert(){
  $("#myAlert").addClass("in")
}
</script>