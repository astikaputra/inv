 <div class="container main-menu">

      <div class="row">
        <div class="span6 menu">
		<a href="<?php echo base_url();?>document_control/manage_company_cat ">
          <img src="<?php echo $this->config->item('template').'icon/';?>company.png" width=128px; height=128px;>
          <p><b>Kelola Data Kategori Perusahaan</b></p>
		  </a>
        </div>
        <div class="span6 menu">
		<a href="<?php echo base_url();?>document_control/manage_document_cat ">
          <img src="<?php echo $this->config->item('template').'icon/';?>dokumen.png" width=128px; height=128px;>
          <p><b>Kelola Data Kategori Dokumen</b></p>
		  </a>
        </div>
	   </div>
	   
	   <div class="row">
	    <div class="span12 back">
			<a href="<?php echo base_url();?>document_control" class="btn btn-inverse">Kembali Ke Menu Utama</a>
			</div>
	   </div>
</div>