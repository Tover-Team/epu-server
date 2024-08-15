<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 주소처리
// $wr_data['zip'] = $zip1.'|'.$zip2.'|'.$zip3.'|'.$zip4.'|'.$zip5;

// 에디터 내용
$wr_data['content'] = $wr_synopsis; // 메인 컨텐츠
$wr_data['intention'] = $wr_intention;
$wr_data['prize'] = $wr_prize;
$wr_data['staff'] = $wr_staff;
$wr_data['director'] = $wr_director;
$wr_data['filmography'] = $wr_filmography;

// 글내용에 전체 데이터 등록
$wr_content = apms_pack($wr_data);

?>