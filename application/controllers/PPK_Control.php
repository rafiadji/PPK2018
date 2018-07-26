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
	
	public function dashboard($pagetoken = NULL)
	{
		$file = $this->google->getFile($pagetoken);
		$data["file"] = $file["files"];
		$data["pagetoken"] = $file["nextPageToken"];
		var_dump($file["errors"]);
		$this->load->view('dashboard', $data);
	}
	
	public function logout()
	{
		$this->google->logout();
		redirect(base_url());
	}
}