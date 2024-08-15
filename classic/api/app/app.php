<?php

use api\database\Mysql;

require "../config.php";
require "../constant.php";

include_once('../database/mysql.php');
include_once('../model/api.php');

include_once('../_common.php');

/**
 * 개별 푸시
 * 전체 푸시
 * 알림 리스트 전달
 * */

/**
 *  알림 메세지
 * 누가
 * 누구에게
 * 언제
 * 확인여부
 * 타입
 * 이동페이지
 */


class App {
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

    function getAppInfo() {
        $platform = $_REQUEST["platform"];
        if ($platform == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("파라미터를 확인해주세요.");
            $this->api->setEntity("");

            return $this->api;
        }
        $sql =  "Select * From app_info WHERE platform = '{$platform}'";
        $result = $this->db->sql_fetch($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("조회에 실패했습니다.");
            $this->api->setEntity($result);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 성공했습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function checkPush() {
        $bo_table = $_REQUEST["bo_table"];
        $mb_id = $_REQUEST["mb_id"];
        if ($bo_table == null || $mb_id == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("파라미터를 확인해주세요.");
            $this->api->setEntity("");

            return $this->api;
        }
        $push_type = $this->_getPushType($bo_table);
        $sql = "UPDATE g5_member
                SET $push_type = 0
                WHERE mb_id = '$mb_id'";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("조회에 실패했습니다.");
            $this->api->setEntity($result);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 성공했습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    /**
     * type
     * 1 - 댓글
     * 2 - 답글
     * 3 -
     * 4 -
     * 5 - 새글
     * 6 - 공지
     */

    /**
     * page
     * - notam
     * - briefing
     * - schedule
     * - crm
     * - request
     * - vote
     * - manual
     */

    function response($from, $from_name, $to, $to_name, $type, $page, $detail) {
        if ($from == $to) {
            return;
        }

        $message = "알림이 도착했습니다.";

        if ($page == "crm") {
            $from_name = "익명";
        }
        switch ($type) {
            case PUSH_TYPE_COMMENT:
                $message = "{$from_name}님이 내 글에 댓글을 다셨습니다.";
                break;
            case PUSH_TYPE_RE_COMMENT:
                $message = "{$from_name}님이 댓글에 답글을 다셨습니다.";
                break;
            case PUSH_TYPE_NEW:
                $message = "{$page}게시판글에 새 댓글이 작성됐습니다.";
                break;
            case PUSH_TYPE_NOTICE:
                $message = "공지가 작성되었습니다.";
                break;
        }

        $result = "";
        if ($type == "5" || $type == "6") {
            $result = $this->pushAll($message, $to, $type, $page, $detail);
        } else {
            $result = $this->push($message, $from, $to, $type, $page, $detail);
        }
        return $result;
    }

    /**
     *  알림 메세지
     * 누가
     * 누구에게
     * 언제
     * 확인여부
     * 타입
     * 이동페이지
     */
    function pushRPC() {
        $message = $_REQUEST[message];
        $from = $_REQUEST[from];
        $to = $_REQUEST[to];
        $type = $_REQUEST[type];
        $page = $_REQUEST[page];

        $result = $this->push($message, $from, $to, $type, $page);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("작성에 실패했습니다.");
            $this->api->setEntity("");
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("작성에 성공하였습니다.");
            $this->api->setEntity("");
        }
        return  $this->api;
    }

    // 개별 푸시
    function push($message, $from, $to, $type, $page, $detail) {
        $when = date('Y-m-d H:i:s', time());

        $sql = "UPDATE g5_member
                SET push_count = push_count + 1 
                WHERE mb_id = '{$to}'";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            return "증가에 실패했습니다.";
        }
        $sql = "INSERT INTO push_message
                SET `from` = '$from',
                     `to` = '$to',
                     `message` = '$message',
                     `timestamp` = '$when',
                     `type` = '$type',
                     `page` = '$page',
                     `wr_1` = '$detail'";

        $result = $this->db->sql_query($sql);
        if ($result == null) {
            return "최종 쿼리에 실패했습니다.";
        }

        return "";
    }

    function pushAllRPC() {
        $message = $_REQUEST[message];
        $to = $_REQUEST[to];
        $type = $_REQUEST[type];
        $page = $_REQUEST[page];

        $result = $this->pushAll($message, $to, $type, $page);
        if ($result == null) {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("작성에 성공하였습니다.");
            $this->api->setEntity("");
        } else {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage($result);
            $this->api->setEntity("");
        }

        return  $this->api;
    }

    function _getPushType($page) {
        $push_type = "push_10";
        switch ($page) {
            case "notam":
                $push_type = "push_1";
                break;
            case "briefing":
                $push_type = "push_2";
                break;
            case "crm":
                $push_type = "push_3";
                break;
            case "request":
                $push_type = "push_4";
                break;
            case "vote":
                $push_type = "push_5";
                break;
            case "manual":
                $push_type = "push_6";
                break;
            default:
                $push_type = "push_7";
        };
        return $push_type;
    }

    // 전체 푸시
    function pushAll($message, $to, $type, $page, $detail) {
        $when = date('Y-m-d H:i:s', time());

        $push_type = $this->_getPushType($page);
        $sql = "UPDATE g5_member
                SET $push_type = $push_type + 1";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            return "첫번째 증가에 실패했습니다.";
        }

        $sql = "UPDATE push_index
                SET push_1 = push_1 + 1
                WHERE id = 1";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            return "두번째 증가에 실패했습니다.";
        }
        $sql = "INSERT INTO push_notice
                SET `from` = 'epu', 
                     `to` = '$to', 
                     `message` = '$message', 
                     `timestamp` = '$when', 
                     `type` = '$type', 
                     `page` = '$page', 
                     `wr_1` = '$detail' ";

        $result = $this->db->sql_query($sql);
        if ($result == null) {
            return "마지막 반환에 실패하였습니다.";
        }
        if ($page != "schedule") {
            $this->push_message("새글 알림", $message, "", "");
        }

        return "";
    }

    // 개인 알림 내역
    function getResponse() {
        $mb_id = $_REQUEST["mb_id"];
        if ($mb_id == "") {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("wr_id를 확인해주세요.");
            return $this->api;
        }

//        $sql = "(SELECT * FROM `push_message` WHERE `to` = '{$mb_id}' ORDER BY timestamp DESC LIMIT 5)UNION(SELECT * FROM `push_notice` ORDER BY timestamp DESC LIMIT 5);";
        $sql = "SELECT * FROM `push_message` WHERE `to` = '{$mb_id}' ORDER BY timestamp DESC";
        $result = $this->db->queryList($sql);
        if ($result == null) {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 실패했습니다.");
            $this->api->setEntity([]);
        } else {
            $count = $this->_get_push_total_count($mb_id);
            $sql = "UPDATE g5_member
                SET push_check = $count 
                WHERE mb_id = '$mb_id'";
            $update = $this->db->sql_query($sql);
            if ($update == null) {
                $this->api->setCode(RPC_QUERY_ERROR);
                $this->api->setMessage("증가에 실패했습니다.");
                $this->api->setEntity($count);
                return $this->api;
            }

            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 성공하였습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function _get_push_total_count($mb_id) {
        $person = $this->db->sql_fetch(" SELECT push_count AS cnt FROM  g5_member WHERE mb_id = '$mb_id'");
        $notice = $this->db->sql_fetch(" SELECT push_1 AS cnt FROM push_index WHERE id = 1");
        return $person['cnt'] + 0;
    }

    function _get_push_unread_count($mb_id) {
        $check = $this->db->sql_fetch(" SELECT push_check AS cnt FROM  g5_member WHERE mb_id = '$mb_id'");
        return $this->_get_push_total_count($mb_id) - $check['cnt'];
    }

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
//        $key = "";
        $message_status = $this->send_notification_ios($title_content, $message_content, $mb_link, $mb_image, $key);
        $message_status = $this->send_notification_android($title_content, $message_content, $mb_link, $mb_image, $key);
    }
}

?>