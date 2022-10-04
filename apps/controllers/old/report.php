<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if($this->session->userdata('db_name'))
		{	
			$data['title'] = "Connected To ".$this->session->userdata('db_host').' '.$this->session->userdata('db_name')." |  MedicOS Support Tools :: ".$this->session->userdata('hospital_name')." ";
			$data['style'] = 'portal.css'; 
			$data['page']='menu';
			$data['modul'] = $this->sys_model->get_modul();
			//$data['all_modul'] = $this->sys_model->get_modul();
			$data['spec_modul'] = $this->sys_model->get_sort_modul();
			$data['user'] = $this->sys_model->get_data_user($this->session->userdata('user'));
			$data['message'] = "Selamat Datang".$this->session->userdata('user');
			$data['content'] = 'main_app/report'; 
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