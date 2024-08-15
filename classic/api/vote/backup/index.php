<?php

use api\model\API;

include_once('vote.php');
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
    $vote = new Vote($api);
    $vote -> __init();

    switch ($apiName) {
        case "create":
            $api = $vote -> create();
            break;
        case "stop":
            $api = $vote -> stop();
            break;
        case "isVote":
            $api = $vote -> isVote(
                $_REQUEST["wr_id"],
                $_REQUEST["mb_id"]
            );
            break;
        case "vote":
            $api = $vote -> vote(
                $_REQUEST["wr_id"],
                $_REQUEST["mb_id"],
                $_REQUEST["no"]
            );
            break;
        case "unVote":
            $api = $vote -> unVote(
                $_REQUEST["wr_id"],
                $_REQUEST["mb_id"]
            );
            break;
        case "getList":
            $api = $vote -> getList(
                $_REQUEST["bo_table"],
                $_REQUEST["offset"],
                $_REQUEST["limit"]
            );
            break;
        case "getInfo":
            $api = $vote -> getInfo(
                $_REQUEST["wr_id"]
            );
            break;
        case "getVoteInfo":
            $api = $vote -> getVoteInfo(
                $_REQUEST["wr_id"]
            );
            break;
    }

    echo json_encode($api);
}
?>