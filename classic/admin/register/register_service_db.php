<?php
@set_time_limit(0);
$gmnow = gmdate('D, d M Y H:i:s') . ' GMT';
header('Expires: 0'); // rfc2616 - Section 14.21
header('Last-Modified: ' . $gmnow);
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0
@header('Content-Type: text/html; charset=utf-8');
@header('X-Robots-Tag: noindex');
include_once('../header.php');
define('G5_DATA_DIR',       'data');
$data_path = '../'.G5_DATA_DIR;

if (!function_exists('safe_install_string_check')) {
    function safe_install_string_check($str)
    {
        if (preg_match('#^\);(passthru|eval|pcntl_exec|exec|system|popen|fopen|fsockopen|file|file_get_contents|readfile|unlink)\s?\(\$_(get|post|request)\s?\[.*?\]\s?\)#i', $str)) {
            die("입력한 값에 안전하지 않는 문자가 포함되어 있습니다. 설치를 중단합니다.");
        }

        return $str;
    }
}

include_once("../dbconfig.php");

define('G5_SERVER_TIME',    time());
define('G5_TIME_YMDHIS',    date('Y-m-d H:i:s', G5_SERVER_TIME));
$mb_id = $_POST['mb_id']; // 연결 계정
$wr_subject = $_POST['wr_subject']; // 앱 이름
$wr_content = $_POST['wr_content']; //
$wr_1 = $_POST['wr_1']; // 상태 (0 안드로이드 1 ios 2 둘다)
$wr_2 = $_POST['wr_2']; // 앱 토큰키
$wr_3 = $_POST['wr_3']; // 앱 홈페이지
$wr_4 = $_POST['wr_4']; // 앱 카테고리
$wr_5 = $_POST['wr_5']; // 앱 설명(80자)
$wr_6 = $_POST['wr_6']; // 앱 자세한 설명(4000자)
$wr_9 = $_POST['wr_9']; // 계정 명
$wr_10 = $_POST['wr_10']; // 계정 비밀번호
echo "1223232 <br>\n";

$dblink = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

echo "111111111 <br>\n";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$sql = " select count(*) as cnt from g5_member where mb_id = '$mb_id'";
$result = mysqli_query($conn, $sql);
$row = @mysqli_fetch_assoc($result);
$id_cnt = $row[cnt];

echo "22222222 <br>\n";

if ($id_cnt == 0){
    echo "<meta charset='utf-8'>";
    echo "<script>alert('아이디가 존재하지 않습니다.');history.back();</script>";
    exit;
}

sql_set_charset2('utf8', $dblink);

$sql = " insert into g5_write_push_service
            set mb_id = '$mb_id',
                 wr_subject = '$wr_subject',
                 wr_content = '$wr_content',
                 wr_1 = '$wr_1',
                 wr_2 = '$wr_2',
                 wr_3 = '$wr_3',
                 wr_4 = '$wr_4',
                 wr_5 = '$wr_5',
                 wr_6 = '$wr_6',
                 wr_9 = '$wr_9',
                 wr_10 = '$wr_10',
                 wr_datetime = '".G5_TIME_YMDHIS."'
                 ";
$result = mysqli_query($conn, $sql);

if ($result){
    echo "<meta charset='utf-8'>";
    echo "<script>alert('생성되었습니다.');history.back();</script>";
    exit;
} 
else {
    echo "<meta charset='utf-8'>";
    echo "<script>alert('생성실패');history.back();</script>";
    exit;
}
?>