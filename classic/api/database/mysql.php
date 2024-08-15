<?php
include_once('../_common.php');

class Mysql
{
    var $host;
    var $user;
    var $password;
    var $name;
    var $dns;
    var $conn;

    function __construct($_host, $_user, $_password, $_name, $_dns)
    {
        $this->host = $_host;
        $this->user = $_user;
        $this->password = $_password;
        $this->name = $_name;
        $this->dns = $_dns;
    }

    function __connect()
    {
        $conn = mysqli_connect(
            $this->host,
            $this->user,
            $this->password,
            $this->name
        );
        mysqli_set_charset($conn, 'utf8');
        $this->conn = $conn;
        //return $conn;
    }

    function get_last_id() {
        $link = $this->conn;
        return $link->insert_id;
    }

    // mysqli_query 와 mysqli_error 를 한꺼번에 처리
    // mysql connect resource 지정 - 명랑폐인님 제안
    function sql_query($sql, $error = FALSE, $link = null)
    {
        $link = $this->conn;

        // Blind SQL Injection 취약점 해결
        $sql = trim($sql);
        // union의 사용을 허락하지 않습니다.
        //$sql = preg_replace("#^select.*from.*union.*#i", "select 1", $sql);
        $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
        // `information_schema` DB로의 접근을 허락하지 않습니다.
        $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

        // MySQLi 사용여부를 설정합니다.
        $MYSQLI_USE = true;
        if (function_exists('mysqli_query') && $MYSQLI_USE) {
            if ($error) {
                $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " . mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
                return null;
            } else {
                $result = @mysqli_query($link, $sql);
                return $result;
            }
        } else {
            if ($error) {
                $result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " . mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
            } else {
                $result = @mysql_query($sql, $link);
            }
        }
    }

    // 결과값에서 한행 연관배열(이름으로)로 얻는다.
    function sql_fetch_array($result)
    {
        if(function_exists('mysqli_fetch_assoc') && G5_MYSQLI_USE)
            $row = @mysqli_fetch_assoc($result);
        else
            $row = @mysql_fetch_assoc($result);

        return $row;
    }

    // 쿼리를 실행한 후 결과값에서 한행을 얻는다.
    function sql_fetch($sql, $error=G5_DISPLAY_SQL_ERROR, $link=null)
    {
        if (!$link) {
            $link = $this->conn;
        }

        $result = $this->sql_query($sql);
//        if ($result) {
//            echo "sql_fetch: success";
//        } else {
//            echo "sql_fetch: fail: $sql";
//        }

        //$row = @sql_fetch_array($result) or die("<p>$sql<p>" . mysqli_errno() . " : " .  mysqli_error() . "<p>error file : $_SERVER['SCRIPT_NAME']");
        $row = $this->sql_fetch_array($result);
        return $row;
    }

    function queryList($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            return null;
        } else {
            $resultArr = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $item = array();
                foreach ($row as $key => $value) {
                    $item[$key] = $value;
                }
                array_push($resultArr, $item);
            }

            return $resultArr;
        }
    }

    function queryListUnmarshal($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }

    function get_encrypt_string($str)
    {
        if (defined('G5_STRING_ENCRYPT_FUNCTION') && G5_STRING_ENCRYPT_FUNCTION) {
            $encrypt = call_user_func(G5_STRING_ENCRYPT_FUNCTION, $str);
        } else {
            $encrypt = $this->sql_password($str);
        }
        return $encrypt;
    }

    function sql_password($value)
    {
        // mysql 4.0x 이하 버전에서는 password() 함수의 결과가 16bytes
        // mysql 4.1x 이상 버전에서는 password() 함수의 결과가 41bytes
        $row = $this->sql_fetch(" select password('$value') as pass ");

        return $row['pass'];
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDns()
    {
        return $this->dns;
    }

    public function setDns($dns)
    {
        $this->dns = $dns;
    }

    public function getConn()
    {
        return $this->conn;
    }

    public function setConn($conn)
    {
        $this->conn = $conn;
    }
}

?>