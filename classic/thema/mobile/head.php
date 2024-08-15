<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
include_once(THEMA_PATH.'/assets/thema.php');
?>


<div id="thema_wrapper" class="wrapper <?php echo $is_thema_layout;?> <?php echo $is_thema_font;?>">
    <div class="at-body">
        <?php if($col_name) { ?>
        <div class="at-container">
            <?php if($col_name == "two") { ?>
            <div class="row at-row">
                <div class="col-md-<?php echo $col_content;?><?php echo ($at_set['side']) ? ' pull-right' : '';?> at-col at-main">
                    <?php } else { ?>
                    <div class="at-content">
                        <?php } ?>
                        <?php } ?>
