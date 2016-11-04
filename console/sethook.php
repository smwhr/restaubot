<?php

require_once(__DIR__."/../app/bootstrap.php");

$ok = $app["messager"]('setWebhook', array('url' => isset($argv[1]) && $argv[1] == 'delete' ? '' : WEBHOOK_URL));
var_dump($ok);
