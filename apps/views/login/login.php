<div class="container-fluid">
<div class="row-fluid">

		<div class="account-wall">
			<?php 
				echo form_open('core/login',array('class'=>'form login-form'));
				?>
                <br />
                <center>
					<img src="<?php echo $this->config->item('template').'images/medicos-centric.png';?>"/>
				</center>
                <h1 class="text-center login-title">Sign In To <span class="blue">APT</span></h1>

            	<br />
                    <center>
					<div class="input-prepend">
					<span class="add-on"><i class="icon-user"></i></span>
					<input type="text" class="form-control span10" name="username" placeholder="User Name" required/>
					</div>
					</center>
   
                    <center>
					<div class="input-prepend">
					<span class="add-on"><i class="icon-lock"></i></span>
					<input type="password" class="form-control span10" name="password" placeholder="Password"  required/>
					</div>
					<center>
					<button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>

        <?php echo form_close();?>
		<br />
		<img src="<?php echo $this->config->item('template').'images/logo.png';?>">
        </div>

</div> 
</div>