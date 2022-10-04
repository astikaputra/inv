<div class="container-fluid">
    <div class="row-fluid">
	<?php $this->load->view('component/issues_nav_menu');?>
        <div class="span2">

			    <ul class="nav nav-list well">
			
			    <li class="nav-header">
			 	   Administration
			    </li>
			
			    <li<?php if($this->uri->segment(2) == "projects"): ?> class="active"<?php endif; ?>><a href="<?php echo base_url(); ?>admin/projects">Projects</a></li>
			    <li<?php if($this->uri->segment(2) == "milestones"): ?> class="active"<?php endif; ?>><a href="<?php echo base_url(); ?>admin/milestones">Milestones</a></li>
			
			    <li class="nav-header">
			  	 Settings
			    </li>
			    
			    <li<?php if($this->uri->segment(2) == "categories"): ?> class="active"<?php endif; ?>><a href="<?php echo base_url(); ?>admin/categories">Categories</a></li>
			    <li<?php if($this->uri->segment(2) == "priorities"): ?> class="active"<?php endif; ?>><a href="<?php echo base_url(); ?>admin/priorities">Priorities</a></li>
			    <li<?php if($this->uri->segment(2) == "settings"): ?> class="active"<?php endif; ?>><a href="<?php echo base_url(); ?>admin/settings">General Settings</a></li>    
			
			    </ul>
	
			</div>
			<div class="span10">
				
			<?php foreach( array('alert-success', 'alert-error', 'alert-info', 'alert-block') as $type): 
			if( $msg = $this->session->flashdata($type) ): ?>
	    <div class="alert alert-success">
	    	<a class="close" data-dismiss="alert" href="#">&times;</a>
  	  	<?php echo $msg; ?>
	    </div>			
	    <?php endif; endforeach; ?>
						</div>
                        </div>
                    </div>