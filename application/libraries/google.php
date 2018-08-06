<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'third_party/vendor/autoload.php';

class Google{
	private $CI;
	var $sess_name;
	var $tokens;
	var $gdrive;
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
		$this->client->setScopes(array(
			Google_Service_Drive::DRIVE_FILE,
			Google_Service_Drive::DRIVE_METADATA
		));
		$this->client->setAccessType('online');
		$this->client->setApprovalPrompt('auto');
		
		$this->sess_name = $this->CI->config->item('sess_name', 'google');
		
		$this->tokens = $this->CI->session->userdata('token');
		//var_dump($this->tokens);
		if($this->tokens){
			$this->client->setAccessToken($this->tokens);
		}elseif($code = $this->CI->input->get('code', TRUE)){
			$this->client->authenticate($code);
			$this->tokens = $this->client->getAccessToken();
			$this->client->setAccessToken($this->tokens);
			$this->CI->session->set_userdata('token', $this->tokens);
		}
		else
		{
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
		/* try{
			
			$result = array();
			$error = array();
			try{
				// if(!empty($filters)){
					// $where = "";
					// foreach ($filters as $i => $filter) {
						// if($i > 0){
							// $where .= " and {$filter}";
						// }else {
							// $where .= $filter;
						// }
					// }
					// $param = array(
						// "q" => $where
						// // "pageSize" => 10
					// );
				// } else {
					// $param = array(
						// "q" => "mimeType != 'application/vnd.google-apps.folder'"
						// // "pageSize" => 10
					// );
				// }
// 				
				// if($pageToken){
					// $param['pageToken'] = $pageToken;
				// }
				$param['fields'] = "nextPageToken, files(id, name)";
				$files = $this->gdrive->files->listFiles($param);
				var_dump($files);
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
		}try{
			$result = array();
			$error = array();
			try{
				// if(!empty($filters)){
					// $where = "";
					// foreach ($filters as $i => $filter) {
						// if($i > 0){
							// $where .= " and {$filter}";
						// }else {
							// $where .= $filter;
						// }
					// }
					// $param = array(
						// "q" => $where
						// // "pageSize" => 10
					// );
				// } else {
					// $param = array(
						// "q" => "mimeType != 'application/vnd.google-apps.folder'"
						// // "pageSize" => 10
					// );
				// }
// 				
				// if($pageToken){
					// $param['pageToken'] = $pageToken;
				// }
				$param['fields'] = "nextPageToken, files(id, name)";
				$files = $this->gdrive->files->listFiles($param);
				var_dump($files);
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
		} */
		$this->gdrive = new Google_Service_Drive($this->client);
		$optParams = array(
		  'pageSize' => 10,
		  'fields' => 'nextPageToken, files(id, name)'
		);
		$results = $this->gdrive->files->listFiles($optParams);

		if (count($results->getFiles()) == 0) {
			print "No files found.\n";
		} else {
			print "Files:\n";
			foreach ($results->getFiles() as $file) {
				printf("%s (%s)\n", $file->getName(), $file->getId());
			}
		}//print_r($files);
	}

	public function uploadFile($uploaddata)
	{
		// code buat upload file ke assets

		

			//jika file berhasil diupload isi nama file dan mime file
		$alamat_file = $uploaddata['full_path'];
		$nama_file = $uploaddata['file_name'];
		$mime_file = $uploaddata['file_type'];
		// upload file ke google drive
		$this->gdrive = new Google_Service_Drive($this->client);
		$fileMetadata = new Google_Service_Drive_DriveFile(array('name' => $nama_file));
		$content = file_get_contents($alamat_file);
		$file = $this->gdrive->files->create($fileMetadata, array(
		    'data' => $content,
		    'mimeType' => $mime_file,
		    'uploadType' => 'multipart',
		    'fields' => 'id'));
		printf("File ID: %s\n", $file->id);

		// jika file berhasil diupload, hapus file di assets
		}

		public function DownloadFile(){
			$fileId = '1mwNCwrU0thGmrQ9fxpwS2pJV-Rl7oJFj';
			$this->gdrive = new Google_Service_Drive($this->client);
			$response = $this->gdrive->files->get($fileId, array(
   			 'alt' => 'media'));
			$content = $response->getBody()->getContents();
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=tes.docx'); 
			echo $content;
			//print_r($content = $response->getBody()->getContents());
		}
	
		
		
}