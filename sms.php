
<?php
$number ='91'.'8987551087';
    // Account details
    $apiKey = urlencode('NGU2MjZhNjc3ODMzNGU3ODMxNTk2Zjc5NDU1NjMxMzk=');
    // Message details
    $numbers = array($number);
    $sender = urlencode('VERMA-PLATEFORM');
    $message = rawurlencode('This is your message');
     
    $numbers = implode(",", $numbers);
     
    // Prepare data for POST request
    $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
    // Send the POST request with cURL
    $ch = curl_init('https://api.textlocal.in/send/');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    // Process your response here
    echo $response."work";
    ?>
