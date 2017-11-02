<?php
require_once __DIR__ . '/config.php';

use userdata;

$_SESSION['FBRLH_state'] = $_GET['state'];

try {
    $accessToken = $helper->getAccessToken();

    $response = $fb->get('/me?fields=id,name,email,picture', $accessToken);
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit();
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit();
}

if (!isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit();
}

$oAuth2Client = $fb->getOAuth2Client();
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
$tokenMetadata->validateAppId($fb['app_id']);
$tokenMetadata->validateExpiration();

if (!$accessToken->isLongLived()) {
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "Error getting long-lived access token!";
        exit();
    }
}

$_SESSION['fb_access_token'] = (string) $accessToken;

$user = $response->getGraphUser();

$data = [
    'facebook_id' => $user->getId(),
    'name' => $user->getName(),
    'email' => $user->getEmail(),
    'image' => $user->getPicture()->getUrl(),
    'is_active' => true,
];

$pdo = connectPDO();


try {
    $_SESSION['user'] = $data;
    header('Location: https://kristiannikolic.com/sweetheart/userprofile.php');
} catch (\Exception $e){
echo $e ;
}