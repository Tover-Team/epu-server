<?php
function send_notification_android($title, $body, $urlPath, $imageUrl, $GOOGLE_API_KEY)
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array(
        'condition' => "'android' in topics",
        'notification' => array("title" => $title, "body" => $body, "urlPath" => $urlPath , "imageUrl" => $imageUrl)
    );
    $headers = array(
        'Authorization:key =' . $GOOGLE_API_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

function send_notification_ios($title, $body, $urlPath, $imageUrl, $GOOGLE_API_KEY)
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array(
        'condition' => "'ios' in topics",
        'notification' => array("title" => $title, "body" => $body, "urlPath" => $urlPath , "imageUrl" => $imageUrl),
        'data' => array("title" => $title, "message" => $body, "urlPath" => $urlPath, "imageUrl" => $imageUrl)
    );
    $headers = array(
        'Authorization:key =' . $GOOGLE_API_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

function push_message($title_content, $message_content, $mb_link, $mb_image) {
    $key = "AAAAbnoc48I:APA91bEcF0DGz-IZxHyi3DtBzexB4rB0DVNeG-5mF64Nfcl2t0WkuoQ9uV_W-omn_rIacsJQOi9uvp6iuuCxYn4L6epHXmKraxO9WFnt4ymi4Z2m5G5he6vi9Pa8wpuCQRxrPoB_cNQ-";
    $message_status = send_notification_ios($title_content, $message_content, $mb_link, $mb_image, $key);
    $message_status = send_notification_android($title_content, $message_content, $mb_link, $mb_image, $key);
}