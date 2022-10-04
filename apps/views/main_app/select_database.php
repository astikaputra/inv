<style>
.database-wall
{
	padding: 15px;
	border-radius: 15px;
	position: center;
	text-align:center;
	display: block;
    width: 300px;
	left: 50%;
	top: 50%;
	margin-left: -150px;
	margin-top: -200px;
	position: absolute;
	background-color: rgba(255, 255, 255, 0.5);
	border-radius: 15px;
}
    
</style>
<body class="lock-screen">
<div class="container-fluid">
<div class="row-fluid">
		<div class="database-wall">
        <?php echo form_open('core/set_db');?>
			<?php foreach($list_db as $row){?>
			<label class="radio">
			<input type="radio" name="db" value="<?php echo $row->connection_id; ?>"><b><?php echo $row->real_hospital_name.'  ('.$row->database_type.')'; ?></b>
            </label>
			<?php }?>
		
			<br />
			
			<button type="submit" class="btn btn-primary">Select Hospitals</button>
			
			<?php echo form_close();?>
		</div>
      </div>
</div>
</body>