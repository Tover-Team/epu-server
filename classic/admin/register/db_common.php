<?php


// DB 연결
function sql_connect2($host, $user, $pass, $db=G5_MYSQL_DB)
{
    global $g5;

    if(function_exists('mysqli_connect')) {
        $link = mysqli_connect($host, $user, $pass, $db);

        // 연결 오류 발생 시 스크립트 종료
        if (mysqli_connect_errno()) {
            die('Connect Error: '.mysqli_connect_error());
        }
    } else {
        $link = mysql_connect($host, $user, $pass);
    }

    return $link;
}

function sql_select_db3($db, $connect)
{
    global $g5;

    if(function_exists('mysqli_select_db'))
        return @mysqli_select_db($connect, $db);
    else
        return @mysql_select_db($db, $connect);
}

// DB 연결
function sql_connect3($host, $user, $pass, $db=G5_MYSQL_DB)
{
    if(function_exists('mysqli_connect')) {
        $link = mysqli_connect($host, $user, $pass, $db);

        // 연결 오류 발생 시 스크립트 종료
        if (mysqli_connect_errno()) {
            die('Connect Error: '.mysqli_connect_error());
        }
    } else {
        $link = mysql_connect($host, $user, $pass);
    }

    return $link;
}



function sql_set_charset2($charset, $link=null)
{
    global $g5;

    if(!$link)
        $link = $g5['connect_db'];

    if(function_exists('mysqli_set_charset'))
        mysqli_set_charset($link, $charset);
    else
        mysql_query(" set names {$charset} ", $link);
}


// mysqli_query 와 mysqli_error 를 한꺼번에 처리
// mysql connect resource 지정 - 명랑폐인님 제안
function sql_query2($sql,$mysql_host,$mysql_user,$mysql_password,$db,$error="error", $link=null)
{
    //echo $mysql_host."//".$mysql_user."//".$mysql_password."//".$db;
    $connect_db = sql_connect3($mysql_host, $mysql_user, $mysql_password,$db) or die('MySQL Connect Error!!!');
    $select_db  = sql_select_db3($db, $connect_db) or die('MySQL DB Error!!!');
    sql_set_charset2('utf8', $connect_db);

    if(!$link)
        $link = $connect_db;

    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    // union의 사용을 허락하지 않습니다.
    //$sql = preg_replace("#^select.*from.*union.*#i", "select 1", $sql);
    $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
    // `information_schema` DB로의 접근을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    if(function_exists('mysqli_query')) {
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
function sql_fetch_array2($result)
{
    if(function_exists('mysqli_fetch_assoc') )
        $row = @mysqli_fetch_assoc($result);
    else
        $row = @mysql_fetch_assoc($result);

    return $row;
}

?>