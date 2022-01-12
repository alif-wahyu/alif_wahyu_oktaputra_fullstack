<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function index()
	{
		$this->load->view('nav_bar/header');
		$this->load->view('home');
		$this->load->view('nav_bar/footer');
	}
}
