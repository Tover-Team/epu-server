<style>
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 50%; /* Could be more or less, depending on screen size */
    }
    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    #closeButton {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    #closeButton:hover,
    #closeButton:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    .doob_top_button_center{
        background:#fff;
        width: 120px;
        height: 45px;
        line-height: 45px;
        text-align:center;
        border: 1px solid #dcdcdc;
        float: left;
        position: relative;
        left: 50%;
    }

    #test {
        float: right;
        position: relative;
        left: -50%;
    }
    #test li {
        float: left;
        position: relative;
        left: 50%;
        border: 1px solid red;
    }
    #center_container {
        float: right;
        position: relative;
        left: -50%;
    }
    .at-body{
        background: #efefef;
    }
</style>
<script src="//code.jquery.com/jquery.min.js"></script>


<script type="text/javascript">
    window.onload = function () {
       /**
        * 직책 변경
        * */
        var modal1 = document.getElementById('myModal');
        // Get the button that opens the modal
        var btn1 = document.getElementById("myBtn");
        // Get the <span> element that closes the modal
        var span1 = document.getElementsByClassName("close")[0];
        // When the user clicks on the button, open the modal
        btn1.onclick = function() {
            modal1.style.display = "block";
        }
        // When the user clicks on <span> (x), close the modal
        span1.onclick = function() {
            modal.style.display = "none";
            modal1.style.display = "none";
        }
        // When the user clicks anywhere outside of the modal, close it


        /**
         * 직위 변경
         * */
        var modal2 = document.getElementById('positionModal');
        // Get the button that opens the modal
        var btn2 = document.getElementById("positionButton");
        // Get the <span> element that closes the modal
        var span2 = document.getElementsByClassName("positionClose")[0];
        // When the user clicks on the button, open the modal
        btn2.onclick = function() {
            modal2.style.display = "block";
        }
        // When the user clicks on <span> (x), close the modal
        span2.onclick = function() {
            modal2.style.display = "none";
        }


        /**
         * 삭제창
         * */
        // Get the modal
        var modal = document.getElementById('deleteModal');
        // Get the button that opens the modal
        var btn = document.getElementById("deleteUser");
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[1];
        // When the user clicks on the button, open the modal

        btn.onclick = function() {
            modal.style.display = "block";
        }
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
            modal1.style.display = "none";
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal || event.target == modal1 || event.target == modal2) {
                modal.style.display = "none";
                modal1.style.display = "none";
                modal2.style.display = "none";
            }
        }
    }

    function changeGrade(userID, strGrade, grade) {
        var url = '<?php echo G5_URL."/api/user"?>';
        if (confirm("등급을 수정하시겠습니까??") == true){
            $.ajax({
                type : 'get',
                url : url,
                data :{
                    "api_name" : 'updateGrade',
                    "mb_id" : userID,
                    "mb_grade" : grade
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

    function changePosition(userID, position) {
        var url = '<?php echo G5_URL."/api/user"?>';
        if (confirm("직위를 수정하시겠습니까??") == true){
            $.ajax({
                type : 'get',
                url : url,
                data :{
                    "api_name" : 'updatePosition',
                    "mb_id" : userID,
                    "position" : position
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

    function deleteUser(userID) {
        var url = '<?php echo G5_URL."/api/user"?>';
        if (confirm("유저를 삭제하시겠습니까?") == true){
            $.ajax({
                type : 'get',
                url : url,
                data :{
                    "api_name" : 'deleteUser',
                    "mb_id" : userID
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
                    location.reload();
                    // history.back();
                },
                error : function(data) {
                    location.reload();
                    // history.back();
                    return false;
                }
            });
        }else{
            return;
        }
    }
</script>
<?php
    $mb_id = $_REQUEST['mb_id'];
    if (!$mb_id) {
        echo "<meta charset='utf-8'>";
//        echo "<script>alert('존재하지 않는 사용자입니다..');history.back();</script>";
        echo "<meta http-equiv='refresh' content='0; url=$_SERVER[HTTP_HOST]'>";
        exit;
    }
?>

<!-- The Modal -->
<div id="deleteModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content" style="text-align: center">
        <span class="close">&times;</span>
        <p>해당 유저를 탈퇴처리합니다. (되돌릴 수 없으니 주의해주세요)</p>
        <br/>
        <div style="height: 50px;">
            <div id="center_container">
                <div class="doob_top_button_center" onclick="deleteUser('<?php echo $mb_id; ?>');">
                    탈퇴처리합니다.
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content" style="text-align: center">
        <span class="close">&times;</span>
        <p>해당 유저의 그룹을 변경합니다.</p>
        <br/>
        <div style="height: 50px;">
            <div id="center_container">
                <div class="doob_top_button_center" onclick="changeGrade('<?php echo $mb_id; ?>', '', 1);">
                    조합원
                </div>
                <div class="doob_top_button_center" onclick="changeGrade('<?php echo $mb_id; ?>', '', 2);">
                    대의원
                </div>
                <div class="doob_top_button_center" onclick="changeGrade('<?php echo $mb_id; ?>', '', 3);" >
                    집행부
                </div>
                <div class="doob_top_button_center" onclick="changeGrade('<?php echo $mb_id; ?>', '', 5);" >
                    집행부(앱관리자)
                </div>
                <div class="doob_top_button_center" onclick="changeGrade('<?php echo $mb_id; ?>', '', 6);" >
                    임시외부자
                </div>
            </div>
        </div>
    </div>
</div>

<div id="positionModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content" style="text-align: center">
        <span class="positionClose" id="closeButton">&times;</span>
        <p>해당 유저의 직위를 변경합니다.</p>
        <br/>
        <div style="height: 50px;">
            <div id="center_container">
                <div class="doob_top_button_center" onclick="changePosition('<?php echo $mb_id; ?>', '기장');">
                    기장
                </div>
                <div class="doob_top_button_center" onclick="changePosition('<?php echo $mb_id; ?>', '부기장');">
                    부기장
                </div>
            </div>
        </div>
    </div>
</div>

<div style="height: 45px;width: 100%">
    <div class="doob_top_button" onclick="history.back()" style="float: left">
        목록보기
    </div>
    <div class="doob_top_button" id="myBtn" style="float: left">
        직책수정
    </div>
    <div class="doob_top_button" id="positionButton" style="float: left">
        직위수정
    </div>
    <div class="doob_top_button" id="deleteUser" style="float: left">
        유저탈퇴처리
    </div>

    <?php
    $mb = get_member($mb_id);
    if (!$mb) {
        echo "<meta charset='utf-8'>";
//        echo "<script>alert('존재하지 않는 사용자입니다..');history.back();</script>";
        echo "<meta http-equiv='refresh' content='0; url=http://$_SERVER[HTTP_HOST]/bbs/page.php?hid=userList'>";
        exit;
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


<div class="cell_content">


    <div class="cell_block" style="background: #5a5a5a; color:white;font-weight: 600">
        <div class="cell_deviceID">
            사번
        </div>
        <div class="cell_storeID">
            이름
        </div>
        <div class="cell_reqDate">
            닉네임
        </div>
        <div class="cell_reqDate">
            직위
        </div>
        <div class="cell_reqDate">
            직책
        </div>
        <div class="cell_reqDate">
            마지막 로그인 일자
        </div>
    </div>
</div>
<div>
</div>


<div class="cell_content">

    <div class="cell_block">
        <div class="cell_deviceID">
            <?php echo substr($mb[mb_id], 0, 30); ?>
        </div>
        <div class="cell_storeID">
            <?php echo substr($mb[mb_name], 0, 30); ?>
        </div>
        <div class="cell_reqDate">
            <?php echo substr($mb[mb_nick], 0, 30); ?>
        </div>
        <div class="cell_reqDate">
            <?php echo substr($mb[mb_2], 0, 30); ?>
        </div>
        <div class="cell_reqDate">
            <?php
            switch ($mb["mb_grade"]) {
                case "6": // 임시외부자
                    echo "임시외부자";
                    break;
                case "5": // 관리자 집행부
                    echo "집행부(앱 관리자)";
                    break;
                case "3":
                    echo "집행부";
                    break;
                case "4":
                    echo "대의원(앱 관리자)";
                    break;
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

            ?>
        </div>
        <div class="cell_reqDate">
            <?php echo substr($mb[mb_today_login], 0, 30); ?>
        </div>
    </div>
</div>

