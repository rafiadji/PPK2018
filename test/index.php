<?php
require __DIR__ . '/vendor/autoload.php';

$client = new Google_Client();
$client->setApplicationName('PPK2018App');
$client->setAuthConfig('client_secret.json');
$client->setAccessType('offline');
$client->setIncludeGrantedScopes(true);   // incremental auth
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
$client->setRedirectUri('http://localhost/PPK2018/test/');

if(isset($_GET['code'])){
	
	$client->authenticate($_GET['code']);
	$access_token = $client->getAccessToken();


	$client->setAccessToken($access_token);
	$service = new Google_Service_Drive($client);
	$optParams = array(
	  'pageSize' => 10,
	  'fields' => 'nextPageToken, files(id, name)'
	);
	$results = $service->files->listFiles($optParams);

	if (count($results->getFiles()) == 0) {
		print "No files found.\n";
	} else {
		print "Files:\n";
		foreach ($results->getFiles() as $file) {
			printf("%s (%s)\n", $file->getName(), $file->getId());
		}
	}//print_r($files);
}
else{
	$auth_url = $client->createAuthUrl();
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}
