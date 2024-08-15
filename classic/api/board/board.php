<?php
require "../config.php";
require "../constant.php";

include_once('../app/app.php');
include_once('../database/mysql.php');
include_once('../model/api.php');

include_once('../_common.php');

class Board {
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

    function create() {
        $bo_table = $_REQUEST["bo_table"]; // 제목
        $wr_subject = $_REQUEST["wr_subject"]; // 제목
        $wr_content = $_REQUEST["wr_content"]; // 내용
        $mb_id = $_REQUEST["mb_id"]; // 작성자
        $ca_name = $_REQUEST["ca_name"];
        $is_secret = $_REQUEST["is_secret"]; // 공개 여부 Y or N
        $is_anonymous = $_REQUEST["is_anonymous"]; // 익명 여부 Y or N
        $is_comment = $_REQUEST["is_comment"]; // 댓글 허용 여부 Y or N
        $file_1 = $_REQUEST["file_1"];
        $file_2 = $_REQUEST["file_2"];
        $file_3 = $_REQUEST["file_3"];
        $file_4 = $_REQUEST["file_4"];
        $file_5 = $_REQUEST["file_5"];

        $current_date = date('Y-m-d H:i:s', time()); // 작성일
        $wr_num = $this->get_next_num("g5_write_$bo_table");
        $sql = " insert into g5_write_$bo_table
                set wr_num = '$wr_num',
                     wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     mb_id = '$mb_id',
                     ca_name = '$ca_name',
                     wr_datetime = '$current_date',
                     wr_last = '$current_date',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}', 
					 is_secret = '$is_secret', 
                     is_anonymous = '$is_anonymous',
                     is_comment = '$is_comment',
                     file_1 = '$file_1',
                     file_2 = '$file_2',
                     file_3 = '$file_3',
                     file_4 = '$file_4',
                     file_5 = '$file_5'";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("게시글 생성에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $result = $this->db->sql_query("update g5_board set bo_count_write = bo_count_write + 1 where bo_table = '{$bo_table}'");
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("게시글 생성에 성공하였습니다.");
            $this->api->setEntity($sql);
        }

        return $this->api;
    }

    function modify() {
        $wr_id = $_REQUEST["wr_id"];
        $bo_table = $_REQUEST["bo_table"]; // 제목
        $wr_subject = $_REQUEST["wr_subject"]; // 제목
        $wr_content = $_REQUEST["wr_content"]; // 내용
        $mb_id = $_REQUEST["mb_id"]; // 작성자
        $ca_name = $_REQUEST["ca_name"];
        $is_secret = $_REQUEST["is_secret"]; // 공개 여부 Y or N
        $is_anonymous = $_REQUEST["is_anonymous"]; // 익명 여부 Y or N
        $is_comment = $_REQUEST["is_comment"]; // 댓글 허용 여부 Y or N
        $file_1 = $_REQUEST["file_1"];
        $file_2 = $_REQUEST["file_2"];
        $file_3 = $_REQUEST["file_3"];
        $file_4 = $_REQUEST["file_4"];
        $file_5 = $_REQUEST["file_5"];
        $current_date = date('Y-m-d H:i:s', time()); // 작성일

        $sql = " UPDATE g5_write_$bo_table
                set wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     mb_id = '$mb_id',
                     ca_name = '$ca_name',
                     wr_datetime = '$current_date',
                     wr_last = '$current_date',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}', 
					 is_secret = '$is_secret', 
                     is_anonymous = '$is_anonymous',
                     is_comment = '$is_comment',
                     file_1 = '$file_1',
                     file_2 = '$file_2',
                     file_3 = '$file_3',
                     file_4 = '$file_4',
                     file_5 = '$file_5'
                     WHERE wr_id = $wr_id";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("게시글 수정에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("게시글 수정에 성공하였습니다.");
            $this->api->setEntity($sql);
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

        $keywords = $_REQUEST[keywords];
        if ($keywords == "") {
            $sql = "SELECT * 
                FROM g5_write_$table
                WHERE wr_is_comment = 0 
                ORDER BY wr_id
                DESC ";
//                LIMIT $offset, $limit";
        } else {
            $sql = "SELECT * 
                FROM g5_write_$table
                WHERE wr_is_comment = 0 AND AND wr_subject like '%{$keywords}%' 
                ORDER BY wr_id
                DESC ";
//                LIMIT $offset, $limit";
        }

        // Order by Member is mb_no and board is wr_id
        $result = $this->db->queryList($sql);
        if ($result == null) {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 실패했습니다.".$sql);
            $this->api->setEntity([]);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 성공하였습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function getNoticeList($table, $offset, $limit) {
        if (!isset($offset)) {
            $offset = 0;
        }
        if (!isset($limit)) {
            $limit = 10;
        }

        $keywords = $_REQUEST[keywords];

        // Order by Member is mb_no and board is wr_id
        $sql = "SELECT * FROM g5_board WHERE bo_table = '$table' ";
        $result = $this->db->sql_fetch($sql);
        if (!$result) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("공지사항 조회 실패".$sql);
            $this->api->setEntity($result);
            return $this->api;
        }

        $notices = explode(",", $result['bo_notice']);

        $sql = "";
        $keywords = $_REQUEST[keywords];
        if ($keywords == "") {
            $sql = "SELECT * 
                FROM g5_write_$table
                WHERE wr_is_comment = 0 ";
        } else {
            $sql = "SELECT * 
                FROM g5_write_$table
                WHERE wr_is_comment = 0 AND wr_subject like '%{$keywords}%' ";
        }

        $count = 0;
        if (count($notices) > 0) {
            $sql = $sql . "AND ( wr_id = -1 ";
            foreach($notices as $val) {
                if ($val != '') {
                    $count ++;
                    $sql = $sql . "OR wr_id = '$val' ";
                }
            }
            $sql = $sql . ") ";
        }

        if ($count == 0) {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 성공하였습니다.");
            $this->api->setEntity([]);

            return $this->api;
        }

        $sql = $sql . "ORDER BY wr_id ";
        $sql = $sql . "DESC ";

        // Order by Member is mb_no and board is wr_id
        $result = $this->db->queryList($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("조회에 실패했습니다.".$sql);
            $this->api->setEntity([]);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 성공하였습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function getCategoryList($table, $offset, $limit) {
        if (!isset($offset)) {
            $offset = 0;
        }
        if (!isset($limit)) {
            $limit = 10;
        }

        $keywords = $_REQUEST[keywords];
        $category = $_REQUEST[category];

        if ($keywords == "") {
            $sql = "SELECT * 
                FROM g5_write_$table
                WHERE wr_is_comment = 0 AND ca_name = '$category'
                ORDER BY wr_id
                DESC ";
//                LIMIT $offset, $limit";
        } else {
            $sql = "SELECT * 
                FROM g5_write_$table
                WHERE wr_is_comment = 0 AND ca_name = '$category' AND wr_subject like '%{$keywords}%' 
                ORDER BY wr_id
                DESC ";
//                LIMIT $offset, $limit";
        }

        // Order by Member is mb_no and board is wr_id
        $result = $this->db->queryList($sql);
        if ($result == null) {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 실패했습니다.");
            $this->api->setEntity([]);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 성공하였습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function getFileList($table) {
        $wr_id = $_REQUEST[wr_id];

        // Order by Member is mb_no and board is wr_id
        $result = $this->_getFileList($table, $wr_id);
        if ($result == null) {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 실패했습니다.");
            $this->api->setEntity([]);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("조회에 성공하였습니다.");
            $this->api->setEntity($result);
        }

        return $this->api;
    }

    function _getFileList($table, $wr_id) {
        $sql = "SELECT * 
                FROM g5_board_file
                WHERE wr_id = $wr_id AND bo_table = '$table'";
        $result = $this->db->queryList($sql);
        return $result;
    }

    function getComment($table, $wr_id, $offset, $limit) {
        if ($wr_id == "") {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("wr_id를 확인해주세요.");
            return $this->api;
        }
        if (!isset($offset)) {
            $offset = 0;
        }
        if (!isset($limit)) {
            $limit = 1000;
        }

        $sql = "SELECT * 
                FROM g5_write_$table
                WHERE wr_is_comment = 1 AND wr_parent = $wr_id
                ORDER BY wr_comment ASC, wr_comment_reply ASC
                LIMIT $offset, $limit";

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

    function getInfo() {
        $table = $_REQUEST["bo_table"];
        $wr_id = $_REQUEST["wr_id"];
        if ($table == null || $wr_id == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("파라미터를 확인해주세요.");
            $this->api->setEntity("");

            return $this->api;
        }
        $this->db->sql_query("UPDATE g5_write_$table set wr_hit = wr_hit + 1 where wr_id = '{$wr_id}' ");
        $sql =  "Select * From g5_write_$table WHERE wr_id = '{$wr_id}'";
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

    function delete() {
        $table = $_REQUEST["bo_table"];
        $wr_id = $_REQUEST["wr_id"];
        if (!$table || !$wr_id) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("파라미터를 확인해주세요.");
            $this->api->setEntity("");

            return $this->api;
        }

        $sql = "DELETE FROM g5_write_$table WHERE wr_id = $wr_id";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("삭제에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("삭제에 성공하였습니다.");
            $this->api->setEntity($sql);
        }

        return $this->api;
    }

    function answer() {
        $bo_table = $_REQUEST["bo_table"]; // 제목
        $wr_id = $_REQUEST["wr_id"];
        $wr_10 = $_REQUEST["wr_10"]; // 내용

        $sql = " UPDATE g5_write_$bo_table
                set wr_10 = '$wr_10'
                     WHERE wr_id = $wr_id";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("답변에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("답변에 성공하였습니다.");
            $this->api->setEntity($sql);
        }

        return $this->api;
    }

    // 만약 댓글을 달리면 게시물 유저에게 알림
    // 만약 대댓글 달리면 댓글 유저에게 알림
    function comment() {
        $bo_table = $_REQUEST["bo_table"]; // 제목
        $wr_parent = $_REQUEST["wr_parent"]; // 본문 글의 wr_id
        $wr_num = $_REQUEST["wr_num"]; // 본문 게시물의 wr_num 본문과 댓글의 값이 같음
        $wr_content = $_REQUEST["wr_content"]; // 내용
        $mb_id = $_REQUEST["mb_id"]; // 작성자
        $wr_comment = $_REQUEST["wr_comment"]; // 댓글 순서 및 자식 순서
        $is_anonymous = $_REQUEST["is_anonymous"]; // 익명 여부
        $current_date = date('Y-m-d H:i:s', time()); // 작성일
        $wr_name = $_REQUEST["wr_name"]; // 이름
        // wr_comment 가 있으면 기존 댓글에 댓글 다는 것.
        if ($wr_comment) {
            $sql = " select wr_id, mb_id, wr_parent, wr_comment, wr_comment_reply, wr_name from g5_write_$bo_table where wr_id = '$wr_comment' ";
            $reply_array = $this->db->sql_fetch($sql);
            if (!$reply_array['wr_id']) {
                $this->api->setCode(RPC_QUERY_ERROR);
                $this->api->setMessage("답변할 댓글이 없습니다.\\n\\n답변하는 동안 댓글이 삭제되었을 수 있습니다.");
                $this->api->setEntity($sql);
                return $this->api;
            }

            // 기존 댓글 wr_comment
            $tmp_comment = $reply_array['wr_comment'];

            //대댓글 내글반응
            $as_re_mb = $reply_array['mb_id']; // 기존 댓글 회원의 id
            $as_re_name = $reply_array['wr_name']; // 기존 댓글 회원의 닉네임
            $as_re_cnt = strlen($reply_array['wr_comment_reply']); // 댓글의 포인터 A, AA, CA

            $this->app->response($mb_id, $wr_name, $as_re_mb, $as_re_name, PUSH_TYPE_RE_COMMENT, $bo_table, $wr_parent);

            // 스택이 5개 이상이면 금지
            if ($as_re_cnt == 3) {
                $this->api->setCode(RPC_QUERY_ERROR);
                $this->api->setMessage("더 이상 답변하실 수 없습니다.\\n\\n답변은 5단계 까지만 가능합니다.");
                $this->api->setEntity($sql);
                return $this->api;
            }

            $reply_len = $as_re_cnt + 1;
            $begin_reply_char = 'A';
            $end_reply_char = 'Z';
            $reply_number = +1;
            $sql = " select MAX(SUBSTRING(wr_comment_reply, $reply_len, 1)) as reply
                        from g5_write_$bo_table
                        where wr_parent = '$wr_parent'
                        and wr_comment = '$tmp_comment'
                        and SUBSTRING(wr_comment_reply, $reply_len, 1) <> '' ";

            if ($reply_array['wr_comment_reply'])
                $sql .= " and wr_comment_reply like '{$reply_array['wr_comment_reply']}%' ";
            $row = $this->db->sql_fetch($sql);

            if (!$row['reply'])
                $reply_char = $begin_reply_char;
            else if ($row['reply'] == $end_reply_char)  { // A~Z은 26 입니다.
                $this->api->setCode(RPC_QUERY_ERROR);
                $this->api->setMessage("더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.");
                $this->api->setEntity($sql);
                return $this->api;
            }
            else
                $reply_char = chr(ord($row['reply']) + $reply_number);

            $tmp_comment_reply = $reply_array['wr_comment_reply'] . $reply_char;
        }
        else
        {
            $sql = " select max(wr_comment) as max_comment from g5_write_$bo_table
                    where wr_parent = '$wr_parent' and wr_is_comment = 1 ";
            $row = $this->db->sql_fetch($sql);

            $board_info = $this->get_board($bo_table, $wr_parent);
            $this->app->response($mb_id, $wr_name, $board_info["mb_id"], $board_info["wr_name"], PUSH_TYPE_COMMENT, $bo_table, $wr_parent);
            //$row[max_comment] -= 1;
            $row['max_comment'] += 1;
            $tmp_comment = $row['max_comment'];
            $tmp_comment_reply = '';
        }

        $sql = " insert into g5_write_$bo_table
                set wr_num = '{$wr_num}',
                     wr_reply = '',
                     wr_parent = '$wr_parent',
                     wr_name = '$wr_name',
                     wr_is_comment = 1,
                     wr_comment = '$tmp_comment',
                     wr_comment_reply = '$tmp_comment_reply',
                     wr_subject = '',
                     wr_content = '$wr_content',
                     mb_id = '$mb_id',
                     as_update = '".$current_date."',
                     wr_datetime = '".$current_date."',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}',
                     wr_last = '',
                     is_anonymous = '$is_anonymous' ";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("댓글 작성에 실패했습니다.");
            $this->api->setEntity($sql);
            return $this->api;
        }

        $last_id = $this->db->get_last_id();
        $push_type = PUSH_TYPE_NEW;
        $result = $this->app->response("epu", "epu", "user", "user", $push_type, $bo_table, $last_id);
        if ($result != null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage($result);
            $this->api->setEntity($result);
            return $this->api;
        }

        // 원글에 댓글수 증가 & 마지막 시간 반영
        $result = $this->db->sql_query(" update g5_write_$bo_table set wr_comment = wr_comment + 1, wr_last = '".$current_date."' where wr_id = '$wr_parent' ");
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("댓글 수 증가 및 마지막 시간 반영에 실패했습니다.");
            $this->api->setEntity($sql);
            return $this->api;
        }
        // 댓글 1 증가
        $result = $this->db->sql_query(" update g5_board set bo_count_comment = bo_count_comment + 1 where bo_table = '$bo_table' ");
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("댓글 1 증가에 실패했습니다.");
            $this->api->setEntity($sql);
            return $this->api;
        }
        // APMS : 내글반응 등록

        $this->api->setCode(RPC_SUCCESS);
        $this->api->setMessage("댓글 작성에 성공하였습니다.");
        $this->api->setEntity($sql);

        return $this->api;
    }

    function modifyComment() {
        $bo_table = $_REQUEST["bo_table"]; // 제목
        $wr_id = $_REQUEST["wr_id"];
        $wr_content = $_REQUEST["wr_content"]; // 내용

        $sql = " UPDATE g5_write_$bo_table
                set wr_content = '$wr_content'
                     WHERE wr_id = $wr_id";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("댓글 수정에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("댓글 수정에 성공하였습니다.");
            $this->api->setEntity($sql);
        }

        return $this->api;
    }

    function deleteComment() {
        $bo_table = $_REQUEST["bo_table"]; // 제목
        $wr_id = $_REQUEST["wr_id"];

        $sql = " UPDATE g5_write_$bo_table
                set wr_content = '삭제된 댓글입니다.',
                    wr_name = '(삭제)',
                    mb_id = 'delete'
                     WHERE wr_id = $wr_id";
        $result = $this->db->sql_query($sql);
        if ($result == null) {
            $this->api->setCode(RPC_QUERY_ERROR);
            $this->api->setMessage("댓글 삭제에 실패했습니다.");
            $this->api->setEntity($sql);
        } else {
            $this->api->setCode(RPC_SUCCESS);
            $this->api->setMessage("댓글 삭제에 성공하였습니다.");
            $this->api->setEntity($sql);
        }

        return $this->api;
    }

    function blind() {

    }

    // 게시판의 다음글 번호를 얻는다.
    function get_next_num($table)
    {
        // 가장 작은 번호를 얻어
        $sql = " select max(wr_num) as min_wr_num from $table ";
        $row = $this->db->sql_fetch($sql);
        // 가장 작은 번호에 1을 빼서 넘겨줌
        return (int)($row['min_wr_num'] + 1);
    }


    function write() {
        $bo_table = $_REQUEST["bo_table"];
        $wr_subject = $_REQUEST["wr_subject"];
        $wr_reply = $_REQUEST["wr_reply"];
        $wr_content = $_REQUEST["wr_content"];
        $wr_address = $_REQUEST["wr_address"];
        $ca_name = $_REQUEST["ca_name"];
        $wr_x = $_REQUEST["wr_x"];
        $wr_y = $_REQUEST["wr_y"];
        $wr_dday = $_REQUEST["wr_dday"];
        $wr_startDate = $_REQUEST["wr_startDate"];
        $wr_endDate = $_REQUEST["wr_endDate"];
        $wr_cancel = $_REQUEST["wr_cancel"];
        $wr_complete = $_REQUEST["wr_complete"];
        $mb_id = $_REQUEST["mb_id"];
        $wr_1 = $_REQUEST["wr_1"];
        $wr_2 = $_REQUEST["wr_2"];
        $wr_3 = $_REQUEST["wr_3"];
        $wr_4 = $_REQUEST["wr_4"];
        $wr_5 = $_REQUEST["wr_5"];
        $wr_6 = $_REQUEST["wr_6"];
        $wr_7 = $_REQUEST["wr_7"];
        $wr_8 = $_REQUEST["wr_8"];
        $wr_9 = $_REQUEST["wr_9"];
        $wr_10 = $_REQUEST["wr_10"];
        $img_list = $_REQUEST["img_list"];
        $img_1 = $_REQUEST["img_1"];
        $img_2 = $_REQUEST["img_2"];
        $img_3 = $_REQUEST["img_3"];
        $img_4 = $_REQUEST["img_4"];
        $img_5 = $_REQUEST["img_5"];
        $img_6 = $_REQUEST["img_6"];
        $img_7 = $_REQUEST["img_7"];
        $img_8 = $_REQUEST["img_8"];
        $img_9 = $_REQUEST["img_9"];
        $img_10 = $_REQUEST["img_10"];
        $current_date = date('Y-m-d H:i:s', time());

        if (!$bo_table) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("테이블을 입력하세요.");
        }
        else if (!$wr_subject) {
            $this->api->setCode(RPC_PARAM_ERROR);
            $this->api->setMessage("테이블을 입력하세요.");
        } else {
            $wr_num = $this->get_next_num("g5_write_$bo_table");

            $sql = " insert into g5_write_$bo_table
                set wr_num = '$wr_num',
                     wr_reply = '$wr_reply',
                     wr_comment = 0,
                     ca_name = '$ca_name',
                     wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     wr_link1_hit = 0,
                     wr_link2_hit = 0,
                     wr_hit = 0,
                     wr_good = 0,
                     wr_nogood = 0,
                     mb_id = '$mb_id',
                     wr_datetime = '$current_date',
                     wr_last = '$current_date',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}', 
					 wr_1 = '$wr_1',
                     wr_2 = '$wr_2',
                     wr_3 = '$wr_3',
                     wr_4 = '$wr_4',
                     wr_5 = '$wr_5',
                     wr_6 = '$wr_6',
                     wr_7 = '$wr_7',
                     wr_8 = '$wr_8',
                     wr_9 = '$wr_9',
                     wr_10 = '$wr_10',
                     img_list = '$img_list',
                     img_1 = '$img_1',
                     img_2 = '$img_2',
                     img_3 = '$img_3',
                     img_4 = '$img_4',
                     img_5 = '$img_5',
                     img_6 = '$img_6',
                     img_7 = '$img_7',
                     img_8 = '$img_8',
                     img_9 = '$img_9',
                     img_10 = '$img_10',
                     wr_address = '$wr_address',
                     wr_x = '$wr_x',
                     wr_y = '$wr_y',
                     wr_dday = '$wr_dday',
                     wr_startDate = '$wr_startDate',
                     wr_endDate = '$wr_endDate',
                     wr_cancel = '$wr_cancel',
                     wr_complete = '$wr_complete' ";
            $result = $this->db->sql_query($sql);
            $result = $this->db->sql_query("update g5_board set bo_count_write = bo_count_write + 1 where bo_table = '{$bo_table}'");


            if ($result == null) {
                $this->api->setCode(RPC_QUERY_ERROR);
                $this->api->setMessage("작성에 실패했습니다.");
                $this->api->setEntity($sql);
            } else {
                $this->api->setCode(RPC_SUCCESS);
                $this->api->setMessage("작성에 성공하였습니다.");
                $this->api->setEntity($sql);
            }
        }

        return $this->api;
    }

    // 회원 정보를 얻는다.
    function get_board($table, $wr_id)
    {
        $sql =  "Select * From g5_write_$table WHERE wr_id = '{$wr_id}'AND wr_is_comment = 0";
        $result = $this->db->sql_fetch($sql);
        return $result;
    }
}

?>