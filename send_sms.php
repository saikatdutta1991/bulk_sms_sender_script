<?php

// Required if your environment does not handle autoloading
require __DIR__ . '/vendor/autoload.php';
require __DIR__. '/helper.php';

use Twilio\Rest\Client;

$sid = 'xxx';
$token = 'xxxx';
$client = new Client($sid, $token);

$phoneNumber = $_REQUEST['phone_number'];
$messageBody = $_REQUEST['message_body'];

try {

    $client->messages->create($phoneNumber, [
        'from' => '+1757513267967',
        'body' => $messageBody
    ]);

} catch(\Exception $e) {
    return sendJsonResponse(false, 'failed', $e->getMessage());
}

return sendJsonResponse(true, 'success', 'message sent successfully');