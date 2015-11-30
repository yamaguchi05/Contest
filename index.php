<?php
define('DIR_PATH', dirname(__FILE__));
// require_once(DIR_PATH . '/' . 'palindrome.php');
require_once(DIR_PATH . '/' . 'Loop.php');

// メインをよびだし
// ひねらない
// $instance = new Palindrome();
// ひねる
$instance = new Loop();
$instance->main();
// $instance->dispatch();
exit;