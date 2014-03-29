<?php

session_start();

include('/var/www/a/drive/Google/Google_Client.php');
include('/var/www/a/drive/Google/contrib/Google_DriveService.php');
// Set your client id, service account name, and the path to your private key.
// For more information about obtaining these keys, visit:
// https://developers.google.com/console/help/#service_accounts
const CLIENT_ID = '823760235077-v3u2dbs6krknmj54h589a9i3a5egiuui.apps.googleusercontent.com';
const SERVICE_ACCOUNT_NAME = '823760235077-v3u2dbs6krknmj54h589a9i3a5egiuui@developer.gserviceaccount.com';

// Make sure you keep your key.p12 file in a secure location, and isn't
// readable by others.
const KEY_FILE = '/key/key.p12';

// Load the key in PKCS 12 format (you need to download this from the
// Google API Console when the service account was created.
$client = new Google_Client();
$service = new Google_DriveService($client);
$client->setUseObjects(true);

$key = file_get_contents(KEY_FILE);
$client->setClientId(CLIENT_ID);
$client->setAssertionCredentials(new Google_AssertionCredentials(
  SERVICE_ACCOUNT_NAME,
  array('https://www.googleapis.com/auth/drive'),
  $key)
);


$fileId = '0Arh3w_1KfCECdEl3UUUyZ0pFSFBWcmpaTDVfa1lBUGc';

 $file = $service->files->get($fileId);

function downloadFile($service, $file) {
  //$downloadUrl = $file->getDownloadUrl();
  $files = $file->getExportLinks();

	$downloadUrl = $files['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
	$downloadUrl = str_replace('exportFormat=xlsx', 'exportFormat=csv', $downloadUrl);
	
  if ($downloadUrl) {
    $request = new Google_HttpRequest($downloadUrl, 'GET', null, null);
    $httpRequest = Google_Client::$io->authenticatedRequest($request);
    if ($httpRequest->getResponseHttpCode() == 200) {
      return $httpRequest->getResponseBody();
    } else {
      // An error occurred.
      return null;
    }
  } else {
    // The file doesn't have any content stored on Drive.
    return null;
  }
}

var_dump(downloadFile($service, $file));

?>