<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PPK_Model extends CI_Model {
	public function checkUser($info)
	{
		$data['oauth_provider'] = 'google';
		$data['oauth_uid']      = $info['id'];
		$data['first_name']     = $info['given_name'];
		$data['last_name']      = $info['family_name'];
		$data['email']          = $info['email'];
		$data['gender']         = !empty($info['gender'])?$info['gender']:'';
		$data['locale']         = !empty($info['locale'])?$info['locale']:'';
		$data['profile_url']    = !empty($info['link'])?$info['link']:'';
		$data['picture_url']    = !empty($info['picture'])?$info['picture']:'';
		
		$this->db->select("id");
		$this->db->from("users");
		$this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
		$query = $this->db->get();
		$check = $query->num_rows();
		
		if($check > 0){
			$result = $query->row_array();
			$data['modified'] = date("Y-m-d H:i:s");
			$update = $this->db->update("users",$data,array('id'=>$result['id']));
			$userID = $result['id'];
		}else{
			$data['created'] = date("Y-m-d H:i:s");
			$data['modified']= date("Y-m-d H:i:s");
			$insert = $this->db->insert("users",$data);
			$userID = $this->db->insert_id();
		}
		return $userID?$userID:false;
	}
}