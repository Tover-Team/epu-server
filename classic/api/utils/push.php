<?php
require "../config.php";
require "../constant.php";

include_once('../database/mysql.php');
include_once('../model/api.php');

include_once('../_common.php');

class PushManager {
    var $api;
    var $db;

    function __construct($_api)
    {
        $this->api = $_api;
    }

    function __init() {
        $db = new Mysql(
            DB_HOST,
            DB_USER,
            DB_PASSWORD,
            DB_NAME,
            DB_DNS
        );
        $db->__connect();
        $this->db = $db;
    }

    function allPush($message, $target_link, $img_url) {

    }

    function send($to, $message, $target_link, $img_url) {

    }
}

?>