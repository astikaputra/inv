<div class="container-fluid">

      <div class="row-fluid">
	    <div class="span12">
		   <?php echo $output;?>
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
</div>