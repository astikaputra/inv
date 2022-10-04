<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class All_tools extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Connected To ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name')." |  MedicOS Support Tools :: ".$this->session->userdata('hospital_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['modul'] = $this->sys_model->get_modul();
			$data['catcode'] = $this->sys_model->get_cat_id();
			//$data['all_modul'] = $this->sys_model->get_modul();
			//$data['spec_modul'] = $this->sys_model->get_sort_modul();
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['message'] = "Selamat Datang".$this->session->userdata('user');
			$data['content'] = 'main_app/all_tools'; 
			$this->load->view('main_system',$data);
		}
		else
		{
			if($this->session->userdata('username'))
			{
			redirect('core/select_database', 'refresh');
			}
			else
			{
			$this->session->sess_destroy();
			redirect('core', 'refresh');
			}
			
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */