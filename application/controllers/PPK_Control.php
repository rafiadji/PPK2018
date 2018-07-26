<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PPK_Control extends CI_Controller {
	
	public function  __construct(){
		parent::__construct();
		$this->load->library('google');
		$this->load->model('PPK_Model','ppk2018');
		$this->load->helper(array('form', 'url'));
	}
	
	public function index(){
		if($this->google->isReady()){
			redirect("PPK_Control/dashboard");
		}
		$data["loginUrl"] = $this->google->loginURL();
		$this->load->view('login',$data);
	}

	public function formupload(){
        $this->load->view('form');
    }
    public function upload(){
    	$config['upload_path']          = 'assets/file/';
		$config['allowed_types']        = 'gif|jpg|png|docx|pdf';
		$config['max_size']             = 1000;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
 
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file')){
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('form', $error);
		}else{
			$data = $this->upload->data();
			// $this->load->view('form', $data);
			$res = $this->google->uploadFile($data);
			print_r($res);die;
			// $this->load->view('upload');
		}
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