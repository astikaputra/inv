 <div class="container-fluid main-menu">
      <div class="row-fluid">
	  <div class="span12">
	  <h3> <?php echo $content_title; ?> </h3>
	  </div>
	  
	 <center>
	 <div class="span12">
		<div class="span12 well">
        <?php echo form_open($form_request);?>
			<center><input type="text" name="user_requested" placeholder="Who's requested" required/>
			<span class="help-block">* Please input user id.</span>
			</center>
			<br />
			<center>
			<button type="submit" class="btn btn-large btn-primary">Execute</button>
			</center>
			<?php echo form_close();?>
      </div>
	  </div>
	  </center>
</div>