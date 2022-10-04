<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('adm_template');
		$this->load->model('admin_model');
		$this->load->model('Gallery_model');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');	
		//$this->load->database();
	}
	
		function _example_output($output = null)
	{
		$this->load->view('admin/home.php',$output);	
	}
	

   public function index()
	{
	if(($this->session->userdata('admin_id')!=""))
		{
			$this->welcome();
		}
	else{
		$data['title']= 'Home';
		//$data['error'] ='';
			//$data['_content'] ='';
			$this->load->view('admin/login',$data);
			
		}
	}
		public function welcome()
			{	
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('tb_order');
			$crud->columns('id_order','order_date','status','fname','phone','note','id_customer','total');
			$crud->add_action('order_detail', '', 'admin/order_detail','ui-icon-plus');
			$crud->field_type('status','dropdown',
            array('Pending' => 'Pending', 'Complete' => 'Complete' , 'Canceled' => 'Canceled'));
			$crud->callback_before_update(array($this,'_update_stock_product'));	
			$crud->unset_print();
			$output = $crud->render();
			$this->_example_output($output);
			}
		
		function _update_stock_product($post_array,$primary_key)
		{	
			$order_cart = $this->db->get_where('tb_cart',array('id_order' => $primary_key))->result();
			if($post_array['status']=='Complete')
			{		
				foreach($order_cart as $row)
				{
				$product = $this->db->get_where('tb_product',array('prod_id' => $row->id_prod))->row();
				$stock_before = $product->stock;
				$stock_cart = $row->qty;
				$data['stock'] = $stock_before - $stock_cart;
				$this->db->update('tb_product',$data,"prod_id = $row->id_prod");
				}
			}
			   return true;

			
		}
			
		public function thank()
			{
				$data['error']= 'Registrasi Berhasil';
				$this->load->view('admin/login',$data);
			}
			
		public function login()
		{
			$username=$this->input->post('username');
			$password=md5($this->input->post('password'));

			$result=$this->admin_model->login($username,$password);
			if($result) {
			redirect('admin/', 'refresh');
			$this->welcome();
			}
			else        //$this->index();
			{$data['error']='!! Username / Password Salah !!';
			$this->load->view('admin/login',$data);}
		}
			public function registration()
		{
			$this->load->library('form_validation');
			// field name, error message, validation rules
			$this->form_validation->set_rules('newusername', 'User Name', 'trim|required|min_length[4]|xss_clean');
			//$this->form_validation->set_rules('email_address', 'Your Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('newpassword', 'Password', 'trim|required|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('con_newpassword', 'Password Confirmation', 'trim|required|matches[password]');

			if($this->form_validation->run() == FALSE)
			{
				//$this->index();
				$data['error']='!! Registrasi Gagal !!';
				$this->load->view('admin/login',$data);
			}
			else
			{
				$this->admin_model->add_user();
				$this->thank();
			}
		}
			public function logout()
			{
				$newdata = array(
				'user_id'   =>'',
				'user_name'  =>'',
				'user_email'     => '',
				'logged_in' => FALSE,
			);
				$this->session->unset_userdata($newdata );
				$this->session->sess_destroy();
				redirect('admin/', 'refresh');
				
			}  
	
	function order_detail($order_id=NULL)
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tb_cart');
			$crud->where('id_order',$order_id);
   			$output = $crud->render();
			$this->_example_output($output);
		
	}
	
			function order_history($member=NULL)
			{	
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('tb_order');
			$crud->where('id_customer',$member);
			$crud->columns('id_order','status','fname','phone','note','id_customer','total');
			$crud->add_action('order_detail', '', 'admin/order_detail','ui-icon-plus');
			$crud->field_type('status','dropdown',
            array('Pending' => 'Pending', 'Process' => 'Process','Complete' => 'Complete' , 'Canceled' => 'Canceled'));
			$output = $crud->render();
			$this->_example_output($output);
			}
			
	function product_cat_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tb_category');
			$crud->field_type('menu_show','dropdown',
            array('Yes' => 'Yes', 'No' => 'Yes'));
			$crud->required_fields('cat_name');
			$crud->unset_export();
			$crud->unset_print();
			$crud->unset_delete();
			$output = $crud->render();
			$this->_example_output($output);
		
	}
	
	function profile_page()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tb_page');
			$crud->field_type('page_cat','dropdown',
            array('Halal Mart' => 'Halal Mart', 'Komunitas' => 'Komunitas'));
			$crud->required_fields('page_name','content');
			$crud->unset_export();
			$crud->unset_print();
			$output = $crud->render();
			$this->_example_output($output);
		
	}
	
	function manage_user()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tb_user');
			$crud->field_type('password','password');
			$crud->required_fields('username','password','email');
			$crud->callback_before_insert(array($this,'encrypt_password_callback'));			
			$crud->callback_before_update(array($this,'encrypt_password_callback'));			
			$crud->unset_export();
			$crud->unset_print();
			$output = $crud->render();
			$this->_example_output($output);
		
	}
	
		function manage_product()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tb_product');
			$crud->set_relation('prod_cat','tb_category','cat_name');
			$crud->required_fields('username','password','email');
			$crud->set_field_upload('prod_img1','public/upload/images/');
			$crud->set_field_upload('prod_img2','public/upload/images/');
			$crud->set_field_upload('prod_img3','public/upload/images/');
			$crud->field_type('featured','dropdown',
            array('Yes' => 'Yes', 'No' => 'Yes'));
			$crud->columns('prod_img1','prod_name','stock','prod_price','featured');
			$output = $crud->render();
			$this->_example_output($output);
		
	}
	
		function manage_banner()
	{
			$crud = new grocery_CRUD();
		
			$crud->set_theme('datatables');
			$crud->set_table('tb_banner');
			$crud->field_type('id_banner','hidden');
			$crud->field_type('link_to','string');
			$crud->display_as('banner_content','ads content source');
			$crud->field_type('location','dropdown',
            array('Top' => 'top', 'Sidebar' => 'sidebar'));
			$crud->required_fields('banner_content','start_date','end_date','location','link_to');
			$output = $crud->render();
			$this->_example_output($output);
		
	}	
	
		function manage_slider()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tb_slider');
			$crud->required_fields('slider_url','desc_1','desc_2');
			$crud->set_field_upload('slider_url','public/upload/images/');
			$output = $crud->render();
			$this->_example_output($output);
		
	}
	
			function manage_member()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tb_member');
			$crud->callback_before_insert(array($this,'encrypt_password_callback'));			
			$crud->callback_before_update(array($this,'encrypt_password_callback'));	
			$crud->add_action('history transaction', '', 'admin/order_history','ui-icon-plus');
			$crud->columns('firstname','lastname','phone','email');
			$output = $crud->render();
			$this->_example_output($output);
		
	}
	
		function manage_testimonial()
	{
		$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tb_testimonial');
			$output = $crud->render();
			$this->_example_output($output);
	}
	
	function manage_comment()
	{
		$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tb_comment');
			$output = $crud->render();
			$this->_example_output($output);
	}
	
	function encrypt_password_callback($post_array) {
		$post_array['password'] = md5($post_array['password']);
		return $post_array;
	}    

	function setup_report()
	{
	$this->load->view('admin/report');
	
	}
	
	function generate_report()
	{
	$jenis_report = $this->input->post('jenis_report');
	$sd = date("Y-m-d", strtotime($this->input->post('startdate')));
	$ed = date("Y-m-d", strtotime($this->input->post('enddate')));
	$member = $this->input->post('dropdown_member');
	$product = $this->input->post('dropdown_product');
	if($jenis_report == 'by_date_range')
	{
	$data['trans'] = $this->db->where('order_date >=', $sd); 
	$data['trans'] = $this->db->where('order_date <=', $ed); 
	}
	if($member != 'all')
	{
	$data['trans'] = $this->db->where('id_customer', $member); 
	}
	if($product != 'all')
	{
	$data['trans'] = $this->db->select('tb_order.*');
	$data['trans'] = $this->db->join('tb_cart', 'tb_cart.id_order = tb_order.id_order');
	$data['trans'] = $this->db->where('id_prod', $product); 
	}
	$data['trans'] = $this->db->order_by('order_date','desc');
	$data['trans'] = $this->db->get('tb_order');
	//echo $this->db->last_query();
	$this->load->view('admin/rpt_template',$data);
	}
			
	}
/* End of file hello_view.php */
/* Location: ./application/controllers/hello_view.php */

