<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'third_party/google-api-php-client/Google_Client.php';
require APPPATH .'third_party/google-api-php-client/contrib/Google_Oauth2Service.php';
require APPPATH .'third_party/google-api-php-client/contrib/Google_DriveService.php';

class Google{
	private $CI;
	var $sess_name;
	var $tokens;
	var $ready = false;
	
	public function __construct(){
	
		$this->CI =& get_instance();
		$this->CI->config->load('google');
				
		$this->client = new Google_Client();
		$this->client->setApplicationName($this->CI->config->item('application_name', 'google'));
		$this->client->setClientId($this->CI->config->item('client_id', 'google'));
		$this->client->setClientSecret($this->CI->config->item('client_secret', 'google'));
		$this->client->setRedirectUri($this->CI->config->item('redirect_uri', 'google'));
		$this->client->setDeveloperKey($this->CI->config->item('api_key', 'google'));
		$this->client->setScopes($this->CI->config->item('scopes', 'google'));
		$this->client->setAccessType('online');
		$this->client->setApprovalPrompt('auto');
		$this->client->setUseObjects(true);
		$this->oauth2 = new Google_Oauth2Service($this->client);
		$this->gdrive = new Google_DriveService($this->client);
		$this->sess_name = $this->CI->config->item('sess_name', 'google');
		
		$this->tokens = $this->CI->session->userdata($this->sess_name);
		
		if($this->tokens){
			$this->client->setAccessToken($this->tokens);
		}elseif($code = $this->CI->input->get('code', TRUE)){
			$this->client->authenticate($code);
			$this->tokens = $this->client->getAccessToken();
		}else{
			return;
		}
		
		if($this->client->isAccessTokenExpired() && $this->tokens){
			$token = json_decode($this->tokens);
			$refreshToken = $token->refresh_token;
			$this->client->refreshToken($refreshToken);
			$this->tokens = $this->client->getAccessToken();
		}
		
		if(!$this->client->isAccessTokenExpired()){
			$this->CI->session->set_userdata($this->sess_name);
			$this->ready = true;
		}
		else {
			$this->ready = false;
		}
	}
	
	public function loginURL() {
		return $this->client->createAuthUrl();
	}
	
	public function getUser() {
		return $this->oauth2->userinfo->get();
	}
	
	public function logout() {
		$this->CI->session->unset_userdata($this->sess_name);
	}
	
	public function isReady()
	{
		return $this->ready;
	}
	
	public function sessName()
	{
		return $this->sess_name;
	}
	
	public function getAuthenticate($code = "") {
		return $this->client->authenticate($code);
	}
	
	public function getAccessToken() {
		return $this->client->getAccessToken();
	}
	
	public function setAccessToken($token) {
		return $this->client->setAccessToken($token);
	}
	
	public function revokeToken($acctoken = "") {
		return $this->client->revokeToken($acctoken);
	}

	public function getFile($pageToken = null, $filters = null)
	{
		try{
			$result = array();
			$error = array();
			try{
				if(!empty($filters)){
					$where = "";
					foreach ($filters as $i => $filter) {
						if($i > 0){
							$where .= " and {$filter}";
						}else {
							$where .= $filter;
						}
					}
					$param = array(
						"q" => $where
						// "maxResult" => 10
					);
				} else {
					$param = array(
						"q" => "mimeType != 'application/vnd.google-apps.folder'"
						// "maxResult" => 10
					);
				}
				
				if($pageToken){
					$param['pageToken'] = $pageToken;
				}
				
				$files = $this->gdrive->files->listFiles($param);
				$result = array_merge($result, $files->getItems());
				$pageToken = $files->getNextPageToken();
			}catch(Exception $ex){
				$pageToken = null;
				$error[] = $ex->getMessage();
			}
			
			return array(
				"success" => true,
				"files" => $result,
				"nextPageToken" => $pageToken,
				"errors" => $error,
				"param" => $param
			);
		}catch(Exception $ex){
			return array(
				"success" => false,
				"message" => $ex->getMessage()
			);
		}
	}
}