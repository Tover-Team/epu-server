<?php
include_once('./_common.php');

// 회원이 많을 경우 대비 설정변경
set_time_limit ( 0 );
ini_set('memory_limit', '50M');

auth_check($auth[$sub_menu], "w");

function only_number($n)
{
    return preg_replace('/[^0-9]/', '', $n);
}

if($_FILES['excelfile']['tmp_name']) {
    $file = $_FILES['excelfile']['tmp_name'];

    include_once(G5_LIB_PATH.'/Excel/reader.php');

    $data = new Spreadsheet_Excel_Reader();

    // Set output Encoding.
    $data->setOutputEncoding('UTF-8');

    /***
    * if you want you can change 'iconv' to mb_convert_encoding:
    * $data->setUTFEncoder('mb');
    *
    **/

    /***
    * By default rows & cols indeces start with 1
    * For change initial index use:
    * $data->setRowColOffset(0);
    *
    **/



    /***
    *  Some function for formatting output.
    * $data->setDefaultFormat('%.2f');
    * setDefaultFormat - set format for columns with unknown formatting
    *
    * $data->setColumnFormat(4, '%.3f');
    * setColumnFormat - set format for column (apply only to number fields)
    *
    **/

    $data->read($file);

    /*


     $data->sheets[0]['numRows'] - count rows
     $data->sheets[0]['numCols'] - count columns
     $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column

     $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell

        $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
            if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
        $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format
        $data->sheets[0]['cellsInfo'][$i][$j]['colspan']
        $data->sheets[0]['cellsInfo'][$i][$j]['rowspan']
    */

    error_reporting(E_ALL ^ E_NOTICE);

    $dup_mb_id = array();
    $fail_mb_id = array();
    $dup_count = 0;
    $total_count = 0;
    $fail_count = 0;
    $succ_count = 0;

    for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
        $total_count++;

        $j = 1;

        $mb_id            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_name            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_nick            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_email            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_homepage            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_level            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_tel            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_hp            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_certify            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_adult            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_zip1            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_zip2            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_addr1            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_addr2            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_addr3            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_addr_jibeon            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_recommend            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_point            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_leave_date            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_intercept_date            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_email_certify            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_memo            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_mailling            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_sms            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_open            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_open_date            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_profile            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_1            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_2            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_3            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_4            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_5            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_6            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_7            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_8            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_9            = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $mb_10            = addslashes($data->sheets[0]['cells'][$i][$j++]);


        if(!$mb_id || !$mb_email) {
            $fail_count++;
            continue;
        }

$sql_common = "  mb_name = '{$mb_name}',
                 mb_nick = '{$mb_id}',
                 mb_email = '{$mb_email}',
                 mb_homepage = '{$mb_homepage}',
                 mb_level = '{$mb_level}',
                 mb_tel = '{$mb_tel}',
                 mb_hp = '{$mb_hp}',
                 mb_certify = '{$mb_certify}',
                 mb_adult = '{$mb_adult}',
                 mb_zip1 = '$mb_zip1',
                 mb_zip2 = '$mb_zip2',
                 mb_addr1 = '{$mb_addr1}',
                 mb_addr2 = '{$mb_addr2}',
                 mb_addr3 = '{$mb_addr3}',
                 mb_addr_jibeon = '{$mb_addr_jibeon}',
                 mb_recommend = '{$mb_recommend}',
                 mb_point = '{$mb_point}',
                 mb_leave_date = '{$mb_leave_date}',
                 mb_intercept_date='{$mb_intercept_date}',
                 mb_email_certify='{$mb_email_certify}',
                 mb_memo = '{$mb_memo}',
                 mb_mailling = '{$mb_mailling}',
                 mb_sms = '{$mb_sms}',
                 mb_open = '{$mb_open}',
                 mb_open_date = '{$mb_open_date}',
                 mb_profile = '{$mb_profile}',
                 mb_1 = '{$mb_1}',
                 mb_2 = '{$mb_2}',
                 mb_3 = '{$mb_3}',
                 mb_4 = '{$mb_4}',
                 mb_5 = '{$mb_5}',
                 mb_6 = '{$mb_6}',
                 mb_7 = '{$mb_7}',
                 mb_8 = '{$mb_8}',
                 mb_9 = '{$mb_9}',
                 mb_10 = '{$mb_10}' ";

    $sql = " update {$g5['member_table']}
                set {$sql_common}
                where mb_id = '{$mb_id}' ";
    sql_query($sql);

        $succ_count++;
    }
}

$g5['title'] = '회원 엑셀일괄등록 결과';
include_once(G5_PATH.'/head.sub.php');
?>

<div class="new_win">
    <h1><?php echo $g5['title']; ?></h1>

    <div class="local_desc01 local_desc">
        <p>회원등록을 완료했습니다.</p>
    </div>

    <dl id="excelfile_result">
        <dt>총회원수</dt>
        <dd><?php echo number_format($total_count); ?></dd>
        <dt>완료건수</dt>
        <dd><?php echo number_format($succ_count); ?></dd>
        <dt>실패건수</dt>
        <dd><?php echo number_format($fail_count); ?></dd>
        <?php if($fail_count > 0) { ?>
        <dt>실패회원코드</dt>
        <dd><?php echo implode(', ', $fail_mb_id); ?></dd>
        <?php } ?>
        <?php if($dup_count > 0) { ?>
        <dt>회원코드중복건수</dt>
        <dd><?php echo number_format($dup_count); ?></dd>
        <dt>중복회원코드</dt>
        <dd><?php echo implode(', ', $dup_mb_id); ?></dd>
        <?php } ?>
    </dl>

    <div class="btn_win01 btn_win">
        <button type="button" onclick="window.close();">창닫기</button>
    </div>

</div>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>