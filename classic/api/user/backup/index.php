<?php

use api\model\API;
use api\user\User;

include_once('user.php');
include_once('../model/api.php');

$api = new API();
$api->setCode(-1);
$api->setMessage("API 명을 확인해주세요.");
$api->setEntity("");

$apiName = $_REQUEST["api_name"];
if (!isset($apiName)) {
    echo json_encode($api);
} else {
    switch ($apiName) {
        case "addUser":
            $user = new User($api);
            $user -> __init();
            $api = $user -> addUser();
            break;
        case "deleteUser":
            $user = new User($api);
            $user -> __init();
            $api = $user -> deleteUser();
            break;
        case "login":
            $user = new User($api);
            $user -> __init();
            $api = $user -> login();
            break;
        case "get_info":
            $user = new User($api);
            $user -> __init();
            $api = $user -> getInfo();
            break;
        case "change_password":
            $user = new User($api);
            $user -> __init();
            $api = $user -> change_password();
            break;
        case "getList":
            $board = new User($api);
            $board -> __init();
            $api = $board -> getList(
                "g5_member",
                $_GET["offset"],
                $_GET["limit"]
            );
            break;
        case "updateGrade":
            $board = new User($api);
            $board -> __init();
            $api = $board -> updateGrade(
                $_REQUEST["mb_id"],
                $_REQUEST["mb_grade"]
            );
            break;
        case "updatePosition":
            $board = new User($api);
            $board -> __init();
            $api = $board -> updatePosition();
            break;
        case "updatePush":
            $board = new User($api);
            $board -> __init();
            $api = $board -> updatePush(
                $_REQUEST["mb_id"],
                $_REQUEST["push_token"],
                $_REQUEST["store_type"],
                $_REQUEST["is_push_receive"]
            );
            break;
    }

    echo json_encode($api);
}
?>