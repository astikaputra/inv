 <div class="container main-menu">

      <div class="row">
	  <?php foreach($modul as $tools)
	  
	  {?>
        <div class="span2 menu">
		<a href="<?php echo base_url().$tools->modul_url;?>" class="to_modal">
          <img src="<?php echo $this->config->item('template').'icon/'.$tools->modul_icon;?>" width=64px; height=64px; alt="<?php echo $tools->modul_description;?>">
          <p><b><?php echo $tools->modul_name;?></b></p>
		  </a>
        </div>
       <?php 
	   
	   }
	   ?>
		<div class="span2 menu">
		  <a href="<?php echo base_url();?>core/logout ">
		  <img src="<?php echo $this->config->item('template').'icon/';?>logout.png" width=64px; height=64px;>
          <p><b>Logout</b></p>
		  </a>
        </div>
      </div>
	
</div>

<div class="connection_info span4">
	Hi <?php echo $this->sys_model->get_data_user($this->session->userdata('user'))->real_name; ?> <br />
	You are Connected To :<?php echo $this->session->userdata('db_host').' '.$this->session->userdata('db_name');?>
</div>