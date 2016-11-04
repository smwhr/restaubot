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
  function($method, $parameters, $plain = false) use ($app){
  $api_url = 'https://api.telegram.org/bot'.BOT_TOKEN.'/';
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  if($plain){
      foreach ($parameters as $key => &$val) {
        // encoding to JSON array parameters, for example reply_markup
        if (!is_numeric($val) && !is_string($val)) {
          $val = json_encode($val);
        }
      }
      $url = $api_url.$method.'?'.http_build_query($parameters);
  }else{
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
      $url = $api_url;
  }

  curl_setopt($ch, CURLOPT_URL, $url);
  
  $result = exec_curl_request($ch);
  curl_close($ch);
  return $result;
});