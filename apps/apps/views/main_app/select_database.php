 <div class="container main-menu">

      <div class="row">
		<div class="span6 offset3" style="background-color: rgba(250, 227, 227, 0.6);padding:20px;border-radius: 5px;">
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