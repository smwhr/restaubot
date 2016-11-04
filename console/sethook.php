<?php

require_once(__DIR__."/../app/bootstrap.php");

if($argv[1] == "delete"){
  $ok = $app["messager"]('setWebhook', ['url' => ''], true);
}else{
  $ok = $app["messager"]('setWebhook', ['url' => WEBHOOK_URL], true);
}

var_dump($ok);
