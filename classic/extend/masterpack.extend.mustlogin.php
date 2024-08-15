<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// ============================================================================================
// 마스타팩 extend
// 로그인해야 웹사이트 사용가능하게 하기
// * 주요변수
// $must_login_use - 1:기능사용함, 0:기능사용안함
// $must_login_urls - 로그인을 해야 접근할 수 있는 페이지의 배열 변수
// ============================================================================================

$must_login_use = 1;
$must_login_urls = array(G5_URL."/index.php", G5_BBS_URL."/board.php", G5_BBS_URL."/write.php");
$must_logout_urls = array(G5_BBS_URL."/write.php?bo_table=notam", G5_BBS_URL."/board.php?bo_table=schedule");

if ($is_guest && $must_login_use) {
	$must_login_redirect = false;

	foreach($must_login_urls as $i) {
		if(stripos($i, $_SERVER['SCRIPT_NAME']) !== false) {
			$must_login_redirect = true;
			break;
		}
	}
    foreach($must_logout_urls as $i) {
        if(stripos($i, $_SERVER['SCRIPT_NAME']) !== false) {
            $must_login_redirect = false;
            break;
        }
    }

	if($must_login_redirect) {
		goto_url(G5_BBS_URL.'/login.php');
	}
}
?>
