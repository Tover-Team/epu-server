<?php

use api\database\Mysql;
use api\user\User;

require "../config.php";
require "../constant.php";

include_once('../app/app.php');
include_once('../database/mysql.php');
include_once('../model/api.php');
include_once('../user/user.php');

include_once('../_common.php');

class Vote {
    var $api;
    var $db;
    var $user;
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
        $this->user = new User($this->api);
        $this->app = new App($this->api);
        $this->app -> __init();
    }

    /**
     * id -> wr_subject: 투표 본문
     * no -> wr_content: 투표 번호
     * mb_id -> mb_id: 투표자
    */
    function vote($id, $mb_id, $no) {
        // 종료 여부 판단
        $row = $this->_getInfo($id);
        if ($row[wr_2] != "1") {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("종료된 투표입니다.");
            $this->api->setEntity($row[wr_1]);
            return $this->api;
        }
        // 이미 투표 했는지 여부 판단
        $isVote = $this->_isVote($id, $mb_id);
        if ($isVote) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("이미 투표하셨습니다.");
            $this->api->setEntity("");
            return $this->api;
        }

        // 해당 허용하는 그룹인지 체크
        $sql = " insert into g5_write_vote_member
                set wr_subject = '$id',
                     wr_content = '$no',
                     mb_id = '$mb_id' ";
        $result = $this->db->sql_query($sql);

        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("투표에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("투표에 성공했습니다.");
            $this->api->setEntity($sql);
        }

        return $this->api;
    }

    function unVote($id, $mb_id) {
        // 종료 여부 판단
        $row = $this->_getInfo($id);
        if ($row[wr_2] != "1") {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("종료된 투표입니다.");
            $this->api->setEntity($row[wr_1]);
            return $this->api;
        }
        // 이미 투표 했는지 여부 판단
        $isVote = $this->_isVote($id, $mb_id);
        if (!$isVote) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("투표하지 않았습니다.");
            $this->api->setEntity("");
            return $this->api;
        }

        // 투표 삭제
        $sql = "DELETE FROM g5_write_vote_member 
                WHERE wr_subject = '{$id}' AND 
                     mb_id = '{$mb_id}' ";
        $result = $this->db->sql_query($sql);

        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("투표 취소에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("투표 취소에 성공했습니다.");
            $this->api->setEntity($sql);
        }

        return $this->api;
    }

    function isVote($id, $mb_id) {
        $result = $this->_isVote($id, $mb_id);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("아직 투표하지 않으셨습니다.");
            $this->api->setEntity($result);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("이미 투표하셨습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function _isVote($id, $mb_id) {
        $sql = "SELECT COUNT(*) as cnt FROM g5_write_vote_member WHERE mb_id = '$mb_id' AND wr_subject = '$id'";
        $row = $this->db->sql_fetch($sql);
        if ($row['cnt'] > 0) {
            return true;
        } else {
            return null;
        }
    }

    function getInfo($id) {
        $result = $this->_getInfo($id);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("존재하지 않는 투표입니다.");
            $this->api->setEntity("");
        } else {
            $info = $this->_getVoteMemberList($id);
            $result["info"] = $info;

            // Date
            $dt = new DateTime();
            $today = str_replace("-", "", $dt->format('Y-m-d'));
            $wr_endDate = str_replace("-", "", $result["wr_endDate"]);
            if ($today - $wr_endDate > 0) {
                $result["wr_2"] = -1;
            }

            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회 성공");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function getVoteCount($id, $mb_id, $no) {
        $row = $this->_getInfo($id);
        if ($row[wr_1] != "1") {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("종료된 투표입니다.");
            $this->api->setEntity($row[wr_1]);
            return $this->api;
        }
        // 이미 투표 했는지 여부 판단
        $isVote = $this->_isVote($id, $mb_id);
        if ($isVote) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("이미 투표하셨습니다.");
            $this->api->setEntity("");
            return $this->api;
        }

        // 해당 허용하는 그룹인지 체크
        $sql = " insert into g5_write_vote_member
                set wr_subject = '$id',
                     wr_content = '$no',
                     mb_id = '$mb_id' ";
        $result = $this->db->sql_query($sql);

        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("투표에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("투표에 성공했습니다.");
            $this->api->setEntity($sql);
        }

        return $this->api;
    }

    function getVoteInfo($wr_id) {
        $list = $this->_getVoteInfo($wr_id);

        if ($list == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("존재하지 않는 투표입니다.");
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("성공");
            $this->api->setEntity($list);
        }

        return $this->api;
    }

    function _getVoteInfo($wr_id) {
        $c1 = $this->_getVoteCount($wr_id, 1);
        $c2 = $this->_getVoteCount($wr_id, 2);
        $c3 = $this->_getVoteCount($wr_id, 3);
        $c4 = $this->_getVoteCount($wr_id, 4);
        $c5 = $this->_getVoteCount($wr_id, 5);
        $c6 = $this->_getVoteCount($wr_id, 6);
        $c7 = $this->_getVoteCount($wr_id, 7);
        $c8 = $this->_getVoteCount($wr_id, 8);
        $c9 = $this->_getVoteCount($wr_id, 9);
        $c10 = $this->_getVoteCount($wr_id, 10);
        $c11 = $this->_getVoteCount($wr_id, 11);
        $c12 = $this->_getVoteCount($wr_id, 12);
        $c13 = $this->_getVoteCount($wr_id, 13);
        $c14 = $this->_getVoteCount($wr_id, 14);
        $c15 = $this->_getVoteCount($wr_id, 15);
        $c16 = $this->_getVoteCount($wr_id, 16);
        $c17 = $this->_getVoteCount($wr_id, 17);
        $c18 = $this->_getVoteCount($wr_id, 18);
        $c19 = $this->_getVoteCount($wr_id, 19);
        $c20 = $this->_getVoteCount($wr_id, 20);

        $list = array($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20);

        return $list;
    }

    function _getVoteMemberList($wr_id) {
        $c1 = $this->_getVoteMember($wr_id, 1);
        $c2 = $this->_getVoteMember($wr_id, 2);
        $c3 = $this->_getVoteMember($wr_id, 3);
        $c4 = $this->_getVoteMember($wr_id, 4);
        $c5 = $this->_getVoteMember($wr_id, 5);
        $c6 = $this->_getVoteMember($wr_id, 6);
        $c7 = $this->_getVoteMember($wr_id, 7);
        $c8 = $this->_getVoteMember($wr_id, 8);
        $c9 = $this->_getVoteMember($wr_id, 9);
        $c10 = $this->_getVoteMember($wr_id, 10);
        $c11 = $this->_getVoteMember($wr_id, 11);
        $c12 = $this->_getVoteMember($wr_id, 12);
        $c13 = $this->_getVoteMember($wr_id, 13);
        $c14 = $this->_getVoteMember($wr_id, 14);
        $c15 = $this->_getVoteMember($wr_id, 15);
        $c16 = $this->_getVoteMember($wr_id, 16);
        $c17 = $this->_getVoteMember($wr_id, 17);
        $c18 = $this->_getVoteMember($wr_id, 18);
        $c19 = $this->_getVoteMember($wr_id, 19);
        $c20 = $this->_getVoteMember($wr_id, 20);

        $list = array($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20);

        return $list;
    }

    function _getVoteMember($wr_id, $num) {
        $sql = " select mb_id from g5_write_vote_member where wr_subject = '{$wr_id}' and wr_content = '{$num}' ";
        $result = $this->db->queryListUnmarshal($sql);
        $list = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mb_id = $row["mb_id"];
            array_push($list, $mb_id);
        }

        return $list;
    }

    function _getVoteCount($wr_id, $num) {
        $sql = " select count(*) as cnt from g5_write_vote_member where wr_subject = '{$wr_id}' and wr_content = '{$num}' ";
        $row = $this->db->sql_fetch($sql);
        return $row['cnt'];
    }

    function _getInfo($id) {
        $sql = "SELECT * 
                FROM g5_write_vote
                WHERE wr_id = '$id'";
        $row = $this->db->sql_fetch($sql);

        return $row;
    }

    function getList($table, $offset, $limit) {
        if (!isset($offset)) {
            $offset = 0;
        }
        if (!isset($limit)) {
            $limit = 10;
        }

        $keywords = $_REQUEST[keywords];
        if ($keywords == "") {
            $sql = "SELECT * 
                FROM g5_write_$table
                WHERE wr_is_comment = 0
                ORDER BY wr_id
                DESC 
                LIMIT $offset, $limit";
        } else {
            $sql = "SELECT * 
                FROM g5_write_$table
                WHERE wr_is_comment = 0 AND mb_id like '%{$keywords}%' 
                ORDER BY wr_id
                DESC 
                LIMIT $offset, $limit";
        }

        // Order by Member is mb_no and board is wr_id
        $result = $this->db->queryListUnmarshal($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("조회에 실패했습니다.");
        } else {
            $list = array();
            while ($row = mysqli_fetch_assoc($result)) {
               $wr_id = $row["wr_id"];
               $info = $this->_getVoteMemberList($wr_id);
               $row["info"] = $info;

                $dt = new DateTime();
                $today = str_replace("-", "", $dt->format('Y-m-d'));
                $wr_endDate = str_replace("-", "", $row["wr_endDate"]);
                if ($today - $wr_endDate > 0) {
                    $row["wr_2"] = -1;
                }

               array_push($list, $row);
            }

            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 성공하였습니다.");
            $this->api->setEntity($list);
        }

        return $this->api;
    }

    function stop() {
        $wr_id = $_REQUEST["wr_id"];
        if (!$wr_id) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("게시물 아이디를 입력하세요.");
            return $this->api;
        }

        $result = $this->_updateVote($wr_id, "-1");
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("수정에 실패했습니다.");
            $this->api->setEntity(false);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("수정에 성공하였습니다.");
            $this->api->setEntity(true);
        }

        return $this->api;
    }

    function _updateVote($id, $type) {
        $sql = "UPDATE g5_write_vote
                SET wr_2 = '$type'
                WHERE  wr_id = '$id' ";
        $result = $this->db->sql_query($sql);

        if ($result == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     *  mb_id: 작성자
     *  wr_1 -> grade: 작성할 수 있는 등급 이상
     * <option value="1">전체</option>
     * <option value="2">집행부</option>
     * <option value="3">대의원</option>
     * <option value="4">집행부+대의원</option>
     *
     *  wr_2 -> status: 상태 (-1 종료, 0 대기, 1 시작)
     *  title -> wr_subject: 게시글 제목
     *  desc -> wr_content: 게시글 본문
     *  question1~5 -> wr_5~wr_10: 항목
     *  startDate: 투표 시작일
     *  endDate: 투표 종료일
     *  wr_3: 투표 개수
     *
     */
    function create() {
        $wr_subject = $_REQUEST["wr_subject"];
        $wr_content = $_REQUEST["wr_content"];
        $wr_startDate = $_REQUEST["wr_startDate"];
        $wr_endDate = $_REQUEST["wr_endDate"];
        $mb_id = $_REQUEST["mb_id"];
        $wr_name = $_REQUEST["wr_name"];
        $wr_1 = $_REQUEST["wr_1"];
        $wr_2 = "1";
        $wr_5 = $_REQUEST["wr_5"];
        $wr_6 = $_REQUEST["wr_6"];
        $wr_7 = $_REQUEST["wr_7"];
        $wr_8 = $_REQUEST["wr_8"];
        $wr_9 = $_REQUEST["wr_9"];
        $wr_10 = $_REQUEST["wr_10"];
        $current_date = date('Y-m-d H:i:s', time());

        if (!$wr_subject) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("제목을 입력해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }
        if (!$wr_content) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("설명을 입력해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }
        if (!$wr_startDate || !$wr_endDate) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("일자를 입력해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }
        if (!$wr_1) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("등급 입력해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }
        if (!$wr_5 && !$wr_6 && !$wr_7 && !$wr_8 && !$wr_9) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("항목을 입력해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }

        $sql = " insert into g5_write_vote
                set wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     mb_id = '$mb_id',
                     wr_name = '$wr_name',
                     wr_datetime = '$current_date',
                     wr_last = '$current_date',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}', 
					 wr_1 = '$wr_1',
                     wr_2 = '$wr_2',
                     wr_5 = '$wr_5',
                     wr_6 = '$wr_6',
                     wr_7 = '$wr_7',
                     wr_8 = '$wr_8',
                     wr_9 = '$wr_9',
                     wr_10 = '$wr_10',
                     wr_startDate = '$wr_startDate',
                     wr_endDate = '$wr_endDate'";
        $result = $this->db->sql_query($sql);

        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("투표 생성에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("투표 생성에 성공하였습니다.");
            $this->api->setEntity($sql);
        }

        return $this->api;
    }

    function delete() {
        $wr_id = $_REQUEST["wr_id"];

        $sql = "DELETE FROM g5_write_vote WHERE wr_id = $wr_id";
        $result = sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("삭제에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("삭제에 성공하였습니다.");
            $this->api->setEntity($sql);
        }
    }

    function modify() {
        $wr_id = $_REQUEST["wr_id"];
        $wr_subject = $_REQUEST["wr_subject"];
        $wr_content = $_REQUEST["wr_content"];
        $wr_startDate = $_REQUEST["wr_startDate"];
        $wr_endDate = $_REQUEST["wr_endDate"];
        $mb_id = $_REQUEST["mb_id"];
        $wr_name = $_REQUEST["wr_name"];
        $wr_1 = $_REQUEST["wr_1"];
        $wr_2 = "1";
        $wr_5 = $_REQUEST["wr_5"];
        $wr_6 = $_REQUEST["wr_6"];
        $wr_7 = $_REQUEST["wr_7"];
        $wr_8 = $_REQUEST["wr_8"];
        $wr_9 = $_REQUEST["wr_9"];
        $wr_10 = $_REQUEST["wr_10"];
        $current_date = date('Y-m-d H:i:s', time());

        if (!$wr_subject) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("제목을 입력해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }
        if (!$wr_content) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("설명을 입력해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }
        if (!$wr_startDate || !$wr_endDate) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("일자를 입력해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }
        if (!$wr_1) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("등급 입력해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }
        if (!$wr_5 && !$wr_6 && !$wr_7 && !$wr_8 && !$wr_9) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("항목을 입력해주세요.");
            $this->api->setEntity("");
            return $this->api;
        }

        $sql = " UPDATE g5_write_vote
                set wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     mb_id = '$mb_id',
                     wr_name = '$wr_name',
                     wr_datetime = '$current_date',
                     wr_last = '$current_date',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}', 
					 wr_1 = '$wr_1',
                     wr_2 = '$wr_2',
                     wr_5 = '$wr_5',
                     wr_6 = '$wr_6',
                     wr_7 = '$wr_7',
                     wr_8 = '$wr_8',
                     wr_9 = '$wr_9',
                     wr_10 = '$wr_10',
                     wr_startDate = '$wr_startDate',
                     wr_endDate = '$wr_endDate'
                     WHERE  wr_id = '$wr_id'";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("투표 수정에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("투표 수정에 성공하였습니다.");
            $this->api->setEntity($sql);
        }

        return $this->api;
    }

//    function modify() {
//        $wr_id = $_REQUEST["wr_id"];
//        $bo_table = $_REQUEST["bo_table"];
//        $wr_subject = $_REQUEST["wr_subject"];
//        $wr_reply = $_REQUEST["wr_reply"];
//        $wr_content = $_REQUEST["wr_content"];
//        $wr_address = $_REQUEST["wr_address"];
//        $ca_name = $_REQUEST["ca_name"];
//        $wr_x = $_REQUEST["wr_x"];
//        $wr_y = $_REQUEST["wr_y"];
//        $wr_dday = $_REQUEST["wr_dday"];
//        $wr_startDate = $_REQUEST["wr_startDate"];
//        $wr_endDate = $_REQUEST["wr_endDate"];
//        $wr_cancel = $_REQUEST["wr_cancel"];
//        $wr_complete = $_REQUEST["wr_complete"];
//        $mb_id = $_REQUEST["mb_id"];
//        $wr_1 = $_REQUEST["wr_1"];
//        $wr_2 = $_REQUEST["wr_2"];
//        $wr_3 = $_REQUEST["wr_3"];
//        $wr_4 = $_REQUEST["wr_4"];
//        $wr_5 = $_REQUEST["wr_5"];
//        $wr_6 = $_REQUEST["wr_6"];
//        $wr_7 = $_REQUEST["wr_7"];
//        $wr_8 = $_REQUEST["wr_8"];
//        $wr_9 = $_REQUEST["wr_9"];
//        $wr_10 = $_REQUEST["wr_10"];
//        $img_list = $_REQUEST["img_list"];
//        $img_1 = $_REQUEST["img_1"];
//        $img_2 = $_REQUEST["img_2"];
//        $img_3 = $_REQUEST["img_3"];
//        $img_4 = $_REQUEST["img_4"];
//        $img_5 = $_REQUEST["img_5"];
//        $img_6 = $_REQUEST["img_6"];
//        $img_7 = $_REQUEST["img_7"];
//        $img_8 = $_REQUEST["img_8"];
//        $img_9 = $_REQUEST["img_9"];
//        $img_10 = $_REQUEST["img_10"];
//        $current_date = date('Y-m-d H:i:s', time());
//
//        if (!$bo_table) {
//            $this->api->setCode(RPC_PARAM_ERROR);
//            $this->api->setMessage("테이블을 입력하세요.");
//        }
//        else if (!$wr_subject) {
//            $this->api->setCode(RPC_PARAM_ERROR);
//            $this->api->setMessage("테이블을 입력하세요.");
//        } else {
//            $wr_num = $this->get_next_num("g5_write_$bo_table");
//
//            $sql = "UPDATE g5_write_$bo_table
//                SET wr_id = '$wr_id',
//                     wr_num = '$wr_num',
//                     wr_reply = '$wr_reply',
//                     wr_comment = 0,
//                     ca_name = '$ca_name',
//                     wr_subject = '$wr_subject',
//                     wr_content = '$wr_content',
//                     wr_link1_hit = 0,
//                     wr_link2_hit = 0,
//                     wr_hit = 0,
//                     wr_good = 0,
//                     wr_nogood = 0,
//                     mb_id = '$mb_id',
//                     wr_datetime = '$current_date',
//                     wr_last = '$current_date',
//                     wr_ip = '{$_SERVER['REMOTE_ADDR']}',
//					 wr_1 = '$wr_1',
//                     wr_2 = '$wr_2',
//                     wr_3 = '$wr_3',
//                     wr_4 = '$wr_4',
//                     wr_5 = '$wr_5',
//                     wr_6 = '$wr_6',
//                     wr_7 = '$wr_7',
//                     wr_8 = '$wr_8',
//                     wr_9 = '$wr_9',
//                     wr_10 = '$wr_10',
//                     img_list = '$img_list',
//                     img_1 = '$img_1',
//                     img_2 = '$img_2',
//                     img_3 = '$img_3',
//                     img_4 = '$img_4',
//                     img_5 = '$img_5',
//                     img_6 = '$img_6',
//                     img_7 = '$img_7',
//                     img_8 = '$img_8',
//                     img_9 = '$img_9',
//                     img_10 = '$img_10',
//                     wr_address = '$wr_address',
//                     wr_x = '$wr_x',
//                     wr_y = '$wr_y',
//                     wr_dday = '$wr_dday',
//                     wr_startDate = '$wr_startDate',
//                     wr_endDate = '$wr_endDate',
//                     wr_cancel = '$wr_cancel',
//                     wr_complete = '$wr_complete' ";
//            $result = $this->db->sql_query($sql);
//
//            if ($result == null) {
//                $this->api->setCode(RPC_QUERY_ERROR);
//                $this->api->setMessage("수정에 실패했습니다.");
//                $this->api->setEntity($sql);
//            } else {
//                $this->api->setCode(RPC_SUCCESS);
//                $this->api->setMessage("수정에 성공하였습니다.");
//                $this->api->setEntity($sql);
//            }
//        }
//
//        return $this->api;
//    }
}

?>