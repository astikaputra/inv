 <div class="container-fluid">

      <div class="row-fluid">
		<div class="span12">
			<h3> <?php echo $content_title; ?> </h3>
        </div>
		
		<center>
		<div class="span12">
		<div class="span12 well">
			<?php echo form_open("$form_search_action",array('class'=>'form-search'));?>
			<center>
			<input type="text" name="keyword" class="input-large search-query" placeholder="Search Item Name or Item Code" required/>
			<span class="help-block text-center">* Please input item service name or code.</span>
			</center>
			<br />
			<center>
			<button type="submit" class="btn btn-large btn-primary">Search</button>
			</center>
			<?php echo form_close();?>	

		
	<?php if(isset($items_data)) { ?>
	<center>
     <div class="span12 well">
	 <img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">
	 <p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
	<table class="table table-striped table-bordered" >
	<thead>
		<tr>
			<th>Id</th><th>CodeValue</th><th>NameValue</th><th>Assign</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($items_data as $items)
		{?>	
		<tr>
		<td><?php echo $items->Id;?></td>
		<td><?php echo $items->CodeValue;?></td>
		<td><?php echo $items->NameValue;?></td>
		<td><a href="<?php echo base_url();?><?php echo $button_action;?><?php echo $items->Id; ?>" class="btn btn-mini btn-primary">assign</a></td>
		</tr>
		<?php }?>
	</tbody>
	</table>
	</div>
	<center>
	<?php } ?>
		
   <div class="row pull-right">
	    <div class="span12 back">
			<?php if(isset($parent_page))
			{?>
			<a href="<?php echo base_url().$parent_page;?>" class="btn btn-inverse">Kembali Ke Halaman Sebelumnya</a>
			<?php }?>
			<a href="<?php echo base_url();?>tools" class="btn btn-success">Kembali Ke Menu Utama</a>
		</div>
			
    </div>
	</div>
	</div>
		</center>
	</div>
</div>
