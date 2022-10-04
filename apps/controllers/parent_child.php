<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parent_Child extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('tree');
		$this->load->model('p_c_model');
	}

	function index()
	{
		$data["menu"] = $this->p_c_model->tampil_menu();
		$this->load->view('menu/home',$data);
	}
}
