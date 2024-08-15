<!doctype html>

<!doctype html>
<html lang="en">
<head>

    <script language="javascript">
        function noti(text, url) {
            window.location.href = "custom_notification.php?message=" + text + "&urlPath=" + url;
        }

        function noti(text, url, imageUrl) {
            window.location.href = "custom_notification.php?message=" + text + "&urlPath=" + url + "&imageUrl=" + imageUrl;
        }
    </script>
    <meta charset="UTF-8">
    <meta name="Generator" content="EditPlus®">
    <meta name="Author" content="">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <title></title>
    <script src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/webfont/1.4.10/webfont.js"></script>

    <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"/>
    <script language="javascript" type="text/javascript" src="./defalut.js"></script>
    <link rel="stylesheet" type="text/css" href="design.css"></link>
</head>
<body>

<div class="viewHeader txtNrBold">
    <a href="./index.php">
        <div class="txtTitle" id="txtTitle">
            PUSHAPP version 0.1
        </div>
    </a>
    <a href="bbs/logout.php">
        <div class="txtUserInfo">
            로그아웃
        </div>
    </a>
</div>
<div class="viewInfo txtNrBold">
    <div class="txtHeaderInfoTitle change_greeting">
        현재페이지 > 메인
    </div>
</div>

<script type="text/javascript">

    function noti_send() {
        $(function () {
            $('.change_greeting').text('하이');
            noti($('#txtmessage').val(), $('#txt_url').val(), $('#txt_image').val());
        });
    }
</script>


<?php
if (!defined('G5_MYSQLI_USE')) define('G5_MYSQLI_USE ', 'DOOBSOFT');


if (!isset($_COOKIE['user_id'])) {
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}


function txtHeader($text)
{
    echo '<script  type="text/javascript">';
    echo "$(function(){";
    echo "      $('.change_greeting').text($text);";
    echo " })";
    echo '</script>';
}

include_once("common.php");

$result = "";

if (isset($_GET['message'])) {
    $result = $_GET['message'];
}


if ($result) {
    notification();
}


function send_notification_ios($tokensIos, $messageIos, $urlPath)
{
    $apnsCert = 'PUSH_DST.pem';
    $message = $messageIos;
    $payload = array('aps' => array('alert' => $message, 'badge' => 0, 'sound' => 'default'), 'job_id' => $urlPath);
    $payload = json_encode($payload);
    $streamContext = stream_context_create();
    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
    $apns = stream_socket_client('ssl://gateway.push.apple.com:2195', $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
    for ($i = 0; i < count($tokensIos); $i++) {
        $deviceToken = $tokensIos[$i];
        if ($apns) {
            $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $deviceToken)) . chr(0) . chr(strlen($payload)) . $payload;
            fwrite($apns, $apnsMessage);
            fclose($apns);
        }
    }
    return true;
}

function send_notification($tokens, $message)
{

    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array(
        'registration_ids' => $tokens,
        'data' => $message
    );
    $headers = array(
        'Authorization:key =' . GOOGLE_API_KEY,
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


function notification()
{
    //데이터베이스에 접속해서 토큰들을 가져와서 FCM에 발신요청
    include_once 'dbconfig.php';
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $sql = "Select userID,token, storeNumber From ds_user WHERE mb_id = '$my_id'";

    $result = mysqli_query($conn, $sql);
    $tokens = array();

    $tokensIos = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["storeNumber"] == '1') {
                $tokens[] = $row["token"];
            } else if ($row["storeNumber"] == '2') {
                //echo "<script>alert(\"".$row["userID"]."/".$row["storeNumber"]."\");</script>";
                //echo "<script>alert(\"".$row["userID"]."\");</script>";
                $tokensIos[] = $row["token"];
            }
        }
    }

    //mysqli_close($conn);

    $myMessage = $_REQUEST['message'];
    if ($myMessage == "") {
        $myMessage = "새글이 등록되었습니다.";
    }

    $urlQuery = $_SERVER['QUERY_STRING'];
    $queryUrl = substr($urlQuery, (strpos($urlQuery, "urlPath=") + 8));
    $urlPath = substr($queryUrl, 0, strlen($queryUrl) - (strlen($queryUrl) - strpos($queryUrl, "&imageUrl")));
    $imageUrl = $_REQUEST['imageUrl'];

    $message = array("message" => $myMessage, "urlPath" => $urlPath, "imageUrl" => $imageUrl);

    $message_status = send_notification($tokens, $message);
    $roro = json_decode($message_status, true);
    $state = false;

    if (array_key_exists('success', $roro)) {
        if ($roro['success'] != 0) {
            $state = true;
        }
    }

    $result = send_notification_ios($tokensIos, $myMessage, $urlPath);
    $query = "INSERT INTO ds_push_history
                      set text = '{$myMessage}',
                      success = '{$roro['success']}';";

    if (isset($roro['fail'])) {
        $query = $query . ",
                     fail = '{$roro['fail']}'";
    }

    mysqli_query($conn, $query);
    mysqli_close($conn);

    if ($state) {
        echo "<script>alert(\"전송에 성공하셨습니다. \");</script>";
    } else {
        echo "<script>alert(\"전송에 실패하셨습니다.\");</script>";
    }


}

?>

<script type="text/javascript">
    $(function () {
        $('.change_greeting').text('푸시발송');
    });
</script>

<div class="viewContent">
    <div class="viewSide">
        <a href="index.php">
            <div class="itemMenu" onclick=" insert_input()">
                <div class="itemMenuTitle txtNrBold">유저리스트</div>
            </div>
        </a>

        <a href="custom_notification.php">
            <div class="itemMenu">
                <div class="itemMenuTitle txtNrBold">푸시발송</div>

            </div>
            <a/>
            <a href="table.php">
                <div class="itemMenu">
                    <div class="itemMenuTitle txtNrBold">어플통계</div>

                </div>
                <a/>
                <a href="license.php">
                    <div class="itemMenu">
                        <div class="itemMenuTitle txtNrBold">라이센스 및 업그레이드</div>
                    </div>
                </a>
</div>
