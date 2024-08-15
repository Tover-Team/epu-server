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

    function pushAllRPC() {
        $message = $_REQUEST[message];
        $to = $_REQUEST[to];
        $type = $_REQUEST[type];
        $page = $_REQUEST[page];

        $result = $this->pushAll($message, $to, $type, $page);
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

    /**
    * type
     * 1 - 댓글
     * 2 - 답글
     * 3 -
     * 4 -
     * 5 -
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
        $message = "알림이 도착했습니다.";
        switch ($type) {
            case PUSH_TYPE_COMMENT:
                $message = "{$from_name}님이 내 글에 댓글을 다셨습니다.";
                break;
            case PUSH_TYPE_RE_COMMENT:
                $message = "{$from_name}님이 댓글에 답글을 다셨습니다.";
                break;
            case PUSH_TYPE_NOTICE:
                $message = "공지입니다.";
                break;
        }

        $this->push($message, $from, $to, $type, $page, $detail);
    }

    // 개별 푸시
    function push($message, $from, $to, $type, $page, $detail) {
        $when = date('Y-m-d H:i:s', time());

        $sql = "UPDATE g5_member
                SET push_count = push_count + 1 
                WHERE mb_id = '{$to}'";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("증가에 실패했습니다.");
            $this->api->setEntity($sql);
            return $this->api;
        }
        $sql = "INSERT INTO push_message
                SET `from` = '$from',
                     `to` = '$to',
                     `message` = '$message',
                     `timestamp` = '$when',
                     `type` = '$type',
                     `page` = '$page',
                     `wr_1` = '$detail'";

        return $this->db->sql_query($sql);
    }

    // 전체 푸시
    function pushAll($message, $to, $type, $page, $detail) {
        $when = date('Y-m-d H:i:s', time());
        $sql = "UPDATE push_index
                SET push_1 = push_1 + 1
                WHERE id = 1";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("증가에 실패했습니다.");
            $this->api->setEntity($sql);
            return $this->api;
        }
        $sql = "INSERT INTO push_notice
                SET `from` = 'epu',
                     `to` = '$to',
                     `message` = '$message',
                     `timestamp` = '$when',
                     `type` = '$type',
                     `page` = '$page'";

        return $this->db->sql_query($sql);
    }

    // 개인 알림 내역
    function getResponse() {
        $mb_id = $_REQUEST["mb_id"];
        if ($mb_id == "") {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("wr_id를 확인해주세요.");
            return $this->api;
        }

        $sql = "(SELECT * FROM `push_message` WHERE `to` = '{$mb_id}' ORDER BY timestamp DESC LIMIT 5)UNION(SELECT * FROM `push_notice` ORDER BY timestamp DESC LIMIT 5);";
        $result = $this->db->queryList($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("조회에 실패했습니다.");
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
        return $person['cnt'] + $notice['cnt'];
    }

    function _get_push_unread_count($mb_id) {
        $check = $this->db->sql_fetch(" SELECT push_check AS cnt FROM  g5_member WHERE mb_id = '$mb_id'");
        return $this->_get_push_total_count($mb_id) - $check['cnt'];
    }
}

?>