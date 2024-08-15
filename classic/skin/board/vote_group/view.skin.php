<style>
    .ins_ta ins_license, .ins_ta #ins_license {
        width: 80%;
        height: 400px;
    }

    .ins_agree label {
        font-size: 40px;
    }

    .cell_content {
        width: 100%;
        height: 50px;
        margin-top: 4px;
        text-align: center;
    }

    .cell_header_content img {
        margin-top: 20px;
        width: 60px;
        height: 60px;
    }

    .cell_block {
        border: 1px solid #cccccc;
        background: #fff;
        width: 100%;
        margin-left: 10px;
        height: 50px;
        line-height: 50px;
        display: inline-block;
        vertical-align: middle;
    }

    .cell_deviceID {
        float: left;
        width: 25%;
    }

    .cell_50 {
        float: left;
        width: 49%;
    }

    .doob_top_button {
        background: #fff;
        width: 120px;
        height: 45px;
        line-height: 45px;
        text-align: center;
        border: 1px solid #dcdcdc
    }

    clear {
        clear: both;
    }

    c {
        color: #00a65a;
    }
</style>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
    function showVotePopup() {
        $('#vote_subject').val("<?php echo $view['wr_subject'] ?>");
        $('#vote_wr_1').val("<?php echo $view['wr_5'] ?>");
        $('#vote_wr_2').val("<?php echo $view['wr_6'] ?>");
        $('#vote_wr_3').val("<?php echo $view['wr_7'] ?>");
        $('#vote_wr_4').val("<?php echo $view['wr_8'] ?>");
        $('#vote_wr_5').val("<?php echo $view['wr_9'] ?>");
        $("#accountModal").modal();
    }

    function updateSubVote() {
        var subject = $('#vote_subject').val();
        var wr_1 = $('#vote_wr_1').val();
        var wr_2 = $('#vote_wr_2').val();
        var wr_3 = $('#vote_wr_3').val();
        var wr_4 = $('#vote_wr_4').val();
        var wr_5 = $('#vote_wr_5').val();
        var wr_id = <?php echo $view['wr_id'] ?>;

        if (confirm("수정하시겠습니까?")) {
            var url = '<?php echo G5_URL . "/api/vote/"?>';
            jQuery.ajax({
                url: url,
                type: "POST",
                data: {
                    "api_name": "updateSubVote",
                    "wr_id": wr_id,
                    "subject": subject,
                    "wr_1": wr_1,
                    "wr_2": wr_2,
                    "wr_3": wr_3,
                    "wr_4": wr_4,
                    "wr_5": wr_5
                },
                dataType: "json",
                async: false,
                cache: false,
                success: function (data) {
                    var entity = data.entity;
                    if (entity == null) {
                        return;
                    }
                    var code = data.code;
                    var message = data.message;
                    var entity = data.entity;
                    if (code != 1) {
                        alert(message);
                        return;
                    }
                    alert("투표가 수정됐습니다.");
                    location.reload();
                },
                complete: function (data) {
                    //alert("complete:");
                },
                error: function (data) {
                    try {
                        alert("fail: ".data)
                        // console.log(data)
                    } catch (e) {
                        alert("fail: ".data)
                    }
                    ;
                }
            });
        }
        return true;
    }


    function deleteSubVote(wr_id) {
        if (confirm("삭제하시겠습니까? 복구가 불가능합니다.")) {
            var url = '<?php echo G5_URL . "/api/vote/"?>';
            jQuery.ajax({
                url: url,
                type: "POST",
                data: {
                    "api_name": "deleteSubVote",
                    "wr_id": wr_id
                },
                dataType: "json",
                async: false,
                cache: false,
                success: function (data) {
                    var entity = data.entity;
                    if (entity == null) {
                        return;
                    }
                    var code = data.code;
                    var message = data.message;
                    var entity = data.entity;
                    if (code != 1) {
                        alert(message);
                        return;
                    }
                    alert("투표가 삭제됐습니다.");
                },
                complete: function (data) {
                    //alert("complete:");
                },
                error: function (data) {
                    try {
                        alert("fail: ".data)
                        // console.log(data)
                    } catch (e) {
                        alert("fail: ".data)
                    }
                    ;
                }
            });
        }
        return true;
    }
</script>

<script src="../../../js/view.js"></script>
<div class="modal" id="accountModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 600px; left: -200px; top: 200px">
            <div class="modal-body">
                <form>
                    <h2>투표 수정</h2>
                    <input style="display: none" id="vote_wr_id">
                    <div class="input-group mb-3">
                        제목 <input style="font-size: 17px;" type="text" class="form-control" id="vote_subject"
                                  placeholder="제목 입력하세요." required>
                    </div>
                    <div class="input-group mb-3">
                        항목1 <input style="font-size: 17px;" type="text" class="form-control" id="vote_wr_1"
                                   placeholder="항목1 입력하세요." required>
                    </div>
                    <div class="input-group mb-3">
                        항목2 <input style="font-size: 17px;" type="text" class="form-control" id="vote_wr_2"
                                   placeholder="항목2 입력하세요." required>
                    </div>
                    <div class="input-group mb-3">
                        항목3 <input style="font-size: 17px;" type="text" class="form-control" id="vote_wr_3"
                                   placeholder="항목3 입력하세요.">
                    </div>
                    <div class="input-group mb-3">
                        항목4 <input style="font-size: 17px;" type="text" class="form-control" id="vote_wr_4"
                                   placeholder="항목4 입력하세요.">
                    </div>
                    <div class="input-group mb-3">
                        항목5 <input style="font-size: 17px;" type="text" class="form-control" id="vote_wr_5"
                                   placeholder="항목5 입력하세요.">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" onclick="updateSubVote()">수정하기</button>
                <button type="button" class="btn" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="listModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 600px; left: -200px; top: 200px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <button type="button" onclick="printIt(document.getElementById('printme').innerHTML)">인쇄</button>
            </div>
            <div class="modal-body" id="printme" style="width: 100%;">
                <table class="table table-hover" style="width: 100%; background: #ffffff;border: 1px solid #ddd">
                    <thead style="background: #5A5A5A;color: #ffffff">
                    <tr style="width: 100%;">
                        <th scope="col" style="text-align: center;width: 20%; line-height: 40px; height: 40px;">번호</th>
                        <th scope="col" style="text-align: center;width: 25%; line-height: 40px; height: 40px;">사번</th>
                        <th scope="col" style="text-align: center;width: 25%; line-height: 40px; height: 40px;">이름</th>
                        <th scope="col" style="text-align: center;width: 30%; line-height: 40px; height: 40px;">투표일</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $get_sql = "SELECT * 
                FROM g5_write_vote_member
                WHERE wr_subject = '{$view['wr_id']}'
                ORDER BY wr_id
                DESC ";
                    $result = sql_query($get_sql);
                    $i = 1;
                    while ($row = sql_fetch_array($result)) {
                        $mb = get_member($row['mb_id']);
                        ?>
                        <tr style="width: 100%;">

                            <td scope="col"
                                style="text-align: center;width: 20%; line-height: 40px; height: 40px;"><?= $i ?></td>
                            <td scope="col"
                                style="text-align: center;width: 25%; line-height: 40px; height: 40px;"><?php
                                if (!$mb['mb_id']) {
                                    echo $row['mb_id'];
                                } else {
                                    echo $mb['mb_id'];
                                }
                                ?></td>
                            <td scope="col"
                                style="text-align: center;width: 25%;line-height: 40px; height: 40px;"><?php
                                if (!$mb['mb_name']) {
                                    echo "탈퇴자";
                                } else {
                                    echo $mb['mb_name'];
                                }

                                ?></td>
                            <td scope="col"
                                style="text-align: center;width: 30%;line-height: 40px; height: 40px;"><?= $row['wr_datetime'] ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">


    function goPage(message, mb_id, state) {

        if (confirm(message) == true) {    //확인
            location.href = "<?php echo G5_URL;?>/page/user/user_update.php?mb_id=" + mb_id + "&state=" + state;
            first = true;
        } else {   //취소
            return;
        }
    }

    function goPageGrade(message, mb_id, state) {
        if (confirm(message) == true) {    //확인
            location.href = "<?php echo G5_URL;?>/page/user/user_update_grade.php?mb_id=" + mb_id + "&state=" + state;
            first = true;
        } else {   //취소
            return;
        }
    }
</script>

<?php
$list_href = str_replace("board.php", "vote.php", $list_href);
$list_href = str_replace("vote_group", "vote", $list_href);
$update_href = str_replace("write.php", "vote_write.php", $update_href);
?>

<div style="height: 45px;width: 100%">
    <button class="doob_top_button" style="float: left" onclick="showVotePopup();">
        수정
    </button>
    <button class="doob_top_button" style="float: left" onclick="deleteSubVote('<?php echo $view['wr_id'] ?>');">
        삭제
    </button>
    <?php
    $now = date("Y-m-d");
    $end_date = $view['wr_endDate'];
    $str_now = strtotime($now);
    $str_target = strtotime($end_date);
    // 오늘이 일정을 지났다면
    $isOngoing = $view['wr_2'] == "-1" || ($view['wr_2'] == "1" && $str_now <= $str_target);
    if ($isOngoing) {
        ?>
        <a href="#" onclick="$('#listModal').modal(); return false;">
            <div class="doob_top_button" style="float: left">
                투표자 목록
            </div>
        </a>
        <?php
    }
    ?>
</div>


<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


$conn = mysqli_connect(G5_MYSQL_HOST, G5_MYSQL_USER, G5_MYSQL_PASSWORD, G5_MYSQL_DB);
$sql = "SELECT COUNT(*) FROM g5_member";
mysqli_set_charset($conn, 'utf8');
$result = mysqli_query($conn, $sql);

function _getVoteCount($wr_id, $num)
{
    $s = " select count(*) as cnt from g5_write_vote_member where wr_subject = '{$wr_id}' and wr_content = '{$num}' ";
    $r = sql_fetch($s);
    return $r['cnt'];
}

$countRow = sql_fetch("SELECT COUNT(*) as cnt FROM g5_member WHERE mb_10 != '1' AND mb_2 != '노무사' AND mb_grade != '6'");
$totalCount = $countRow['cnt'];
function getVoteRatio($total, $count)
{
    if ($total <= 0 || $count <= 0) {
        return "0.0";
    } else {
        $ra = ($count / ($total / 10)) * 10;
        $string = sprintf('%0.2f', $ra);
        return $string;
    }
}

$count = 0;
if ($view['wr_5'] != "") {
    $count += 1;
}
if ($view['wr_6'] != "") {
    $count += 1;
}
if ($view['wr_7'] != "") {
    $count += 1;
}
if ($view['wr_8'] != "") {
    $count += 1;
}
if ($view['wr_9'] != "") {
    $count += 1;
}
if ($view['wr_10'] != "") {
    $count += 1;
}
if ($view['wr_11'] != "") {
    $count += 1;
}
if ($view['wr_12'] != "") {
    $count += 1;
}
if ($view['wr_13'] != "") {
    $count += 1;
}
if ($view['wr_14'] != "") {
    $count += 1;
}
if ($view['wr_15'] != "") {
    $count += 1;
}
if ($view['wr_16'] != "") {
    $count += 1;
}
if ($view['wr_17'] != "") {
    $count += 1;
}
if ($view['wr_18'] != "") {
    $count += 1;
}
if ($view['wr_19'] != "") {
    $count += 1;
}
if ($view['wr_20'] != "") {
    $count += 1;
}
if ($view['wr_21'] != "") {
    $count += 1;
}
if ($view['wr_22'] != "") {
    $count += 1;
}
if ($view['wr_23'] != "") {
    $count += 1;
}
if ($view['wr_24'] != "") {
    $count += 1;
}

$voters = 0;
for ($i = 0; $i < $count; $i++) {
    $voters = $voters + (_getVoteCount($view['wr_id'], $i + 1) * 1);
}
?>
<!--<div style="margin-top: 10px">-->
<!--    <div style="width: 300px;height:50px;background: #5a5a5a; color:white;font-weight: 600;text-align: center;line-height: 50px;float: left">-->
<!--        사업자 등록증-->
<!--    </div>-->
<!--    <div style="margin-left:5px;width: 300px;height:50px;background: #5a5a5a; color:white;font-weight: 600;text-align: center;line-height: 50px;float: left">-->
<!--        주민등록증(앞면)-->
<!--    </div>-->
<!---->
<!--</div>-->
<!--<div style="clear:both;">-->
<!--    <img src="--><?php //echo G5_URL . "/bbs/" . $mb[mb_6]; ?><!--" style="width: 300px;height: 200px;overflow: hidden;"/>-->
<!--    <img src="--><?php //echo G5_URL . "/bbs/" . $mb[mb_7]; ?><!--" style="width: 300px;height: 200px;overflow: hidden"/>-->
<!---->
<!--</div>-->


<div class="cell_content">


    <div class="cell_block" style="background: #5a5a5a; color:white;font-weight: 600">
        <div class="cell_deviceID">
            투표 주제
        </div>
        <div class="cell_deviceID">
            투표 그룹
        </div>
        <div class="cell_deviceID">
            시작일
        </div>
        <div class="cell_deviceID">
            종료일
        </div>
    </div>
</div>
<div>
</div>


<div class="cell_content">

    <div class="cell_block">
        <div class="cell_deviceID">
            <?php echo substr($view['subject'], 0, 30); ?>
        </div>
        <div class="cell_deviceID">
            <?php

            function getVoteStatics($totalCount, $c) {
                $ratio = getVoteRatio($totalCount, $c);
                return "{$totalCount}명 중 {$c}명 {$ratio}% 참여";
            }

            $statics = getVoteStatics($totalCount, $voters);

            switch ($view['wr_1']) {
                case "1":
                    echo "전체 ({$statics})";
                    break;
                case "2":
                    echo "집행부 ({$statics})";
                    break;
                case "3":
                    echo "대의원 ({$statics})";
                    break;
                case "4":
                    echo "집행부 + 대의원 ({$statics})";
                    break;
                default:
                    echo "미정 ({$statics})";
                    break;
            }
            ?>
        </div>
        <div class="cell_deviceID">
            <?php echo substr($view['startDate'], 0, 30); ?>
        </div>
        <div class="cell_deviceID">
            <?php echo substr($view['endDate'], 0, 30); ?>
        </div>
    </div>
</div>


<div class="cell_content">
    <div class="cell_block" style="background: #5a5a5a; color:white;font-weight: 600">
        <div class="cell_deviceID">
            번호
        </div>
        <div class="cell_50">
            내용
        </div>
        <div class="cell_deviceID">
            투표 수
        </div>
    </div>
</div>
<div>
</div>

<?php


for ($i = 0; $i < $count; $i++) {
    $key = "wr_" . ($i + 5);
    $c = _getVoteCount($view['wr_id'], $i + 1)
    ?>
    <div class="cell_content">
        <div class="cell_block">
            <div class="cell_deviceID">
                <?php
                echo($i + 1); ?>
            </div>
            <div class="cell_50">
                <?php
                if ($view[$key]) {
                    echo substr($view[$key], 0, 30);
                } else {
                    echo "미입력";
                } ?>
            </div>
            <div class="cell_deviceID">
                <?php
                $ratio = getVoteRatio($voters, $c);
                echo "{$c}표 {$ratio}%";
                ?>
            </div>
        </div>
    </div>

    <?php
}
?>

