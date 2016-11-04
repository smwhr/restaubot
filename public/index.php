<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
  $message = $request->get("message",[]);
  if(empty($message)) return new Response("Empty message");


  $message_id = $message['message_id'];
  $chat_id = $message['chat']['id'];


  if (isset($message['text'])) {
    // incoming text message
    $text = $message['text'];

    if (strpos($text, "/start") === 0) {
      $app["messager"]("sendMessage", array('chat_id' => $chat_id, "text" => 'Hello', 'reply_markup' => array(
        'keyboard' => array(array('Hello', 'Hi')),
        'one_time_keyboard' => true,
        'resize_keyboard' => true)));
    } else if ($text === "Hello" || $text === "Hi") {
      $app["messager"]("sendMessage", array('chat_id' => $chat_id, "text" => 'Nice to meet you'), true);
    } else if (strpos($text, "/stop") === 0){
      // stop now
    } else {
      return new JsonResponse(["method" => "sendMessage",
                               "chat_id" => $chat_id, 
                               "reply_to_message_id" => $message_id, 
                               "text" => "Cool"]);
    }
  } else {
    $app["messager"]("sendMessage", array('chat_id' => $chat_id, "text" => 'I understand only text messages'), true);
  }
});


$app->run();