<div id="page-header">
			<?php					
			$adsq = "SELECT * FROM tb_banner WHERE location = 'top' and start_date <= date(now()) and date(now())<= end_date";
			$query = $this->db->query($adsq)->row();
			if($query)
			{
			echo $query->banner_content;
			}
			?>
		</div>
		
		<!-- BEGIN .section -->
		<div class="section page-content clearfix">
	
			<h2 class="page-title">Login</h2>

			<div class="msg notice"><p>Don't have an account? <a href="<?php echo base_url();?>index.php/member/daftar">Register now</a></p></div>
			
				<?php echo form_open('member/login');?>
				<ul class="columns-2 checkout-form clearfix">
					<li class="col2 clearfix">
					
						<div class="tag-title-wrap clearfix">
							<h4 class="tag-title">Login</h4>
						</div>
						<div>
						<?php if(isset($error)) echo "<b><span style='color:red;'>$error</span></b>";
						if(isset($logout)) echo "<b><span style='color:red;'>$logout</span></b>"; ?></div>
						<input class="half-input fl" type="text" name="email" onblur="if(this.value=='')this.value='Email Address';" onfocus="if(this.value=='Email Address')this.value='';" value="Email Address" />
						<input class="half-input fr" type="password" name="password" onblur="if(this.value=='')this.value='Password';" onfocus="if(this.value=='Password')this.value='';" value="Password" />
			
						
						
						<input class="button2 fr" type="submit" value="Log In" id="login" name="login">
						
					</li>
				</ul>
			</form>
			
			<!-- END .section -->
		</div>
		
		<div class="section page-content clearfix">
	
			<form method="post" action="#">
				<ul class="columns-2 checkout-form clearfix">
					<li class="col2 clearfix">
					
						<div class="tag-title-wrap clearfix">
							<h4 class="tag-title">Forgot Password</h4>
						</div>
					
	
						<input class="full-input" type="text" name="email-address" onblur="if(this.value=='')this.value='Email Address';" onfocus="if(this.value=='Email Address')this.value='';" value="Email Address" />
						<input class="button2 fr" type="submit" value="Submit" id="submit" name="submit">
						
						
						<div style="clear:both;height:20px;margin:0;"></div>
					</li>
				</ul>
			
			</form>

		<!-- END .section -->
		</div>