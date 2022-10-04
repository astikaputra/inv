 <div class="container">

      <div class="row">
		<div class="span12">
			<h3> <?php echo $content_title; ?> </h3>
        </div>	
		<div class="span12">
		 <a href="<?php echo base_url(); ?>core/sys_config/hospital" class="btn btn-success">Manage Hospital Data</a>
		 <a href="<?php echo base_url(); ?>core/sys_config/database" class="btn btn-success">Manage Database Connection</a>
		 <a href="<?php echo base_url(); ?>core/sys_config/tools" class="btn btn-success">Manage Tools</a>
		 <a href="<?php echo base_url(); ?>core/sys_config/user" class="btn btn-success">Manage User</a>
		 <a href="<?php echo base_url(); ?>core/sys_config/log" class="btn btn-success">Log</a>
        </div>
			<div class="span12"> </div>
        <div class="span12 tab">
		   <?php echo $output;?>
        </div>
			
	   </div>
	   
	   <div class="row">
	    <div class="span12 back">
		<?php if(isset($parent_page))
			{?>
			<a href="<?php echo base_url().$parent_page;?>" class="btn btn-inverse">Kembali Ke Halaman Sebelumnya</a>
			<?php }?>
			<a href="<?php echo base_url();?>tools" class="btn btn-success">Kembali Ke Menu Utama</a>
			</div>
			
			</div>
</div>
