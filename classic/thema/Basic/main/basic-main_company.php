<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 위젯 대표아이디 설정
$wid = 'CMB';

// 게시판 제목 폰트 설정
$font = 'font-16 en';

// 게시판 제목 하단라인컬러 설정 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line = 'navy';

// 사이드 위치 설정 - left, right
$side = ($at_set['side']) ? 'left' : 'right';

?>
<style>
    .widget-index .at-main,
    .widget-index .at-side { padding-bottom:0px; }
    .widget-index .div-title-underbar { margin-bottom:15px; }
    .widget-index .div-title-underbar span { padding-bottom:4px; }
    .widget-index .div-title-underbar span b { font-weight:500; }
    .widget-index .widget-img img { display:block; max-width:100%; /* 배너 이미지 */ }
    .widget-box { margin-bottom:25px; }

    .new_main_left{
        width: 48%;
        float: left;
        margin-left: 1%;
    }
    .new_main_right{
        width: 48%;
        margin-left: 2%;
        float: left;
    }
    .new_text_subject{
        margin-top: 10px;
        width: 100%;
        color: #fff;
        line-height: 50px;
        height: 50px;
        text-align: center;
        background: #37d2ae;
        font-size: 19px;
        font-weight: 600;
    }
</style>

<div class="at-container widget-index">

    <div class="h20"></div>

    <?php echo apms_widget('basic-title', $wid.'-wt1', 'height=260px', 'auto=0'); //타이틀 ?>
    <div class="row at-row">
        <div class="new_main_left">
            <div class="new_text_subject">공지사항</div>
            <?php echo apms_widget('basic-post-garo', $wid.'-wm1', 'icon={아이콘:caret-right} date=1 center=1 strong=1,2'); ?>
        </div>
        <div class="new_main_right">
            <div class="new_text_subject">건의사항</div>
            <?php echo apms_widget('basic-post-garo', $wid.'-wm2', 'icon={아이콘:caret-right} date=1 center=1 strong=1,2'); ?>
        </div>
    </div>
</div>
