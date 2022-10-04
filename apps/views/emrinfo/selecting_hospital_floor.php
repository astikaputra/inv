 <div class="container-fluid">

      <div class="row">
					<h3> <?php echo $content_title; ?> </h3>
    
		
	<ul class="nav nav-pills text-center" >
<li class="active"><a href="#floor" data-toggle="tab"><h2> Floor </h2></a></li>
<li><a href="#ward" data-toggle="tab"><h2> Ward </h2></a></li>
 
</ul>
<div class="tab-content">
  <div class="tab-pane active" id="floor">
	<p>
  	<?php foreach($list_floor as $floor) {?>
	 <a class="btn btn-large" style="width:225px; padding:30px; margin:10px; " href=<?php echo $linkto.'/'.$floor->Id;?>><b><?php echo $floor->NameValue;?></b></a>
	    <?php }?>
	</p>
  </div>
  <div class="tab-pane" id="ward">
  <p>
  	<?php foreach($list_ward as $ward) {?>
	 <a class="btn btn-large primary" style="width:300px; padding:30px; margin:10px; " href=<?php echo $linkto.'/'.$ward->Floor.'/'.$ward->Id;?>><b><?php echo $ward->DescValue;?></b></a>
	    <?php }?>
	</p>
  </div>

</div>

	
	</div>
	    <div class="row">
	    <div class="span12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Kembali Ke Menu Utama</a>
		</div>
		<div>
</div>
