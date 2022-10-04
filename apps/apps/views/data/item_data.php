 <div class="container">

      <div class="row">
		<div class="span12">
			<h3> <?php echo $content_title; ?> </h3>
        </div>
        <div class="span12">
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
	<thead class="table_head">
		<tr>
			<th>Id</th><th>CodeValue</th><th>NameValue</th><th>Assign</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Id</th><th>CodeValue</th><th>NameValue</th><th>Action</th>
		</tr>
	</tfoot>
	<tbody>
		<?php foreach($items_data as $items)
		{?>	<tr><td><?php echo $items->Id;?></td><td><?php echo $items->CodeValue;?></td><td><?php echo $items->NameValue;?></td><td><a href="<?php echo base_url();?><?php echo $button_action;?><?php echo $items->Id; ?>" class="btn btn-mini btn-primary">assign</a></td></tr>
		<?php }?>
	</tbody>
</table>
	</div>
   </div>
   <div class="row">
	    <div class="span12 back">
			<?php if(isset($parent_page))
			{?>
			<a href="<?php echo base_url().$parent_page;?>" class="btn btn-inverse">Kembali Ke Halaman Sebelumnya</a>
			<?php }?>
			<a href="<?php echo base_url();?>tools" class="btn btn-success">Kembali Ke Menu Utama</a>
		</div>
			
			</div>
</div>
