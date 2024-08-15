<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 와이드로 설정
$at_set['page'] = 12;

// 글내용 좌측컬럼 너비
$view_left = 9;

// 버튼컬러
$btn1 = (isset($boset['btn1']) && $boset['btn1']) ? $boset['btn1'] : 'black';
$btn2 = (isset($boset['btn2']) && $boset['btn2']) ? $boset['btn2'] : 'color';

// 별점컬러
$vstar_color = (isset($boset['vstar']) && $boset['vstar']) ? $boset['vstar'] : 'crimson';

// 글내용이면
if(isset($wr_id) && $wr_id) {

	// 동영상 자동실행 해제
	$is_link_video = false;

	// 글정보
	$wr_data = apms_unpack($write['wr_content']);

	// SEO용 정보
	$write['wr_name'] = $wr_data['director_ko'];
	$write['wr_content'] = $wr_data['content']; // 메인 컨텐츠
}

?>