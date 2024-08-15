<?php

use api\database\Mysql;
use api\model\API;

require "./config.php";

include_once('./database/mysql.php');
include_once('./model/api.php');

function get_list()
{
    $db = new Mysql(
        DB_HOST,
        DB_USER,
        DB_PASSWORD,
        DB_NAME,
        DB_DNS
    );

    return $db;
}

function get_detail()
{

}

$api = new API();
$api->setCode(-1);
$api->setMessage("API 명을 확인해주세요.");
$api->setEntity("");
$apiName = $_GET["api_name"];

if (!isset($apiName)) {
    $api->setEntity(array("db" => get_list()));
    echo json_encode($api);
} else {
    $api->setMessage("D");
    $user_info = file_get_contents('http://toversystems.codns.com/teps/api/user/user.php');
    $user_info = json_decode($user_info, true);
    $api->setEntity(array("user_info" => $user_info));

    echo json_encode($api);
}
?>