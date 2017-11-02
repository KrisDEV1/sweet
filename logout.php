<?php
require_once __DIR__ . '/config.php';

$data = $_SESSION['user'];
$data['is_active'] = false;


$helper = $fb->getRedirectLoginHelper();
$url = $helper->getLogoutUrl($_SESSION['fb_access_token'], 'http://kristiannikolic.com/sweetheart');

session_destroy();

header('Location: ' . urldecode($url)); ?>