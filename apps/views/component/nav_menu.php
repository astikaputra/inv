<html>
<head>
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/bootstrap.css" rel="stylesheet" media="screen">
<link href="<?php echo $this->config->item('template').'bootstrap/';?>css/bootstrap-responsive.css" rel="stylesheet" media="screen">
</head>

<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
	  </a>
      <a class="brand"><?php echo $content_title; ?></a>
      <div class="nav-collapse">
        <ul class="nav">
      <li class="<?php if($this->uri->segment(3)=='hospital'){echo 'active';}else{echo '';}?>"><a type="button" href="<?php echo base_url(); ?>core/sys_config/hospital">Manage Hospital Data</a></li>
	  <li class="<?php if($this->uri->segment(3)=='database'){echo 'active';}else{echo '';}?>"><a  type="button" href="<?php echo base_url(); ?>core/sys_config/database">Manage Database Connection</a></li>
	  <li class="<?php if($this->uri->segment(3)=='tools'){echo 'active';}else{echo '';}?>"><a type="button" href="<?php echo base_url(); ?>core/sys_config/tools" >Manage Tools</a></li>
	  <li class="<?php if($this->uri->segment(3)=='user'){echo 'active';}else{echo '';}?>"><a type="button" href="<?php echo base_url(); ?>core/sys_config/user" >Manage User</a></li>
	  <li class="<?php if($this->uri->segment(3)=='alert'){echo 'active';}else{echo '';}?>"><a type="button" href="<?php echo base_url(); ?>core/sys_config/alert">Manage Alert</a></li>
	  <li class="<?php if($this->uri->segment(3)=='log'){echo 'active';}else{echo '';}?>"><a type="button" href="<?php echo base_url(); ?>core/sys_config/log">Log</a></li>
        </ul>
      </div><!-- /.nav-collapse -->
    </div>
  </div><!-- /navbar-inner -->
</div>

<script src="<?php echo $this->config->item('template').'js/';?>jquery.js"></script>