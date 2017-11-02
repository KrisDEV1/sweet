<?php
if(!session_id()){
    session_start();
}
require_once __DIR__ . '/vendor/autoload.php';

$app_id = '1475474909210602';
$app_secret = 'c08d6bc32facba7fd4e944855221c908';

$fb = new Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => $app_secret,
    'default_graph_version' => 'v2.10',
]);

$helper = $fb->getRedirectLoginHelper();


function connectPDO()
{
    return new PDO('mysql:dbname=db_is_sweet;host=localhost', 'sweetkris', '3w^T4a.C;O2e');
}
