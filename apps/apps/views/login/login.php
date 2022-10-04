<div class="container-fluid">
<div class="row-fluid">
		
		<div class="center-content span12" id="center_content">
			<div class="span6">
				
				<div align="center" class="app"><em><strong><?php echo $message;?></strong></em></div>
			
			</div>
			<div class="span6">
				<div class="loginarea">
				<?php 
				echo form_open('core/login');
				?>
					<input type="text" name="username" placeholder="User Name" value="user" required/>
					<input type="password" name="password" placeholder="Password" value="password" required/><br />
				<input type="submit" value="Login" name="submit" class="btn btn-large btn-primary" />
				</form>    
				
				</div>
			</div>
		</div>
		<div class="span12 logo">
			<img src="<?php echo $this->config->item('template').'images/logo.png';?>">
		</div>
</div> 
</div>

