<meta charset='utf-8'>
<?php
include_once("../dbconfig.php");
$my_id = $_COOKIE['user_id'];
// 문자열 암호화
function get_encrypt_string($str)
{
    if (defined('G5_STRING_ENCRYPT_FUNCTION') && G5_STRING_ENCRYPT_FUNCTION) {
        $encrypt = call_user_func(G5_STRING_ENCRYPT_FUNCTION, $str);
    } else {
        $encrypt = sql_password($str);
    }

    return $encrypt;
}

function sql_password($value)
{
    // mysql 4.0x 이하 버전에서는 password() 함수의 결과가 16bytes
    // mysql 4.1x 이상 버전에서는 password() 함수의 결과가 41bytes
    $row = sql_fetch(" select password('$value') as pass ");

    return $row['pass'];
}

// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch($sql, $error = FALSE)
{
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $result = sql_query($sql, $error, $conn);
    //$row = @sql_fetch_array($result) or die("<p>$sql<p>" . mysqli_errno() . " : " .  mysqli_error() . "<p>error file : $_SERVER['SCRIPT_NAME']");
    $row = sql_fetch_array($result);
    return $row;
}

function sql_query($sql, $error = FALSE)
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    if (function_exists('mysqli_query') && G5_MYSQLI_USE) {
        if ($error) {
            $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " . mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysqli_query($link, $sql);
        }
    } else {
        if ($error) {
            $result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " . mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysql_query($sql, $link);
        }
    }
    return $result;
}

// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array($result)
{
    if (function_exists('mysqli_fetch_assoc') && true)
        $row = @mysqli_fetch_assoc($result);
    else
        $row = @mysql_fetch_assoc($result);
    return $row;
}

// 회원 정보를 얻는다.
function get_member($mb_id, $fields = '*')
{
    return sql_fetch(" select $fields from g5_member where mb_id = TRIM('$mb_id') ");
}

function add_push()
{
//    $sql = " insert into g5_write_push_service
//            set mb_id = '$admin_id',
//                 mb_password = PASSWORD('$admin_pass'),
//                 mb_name = '$admin_name',
//                 mb_nick = '$admin_name',
//                 mb_email = '$admin_email',
//                 mb_level = '10',
//                 mb_mailling = '1',
//                 mb_open = '1',
//                 mb_email_certify = '".G5_TIME_YMDHIS."',
//                 mb_datetime = '".G5_TIME_YMDHIS."',
//                 mb_ip = '{$_SERVER['REMOTE_ADDR']}'
//                 ";
//    sql_query($sql, true, $dblink);
}

function send_notification($title, $body, $urlPath, $imageUrl, $GOOGLE_API_KEY)
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array(
        'condition' => "'notice' in topics",
        'notification' => array("title" => $title, "body" => $body, "urlPath" => $urlPath , "imageUrl" => $imageUrl),
        'data' => array("title" => $title, "message" => $body, "urlPath" => $urlPath, "imageUrl" => $imageUrl)
    );
    $headers = array(
        'Authorization:key =' . $GOOGLE_API_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

function send_notification_ios($apnsCert, $tokensIos, $messageIos,$urlPath){
    header('X-XSS-Protection:0');
    $message = $messageIos;
    $payload = array('aps' => array('alert' => $message, 'badge' => 0, 'sound' => 'default') , 'job_id' => $urlPath );
    $payload = json_encode($payload);

    $streamContext = stream_context_create();
    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);

    for($i=0;i< count($tokensIos);$i++){
        $deviceToken = $tokensIos[$i];
        $apns = stream_socket_client('ssl://gateway.push.apple.com:2195', $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
        $apnsMessage = chr(0).chr(0).chr(32).pack('H*', str_replace(' ', '', $deviceToken)).chr(0).chr(strlen($payload)).$payload;
        fwrite($apns, $apnsMessage);
        fclose($apns);
        socket_close($apns);
    }
    return true;
}

include("../dbconfig.php");
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$sql = "SELECT * FROM g5_write_push_service WHERE mb_id = '$my_id'";
mysqli_set_charset($conn, 'utf8');
$result = mysqli_query($conn, $sql);
$count = 0;
$topic = "/topics/notice";

while ($row = mysqli_fetch_assoc($result)) {
    $app_name = $row["wr_subject"];
    $storeNumber = $row["wr_1"];
    $google = $row["wr_2"];
    $serviceName = "mb_service".$count;
    $is_on = $_POST[$serviceName];

    $title_content = $_POST[mb_subject];
    $message_content = $_POST[mb_content];
    $mb_link = $_POST[mb_link];
    $mb_image = $_POST[mb_image];

    if($is_on=="on"){
        $message_status = send_notification($title_content, $message_content, $mb_link, $mb_image, $google);
    }

    ?>
    <?php $count++ ?>
    <?php
}
echo "<meta charset='utf-8'>";
echo "<script>alert('발송되었습니다.');history.back();</script>";
exit;
?>
