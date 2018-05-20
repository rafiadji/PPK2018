<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PPK_Control extends CI_Controller {
	
	public function  __construct(){
		parent::__construct();
		$this->load->library('google');
		$this->load->model('PPK_Model','ppk');
	}
	
	public function index()
	{
		$data["loginUrl"] = $this->google->cekLogin();
		$this->load->view('login',$data);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		$acctoken = $this->google->getAccessToken();
		if($acctoken != null){
			$this->google->revokeToken($acctoken);
		}
		redirect(base_url());
	}
}