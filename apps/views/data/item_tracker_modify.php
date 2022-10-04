
 <div class="container-fluid">

      <div class="row-fluid">
		<div class="span12">
			<h3> <?php echo $content_title; ?> </h3>
        </div>
		<hr />
		<div class="well">
			<?php echo form_open('item_modify/lookup',array('class'=>'form-search'));?>
			<p class="text-center">Insert Name / Item Code : <br />
            <br />
            <input type="text" name="keyword" class="span3 search-query" value="" required placeholder="Name Or Item Code"></p>
			<br />
            <div style="text-align: center;">
	   		<button type="submit" class="btn btn-large btn-primary" >Search</button>
            </div>
			
			<?php echo form_close();?>
		
		<?php 
		if(isset($items_data))
		{
		?>
	 <div class="row-fluid">
	 <br />
	 <img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">
	 <p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
	<table class="table table-striped table-bordered" >
	<thead>
		<tr>
			<th>Action</th><th>Item Code</th><th>Item Name</th><th>Buy UOM</th><th>Sell UOM</th><th>Formularium</th><th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($items_data as $items)
		{?>	
		<tr>
		<td><a href="<?php echo base_url();?><?php echo $button_action;?><?php echo $items->CodeValue;?>" data-target="#traceModal" role="button" data-toggle="modal" class="btn btn-mini btn-primary">trace</a></td>
		<td><?php echo $items->CodeValue;?></td>
		<td><?php echo $items->NameValue;?></td>
		<td><?php echo $items->uom_buy;?></td>
		<td><?php echo $items->uom_sell;?></td>
		<td>
		<a data="<?php echo base_url();?><?php if($items->IsFormularium == 'YES'){echo 'item_modify/deactivate_formularium/';}else{echo 'item_modify/activate_formularium/';}?><?php echo $items->CodeValue.'/'.time(); ?>" class="btn btn-mini <?php if($items->IsFormularium == 'YES'){echo 'btn-success';}else{echo 'btn-inverse';}?> formularium" id="fr-<?php echo $items->CodeValue;?>"><?php echo $items->IsFormularium;?></a>
		</td>
		<td>
		<a data="<?php echo base_url();?><?php if($items->RecordStatus == 'Active'){echo 'item_modify/deactivate_item/';}else{echo 'item_modify/activate_item/';}?><?php echo $items->CodeValue.'/'.time(); ?>" class="btn btn-mini <?php if($items->RecordStatus == 'Active'){echo 'btn-success';}else{echo 'btn-inverse';}?> recordstatus" id="rs-<?php echo $items->CodeValue;?>" ><?php echo $items->RecordStatus;?></a>
		</td>
		</tr>
		<?php }?>
	</tbody>
	</table>
	</div>
	<?php 
		}
		?>
		<div class="row" align="right">
	   	<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Main Menu</a>
		</div>
   </div>
</div>

<div class="modal hide fade" style="width:70%; margin: 0 0 0 -450px; " id="traceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
			<center><h4>Drugs & Medical Supplies Tracker</h4><center>
	</div>
   <div class="modal-body"><div class="te"></div></div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal">OK</button>
	</div>
</div>
