<?php $this->load->view('component/admin_header'); ?>
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse "> 
  <!-- BEGIN TOP NAVIGATION BAR -->
  <div class="navbar-inner">
	<div class="header-seperation"> 
		<ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">	
		 <li class="dropdown"> <a id="main-menu-toggle" href="#main-menu" class=""> <div class="iconset top-menu-toggle-white"></div> </a> </li>		 
		</ul>
      <!-- BEGIN LOGO -->	
      <a href=""><img src="<?php echo $this->config->item('template').'images/';?>medicos.png" class="logo pull-left" data-src="<?php echo $this->config->item('template').'images/';?>medicos.png" data-src-retina="<?php echo $this->config->item('template').'images/';?>medicos.png" width="106" height="92" /></a>
      <!-- END LOGO --> 
      <ul class="nav pull-right notifcation-center">	
        <li class="dropdown" id="header_task_bar"> <a href="" class="dropdown-toggle active" data-toggle=""> <div class="iconset top-home"></div> </a> </li>
        <li class="dropdown" id="header_inbox_bar"> <a href="" class="dropdown-toggle"> <div class="iconset top-messages"></div>  <span class="badge" id="msgs-badge">2</span> </a>
		</li><li class="dropdown" id="portrait-chat-toggler" style="display:none"> <a href="#sidr" class="chat-menu-toggle"> <div class="iconset top-chat-white "></div> </a> </li>        
      </ul>
      </div>
      <!-- END RESPONSIVE MENU TOGGLER --> 
      <div class="header-quick-nav"> 
      <!-- BEGIN TOP NAVIGATION MENU -->
	  <div class="pull-left"> 
		  <ul class="nav quick-section">
			<li class="quicklinks"> <a href="#" class="" id="layout-condensed-toggle"><div class="iconset top-menu-toggle-dark"></div> </a> </li>        
		  </ul>
		  <ul class="nav quick-section">
			<li class="quicklinks"> <a href="<?php echo base_url();?>" class=""><div class="iconset top-reload"></div> </a> </li> 
			<li class="quicklinks"> <span class="h-seperate"></span></li>
			<li class="quicklinks"> <a href="#" class=""><div class="iconset top-tiles"></div></a> </li>
			<div class="input-prepend inside search-form no-boarder">
				<span class="add-on"> <a href="#" class=""><div class="iconset top-search"></div></a></span>
				 <input name="" type="text" class="no-boarder " placeholder="Search Dashboard" style="width:250px;" />
			</div>
		  </ul>
	  </div>
	 <!-- END TOP NAVIGATION MENU -->
	 <!-- BEGIN CHAT TOGGLER -->
      <div class="pull-right"> 
		<div class="chat-toggler">	
				<a href="#" class="dropdown-toggle" id="my-task-list" data-placement="bottom" data-content='
						<div style="width:300px" class="scroller" data-height="100px">
						  <div class="notification-messages info">
									<div class="user-profile">
										<img src="img/profiles/d.jpg" data-src="img/profiles/d.jpg" data-src-retina="img/profiles/d2x.jpg" width="35" height="35">
									</div>
									<div class="message-wrapper">
										<div class="heading">
											David Nester - Commented on your wall
										</div>
										<div class="description">
											Meeting postponed to tomorrow
										</div>
										<div class="date pull-left">
										A min ago
										</div>										
									</div>
									<div class="clearfix"></div>									
								</div>	
							<div class="notification-messages danger">
								<div class="iconholder">
									<i class="icon-warning-sign"></i>
								</div>
								<div class="message-wrapper">
									<div class="heading">
										Server load limited
									</div>
									<div class="description">
										Database server has reached its daily capicity
									</div>
									<div class="date pull-left">
									2 mins ago
									</div>
								</div>
								<div class="clearfix"></div>
							</div>	
							<div class="notification-messages success">
								<div class="user-profile">
									<img src="img/profiles/h.jpg" data-src="img/profiles/h.jpg" data-src-retina="img/profiles/h2x.jpg" width="35" height="35">
								</div>
								<div class="message-wrapper">
									<div class="heading">
										You haveve got 150 messages
									</div>
									<div class="description">
										150 newly unread messages in your inbox
									</div>
									<div class="date pull-left">
									An hour ago
									</div>									
								</div>
								<div class="clearfix"></div>
							</div>							
						</div>' data-toggle="dropdown" data-original-title="Notifications">
					<div class="user-details"> 
						<div class="username">
							<span class="badge badge-important">3</span> 
							<?php echo $user->real_name;?>									
						</div>						
					</div> 
					<div class="iconset top-down-arrow"></div>
				</a>						
				<div class="profile-pic"> 
					<img alt="" src="<?php echo $this->config->item('template').'images/';?>avatar.png" data-src="<?php echo $this->config->item('template').'images/';?>avatar.png" data-src-retina="<?php echo $this->config->item('template').'images/';?>avatar.png" width="35" height="35" /> 
				</div>       			
			</div>
		 <ul class="nav quick-section ">
			<li class="quicklinks"> 
				<a data-toggle="dropdown" class="dropdown-toggle  pull-right" href="#">						
					<div class="iconset top-settings-dark "></div> 	
				</a>
				<ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="dropdownMenu">
                  <li><a href="user-profile.html"> My Account</a>
                  </li>
                  <li><a href="calender.html">My Calendar</a>
                  </li>
                  <li><a href=""> My Inbox&nbsp;&nbsp;<span class="badge badge-important animated bounceIn">2</span></a>
                  </li>
                  <li class="divider"></li>                
                  <li><a href="login.html"><i class="icon-off"></i>&nbsp;&nbsp;Log Out</a></li>
               </ul>
			</li> 
			<li class="quicklinks"> <span class="h-seperate"></span></li> 
			<li class="quicklinks"> 	
			<a id="chat-menu-toggle" href="#sidr" class="chat-menu-toggle"><div class="iconset top-chat-dark "><span class="badge badge-important hide" id="chat-message-count">1</span></div>
			</a> 
				<div class="simple-chat-popup chat-menu-toggle hide">
					<div class="simple-chat-popup-arrow"></div><div class="simple-chat-popup-inner">
						 <div style="width:100px">
						 <div class="semi-bold">David Nester</div>
						 <div class="message">Hey you there </div>
						</div>
					</div>
				</div>
			</li> 
		</ul>
      </div>
	   <!-- END CHAT TOGGLER -->
      </div> 
      <!-- END TOP NAVIGATION MENU --> 
   
  </div>
  <!-- END TOP NAVIGATION BAR --> 
</div>

<!-- END HEADER --> 
<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid"> 
  <!-- BEGIN SIDEBAR -->
  <div class="page-sidebar" id="main-menu"> 
  <!-- BEGIN MINI-PROFILE -->
   <div class="user-info-wrapper">	
	<div class="profile-wrapper">
		<img src="<?php echo $this->config->item('template').'images/';?>avatar.png" data-src="<?php echo $this->config->item('template').'images/';?>avatar.png" data-src-retina="<?php echo $this->config->item('template').'images/';?>avatar.png" width="69" height="69" />
	</div>
    <div class="user-info">
      <div class="greeting">Welcome</div>
      <div class="username"><span class="semi-bold"><?php echo $user->real_name;?></span></div>
      <div class="status">Status<a href="#"><div class="status-icon green"></div>Online</a></div>
    </div>
   </div>
  <!-- END MINI-PROFILE -->
  
  <!-- BEGIN MINI-WIGETS -->

   <!-- END MINI-WIGETS -->
   
   <!-- BEGIN SIDEBAR MENU -->	
	<p class="menu-title">BROWSE <span class="pull-right"><a href="javascript:;"><i class="icon-refresh"></i></a></span></p>
    <ul>	
      <li class="start active "> <a href=""> <i class="icon-custom-home"></i> <span class="title">Dashboard</span> <span class="selected"></span> <span class="badge badge-important pull-right">5</span></a> </li>
	  <li class=""> <a href=""> <i class="icon-envelope"></i> <span class="title">Issues</span>  <span class=" badge badge-disable pull-right ">203</span></a> </li>      
      <li class=""> <a href="javascript:;"> <i class="icon-custom-ui"></i> <span class="title">MedicOS Statistics</span> <span class="arrow "></span> </a>
        <ul class="sub-menu">
		  <li> <a href="<?php echo base_url().'admin/admin_dashboard/get_module_stat';?>"> Most Modules Used </a> </li>
		  <li> <a href="messages_notifications.html"> Daily Logs </a> </li>
        </ul>
      </li>
	  <li class=""> <a href="javascript:;"> <i class="icon-custom-form"></i> <span class="title">Live Support</span> <span class="arrow "></span> </a>
        <ul class="sub-menu">
          <li> <a href="form_elements.html">Support Chanel </a> </li>
          <li> <a href="form_validations.html">Live Support Logs</a> </li>
        </ul>
      </li>
	  <li class="hidden-desktop hidden-phone visible-tablet" id="more-widgets" style="display:"> <a href="javascript:;"> <i class="icon-ellipsis-horizontal"></i></a> 
		  <ul class="sub-menu">

		</ul>
	  </li>    
    </ul>
	<div class="side-bar-widgets">
	<p class="menu-title">FOLDER <span class="pull-right"><a href="#" class="create-folder"><i class="icon-plus"></i></a></span></p>
	<ul class="folders" id="folders">
		  <li><a href="#"><div class="status-icon green"></div> My quick tasks </a> </li>
		  <li><a href="#"><div class="status-icon red"></div> To do list </a> </li>
		  <li><a href="#"><div class="status-icon blue"></div> Projects </a> </li>
		  <li id="folder-input" class="folder-input" style="display:none"><input type="text" placeholder="Name of folder" class="no-boarder folder-name" name="" id="folder-name" /></li>
	</ul>
	<p class="menu-title">PROJECTS </p>
		<div class="status-widget">
			<div class="status-widget-wrapper">
				<div class="title">Freelancer<a href="#" class="remove-widget"><i class="icon-custom-cross"></i></a></div>
				<p>Redesign home page</p>
			</div>
		</div>
		<div class="status-widget">
			<div class="status-widget-wrapper">
				<div class="title">envato<a href="#" class="remove-widget"><i class="icon-custom-cross"></i></a></div>
				<p>Statistical report</p>
			</div>
		</div>
	</div>

	<a href="#" class="scrollup">Scroll</a>
	<div class="clearfix"></div>
    <!-- END SIDEBAR MENU --> 
  </div>
   <div class="footer-widget">		
	<div class="progress transparent progress-success progress-small no-radius no-margin">
		<div data-percentage="79%" class="bar animate-progress-bar"></div>		
	</div>
	<div class="pull-right">
		<div class="details-status">
		<span data-animation-duration="560" data-value="86" class="animate-number"></span>%
	</div>	
	<a href="login.html"><i class="icon-off"></i></a></div>
  </div>
  <!-- END SIDEBAR --> 
  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content"> 
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div id="portlet-config" class="modal hide">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button"></button>
        <h3>Widget Settings</h3>
      </div>
      <div class="modal-body"> Widget settings form goes here </div>
    </div>
    <div class="clearfix"></div>
    <div class="content">  
		<div class="page-title">	
			<h3><?php echo $content_title;?> </h3>		
		</div>
	   <div id="container">
       <?php $this->load->view("$content");?>
	   </div> 
    </div>  
  <!-- END PAGE --> 
</div>
<!-- END CONTAINER --> 
<?php $this->load->view('component/admin_footer'); ?>