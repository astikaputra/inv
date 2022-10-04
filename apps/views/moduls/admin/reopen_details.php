		<div class="container-fluid">
		<div class="row-fluid">
		<div class="well">
				   <?php echo form_open($button_action,array('class'=>'form-search'));?>
				   
					<p class="text-center">Insert Reason Of Reopen Payment : <br />
					<br />
						<input type="text" name="reason" class="span8 input-large" value="" placeholder="Reason Of Reopen" required/>
						<br />
						<br />
						<input type="text" name="userreq" class="span3 input-large" value="" placeholder="User Requestor" required/></p>
					<br />
					<div style="text-align: center;">
						<button type="submit" class="btn btn-large btn-primary" >Submit</button>
					</div>				   
				 
				   <?php echo form_close();?>
					
		</div>
		</div>
		</div>