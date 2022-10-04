 <div class="container main-menu">

      <div class="row">
					<h3> <?php echo $content_title; ?> </h3>
        <?php echo form_open($form_request);?>
			<input type="text" name="user_requested" placeholder="Who's requested" required/>
			<br />
			
			<button type="submit" class="btn btn-primary">Execute</button>
			
			<?php echo form_close();?>
      </div>
</div>