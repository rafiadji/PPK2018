<?php
require __DIR__ . '/vendor/autoload.php';

/*************************************************
 * Ensure you've downloaded your oauth credentials
 ************************************************/
$client = new Google_Client();
$client->setApplicationName('PPK2018App');
$client->setAuthConfig('client_secret.json');
$client->setAccessType('offline');
$client->setIncludeGrantedScopes(true);
$service = new Google_Service_Drive($client);
// add "?logout" to the URL to remove a token from the session
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['upload_token']);
}
/************************************************
 * If we have a code back from the OAuth 2.0 flow,
 * we need to exchange that with the
 * Google_Client::fetchAccessTokenWithAuthCode()
 * function. We store the resultant access token
 * bundle in the session, and redirect to ourself.
 ************************************************/
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token);
  // store in the session also
  $_SESSION['upload_token'] = $token;
  // redirect back to the example
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
// set the access token as part of the client
if (!empty($_SESSION['upload_token'])) {
  $client->setAccessToken($_SESSION['upload_token']);
  if ($client->isAccessTokenExpired()) {
    unset($_SESSION['upload_token']);
  }
} else {
  $authUrl = $client->createAuthUrl();
}
/************************************************
 * If we're signed in then lets try to upload our
 * file. For larger files, see fileupload.php.
 ************************************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $client->getAccessToken()) {
  // We'll setup an empty 1MB file to upload.
  DEFINE("TESTFILE", 'testfile-small.txt');
  if (!file_exists(TESTFILE)) {
    $fh = fopen(TESTFILE, 'w');
    fseek($fh, 1024 * 1024);
    fwrite($fh, "!", 1);
    fclose($fh);
  }
  // This is uploading a file directly, with no metadata associated.
  $file = new Google_Service_Drive_DriveFile();
  $result = $service->files->create(
      $file,
      array(
        'data' => file_get_contents(TESTFILE),
        'mimeType' => 'application/octet-stream',
        'uploadType' => 'media'
      )
  );
  // Now lets try and send the metadata as well using multipart!
  $file = new Google_Service_Drive_DriveFile();
  $file->setName("Hello World!");
  $result2 = $service->files->create(
      $file,
      array(
        'data' => file_get_contents(TESTFILE),
        'mimeType' => 'application/octet-stream',
        'uploadType' => 'multipart'
      )
  );
}
?>
