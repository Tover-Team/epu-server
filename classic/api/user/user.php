<?php

use api\database\Mysql;

require "../config.php";
require "../constant.php";

include_once('../app/app.php');
include_once('../database/mysql.php');
include_once('../model/api.php');

include_once('../_common.php');

class User {
    var $api;
    var $db;
    var $app;

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
        $this->app = new App($this->api);
        $this->app -> __init();
    }

    function updateGrade($id, $grade) {
        $sql = "UPDATE g5_member
                SET mb_grade = '$grade'
                WHERE  mb_id = '$id' ";
        $result = $this->db->sql_query($sql);

        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("수정에 실패했습니다.");
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("수정에 성공하였습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function updatePosition() {
        $mb_id = $_REQUEST[mb_id];
        $position = $_REQUEST[position];
        if (!$mb_id) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("파라미터를 확인해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }
        $sql = "UPDATE g5_member
                SET mb_2 = '$position'
                WHERE  mb_id = '$mb_id' ";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("수정에 실패했습니다.");
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("수정에 성공하였습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function updatePush($mb_id, $push_token, $store_type, $is_push_receive) {
        if (!$mb_id) {
            $result = $this->get_member("1004");
            $result["mb_1"] = "-1";
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("수정에 성공하였습니다.");
            $this->api->setEntity($result);
//            $this->api->setCode(RPC_PARAM_ERROR);
//            $this->api->setMessage("파라미터를 확인해주세요.");
//            $this->api->setEntity($store_type);

            return $this->api;
        }

        // 로그인 갱신
        $when = date('Y-m-d H:i:s', time());
        $addr = $_SERVER["REMOTE_ADDR"];
        if ($addr == null) {
            $addr = "";
        }

        $sql = "UPDATE g5_member
                SET push_token = '$push_token', 
                store_type = '$store_type', 
                is_push_receive = '$is_push_receive',
                mb_today_login = '".$when."',
                mb_login_ip = '{$addr}'
                WHERE  mb_id = '$mb_id' ";

        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $result = $this->get_member("1004");
            $result["mb_1"] = "-1";
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("수정에 성공하였습니다.");
            $this->api->setEntity($result);
//            $this->api->setCode(RPC_QUERY_ERROR);
//            $this->api->setMessage("로그인 갱신에 실패했습니다.");
        } else {
            $result = $this->get_member($mb_id);
            if ($result == null) {
                $result = $this->get_member("1004");
                $result["mb_1"] = "-1";
                $this->api->setCode(RPC_SUCCESS);
                $this->api->setMessage("수정에 성공하였습니다.");
                $this->api->setEntity($result);
                return $this->api;
            }
            if ($result["mb_grade"] == "6") {
                $result["mb_1"] = "-1";
            }

            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("수정에 성공하였습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function getList($table, $offset, $limit) {
        if (!isset($offset)) {
            $offset = 0;
        }
        if (!isset($limit)) {
            $limit = 10;
        }

        // Order by Member is mb_no and board is wr_id
//        $sql = "SELECT *
//                FROM $table
//                ORDER BY mb_no
//                DESC
//                LIMIT $offset, $limit";
        $keywords = $_REQUEST[keywords];
        if ($keywords == "") {
            $sql = "SELECT * 
                FROM g5_member
                WHERE mb_10 != '1' AND mb_grade != '6'  
                ORDER BY mb_name";
        } else {
            $sql = "SELECT * 
                FROM (SELECT * FROM `g5_member` WHERE mb_10 != '1' AND mb_grade != '6') as A
                WHERE A.mb_id LIKE '%{$keywords}%' OR A.mb_nick LIKE '%{$keywords}%' OR A.mb_name LIKE '%{$keywords}%'   
                ORDER BY A.mb_name";
        }

        $result = $this->db->queryList($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("조회에 실패했습니다.");
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 성공하였습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function getUserCount() {
        $id_row = $this->db->sql_fetch("SELECT COUNT(*) as cnt FROM g5_member WHERE mb_10 != '1' AND mb_2 != '노무사' AND mb_grade != '6'");
        if ($id_row == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("조회 실패했습니다.");
            $this->api->setEntity("");
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회 성공했습니다.");
            $this->api->setEntity($id_row['cnt']);
        }

        return $this->api;
    }

    function getInfo() {
        $mb_id = $_REQUEST["mb_id"];
        if ($mb_id == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("파라미터를 확인해주세요.");
            $this->api->setEntity("");

            return $this->api;
        }

        $result = $this->get_member($mb_id);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("조회에 실패했습니다.");
            $this->api->setEntity($result);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 성공하였습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function addUser() {
        $mb_id = $_REQUEST["mb_id"];
        $mb_password = $_REQUEST["mb_password"];
        $mb_name = $_REQUEST["mb_name"];
        $mb_nick = $_REQUEST["mb_nick"];
        $mb_2 = $_REQUEST["mb_2"]; // 직위 부기장,
        $mb_grade = $_REQUEST["mb_grade"]; // 직책 조합원
        if ($mb_id == null || $mb_password == null || $mb_name == null || $mb_nick == null || $mb_2 == null || $mb_grade == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("파라미터를 확인해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }

        $id_row = $this->db->sql_fetch(" select count(*) as cnt from  g5_member where mb_id = '$mb_id'");
        if ($id_row['cnt']) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("이미 존재하는 아이디입니다.");
            $this->api->setEntity("");
        } else {
            $sql = "INSERT INTO g5_member
                set mb_id = '{$mb_id}',
                     mb_password = '".$this->get_encrypt_string($mb_password)."',
                     mb_name = '{$mb_name}',
                     mb_level = '2',
                     mb_nick = '{$mb_nick}',
                     mb_2 = '{$mb_2}',
                     mb_grade = '{$mb_grade}'";
            $result = $this->db->sql_query($sql);
            if ($result == null) {
                $this->api->setCode(RPC_QUERY_ERROR);
                $this->api->setMessage("사용자 추가에 실패했습니다.");
                $this->api->setEntity("");
            } else {
                $this->api->setCode(RPC_SUCCESS);
                $this->api->setMessage("사용자 추가에 성공했습니다.");
                $this->api->setEntity("");
            }
        }

        return $this->api;
    }

    function deleteUser() {;
        $mb_id = $_REQUEST["mb_id"];
        if (!$mb_id) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("파라미터를 확인해주세요.");
            $this->api->setEntity("");

            return $this->api;
        }

        $sql = "DELETE FROM g5_member WHERE mb_id = '{$mb_id}'";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("삭제에 실패했습니다.");
            $this->api->setEntity("");
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("삭제에 성공하였습니다.");
            $this->api->setEntity($sql);
        }

        return $this->api;
    }

    function _getGrade($value) {
        switch ($value) {
            case "":
                break;
            case "":
                break;
            case "":
                break;
            case "":
                break;
            case "":
                break;
        }
    }

    /**
     * mb_grade: 1,    ,5(관리자)
     * */
    function login() {
        $mb_id       = trim($_REQUEST['mb_id']);
        $mb_password = trim($_REQUEST['mb_password']);
        if (!$mb_id || !$mb_password) {
            $this->api->setMessage("가입된 회원아이디가 아니거나 비밀번호가 틀립니다. \n비밀번호는 대소문자를 구분합니다");
        } else {
            $mb = $this->get_member($mb_id);

            if (!$mb['mb_id'] || !$this->check_password($mb_password, $mb['mb_password'])) {
                $this->api->setMessage("가입된 회원아이디가 아니거나 비밀번호가 틀립니다. \n비밀번호는 대소문자를 구분합니다");
            } else if ($mb['mb_grade'] == "6") {
                $this->api->setMessage("회원님의 아이디는 접근이 금지되어 있습니다.");
            } else if ($mb['mb_intercept_date'] && $mb['mb_intercept_date'] <= date("Ymd", G5_SERVER_TIME)) {
                $this->api->setMessage("회원님의 아이디는 접근이 금지되어 있습니다.");
            } else if ($mb['mb_leave_date'] && $mb['mb_leave_date'] <= date("Ymd", G5_SERVER_TIME)) {
                $this->api->setMessage("탈퇴한 아이디이므로 접근하실 수 없습니다");
            } else {
                // 마지막 로그인 업데이트, 푸시 값 갱신
                $current_date = date('Y-m-d H:i:s', time());
                $real_client_ip = $this->get_real_client_ip();
                $storeType = trim($_REQUEST['storeType']);
                $registrationKey = trim($_REQUEST['registrationKey']);

                $sql = " UPDATE g5_member
                    SET store_type = '{$storeType}',
                     push_token = '{$registrationKey}',
                     mb_today_login = '{$current_date}',
                     mb_login_ip = '{$real_client_ip}'
                    WHERE mb_id = '{$mb_id}'";
                $result = $this->db->sql_query($sql);
                if ($result == null) {
                    $this->api->setCode(RPC_QUERY_ERROR);
                    $this->api->setMessage("조회에 실패했습니다.");
                } else {
                    $mb = $this->get_member($mb_id);
                    $this->api->setCode(RPC_SUCCESS);
                    $this->api->setMessage("조회에 성공하였습니다.");
                    $this->api->setEntity($mb);
                }
            }
        }

        return $this->api;
    }

    function change_password() {
        $mb_id       = trim($_REQUEST['mb_id']);
        $mb_password = trim($_REQUEST['mb_password']);
        $mb_password_change = trim($_REQUEST['mb_password_change']);

        $mb = $this->get_member($mb_id);
        if (!$mb['mb_id'] || !$this->check_password($mb_password, $mb['mb_password'])) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("비밀번호가 틀립니다. 비밀번호는 대소문자를 구분합니다");
            $this->api->setEntity($mb);
            return $this->api;
        }
        if ($mb['mb_intercept_date'] && $mb['mb_intercept_date'] <= date("Ymd", G5_SERVER_TIME)) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("회원님의 아이디는 접근이 금지되어 있습니다.");
            $this->api->setEntity($mb);
            return $this->api;
        }
        if ($mb['mb_leave_date'] && $mb['mb_leave_date'] <= date("Ymd", G5_SERVER_TIME)) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("탈퇴한 아이디이므로 접근하실 수 없습니다");
            $this->api->setEntity($mb);
            return $this->api;
        }

        $query = " UPDATE g5_member
                    SET mb_password = '" . $this->get_encrypt_string($mb_password_change) . "'
                      WHERE mb_id = '{$mb_id}'";
        $result = $this->db->sql_query($query);
        if ($result) {
            $mb = $this->get_member($mb_id);
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("변경에 성공했습니다.");
            $this->api->setEntity($mb);
        } else {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("변경에 실패했습니다.");
            $this->api->setEntity("");
        }

        return $this->api;
    }

    // 문자열 암호화
    function get_encrypt_string($str)
    {
        if(defined('G5_STRING_ENCRYPT_FUNCTION') && G5_STRING_ENCRYPT_FUNCTION) {
            $encrypt = call_user_func(G5_STRING_ENCRYPT_FUNCTION, $str);
        } else {
            $encrypt = $this->sql_password($str);
        }

        return $encrypt;
    }

    function sql_password($value)
    {
        // mysql 4.0x 이하 버전에서는 password() 함수의 결과가 16bytes
        // mysql 4.1x 이상 버전에서는 password() 함수의 결과가 41bytes
        $row = $this->db->sql_fetch(" select password('$value') as pass ");

        return $row['pass'];
    }


    // Client ip
    function get_real_client_ip(){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
    }

    // 비밀번호 비교
    function check_password($pass, $hash)
    {
        $password =  $this->db->get_encrypt_string($pass);
        return ($password === $hash);
    }

    // 회원 정보를 얻는다.
    function get_member($mb_id)
    {
        $mb = $this->db->sql_fetch("SELECT * FROM g5_member WHERE mb_id = TRIM('$mb_id')");
        $mb["push_total_count"] = $this->app->_get_push_total_count($mb_id);
        $mb["push_unread_count"] = $this->app->_get_push_unread_count($mb_id);
        return $mb;
    }
}

?>