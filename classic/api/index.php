<?php

use api\model\API;

include_once('app.php');
include_once('../model/api.php');

$apiName = $_REQUEST["api_name"];

$api = new API();
$api->setCode(-1);
$api->setMessage("API 명을 확인해주세요.");
$api->setEntity("");
$api->setApiName(isset($apiName) ? $apiName : "");

/**
 * 전체푸시, 개인푸시 조인해서 date대로
 * */

/**
 * 개별 푸시
 * 전체 푸시
 * 알림 리스트 전달
 * */

if (!isset($apiName)) {
    echo json_encode($api);
} else {
    $app = new App($api);
    $app -> __init();

    switch ($apiName) {
        // introduction, office introduction, contact, manual category list
        case "push":
            $api = $app -> pushRPC();
            break;
        case "pushAll":
            $api = $app -> pushAllRPC();
            break;
        case "getResponse":
            $api = $app -> getResponse();
            break;
    }

    echo json_encode($api);
}
?>