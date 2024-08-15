<?php
$response = array();
$response["returnCode"] = -1;
$response["returnMessage"] = "API를 찾을 수 없습니다.";
$response["apiName"] = "push";
$entity = array();


if (isset($_REQUEST["token"])) {
    $userID = $_REQUEST["userID"];
    $token = $_REQUEST["token"];
    $storeNumber = $_REQUEST["storeNumber"];
    $mb_id =  $_REQUEST["mb_id"];
    $isReceive =  $_REQUEST["isReceive"];
    //데이터베이스에 접속해서 토큰을 저장
    include_once 'dbconfig.php';
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = "INSERT INTO ds_user 
                      set userID = '{$userID}',
                     token = '{$token}',
                     mb_id = '{$mb_id}',
                     isReceive = '{$isReceive}',
                     storeNumber = '{$storeNumber}' ON DUPLICATE KEY UPDATE token = '$token', isReceive = '$isReceive'; ";
    mysqli_query($conn, $query);
    mysqli_close($conn);
    $entity["token"] = $token;
    $entity["query"] = $query;
    $response["returnMessage"] = "등록완료";
    $response["isReceive"] = $isReceive;
    $response["returnCode"] = 1;
} else {
    $response["returnMessage"] = '토큰 확인필요.';
}

$response["entity"] = $entity;
echo json_encode($response);
?>