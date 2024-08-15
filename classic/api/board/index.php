<?php

use api\model\API;

include_once('board.php');
include_once('../model/api.php');

$apiName = $_REQUEST["api_name"];

$api = new API();
$api->setCode(-1);
$api->setMessage("API 명을 확인해주세요.");
$api->setEntity("");
$api->setApiName(isset($apiName) ? $apiName : "");

if (!isset($apiName)) {
    echo json_encode($api);
} else {
    $board = new Board($api);
    $board -> __init();

    switch ($apiName) {
        case "create":
            $api = $board -> create();
            break;
        case "modify":
            $api = $board -> modify();
            break;
        case "modify":
            $api = $board -> modify();
            break;
        case "modifyComment":
            $api = $board -> modifyComment();
            break;
        case "deleteComment":
            $api = $board -> deleteComment();
            break;
        case "answer":
            $api = $board -> answer();
            break;
        case "comment":
            $api = $board -> comment();
            break;
        case "modifyComment":
            $api = $board -> modifyComment();
            break;
        case "write":
            $api = $board -> write();
            break;
        case "delete":
            $api = $board -> delete();
            break;
        case "getList":
            $api = $board -> getList(
                $_REQUEST["bo_table"],
                $_REQUEST["offset"],
                $_REQUEST["limit"]
            );
            break;
        case "getNoticeList":
            $api = $board -> getNoticeList(
                $_REQUEST["bo_table"],
                $_REQUEST["offset"],
                $_REQUEST["limit"]
            );
            break;
        case "getCategoryList":
            $api = $board -> getCategoryList(
                $_REQUEST["bo_table"],
                $_REQUEST["offset"],
                $_REQUEST["limit"]
            );
            break;
        case "getFileList":
            $api = $board -> getFileList($_REQUEST["bo_table"]);
            break;
        case "getComment":
            $api = $board -> getComment(
                $_REQUEST["bo_table"],
                $_REQUEST["wr_id"],
                $_REQUEST["offset"],
                $_REQUEST["limit"]
            );
            break;
        case "getInfo":
            $api = $board -> getInfo();
            break;
    }

    echo json_encode($api);
}
?>