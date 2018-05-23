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
		if($this->google->isReady()){
			redirect("PPK_Control/dashboard");
		}
		$data["loginUrl"] = $this->google->loginURL();
		$this->load->view('login',$data);
	}
	
	public function dashboard()
	{
		$file = $this->google->getFile();
		var_dump($file);
		// $data["file"] = $file->files;
		$this->load->view('dashboard', $data);
	}
	
	public function logout()
	{
		$this->google->logout();
		redirect(base_url());
	}
}