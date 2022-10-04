<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_control extends CI_Controller {

public function index()
	{
		if (!$this->session->userdata('username'))
		{
			redirect('core', 'refresh');
		}
	  else 
	  	{
			
			$data['title'] = "Sistem Manajemen Dokumen Perusahaan :: ".$this->config->item('company_name')." Administration Dashboard";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['message'] = "Selamat Datang".$this->session->userdata('user');
					if($this->session->userdata('level') == 'Administrator')
					{
					$data['content'] = 'main_app/admin'; 
					$this->load->view('system',$data);
					}
				else
					{
					$data['content'] = 'main_app/admin'; 
					$this->load->view('system',$data);
					}
			}
		
	}
	
	function config_system()
	{
	if($this->session->userdata('username'))
		{	
			$data['title'] = "Sistem Manajemen Dokumen Perusahaan :: ".$this->config->item('company_name')." Administration Dashboard | System Configuration";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			if($this->session->userdata('level') == 'Administrator')
			{	
				$data['content'] = 'main_app/config_system';
			}
			else
			{
				$data['page_title'] = "Maaf Anda tidak bisa mengakses modul ini... Mohon hubungi admistrator pada perusahaan anda ";
				$data['content'] = 'component/error_page';
			}
			$this->load->view('system',$data);
		}
		else
		{
		redirect('core', 'refresh');
		}
	}
	
	function manage_company_cat()
	{
		if($this->session->userdata('username'))
		{	
			$data['title'] = "Sistem Manajemen Dokumen Perusahaan :: ".$this->config->item('company_name')." Administration Dashboard | Atur Data Kategori Perusahaan";
			$data['style'] = 'portal.css'; 
			if($this->session->userdata('level') == 'Administrator')
			{	
				$crud = new grocery_CRUD();
				$crud->set_table('tbl_kategori_perusahaan');
				$crud->set_theme('datatables');
				
				$crud->required_fields('kategori_perusahaan','detail_kategori');
				$crud->set_subject('Kategori Perusahaan');
				$output = $crud->render();
				$data['content_title']='Konfigurasi Data Tipe Perusahaan'; 
				$data['content'] = 'main_app/main_data';
				$data['page']='data';
			}
			else
			{
				$data['page_title'] = "Maaf Anda tidak bisa mengakses modul ini... Mohon hubungi admistrator pada perusahaan anda ";
				$data['content'] = 'component/error_page';
			}
			$data['parent_page']="document_control/config_system";
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
			
		}
		else
		{
		redirect('core', 'refresh');
		}
	
	}
	
	
	function manage_document_cat($type_cat= NULL,$parent_cat=NULL)
	{
		if($this->session->userdata('username'))
		{	
			$data['title'] = "Sistem Manajemen Dokumen Perusahaan :: ".$this->config->item('company_name')." Administration Dashboard | Atur Kategori Dokumen";
			$data['style'] = 'portal.css'; 
			$data['parent_page']="document_control/config_system";
			if($this->session->userdata('level') == 'Administrator')
			{	
				$crud = new grocery_CRUD();
				if($type_cat=='detil')
				{
				$crud->set_table('tbl_jenis_dokumen');
				$crud->set_theme('datatables');
				$crud->required_fields('kode_dokumen','deskripsi_dokumen');
				$crud->set_relation('kategori_dokumen','tbl_kategori_dokumen','kategori_document');
				$crud->where('kategori_dokumen',$parent_cat);
				$crud->set_subject('Master Jenis Dokumen');
				$data['parent_page']="document_control/manage_document_cat";
				}
				else
				{
				$crud->set_table('tbl_kategori_dokumen');
				$crud->set_theme('datatables');
				$crud->required_fields('kategori_document','deskripsi');
				$crud->add_action('Detail Dokumen','', 'document_control/manage_document_cat/detil','ui-icon-plus');
				$crud->set_subject('Kelompok Dokumen');
				}
				$output = $crud->render();
				$data['content_title']='Konfigurasi Kategori Dokumen'; 
				$data['content'] = 'main_app/main_data';
				$data['page']='data';
			}
			else
			{
				$data['page_title'] = "Maaf Anda tidak bisa mengakses modul ini... Mohon hubungi admistrator pada perusahaan anda ";
				$data['content'] = 'component/error_page';
			}
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
		
		}
		else
		{
		redirect('core', 'refresh');
		}
	
	}
	
	function manage_company()
	{
		if($this->session->userdata('username'))
		{	
			$data['title'] = "Sistem Manajemen Dokumen Perusahaan :: ".$this->config->item('company_name')." Administration Dashboard | Atur Data Perusahaan";
			$data['style'] = 'portal.css'; 
			if($this->session->userdata('level') == 'Administrator')
			{	
				$crud = new grocery_CRUD();
				$crud->set_table('tbl_perusahaan');
				$crud->set_theme('datatables');
				$crud->required_fields('nama_perusahaan','kategori_perusahaan','alamat_perusahaan');
				$crud->columns('nama_perusahaan','kategori_perusahaan','alamat_perusahaan','status_perusahaan');
				$crud->set_relation('kategori_perusahaan','tbl_kategori_perusahaan','detail_kategori');
				$crud->set_subject('Master Data Perusahaan');
				$crud->field_type('di_input_oleh', 'hidden', $this->session->userdata('user'));
				$crud->field_type('di_update_oleh', 'hidden', $this->session->userdata('user'));
				$crud->field_type('status_aktif', 'dropdown',  array('aktif' => 'Aktif', 'tidak_aktif' => 'Tidak Aktif'));
				$crud->field_type('status_perusahaan', 'dropdown',  array('PMA' => 'PMA', 'PMDN' => 'PMDN', 'BUKAN PMA/PMDN' => 'Bukan PMA/PMDN'));
				$output = $crud->render();
				$data['content_title']='Master Data Perusahaan'; 
				$data['content'] = 'main_app/main_data';
				$data['page']='data';
			}
			else
			{
				$data['page_title'] = "Maaf Anda tidak bisa mengakses modul ini... Mohon hubungi admistrator pada perusahaan anda ";
				$data['content'] = 'component/error_page';
			}
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
		
		}
		else
		{
		redirect('core', 'refresh');
		}
	
	
	}
	
	function manage_document()
	{
		if($this->session->userdata('username'))
		{	
			$data['title'] = "Sistem Manajemen Dokumen Perusahaan :: ".$this->config->item('company_name')." Administration Dashboard | Manage Dokumen";
			$data['style'] = 'portal.css'; 
			if($this->session->userdata('level') == 'Administrator')
			{	
				$crud = new grocery_CRUD();
				$crud->set_table('tbl_perusahaan');
				$crud->set_theme('datatables');
				
				$crud->unset_add();
				$crud->unset_delete();
				$crud->unset_edit();
				$crud->unset_print();
				$crud->unset_export();
				$crud->required_fields('nama_perusahaan','kategori_perusahaan','alamat_perusahaan');
				$crud->columns('id_perusahaan','nama_perusahaan');
				$crud->set_relation('kategori_perusahaan','tbl_kategori_perusahaan','detail_kategori');
				$crud->add_action('Manage Document','', 'document_control/company_doc/set','ui-icon-plus');
				$output = $crud->render();
				$data['content_title']='Master Data Perusahaan'; 
				$data['content'] = 'main_app/main_data';
				$data['page']='data';
			}
			else
			{
				$data['page_title'] = "Maaf Anda tidak bisa mengakses modul ini... Mohon hubungi admistrator pada perusahaan anda ";
				$data['content'] = 'component/error_page';
			}
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
		}
		else
		{
		redirect('core', 'refresh');
		}
	}
	
	function company_doc($doc_cat=NULL,$company_id)
	{
	if($this->session->userdata('username'))
		{	
			$data['title'] = "Sistem Manajemen Dokumen Perusahaan :: ".$this->config->item('company_name')." Administration Dashboard | Dokumen Perusahaan";
			$data['style'] = 'portal.css'; 
			$data['tabmenu'] = $this->sys_model->get_pr_cat()->result();
			if($this->session->userdata('level') == 'Administrator')
			{	
				
				
				$crud = new grocery_CRUD();
				$crud->set_table('tbl_master_dokumen');
				$crud->set_theme('flexigrid');
				$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ');
				$crud->unset_print();
				$crud->unset_export();
				$crud->display_as('id_document','ID Dokumen')
					 ->display_as('id_jenis_document','Tipe Dokumen')
					 ->display_as('file_attachment','File');
				if($doc_cat=='set')
				{
				$sesdata = array('company_id'  => $company_id);
				$this->session->set_userdata($sesdata);
				}
				else if($doc_cat=='1')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$crud->set_subject('List Dokumen SKEP Perusahaan');
				$crud->field_type('masa_berlaku','invisible')
						->field_type('tanggal_habis_masa_berlaku','invisible')
						->field_type('luas','invisible')
						->field_type('status','invisible')
						->field_type('nama','invisible')
						->field_type('jabatan','invisible')
						->field_type('luas','invisible');
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);
				}
				else if($doc_cat=='2')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$crud->set_subject('List Dokumen Pendukung Perusahaan');
				$crud->field_type('luas','invisible')
						->field_type('status','invisible')
						->field_type('nama','invisible')
						->field_type('jabatan','invisible')
						->field_type('luas','invisible');
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);
				}
				else if($doc_cat=='3')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$crud->set_subject('List Dokumen Penanggung Jawab Perusahaan');
				$crud->field_type('masa_berlaku','invisible')
						->field_type('luas','invisible')
						->field_type('status','invisible')
						->field_type('luas','invisible');
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);		
				}
				else if($doc_cat=='4')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$crud->set_subject('List Dokumen Bukti Kepemilikan Perusahaan');
				$crud->field_type('nama','invisible')
						->field_type('jabatan','invisible');
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);
				}
				else if($doc_cat=='5')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$crud->set_subject('List Dokumen Fasilitas Lain Perusahaan');
				$crud->field_type('status','invisible')
						->field_type('nama','invisible')
						->field_type('jabatan','invisible');
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);
				}
				else if($doc_cat!='set')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$subject = $this->sys_model->get_pr_cat($doc_cat)->row();
				$crud->set_subject("$subject->deskripsi");
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);
				}
				$crud->columns('id_jenis_document','tanggal_pembuatan','masa_berlaku','file_attachment');
				$crud->set_relation('id_perusahaan','tbl_perusahaan','nama_perusahaan');
				$crud->where('tbl_master_dokumen.id_perusahaan',$company_id);
				$crud->field_type('id_document', 'hidden', 'doc-id-'.md5($company_id.date("Y-m-d H:i:s")));
				$crud->field_type('id_perusahaan', 'hidden', $company_id);
				$crud->order_by('tanggal_upload','desc');				
				$crud->set_field_upload('file_attachment','assets/uploads/document');
				$crud->field_type('di_upload_oleh', 'hidden', $this->session->userdata('user'));
				$crud->callback_before_insert(array($this,'_append_uploaded_file'));
				$crud->callback_before_update(array($this,'_append_uploaded_file'));
				$output = $crud->render();
				$data['content_title']='Dokumen Perusahaan '.$this->sys_model->get_company_name($company_id); 
				$data['content'] = 'main_app/multi_tab';
				$data['page']='data';
			}
			else
			{
				$data['page_title'] = "Maaf Anda tidak bisa mengakses modul ini... Mohon hubungi admistrator pada perusahaan anda ";
				$data['content'] = 'component/error_page';
			}
			$data['parent_page']="document_control/manage_document";
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
		}
		else
		{
		redirect('core', 'refresh');
		}
	
	}
	
	function manage_user()
	{
		if($this->session->userdata('username'))
		{	
			$data['title'] = "Sistem Manajemen Dokumen Perusahaan :: ".$this->config->item('company_name')." Administration Dashboard | Pengaturan Pengguna";
			$data['style'] = 'portal.css'; 
			if($this->session->userdata('level') == 'Administrator')
			{	
				$crud = new grocery_CRUD();
				$crud->set_table('tbl_user');
				$crud->set_theme('flexigrid');
				$crud->required_fields('username','password','nama','birthdate','level_user','email','no_telepon');
				$crud->columns('username','nama','birthdate','level_user','email','no_telepon','active');
				$crud->set_relation('level_user','tbl_level_user','level_user');
				$crud->set_subject('Data Pengguna Sistem');
				$crud->field_type('password', 'password', '');
				$crud->callback_before_insert(array($this,'_encrypt_pass'));
				$crud->callback_before_update(array($this,'_encrypt_pass'));
				$crud->field_type('id_user', 'hidden', md5(date("Y-m-d H:i:s")));
				$crud->field_type('is_online', 'hidden', '');
				$crud->field_type('active', 'dropdown',  array('1' => 'Active', '2' => 'Inactive'));
				$output = $crud->render();
				$data['content_title']='Data Pengguna Sistem'; 
				$data['content'] = 'main_app/main_data';
				$data['page']='data';
			}
			else
			{
				$data['page_title'] = "Maaf Anda tidak bisa mengakses modul ini... Mohon hubungi admistrator pada perusahaan anda ";
				$data['content'] = 'component/error_page';
			}
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
		}
		else
		{
		redirect('core', 'refresh');
		}
	
	
	}
	
	function list_document()
	{
		if($this->session->userdata('username'))
		{	
			$data['title'] = "Sistem Manajemen Dokumen Perusahaan :: ".$this->config->item('company_name')." Administration Dashboard | List Dokumen";
			$data['style'] = 'portal.css'; 
			if($this->session->userdata('level'))
			{	
				$crud = new grocery_CRUD();
				$crud->set_table('tbl_perusahaan');
				$crud->set_theme('datatables');
				$crud->unset_add();
				$crud->unset_delete();
				$crud->unset_edit();
				$crud->unset_print();
				$crud->unset_export();
				$crud->required_fields('nama_perusahaan','kategori_perusahaan','alamat_perusahaan');
				$crud->columns('id_perusahaan','nama_perusahaan');
				$crud->set_relation('kategori_perusahaan','tbl_kategori_perusahaan','detail_kategori');
				$crud->add_action('Lihat Semua Dokumen','', 'document_control/list_company_doc/set','ui-icon-plus');
				$output = $crud->render();
				$data['content_title']='Master Data Dokumen Perusahaan'; 
				$data['content'] = 'main_app/main_data';
				$data['page']='data';
			}
			else
			{
				$data['page_title'] = "Maaf Anda tidak bisa mengakses modul ini... Mohon hubungi admistrator pada perusahaan anda ";
				$data['content'] = 'component/error_page';
			}
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
		}
		else
		{
		redirect('core', 'refresh');
		}
	
	
	}
	
	function list_company_doc($doc_cat=NULL,$company_id)
	{
	if($this->session->userdata('username'))
		{	
			$data['title'] = "Sistem Manajemen Dokumen Perusahaan :: ".$this->config->item('company_name')." Administration Dashboard | List Dokumen ".$this->sys_model->get_company_name($company_id);
			$data['style'] = 'portal.css'; 
			$data['tabmenu'] = $this->sys_model->get_pr_cat()->result();
			if($this->session->userdata('level'))
			{	
				
				
				$crud = new grocery_CRUD();
				$crud->set_table('tbl_master_dokumen');
				$crud->set_theme('flexigrid');
				$crud->display_as('id_document','ID Dokumen')
					 ->display_as('id_jenis_document','Tipe Dokumen')
					 ->display_as('file_attachment','File');
				if($doc_cat=='set')
				{
				$sesdata = array('company_id'  => $company_id);
				$this->session->set_userdata($sesdata);
				}
				else if($doc_cat=='1')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$crud->set_subject('List Dokumen SKEP Perusahaan');
				$crud->field_type('masa_berlaku','invisible')
						->field_type('tanggal_habis_masa_berlaku','invisible')
						->field_type('luas','invisible')
						->field_type('status','invisible')
						->field_type('nama','invisible')
						->field_type('jabatan','invisible')
						->field_type('luas','invisible');
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);
				}
				else if($doc_cat=='2')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$crud->set_subject('List Dokumen Pendukung Perusahaan');
				$crud->field_type('luas','invisible')
						->field_type('status','invisible')
						->field_type('nama','invisible')
						->field_type('jabatan','invisible')
						->field_type('luas','invisible');
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);
				}
				else if($doc_cat=='3')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$crud->set_subject('List Dokumen Penanggung Jawab Perusahaan');
				$crud->field_type('masa_berlaku','invisible')
						->field_type('luas','invisible')
						->field_type('status','invisible')
						->field_type('luas','invisible');
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);		
				}
				else if($doc_cat=='4')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$crud->set_subject('List Dokumen Bukti Kepemilikan Perusahaan');
				$crud->field_type('nama','invisible')
						->field_type('jabatan','invisible');
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);
				}
				else if($doc_cat=='5')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$crud->set_subject('List Dokumen Fasilitas Lain Perusahaan');
				$crud->field_type('status','invisible')
						->field_type('nama','invisible')
						->field_type('jabatan','invisible');
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);
				}
				else if($doc_cat!='set')
				{$crud->set_relation('id_jenis_document','tbl_jenis_dokumen','{kode_dokumen} - {deskripsi_dokumen} ',array('kategori_dokumen' => $doc_cat));
				$subject = $this->sys_model->get_pr_cat($doc_cat)->row();
				$crud->set_subject("$subject->deskripsi");
				$crud->where('tbl_master_dokumen.id_kategori_doc',$doc_cat);
				$crud->field_type('id_kategori_doc', 'hidden', $doc_cat);
				}
				$crud->columns('id_document','id_perusahaan','id_jenis_document','tanggal_pembuatan','masa_berlaku','file_attachment');
				$crud->set_relation('id_perusahaan','tbl_perusahaan','nama_perusahaan');
				$crud->where('tbl_master_dokumen.id_perusahaan',$company_id);
				$crud->order_by('tanggal_upload','desc');				
				$crud->set_field_upload('file_attachment','assets/uploads/document');
				$crud->field_type('di_upload_oleh', 'hidden', $this->session->userdata('user'));
				$crud->callback_before_insert(array($this,'_append_uploaded_file'));
				$crud->callback_before_update(array($this,'_append_uploaded_file'));
				$crud->unset_add();
				$crud->unset_delete();
				$crud->unset_edit();
				$crud->unset_print();
				$crud->unset_export();
				$output = $crud->render();
				$data['content_title']='Dokumen Perusahaan '.$this->sys_model->get_company_name($company_id); 
				$data['content'] = 'main_app/multi_tab_viewer';
				$data['page']='data';
			}
			else
			{
				$data['page_title'] = "Maaf Anda tidak bisa mengakses modul ini... Mohon hubungi admistrator pada perusahaan anda ";
				$data['content'] = 'component/error_page';
			}
			$data['parent_page']="document_control/list_document";
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
		}
		else
		{
		redirect('core', 'refresh');
		}
	
	
	}
	
	public function _rename_uploaded_file($post_array) 
	{
    if (!empty($post_array['file_attachment'])) {
		$company = $this->sys_model->get_company_name($company_id);
        $post_array['file_attachment'] =  $company.'-'.$post_array['id_jenis_document'].'-'.md5($company_id.date("Y-m-d|H:i:s"));
    }

    //You can add or insert to other tables too

    return $post_array;
	}


	
	function _encrypt_pass($post_array){
    $post_array['password'] =  md5($post_array['password']);
    return $post_array;
	}
	
	function notification_center(){
			if($this->session->userdata('username'))
		{	
			$data['title'] = "Sistem Manajemen Dokumen Perusahaan :: ".$this->config->item('company_name')." Administration Dashboard | Notifikasi Center";
			$data['style'] = 'portal.css'; 
			if($this->session->userdata('level') == 'Administrator')
			{	
				$crud = new grocery_CRUD();
				$crud->set_table('tbl_notifikasi');
				$crud->set_theme('datatables');
				$crud->columns('user','event','document_id','document_type','company_id','waktu','keterangan');
				$crud->set_relation('document_id','tbl_master_dokumen','keterangan_dokumen');
				$crud->set_relation('document_type','tbl_jenis_dokumen','{kode_dokumen}-{deskripsi_dokumen}');
				$crud->set_relation('company_id','tbl_perusahaan',"({kategori_perusahaan}){nama_perusahaan} ");
				$crud->unset_add();
				$crud->unset_delete();
				$crud->unset_edit();
				$crud->unset_print();
				$crud->unset_export();
				$crud->set_subject('Laporan Aktifitas Pengguna');
				$output = $crud->render();
				$data['content_title']='Laporan Aktifitas Pengguna'; 
				$data['content'] = 'main_app/main_data';
				$data['page']='data';
			}
			else
			{
				$data['page_title'] = "Maaf Anda tidak bisa mengakses modul ini... Mohon hubungi admistrator pada perusahaan anda ";
				$data['content'] = 'component/error_page';
			}
			$this->load->view('data/crud',$output);
			$this->load->view('system',$data);
		}
		else
		{
		redirect('core', 'refresh');
		}
	
	}
	

	
}
