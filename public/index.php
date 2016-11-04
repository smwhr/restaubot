<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once(__DIR__."/../app/bootstrap.php");

//CONTROLLERS
$app->before(function(Request $request){
  if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
        $request->request->set('raw_json', $data);
    }
});

$app->match('/webhook-malin', function(Request $request) use ($app){
  return new Response("ok");
});


$app->run();