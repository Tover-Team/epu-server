<?php
include_once("../dbconfig.php");

// 문자열 암호화
function get_encrypt_string($str)
{
    if(defined('G5_STRING_ENCRYPT_FUNCTION') && G5_STRING_ENCRYPT_FUNCTION) {
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
function sql_fetch($sql, $error=FALSE)
{
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $result = sql_query($sql, $error, $conn);
    //$row = @sql_fetch_array($result) or die("<p>$sql<p>" . mysqli_errno() . " : " .  mysqli_error() . "<p>error file : $_SERVER['SCRIPT_NAME']");
    $row = sql_fetch_array($result);
    return $row;
}

function sql_query($sql, $error=FALSE)
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    if(function_exists('mysqli_query') && G5_MYSQLI_USE) {
        if ($error) {
            $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " .  mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysqli_query($link, $sql);
        }
    } else {
        if ($error) {
            $result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysql_query($sql, $link);
        }
    }
    return $result;
}

// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array($result)
{
    if(function_exists('mysqli_fetch_assoc') && true)
        $row = @mysqli_fetch_assoc($result);
    else
        $row = @mysql_fetch_assoc($result);
    return $row;
}

// 회원 정보를 얻는다.
function get_member($mb_id, $fields='*')
{
    return sql_fetch(" select $fields from g5_member where mb_id = TRIM('$mb_id') ");
}


$mb_id = trim($_POST['mb_id']); // 필수
$mb_password = trim($_POST['mb_password']); // 필수
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$sql = " select count(*) as cnt from g5_member where mb_id = '$mb_id'";
$result = mysqli_query($conn, $sql);
$row = @mysqli_fetch_assoc($result);
$id_cnt = $row[cnt];

if ($id_cnt == 0){
    echo "<meta charset='utf-8'>";
    echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
    exit;
}
else {
    $mb = get_member($mb_id);
    $encrypt = get_encrypt_string($mb_password);

    $sql = " select count(*) as cnt from g5_member where mb_id = '$mb_id' AND mb_password = '$encrypt'";
    $result = mysqli_query($conn, $sql);
    $row = @mysqli_fetch_assoc($result);

    if ($row[cnt] == 0) {
        echo "<meta charset='utf-8'>";
        echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
        exit;
    }
    setcookie('user_id', $mb_id, time() + (86400 * 30), '/');
}
?>
<meta http-equiv='refresh' content='0;url=../index.php'>
