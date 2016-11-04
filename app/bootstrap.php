<?php

define('BOT_TOKEN', getenv('BOT_TOKEN'));
define('WEBHOOK_URL', 'https://restau.troisyaourts.com/webhook-malin/');

require_once(__DIR__."/../vendor/autoload.php");

$app = new Silex\Application();
$app["debug"] = true;
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => __DIR__."/../logs/all.log",
  'monolog.name' => 'supbot'
));



$app['messager'] = $app->protect(
  function($method, $message) use ($app){
  $url = 'https://api.telegram.org/bot'.BOT_TOKEN.'/';
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($container));
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
});