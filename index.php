<?php
define('DIR_PATH', dirname(__FILE__));
require_once(DIR_PATH . '/' . 'palindrome.php');

// メインをよびだし
$instance = new Palindrome();
$instance->main();
// $instance->dispatch();
exit;