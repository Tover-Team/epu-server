<style>


    .txtNrBold {
        font-family: NR_BOLD;
        font-weight: 600
    }

    .txtUserInfo {
        float: right;
        color: #fff;
        margin-right: 10px;
        margin-top: 7px;
    }

    .viewDetail1 {
        float:left;
        margin-top: 20px;
        padding-left: 40px;
        text-align: center;
        width: 74%;
    }

    .ins_ta ins_license, .ins_ta #ins_license{
        width: 80%;
        height: 400px;
    }

    .ins_agree label {
        font-size: 40px;
    }

    #agree{
        margin-top: 20px;
        padding: 10px;
    }

    .cell_content{
        width:100%;
        height: 50px;
        margin-top: 4px;
        text-align: center;
    }

    .cell_header_content{
        border: 1px solid #cccccc;
        background: #fff;
        width:100%;
        margin-left: 10px;
        height: 100px;
        line-height: 100px;
        vertical-align: middle;

        display:inline-block;
        vertical-align: middle;
        color: #252525;
    }

    .cell_header_content img{
        margin-top: 20px;
        width: 60px;
        height: 60px;
    }


    .cell_header{
        border: 1px solid #cccccc;
        background: #00a65a;
        width:100%;
        margin-left: 10px;
        height: 50px;
        line-height: 50px;
        display:inline-block;
        vertical-align: middle;
        color: #ffffff;
    }


    .cell_content_header{
        border: 1px solid #cccccc;
        background: #fff;
        width:100%;
        margin-left: 10px;
        height: 50px;
        line-height: 50px;
        display:inline-block;
        vertical-align: middle;
        color: #252525;
    }

    .cell_block{
        border: 1px solid #cccccc;
        background: #fff;
        width:100%;
        margin-left: 10px;
        height: 50px;
        line-height: 50px;
        display:inline-block;
        vertical-align: middle;
    }

    .cell_deviceID{
        float: left; width: 25%;
    }

    .cell_50{
        float: left; width: 49%;
    }

    .cell_storeID{
        float: left; width: 15%;
    }

    .doob_top_button{
        background:#fff;width: 120px;height: 45px;line-height: 45px;text-align:center;border: 1px solid #dcdcdc
    }



    .cell_reqDate{
        float: left; width: 15%;
    }

    clear{
        clear:both;
    }

    #txtmessage{
        width: 100%;
        height: 500px;
    }

    #txt_url{
        width: 100%;
        height: 100px;
    }

    .foot_content{
        width:100%;
        height: 50px;
        margin-top: 4px;
        text-align: center;
    }

    .foot_block{
        width:100%;
        margin-left: 10px;
        height: 50px;
        line-height: 50px;
        vertical-align: middle;
        display:inline-block;
    }


    .foot_next{
        border: 1px solid #cccccc;
        background: #fff;
        float: left; width: 23%;
    }

    .foot_center{
        border: 1px solid #cccccc;
        background: #fff;
        margin-left: 1%;
        margin-right: 1%;
        float: left; width: 52%;
    }

    .foot_pre{
        border: 1px solid #cccccc;
        background: #fff;
        float: left; width: 23%;
    }

    .push_subject{
        width:100%;
        height: 50px;
        background: #00a65a;
        color:#fff;
        margin-bottom: 10px;
        line-height: 50px;
        vertical-align: middle;
        display:inline-block;
    }

    .push_button{
        width:100%;
        height: 50px;
        background: #fff;
        border: 1px solid #dcdcdc;
        color:#000;
        line-height: 50px;
        vertical-align: middle;
        display:inline-block;
    }

    .license_content{
        width:100%;
        height: 400px;
        line-height: 400px;
        font-size: 20px;
        background: #fff;
        font-family: NR;
        border: 1px solid #dcdcdc;
    }

    c{
        color:#00a65a;
    }
</style>

<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>

    function call2() {
        if(confirm("한번 투표를 중지하면 재 시작하실 수 없습니다.")) {
            var url = g5_url;
            var subject = "";
            var content = "ㄷㄷㄷㄱㄷㄱㄷ";
            jQuery.ajax({
                url: url+"/api/board/",
                type: "POST",
                data: {
                    "api_name": "getInfo",
                    "bo_table": "vote",
                    "wr_id": "12"
                },
                dataType: "json",
                async: false,
                cache: false,
                success: function(data) {
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

                    alert("success message: " + entity.wr_name);
                },
                complete : function(data) {
                    // alert("complete:");
                },
                error: function(data) {
                    try {
                        alert("fail: ".data.error)
                        // console.log(data)
                    } catch (e) {
                        alert("fail: ".data.error)
                    };
                }
            });
        }


        return true;
    }
</script>





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

<div style="height: 45px;width: 100%">
    <a href="<?php echo $list_href ?>">
        <div class="doob_top_button" style="float: left">
            목록보기
        </div>
    </a>
    <a href="<?php echo $update_href ?>">
        <div class="doob_top_button" style="float: left">
            수정
        </div>
    </a>
    <a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;">
        <div class="doob_top_button" style="float: left">
            삭제
        </div>
    </a>
    <div class="doob_top_button" onclick="call2();" style="float: left">
             투표중지
    </div>
    <?php
    $mb_id = $_REQUEST['mb_id'];
    $mb = get_member($mb_id);
    if ($mb[mb_1]  == "2") {

        ?>
        <div class="doob_top_button" style="float: left" onclick="goPage('가입을 승인하시겠습니까?','<?php echo $mb_id; ?>',3)">
            심사승인
        </div>
        <div class="doob_top_button" style="float: left" onclick="goPage('가입을 거절하시겠습니까?','<?php echo $mb_id; ?>',-1)">
            심사거절
        </div>
        <?php
    }else if($mb[mb_1] > 2){
        ?>
        <div class="doob_top_button" style="float: left" onclick="goPageGrade('등급을 변경하시곘습니까?','<?php echo $mb_id; ?>',-1)">
            권한박탈
        </div>
        <div class="doob_top_button" style="float: left" onclick="goPageGrade('등급을 변경하시곘습니까?','<?php echo $mb_id; ?>',1)">
            1등급설정
        </div>
        <div class="doob_top_button" style="float: left" onclick="goPageGrade('등급을 변경하시곘습니까?','<?php echo $mb_id; ?>',2)">
            2등급설정
        </div>
        <div class="doob_top_button" style="float: left" onclick="goPageGrade('등급을 변경하시곘습니까?','<?php echo $mb_id; ?>',3)">
            3등급설정
        </div>
        <div class="doob_top_button" style="float: left" onclick="goPageGrade('등급을 변경하시곘습니까?','<?php echo $mb_id; ?>',4)">
            4등급설정
        </div>
        <div class="doob_top_button" style="float: left" onclick="goPageGrade('등급을 변경하시곘습니까?','<?php echo $mb_id; ?>',5)">
            5등급설정
        </div>
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
            switch ($view['wr_1']) {
                case "1":
                    echo "전체";
                    break;
                case "2":
                    echo "집행부";
                    break;
                case "3":
                    echo "대의원";
                    break;
                case "4":
                    echo "집행부 + 대의원";
                    break;
                default:
                    echo "미정";
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
for ($i=0; $i < $count; $i++) {
    ?>
    <div class="cell_content">
        <div class="cell_block">
            <div class="cell_deviceID">
                <?php
                echo ($i+1); ?>
            </div>
            <div class="cell_50">
                <?php
                $key = "wr_".($i+5);
                if ($view[$key]) {
                    echo substr($view[$key], 0, 30);
                } else {
                    echo "미입력";
                } ?>
            </div>
            <div class="cell_deviceID">
                <?php
                if ($mb[mb_4]) {
                    echo substr($mb[mb_4], 0, 30);
                } else {
                    echo "미가입";
                } ?>
            </div>
        </div>
    </div>

    <?php
}
?>

