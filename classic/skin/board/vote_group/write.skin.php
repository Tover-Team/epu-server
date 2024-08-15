<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$at_set['page'] = 12;
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

//다음 주소 js
add_javascript(G5_POSTCODE_JS, 0);

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css" media="screen">', 0);

// 버튼컬러
$btn1 = (isset($boset['btn1']) && $boset['btn1']) ? $boset['btn1'] : 'black';
$btn2 = (isset($boset['btn2']) && $boset['btn2']) ? $boset['btn2'] : 'color';

$is_use_tag = ((!$boset['tag'] && $is_admin) || ($boset['tag'] && $member['mb_level'] >= $boset['tag'])) ? true : false;

//// 추가폼값을 전부 글내용(wr_content)에 담음
//$wr_data = apms_unpack($write['wr_content']);

// 필요 배열값
$tel_arr = array('02', '031', '032', '033', '041', '042', '043', '051', '052', '053', '054', '055', '061', '062', '063', '064');

$htel_arr = array('010', '011', '016', '017', '018', '019');

$email_arr = array('naver.com', 'daum.net', 'hanmail.net', 'dreamwiz.com', 'empal.com', 'hanmir.com', 'hanafos.com', 'hotmail.com', 'lycos.co.kr', 'nate.com', 'paran.com', 'netian.com', 'yahoo.co.kr', 'kornet.net', 'nownuri.net', 'unitel.co.kr', 'freechal.com', 'korea.com', 'orgio.net', 'chollian.net', 'hitel.net');

$bo_table = "vote";
$action_url = https_url(G5_BBS_DIR)."/vote_update.php";
$today = date('Y-m-d\TH:i');
?>


<script>
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: new daum.maps.LatLng(37.537187, 127.005476), // 지도의 중심좌표
            level: 5 // 지도의 확대 레벨
        };

    //지도를 미리 생성
    var map = new daum.maps.Map(mapContainer, mapOption);
    //주소-좌표 변환 객체를 생성
    var geocoder = new daum.maps.services.Geocoder();
    //마커를 미리 생성
    var marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(37.537187, 127.005476),
        map: map
    });


    function sample5_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = data.address; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 기본 주소가 도로명 타입일때 조합한다.
                if(data.addressType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                // 주소 정보를 해당 필드에 넣는다.
                document.getElementById("sample5_address").value = fullAddr;
                // 주소로 상세 정보를 검색
                geocoder.addressSearch(data.address, function(results, status) {
                    // 정상적으로 검색이 완료됐으면
                    if (status === daum.maps.services.Status.OK) {

                        var result = results[0]; //첫번째 결과의 값을 활용

                        // 해당 주소에 대한 좌표를 받아서
                        var coords = new daum.maps.LatLng(result.y, result.x);
                        // 지도를 보여준다.
                        mapContainer.style.display = "block";
                        map.relayout();
                        // 지도 중심을 변경한다.
                        map.setCenter(coords);
                        // 마커를 결과값으로 받은 위치로 옮긴다.
                        marker.setPosition(coords)
                    }
                });
            }
        }).open();
    }
</script>

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=297af984666bf6132972bcb55053a53d&libraries=services"></script>

<div id="bo_w" class="write-wrap<?php echo (G5_IS_MOBILE) ? ' font-14' : '';?>">

	<!-- 게시물 작성/수정 시작 { -->
	<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" role="form" class="form">
	<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">

	<h2>
		<span class="green">&nbsp;</span> 그룹투표 등록
	</h2>

	<div class="form-title">
		<b>정보</b>
	</div>
	<div class="table-responsive">
		<table class="table div-table">
		<tr>
		<td class="sub-title">
			<span>투표주제</span>
		</td>
		<td>
			<input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="form-control input-sm">
		</td>
		</tr>
		<?php if($is_category) { //글분류 적용 ?>
			<tr>
			<td class="sub-title">
				<span>분류</span>
			</td>
			<td>
				<div class="row">
					<div class="col-sm-4">
						<!-- 카테고리 적용 -->
						<select name="ca_name" id="ca_name" required class="form-control input-sm">
							<option value="">선택하세요</option>
							<?php echo $category_option ?>
						</select>
					</div>
				</div>
			</td>
			</tr>
		<?php } ?>

            <tr>
                <td class="sub-title">
                    <span>시작일시</span>
                </td>
                <td>
                    <div class="row">
                        <div class="col-sm-4">
                            <input type="text"style="display: none" name="is_group" id="is_group" value="Y">
                            <input type="text" style="display: none" name="is_sub" id="is_sub" value="N">
                            <input type="datetime-local" name="wr_startDate" id="wr_startDate" value="<?php echo $write['wr_startDate'] != "" ? date('Y-m-d\TH:i:s', strtotime($write['wr_startDate']) ): $today ?>" required class="form-control input-sm">
<!--                            <input style="display: none" type="datetime-local" name="wr_startDate" id="wr_startDate" value="--><?php //echo $write['wr_startDate'] != "" ? date('Y-m-d\TH:i:s', strtotime($write['wr_startDate']) ): $today ?><!--" required class="form-control input-sm" >-->
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="sub-title">
                    <span>종료일시</span>
                </td>
                <td>
                    <div class="row">
                        <div class="col-sm-4">
                            <input type="datetime-local" name="wr_endDate" id="wr_endDate" value="<?php echo $write['wr_endDate'] != "" ? date('Y-m-d\TH:i:s', strtotime($write['wr_endDate']) ): $today ?>" required class="form-control input-sm">
                        </div>
                    </div>
                </td>
            </tr>
		</table>
	</div>
	<div class="form-title">
		<b>투표 정보</b>
	</div>


	<div class="table-responsive">
		<table class="table div-table">
            <tr>
                <td class="sub-title">
                    <span>가능한그룹</span>
                </td>
                <td>

                    <div class="row">
                        <div class="col-sm-4 col-xs-6">
                            <select name="wr_1" id="wr_1" value="1" required class="form-control input-sm">
                                <?php
                                $voteGroups = array(
                                    '전체'=>1,
                                    '집행부'=>2,
                                    '대의원'=>3,
                                    '집행부+대의원'=>4
                                );

                                foreach($voteGroups as $key => $value) {
                                    if($value ==  $write['wr_1'])
                                    {
                                        echo "<option selected='selected' value='".$value."'>".$key."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='".$value."'>".$key."</option>";
                                    }
                                }
                                ?>
                             
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr style="display: none;">
                <td class="sub-title">
                    <span>상태</span>
                </td>
                <td>
                    <div class="row">
                        <div class="col-sm-4 col-xs-6">
                            <input type="text" name="wr_2" id="wr_2" value="1" required class="form-control input-sm">
                            <input type="text" name="wr_content" id="wr_content" value="1" required class="form-control input-sm">
                        </div>
                    </div>
                </td>
            </tr>

		<tr>
		<td>

		</td>
		</tr>

		</table>
	</div>


	<?php if($is_guest || $is_name || $is_password || $is_email || $is_homepage) { ?>
		<div class="form-title">
			<b>등록자 정보</b>
		</div>
		<div class="table-responsive">
			<table class="table div-table">
			<?php if ($is_name) { ?>
				<tr style="display: none">
				<td class="sub-title">
					<span>이름</span>
				</td>
				<td>
					<div class="row">
						<div class="col-sm-4">
							<input type="text" name="wr_name" value="guest" id="wr_name" required class="form-control input-sm" size="10" maxlength="20">
						</div>
					</div>
				</td>
				</tr>
			<?php } ?>

			<?php if ($is_password) { ?>
				<tr>
				<td class="sub-title">
					<span>비밀번호</span>
				</td>
				<td>
					<div class="row">
						<div class="col-sm-4">
							<input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="form-control input-sm" maxlength="20">
						</div>
					</div>
				</td>
				</tr>
			<?php } ?>

			<?php if ($is_homepage) { ?>
				<tr style="display: none">
				<td class="sub-title">
					<span>홈페이지</span>
				</td>
				<td>
					<div class="row">
						<div class="col-sm-6">
							<input type="text" name="wr_homepage" id="wr_homepage" value="d" class="form-control input-sm" size="50">
						</div>
					</div>
				</td>
				</tr>
			<?php } ?>

			<?php if ($is_guest) { ?>
				<tr>
				<td class="sub-title">
					<span>자동등록방지</span>
				</td>
				<td>
					<?php echo $captcha_html; ?>
				</td>
				</tr>
			<?php } ?>
			</table>
		</div>
	<?php } ?>

	<div class="write-btn">
		<button type="submit" id="btn_submit" accesskey="s" class="btn btn-<?php echo $btn2;?> btn-sm"><i class="fa fa-check"></i> <b>작성완료</b></button>
		<a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn btn-<?php echo $btn1;?> btn-sm" role="button">취소</a>
	</div>

	<div class="clearfix"></div>

	</form>

</div>

<div class="h20"></div>

<script>

    <?php if($write_min || $write_max) { ?>
    // 글자수 제한
    var char_min = parseInt(<?php echo $write_min; ?>); // 최소
    var char_max = parseInt(<?php echo $write_max; ?>); // 최대
    check_byte("wr_content", "char_count");

    $(function() {
        $("#wr_content").on("keyup", function() {
            check_byte("wr_content", "char_count");
        });
    });
    <?php } ?>

    function html_auto_br(obj) {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f) {
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "ㄷㄷㄷㄱㄷㄱㄷ";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));
                if (char_min > 0 && char_min > cnt) {
                    alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

    $(function(){
        $("#wr_content").addClass("form-control input-sm write-content");
    });


//function fwrite_submit(f) {
//
//	<?php //echo get_editor_js('wr_synopsis'); ?>
<!---->
<!--	--><?php //echo get_editor_js('wr_intention'); ?>
<!---->
<!--	--><?php //echo get_editor_js('wr_prize'); ?>
<!---->
<!--	--><?php //echo get_editor_js('wr_staff'); ?>
<!---->
<!--	--><?php //echo get_editor_js('wr_director'); ?>
<!---->
<!--	--><?php //echo get_editor_js('wr_filmography'); ?>
<!---->
<!--	--><?php //echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>
//
//	document.getElementById("btn_submit").disabled = "disabled";
//
//	return true;
//}
//
//
//
//
//$(function(){
//	$("#director_birth").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", yearRange: "c-100:c" });
//	$("#wr_synopsis").addClass("form-control input-sm write-content");
//	$("#wr_intention").addClass("form-control input-sm write-content");
//	$("#wr_prize").addClass("form-control input-sm write-content");
//	$("#wr_filmography").addClass("form-control input-sm write-content");
//});
</script>
