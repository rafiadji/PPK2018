<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PPK_Control extends CI_Controller {
	
	public function  __construct(){
		parent::__construct();
		$this->load->library('google');
		$this->load->model('PPK_Model','ppk');
		$this->load->helper(array('form', 'url', 'download', 'file'));
	}
	
	public function index(){
		if($this->google->isReady()){
			redirect("PPK_Control/dashboard");
		}
		$data["loginUrl"] = $this->google->loginURL();
		$this->load->view('login',$data);
	}
	
	public function dashboard($pagetoken = NULL)
	{
		$data['page'] = "daftarFile";
		$file = $this->google->getFile($pagetoken);
		$data["file"] = $file["files"];
		$data["pagetoken"] = $file["nextPageToken"];
		$this->load->view('dashboard', $data);
	}

	public function upload(){
    	$config['upload_path']          = 'assets/file/';
		$config['allowed_types']        = 'gif|jpg|png|docx|pdf';
 
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file')){
			$error = array('error' => $this->upload->display_errors());
		}else{
			$data = $this->upload->data();
			$res = $this->google->uploadFile($data);
			unlink($data['full_path']);
			redirect(base_url());
		}
	}
	
	public function download($fileID, $filename)
	{
		force_download($this->google->downloadFile($fileID, $filename));
	}

	public function delete($fileID)
	{
		$hapus = $this->google->deleteFile($fileID);
		if($hapus){
			redirect(base_url());
		}
	}
	
	public function logout()
	{
		$this->google->logout();
		redirect(base_url());
	}
}