 <div class="container">

      <div class="row">
		<div class="span12">
			<h3> <?php echo $content_title; ?> </h3>
        </div>
		<div class="span12">
		<?php foreach($tabmenu as $row)
		{?>
			 <a href="<?php echo base_url(); ?>document_control/list_company_doc/<?php echo $row->id_kategori_doc; ?>/<?php echo $this->session->userdata('company_id'); ?>" class="btn btn-success"><?php echo $row->deskripsi; ?></a>
		<?php } ?>  
        </div>
			<div class="span12"> </div>
        <div class="span12 tab">
		      <?php echo $output;?>
        </div>
			
	   </div>
	   
	   <div class="row">
	    <div class="span12 back">
		<?php if(isset($parent_page))
			{?>
			<a href="<?php echo base_url().$parent_page;?>" class="btn btn-inverse">Kembali Ke Halaman Sebelumnya</a>
			<?php }?>
			<a href="<?php echo base_url();?>document_control" class="btn btn-success">Kembali Ke Menu Utama</a>
			</div>
			
			</div>
</div>
