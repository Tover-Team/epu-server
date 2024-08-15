<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(THEMA_PATH . '/assets/thema.php');
?>

<style>
    .new_header {
        width: 100%;
        height: 100px;
        background: #fff;
        text-align: center;
        line-height: 100px;
    }

    .new_admin_menu {
        width: 100%;
        height: 60px;
        background: #fff;
        border-bottom: 1px solid #dcdcdc;
        text-align: center;
        line-height: 60px;
    }

    .new_admin_menu_item {
        margin-left: 20px;
        float: left;
        color: #999999;
        font-size: 15px;
        font-weight: 600;
    }

    .new_header img {
        width: 150px;

    }
</style>

<div id="thema_wrapper" class="wrapper <?php echo $is_thema_layout; ?> <?php echo $is_thema_font; ?>">


    <div class="new_header">
        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/img/EPU.png" class="svc_img"></a>
    </div>
    <div class="clearfix"></div>
    <div class="new_admin_menu">
        <?php
        //echo $member['mb_level'];

        if ($member['mb_name'] != "") {
        if ($member['mb_grade'] >= 4) {
            ?>
            <div class="new_admin_menu_item">
                <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=userList">사용자관리</a>
            </div>
            <div class="new_admin_menu_item">
                <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=notam">공지사항</a>
            </div>
            <div class="new_admin_menu_item">
                <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=briefing">브리핑</a>
            </div>
            <div class="new_admin_menu_item">
                <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=schedule">스케쥴</a>
            </div>
            <div class="new_admin_menu_item">
                <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=crm">익명게시판</a>
            </div>
            <div class="new_admin_menu_item">
                <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=request">건의사항</a>
            </div>
            <div class="new_admin_menu_item">
                <a href="<?php echo G5_URL; ?>/bbs/vote.php?bo_table=vote">투표</a>
            </div>
            <div class="new_admin_menu_item">
                <a href="<?php echo G5_URL; ?>/bbs/board.php?bo_table=manual">매뉴얼</a>
            </div>
            <div class="new_admin_menu_item">
                <a href="<?php echo G5_URL; ?>/bbs/page.php?hid=chart">조직도</a>
            </div>
<!--            <div class="new_admin_menu_item" style="float: right;margin-right: 20px">-->
<!--                <a href="--><?php //echo G5_URL; ?><!--/adm/member_form.php?w=u&mb_id=admin">비밀번호변경</a>-->
<!--            </div>-->
            <?php
        }
        ?>
        <div class="new_admin_menu_item" style="float: right;margin-right: 20px">
            <a href="<?php echo G5_URL; ?>/bbs/logout.php">로그아웃</a>
        </div>
        <div class="new_admin_menu_item" style="float: right;margin-right: 20px">
            <?php echo $member['mb_name']."(".$member['mb_id'].")"?>
        </div>
    </div>

    <?php } ?>
    <div class="at-body">
        <?php if ($col_name) { ?>
        <div class="at-container">
            <?php if ($col_name == "two") { ?>
            <div class="row at-row">
                <div class="col-md-<?php echo $col_content; ?><?php echo ($at_set['side']) ? ' pull-right' : ''; ?> at-col at-main">
                    <?php } else { ?>
                    <div class="at-content">
                        <?php } ?>
                        <?php } ?>
