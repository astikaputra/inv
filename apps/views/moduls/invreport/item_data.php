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
			<span class="help-block text-center">* Please input item name or code.</span>
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
	<table class="table table-bordered" id="cashier_datbl" >
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
		<td>
		<?php foreach($this->mst_model->check_item_mapping_store($items->CodeValue) as $store_item) { ?>
		<a href="<?php echo base_url();?><?php if($store_item->TotalStore != '0'){echo $button_action;}else{echo $button_action;}?><?php echo $items->Id.'/'.time(); ?>" class="btn btn-mini <?php if($store_item->TotalStore != '0'){echo 'btn-success';}else{echo 'btn-warning';}?>"><?php if($store_item->TotalStore != '0'){echo 'Has Assign';}else{echo 'Not Assign';}?></a>
		<?php } ?>
		</td>
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


<!-- Modal -->
<div class="modal hide fade" style="width:70%; margin: 0 0 0 -450px;" id="traceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <center><h3 class="modal-title"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></h3></center>
            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->