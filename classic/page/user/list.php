<script type="text/javascript">

    function searchID(){

        <?php

        $http_host = $_SERVER['HTTP_HOST'];
        $request_uri = $_SERVER['REQUEST_URI'];
        $url = 'http://' . $http_host . $request_uri;

        ?>
        var text2 = $('#txtValue').val();

        // if(!text2){
        //     alert("검색어를 입력해주세요");
        //     return;
        // }

        window.location.href="<?php echo $url;?>&mb_id="+text2;
    }

    function  openPopup(url) {
        // window.open(url, "","width=400,height=400,left=600");
        $("#accountModal").modal();
    }

    // function addUser() {
    //
    //
    //     window.opener.location.reload();
    //     window.close();
    //
    //     // opener.document.location.reload();
    //     // self.close();
    // }

    function addUser() {
        var mb_id = $('#mb_id').val();
        var mb_name = $('#mb_name').val();
        var mb_nick = $('#mb_name').val();
        var mb_2 = $('#mb_2').val();
        var mb_grade = $('#mb_grade').val();
        if (mb_id=="") {
            alert("사번을 입력해주세요.")
            return;
        }
        if (mb_name=="") {
            alert("이름을 입력해주세요.")
            return;
        }
        if (mb_2=="") {
            alert("직위를 입력해주세요.")
            return;
        }
        if (mb_grade=="") {
            alert("직책을 입력해주세요.")
            return;
        }

        if (confirm("새로운 유저를 추가하시겠습니까?") == true){
            var url = '<?php echo G5_URL."/api/user"?>';
           $.ajax({
               type : 'get',
               url : url,
               data :{
                   "api_name" : 'addUser',
                   "mb_password" : 'abc123',
                   "mb_id" : mb_id,
                   "mb_name" : mb_name,
                   "mb_nick" : mb_nick,
                   "mb_2" : mb_2,
                   "mb_grade" : mb_grade
               },
               dataType: 'json',
               async: false,
               cache: false,
               success : function(data) {
                   var code = data.code;
                   if (!code) {
                       alert("통신이 불안정합니다.");
                       return;
                   }
                   if (code != 1) {
                       alert(data.message + data.entity);
                       return;
                   }

                   // alert("성공"+data.code+data.entity);
                   // $('#accountModal').modal('hide');
                   window.location.reload(true);
               },
               error : function(data) {
                   // alert("실패");
                   // alert(aslang[12]);
                   window.location.reload(true);
                   return false;
               }
           });
        }else{
           return;
        }
    }
</script>

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>

<style>
    .at-body{
        background: #efefef;
    }
    .cell-search{
        margin-top: 10px;
        margin-left: 10px;
        width: 100%;
        height: 40px;
    }

    #txtValue{
        width: 260px;
        height: 25px;
        overflow:hidden;
    }
    .btnSearch2{
        text-align: center;
        width: 60px;
        height: 26px;
        border: 1px solid #353535;
        background: #dcdcdc;
    }

    .formSearch , .btnSearch2{
        float: left;
    }
</style>

<div class="modal" id="accountModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content"  style="width: 600px; left: -200px; top: 200px">
            <div class="modal-body" >
                <form>
                    <h1>사용자 추가</h1>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3" style="font-size: 17px;">사번</span>
                        </div>
                        <input style="font-size: 17px;" type="text" class="form-control" id="mb_id" placeholder="사번을 입력하세요.">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3" style="font-size: 17px;">이름</span>
                        </div>
                        <input style="font-size: 17px;" type="text" class="form-control" id="mb_name" placeholder="이름을 입력하세요.">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3" style="font-size: 17px;">직위</span>
                        </div>
                        <select name="co_tag_filter_use" id="mb_2" class="selectpicker">
                            <option value="부기장">부기장</option>
                            <option value="기장">기장</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3" style="font-size: 17px;">직책</span>
                        </div>
                        <select name="co_tag_filter_use" id="mb_grade">
                            <option value="1">조합원</option>
                            <option value="2">대의원</option>
                            <option value="4">대의원(앱관리자)</option>
                            <option value="3">집행부</option>
                            <option value="5">집행부(앱관리자)</option>
                            <option value="6">임시외부자</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" onclick="addUser()">추가하기</button>
                <button type="button" class="btn" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>


<div class="dobddfox" style="clear:both;height:60px;background:white;width:100%;border:1px solid #c3c3c3;padding:6px;line-height: 60px;">
    <div class="" style="width:1000px;height:60px;">
        <p style="float:left; font-size:24px;">유저관리</p>
    </div>
</div>
<br>
<div style="height: 45px;width: 100%; ">
    <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=userList&mb_1=">
        <div class="doob_top_button" style="float: left">
            전체목록
        </div>
    </a>
    <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=userList&mb_1=2">
        <div class="doob_top_button" style="float: left">
            대의원
        </div>
    </a>
    <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=userList&mb_1=3">
        <div class="doob_top_button" style="float: left">
            집행부
        </div>
    </a>

    <div  style="float:right" class="card card-sm">
        <div class="card-body row no-gutters align-items-center">
            <a onclick="openPopup('<?php echo G5_URL; ?>/page/user/createUser.php')">
                <button type="button" class="btn btn-primary  btn-lg" style="float: right;height: 35px;">사용자추가</button>
            </a>
        </div>
    </div>
    <div style="float:right">
        <div>
            <form method="POST" class="card card-sm formSearch" action="<?php echo G5_BBS_URL;?>/page.php?hid=userList">
                <div class="card-body row no-gutters align-items-center">
                    <input type="text" style="height: 35px" id="txtValue" name="mb_id" placeholder="유저 사번 또는 이름을 입력하세요"/>
                    <a class="btn btn-lg btn-success" style="height: 35px; color: #ffffff; line-height: 25px" onclick="searchID()">
                        검색
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>



<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


$conn = mysqli_connect(G5_MYSQL_HOST, G5_MYSQL_USER, G5_MYSQL_PASSWORD, G5_MYSQL_DB);
mysqli_set_charset($conn, 'utf8');

// 현재페이지
$page = ($_GET['page']) ? $_GET['page'] : 1;
// 표시할 리스트
$list = 10;
// 표시할 블럭
$block = 10;



/*
 * 유저 목록 리스트
 * */
$userID = $_REQUEST["userID"];
$mb_id = $_REQUEST['mb_id'];
$mb_1 =  $_REQUEST['mb_1'];


$sql2 = "";
if ($mb_id) {
    $sql2 = "SELECT * FROM g5_member WHERE mb_name LIKE '%{$mb_id}%' OR mb_id LIKE '%{$mb_id}%' ";
    if($mb_1){
        switch ($mb_1) {
            case "5": // 관리자 집행부
            case "3":
            $sql2 = "{$sql2} AND mb_grade = '3' OR mb_grade = '5' By mb_datetime  DESC";
                break;
            case "4":
            case "2":
            $sql2 = "{$sql2} AND mb_grade = '2' OR WHERE mb_grade = '4' ORDER By mb_datetime  DESC";
                break;
            default:
                break;
        }
    }
}else{
    $sql2 = "SELECT * FROM g5_member";
    if($mb_1) {
        switch ($mb_1) {
            case "5": // 관리자 집행부
            case "3":
            $sql2 = "{$sql2} WHERE mb_grade = '3' OR mb_grade = '5' ORDER By mb_datetime  DESC";
                break;
            case "4":
            case "2":
            $sql2 = "{$sql2} WHERE mb_grade = '2' OR  mb_grade = '4' ORDER By mb_datetime  DESC";
                break;
            default:
                break;
        }
    }
}

//$sql2 = "SELECT * FROM g5_member";
mysqli_set_charset($conn, 'utf8');
$countResult = mysqli_query($conn, $sql2);
$num = 0;
while ($row = mysqli_fetch_assoc($countResult)) {
    $num = $num + 1;
}

// 총 페이지
$totalBlock = ceil($num  / $list);
$pageNum = ceil($num  / $list); // 총 페이지
$blockNum = ceil($pageNum / $block); // 총 블록
$nowBlock = $page/*ceil($page / $block)*/;


$s_page = $nowBlock - ($block/2);
if ($s_page <= 1) {
    $s_page = 1;
}

$e_page = $s_page + 10;
if ($pageNum <= $e_page) {
    $pageNum = $e_page;
}
if ($e_page > $totalBlock) {
    $e_page = $totalBlock;
    $s_page = $e_page - 10;
    if ($s_page <= 1) {
        $s_page = 1;
    }
}

//echo $totalBlock."\n/////";
//echo $blockNum."\n/////";
//echo $nowBlock."\n///";
//echo $s_page."\n///";
//echo $e_page."\n///";

$start = ($list * $page - 10);
$end = ($list * $page);
$s_point = ($page - 1) * $list;
//echo "<br/>현재 페이지" . $page."/".$pageNum . "<br/>";


if ($mb_id) {
    //$sql = "SELECT * FROM g5_member WHERE mb_1 = '{$mb_1}'";

    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#txtValue').val('<?php echo $mb_id ?>');
        });

    </script>

    <?php
    $sql = "SELECT * FROM g5_member WHERE mb_name LIKE '%{$mb_id}%' OR mb_id LIKE '%{$mb_id}%' ";

    if($mb_1){
        switch ($mb_1) {
            case "5": // 관리자 집행부
            case "3":
                $sql = "{$sql} AND mb_grade = '3' OR mb_grade = '5'";
                break;
            case "4":
            case "2":
                $sql = "{$sql} AND mb_grade = '2' OR WHERE mb_grade = '4'";
                break;
            default:
                break;
        }
    }
    $sql = "{$sql} ORDER By mb_name LIMIT $start,10";
//    echo "sql".$sql;
}else{
    $sql = "SELECT * FROM g5_member";
    switch ($mb_1) {
        case "5": // 관리자 집행부
        case "3":
            $sql = "{$sql} WHERE mb_grade = '3' OR mb_grade = '5'";
            break;
        case "4":
        case "2":
            $sql = "{$sql} WHERE mb_grade = '2' OR  mb_grade = '4'";
            break;
        default:
            break;
    }
    $startOffset = $end - $list;
    $sql = "${sql} ORDER By mb_name LIMIT $start,10";
//    echo "sql".$sql;
}


$result2 = mysqli_query($conn, $sql);

?>

<script type="text/javascript">
    function goPage(wr_id) {
        location.href="<?php echo G5_URL;?>/bbs/page.php?hid=userdetail&mb_id="+wr_id;
    }
</script>


<table class="table table-hover" style="background: #ffffff">
    <thead style="background: #5A5A5A;color: #ffffff">
    <tr>
        <th scope="col" style="line-height: 40px; height: 40px;">사번</th>
        <th scope="col" style="line-height: 40px; height: 40px;">이름</th>
        <th scope="col" style="line-height: 40px; height: 40px;">닉네임</th>
        <th scope="col" style="line-height: 40px; height: 40px;">직위</th>
        <th scope="col" style="line-height: 40px; height: 40px;">직책</th>
        <th scope="col" style="line-height: 40px; height: 40px;">마지막 로그인</th>
    </tr>
    </thead>
    <tbody>

    <?php
    if ($result2) {
        while ($row = mysqli_fetch_assoc($result2)) {
            if ($row["mb_id"] == "admin") {
                continue;
            }
            ?>
            <tr onclick="goPage('<?php echo $row["mb_id"]?>')" >
                <td style="line-height: 40px; height: 40px;"><?php echo substr($row["mb_id"], 0, 30); ?></td>
                <td style="line-height: 40px; height: 40px;"><?php echo substr($row["mb_name"], 0, 30); ?></td>
                <td style="line-height: 40px; height: 40px;"><?php echo substr($row["mb_nick"], 0, 30); ?></td>
                <td style="line-height: 40px; height: 40px;"><?php echo substr($row["mb_2"], 0, 30); ?></td>
                <td style="line-height: 40px; height: 40px;"> <?php

                    switch ($row["mb_grade"]) {
                        case "6": // 임시외부자
                            echo "임시외부자";
                            break;
                        case "5": // 관리자 집행부
                        case "3":
                            echo "집행부";
                            break;
                        case "4": // 관리자 집행부
                        case "2":
                            echo "대의원";
                            break;
                        case "-1":
                            echo "승인거절";
                            break;
                        default:
                            echo "조합원";
                            break;
                    }

                    ?></td>
                <td style="line-height: 40px; height: 40px;width: 250px"><?php echo substr($row['mb_today_login'], 0, 30); ?></td>
            </tr>
            <?php
        }
    } else {
        ?>
        <div class="cell_content" onclick="goPage('<?php echo $row["mb_id"]?>')" >
            <div class="cell_block" >
                회원이 없습니다.
            </div>
        </div>
        <?php
    }
    ?>

    </tbody>
</table>





<?php
    if ($e_page >=1) {
    ?>
        <div class="container-fluid row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <ul class="pagination pagination-sm en">
                        <li ><a style="font-size: 15px;" href="<?= G5_URL ?>/bbs/page.php?hid=userList&page=<?= $page - 1 ?>"><</a></li>
                        <?php
                        for ($p = $s_page; $p <= $e_page; $p++) {
                            if ($p == $page) {
                                ?>
                                <li class="active"><a style="font-size: 15px;" href="<?= G5_URL ?>/bbs/page.php?hid=userList&mb_1=<?php echo $mb_1?>&page=<?= $p ?>"><?= $p ?></a></li>
                                <?php
                            } else {
                                ?>
                                <li><a style="font-size: 15px;" href="<?= G5_URL ?>/bbs/page.php?hid=userList&mb_1=<?php echo $mb_1?>&page=<?= $p ?>"><?= $p ?></a></li>
                                <?php
                            }
                        }
                        ?>
                        <li><a style="font-size: 15px;" href="<?= G5_URL ?>/bbs/page.php?hid=userList&page=<?= $page + 1 ?>"> > </></li>
                    </ul>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5"></div>
            </div>
        </div>

    <?php
    }
?>


<div style="width: 100%;clear:both;">
    <div class="container">

    </div>
</div>

