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
		if(isset($_GET['code'])){
			$this->google->getAuthenticate($_GET['code']);
			$this->session->set_userdata('acc_token', $this->google->getAccessToken());
			// redirect("PPK_Control/dashboard");
			echo $this->session->userdata('acc_token');
			if($this->session->userdata('acc_token')){
				$info = $this->google->getUserInfo();
				var_dump($info);
			}
		}
		$data["loginUrl"] = $this->google->loginURL();
		$this->load->view('login',$data);
	}
	
	public function dashboard()
	{
		echo $this->session->userdata('acc_token');
		if($this->session->userdata('acc_token')){
			$info = $this->google->getUserInfo();
			var_dump($info);
		}
		$this->load->view('dashboard',$data);
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