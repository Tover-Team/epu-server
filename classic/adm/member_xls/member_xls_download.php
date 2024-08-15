<?php
include_once('./_common.php');
echo '<meta charset="utf-8">';

$sql_common = " from {$g5['member_table']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_point' :
            $sql_search .= " ({$sfl} >= '{$stx}') ";
            break;
        case 'mb_level' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'mb_tel' :
        case 'mb_hp' :
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

$sql_search .= " and mb_level >= 2 ";

if (!$sst) {
    $sst = "mb_datetime";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select * {$sql_common} {$sql_search} {$sql_order} ";
$result = sql_query($sql);

//var_dump($mb_1);
//exit;

header("Content-Type: application/vnd.ms-excel"); 
header("Content-Type: application/x-msexcel"); 
header("Content-Disposition: attachment; filename=member.xls");
header("Content-Description: PHP4 Generated Data" ); 
//header("Content-charset=utf-8");
?>

<html>
<head>
<style>
.sty { font-family:굴림; font-size:12px;}
.sty0 { font-family:굴림; font-size:12px; text-align:center;}
.sty1 {mso-number-format:"\@";font-family:굴림; font-size:12px}
.sty2 {font-family:굴림; font-size:12px}
.sty3 {font-family:굴림; font-size:12px; color: #ff0000}
.title {font-family:굴림; font-size:12px; font-weight:600}
.title_s {font-family:굴림; font-size:16px}
</style>
</head>
<body bgcolor="#FFFFFF">
<table border="1" style="table-layout:fixed">
<tr align="center">    
    <td bgcolor="#CCFFCC">mb_id</td>
    <td bgcolor="#CCFFCC">mb_name</td>
    <td bgcolor="#CCFFCC">mb_nick</td>
    <td bgcolor="#CCFFCC">mb_email</td>
    <td bgcolor="#CCFFCC">mb_homepage</td>
    <td bgcolor="#CCFFCC">mb_level</td>
    <td bgcolor="#CCFFCC">mb_tel</td>
    <td bgcolor="#CCFFCC">mb_hp</td>
    <td bgcolor="#CCFFCC">mb_certify</td>
    <td bgcolor="#CCFFCC">mb_adult</td>
    <td bgcolor="#CCFFCC">mb_zip1</td>
    <td bgcolor="#CCFFCC">mb_zip2</td>
    <td bgcolor="#CCFFCC">mb_addr1</td>
    <td bgcolor="#CCFFCC">mb_addr2</td>
    <td bgcolor="#CCFFCC">mb_addr3</td>
    <td bgcolor="#CCFFCC">mb_addr_jibeon</td>
    <td bgcolor="#CCFFCC">mb_recommend</td>
    <td bgcolor="#CCFFCC">mb_point</td>
    <td bgcolor="#CCFFCC">mb_leave_date</td>
    <td bgcolor="#CCFFCC">mb_intercept_date</td>
    <td bgcolor="#CCFFCC">mb_email_certify</td>
    <td bgcolor="#CCFFCC">mb_memo</td>
    <td bgcolor="#CCFFCC">mb_mailling</td>
    <td bgcolor="#CCFFCC">mb_sms</td>
    <td bgcolor="#CCFFCC">mb_open</td>
    <td bgcolor="#CCFFCC">mb_open_date</td>
    <td bgcolor="#CCFFCC">mb_profile</td>
    <td bgcolor="#CCFFCC">mb_1</td>
    <td bgcolor="#CCFFCC">mb_2</td>
    <td bgcolor="#CCFFCC">mb_3</td>
    <td bgcolor="#CCFFCC">mb_4</td>
    <td bgcolor="#CCFFCC">mb_5</td>
    <td bgcolor="#CCFFCC">mb_6</td>
    <td bgcolor="#CCFFCC">mb_7</td>
    <td bgcolor="#CCFFCC">mb_8</td>
    <td bgcolor="#CCFFCC">mb_9</td>
    <td bgcolor="#CCFFCC">mb_10</td>
</tr>

<?php for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
    <tr>
        <td class="sty1"><?php echo $row['mb_id'];?></td>
        <td class="sty1"><?php echo $row['mb_name'];?></td>
        <td class="sty1"><?php echo $row['mb_nick'];?></td>
        <td class="sty1"><?php echo $row['mb_email'];?></td>
        <td class="sty1"><?php echo $row['mb_homepage'];?></td>
        <td class="sty1"><?php echo $row['mb_level'];?></td>
        <td class="sty1"><?php echo $row['mb_tel'];?></td>
        <td class="sty1"><?php echo $row['mb_hp'];?></td>
        <td class="sty1"><?php echo $row['mb_certify'];?></td>
        <td class="sty1"><?php echo $row['mb_adult'];?></td>
        <td class="sty1"><?php echo $row['mb_zip1'];?></td>
        <td class="sty1"><?php echo $row['mb_zip2'];?></td>
        <td class="sty1"><?php echo $row['mb_addr1'];?></td>
        <td class="sty1"><?php echo $row['mb_addr2'];?></td>
        <td class="sty1"><?php echo $row['mb_addr3'];?></td>
        <td class="sty1"><?php echo $row['mb_addr_jibeon'];?></td>
        <td class="sty1"><?php echo $row['mb_recommend'];?></td>
        <td class="sty1"><?php echo $row['mb_point'];?></td>
        <td class="sty1"><?php echo $row['mb_leave_date'];?></td>
        <td class="sty1"><?php echo $row['mb_intercept_date'];?></td>
        <td class="sty1"><?php echo $row['mb_email_certify'];?></td>
        <td class="sty1"><?php echo $row['mb_memo'];?></td>
        <td class="sty1"><?php echo $row['mb_mailling'];?></td>
        <td class="sty1"><?php echo $row['mb_sms'];?></td>
        <td class="sty1"><?php echo $row['mb_open'];?></td>
        <td class="sty1"><?php echo $row['mb_open_date'];?></td>
        <td class="sty1"><?php echo $row['mb_profile'];?></td>
        <td class="sty1"><?php echo $row['mb_1'];?></td>
        <td class="sty1"><?php echo $row['mb_2'];?></td>
        <td class="sty1"><?php echo $row['mb_3'];?></td>
        <td class="sty1"><?php echo $row['mb_4'];?></td>
        <td class="sty1"><?php echo $row['mb_5'];?></td>
        <td class="sty1"><?php echo $row['mb_6'];?></td>
        <td class="sty1"><?php echo $row['mb_7'];?></td>
        <td class="sty1"><?php echo $row['mb_8'];?></td>
        <td class="sty1"><?php echo $row['mb_9'];?></td>
        <td class="sty1"><?php echo $row['mb_10'];?></td>
    </tr>
<?php }
sql_free_result($result);
?>
    </table>
</body>
</html>