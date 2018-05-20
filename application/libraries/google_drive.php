<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Google_drive{
	
	public function __construct(){
	
		$CI =& get_instance();
		$CI->config->load('google');
		
		require APPPATH .'third_party/google-api-php-client/Google_Client.php';
		require APPPATH .'third_party/google-api-php-client/contrib/Google_DriveService.php';
		
		$this->client = new Google_Client();
		$this->client->setApplicationName($CI->config->item('application_name', 'google'));
		$this->client->setClientId($CI->config->item('client_id', 'google'));
		$this->client->setClientSecret($CI->config->item('client_secret', 'google'));
		$this->client->setRedirectUri($CI->config->item('redirect_uri', 'google'));
		$this->client->setDeveloperKey($CI->config->item('api_key', 'google'));
		$this->client->setScopes($CI->config->item('scope', 'google'));
		$this->client->setAccessType('offline');
		$this->client->setApprovalPrompt('auto');
		$this->gdrive = new Google_DriveService($this->client);
	}
	
	public function loginURL() {
		return $this->client->createAuthUrl();
	}
	
	public function getAuthenticate($code = "") {
		return $this->client->authenticate($code);
	}
	
	public function getAccessToken() {
		return $this->client->getAccessToken();
	}
	
	public function setAccessToken() {
		return $this->client->setAccessToken();
	}
	
	public function revokeToken($acctoken = "") {
		return $this->client->revokeToken($acctoken);
	}
	
	public function getUserInfo() {
		return $this->oauth2->userinfo->get();
	}
}