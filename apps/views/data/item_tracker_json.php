
 <div class="container-fluid">

      <div class="row-fluid">
		<div class="span12">
			<h3> <?php echo $content_title; ?> </h3>
        </div>
		<hr />
		<div class="span12">
			<?php echo form_open('item_tracker/lookup',array('class'=>'form-search'));?>
			<input type="text" name="keyword" class="input-large search-query" placeholder="Search Item Name or Item Code" required/>
			<button type="submit" class="btn btn-primary">Search</button>
			
			<?php echo form_close();?>
        </div>
		
		<?php 
		if(isset($items_data))
		{
		?>
        <div class="span12">
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
	<thead class="table_head">
		<tr>
			<th>Action</th><th>Item Code</th><th>Item Name</th><th>Buy UOM</th><th>Sell UOM</th><th>Formularium</th><th>Status</th>
		</tr>
	</thead>
	<tfoot class="table_head">
		<tr>
			<th>Action</th><th>Item Code</th><th>Item Name</th><th>Buy UOM</th><th>Sell UOM</th><th>Formularium</th><th>Status</th>
		</tr>
	</tfoot>
	<tbody>
		<?php foreach($items_data as $items)
		{?>	<tr><td><a data="<?php echo base_url();?><?php echo $button_action;?><?php echo $items->CodeValue.'/'.time(); ?>" class="btn btn-mini btn-primary openBtn" id="<?php echo $items->Id; ?>"onclick="this.href='javascript:void(0)';this.disabled=1">trace</a></td><td><?php echo $items->CodeValue;?></td><td><?php echo $items->NameValue;?></td><td><?php echo $items->uom_buy;?></td><td><?php echo $items->uom_sell;?></td><td><?php echo $items->IsFormularium;?></td><td><?php echo $items->RecordStatus;?></td></tr>
		<?php }?>
	</tbody>
</table>
	</div>
	<?php 
		}
		?>
	
	
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

<div id="myModal" class="modal hide fade" style="width: 1100px; margin: 0 0 0 -550px; " tabindex="-1" role="dialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">??</button>
			<center><h4>Drugs & Medical Supplies Tracker</h4><center>
	</div>
	<div class="modal-body">
	  <div id='waiting-inside'><img src='<?php echo base_url();?>/assets/loading_big.gif' style='width:70px;margin:180px auto;'/></div>
      <iframe src="" style="zoom:0.60" width="99.6%" height="700" frameborder="0">
	  </iframe>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal">OK</button>
	</div>
</div>
