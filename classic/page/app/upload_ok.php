<?php

$uploads_dir = './img';
$allowed_ext = array('png');
//$allowed_ext = array('jpg','jpeg','png','gif','PNG');

$error = $_FILES['myfile']['error'];
$name = $_FILES['myfile']['name'];
$ext = array_pop(explode('.', $name));

if( $error != UPLOAD_ERR_OK ) {
    switch( $error ) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            echo "파일 사이즈가 너무 큽니다. ($error)";
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "파일 형식이 다릅니다.. ($error)";
            break;
        default:
            echo "알 수 없는 에러가 발생했습니다. ($error)";
    }
    exit;
}

if( !in_array($ext, $allowed_ext) ) {
    echo "파일이 정상적으로 올라가지 못했습니다..";
    exit;
}

$type = $_REQUEST["type"];
$name = "bg_intro_chart.".$ext;
$newfilename = "$uploads_dir/$name";
if(file_exists($newfilename)){
    unlink($newfilename);
}

move_uploaded_file( $_FILES['myfile']['tmp_name'], $newfilename);
$http_host = $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];
$imgUrl = 'http://' . $http_host ."/app/img/".$name;
echo("<script>location.replace('http://epu8541.cafe24.com/bbs/page.php?hid=chart');</script>");
?>
