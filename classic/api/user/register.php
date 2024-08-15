<?php


$mb_id = trim($_REQUEST['mb_id']); // 필수
if (!$mb_id)
    $response["returnMessage"] = '회원아이디 값이 없습니다. 올바른 방법으로 이용해 주십시오.';

$mb_password = trim($_REQUEST['mb_password']);
$mb_password_re = trim($_REQUEST['mb_password_re']);
$mb_name = trim($_REQUEST['mb_name']);
$mb_nick = trim($_REQUEST['mb_nick']);
$mb_email = trim($_REQUEST['mb_email']);
$mb_sex = isset($_REQUEST['mb_sex']) ? trim($_REQUEST['mb_sex']) : "";
$mb_birth = isset($_REQUEST['mb_birth']) ? trim($_REQUEST['mb_birth']) : "";
$mb_homepage = isset($_REQUEST['mb_homepage']) ? trim($_REQUEST['mb_homepage']) : "";
$mb_tel = isset($_REQUEST['mb_tel']) ? trim($_REQUEST['mb_tel']) : "";
$mb_hp = isset($_REQUEST['mb_hp']) ? trim($_REQUEST['mb_hp']) : "";
$mb_zip1 = isset($_REQUEST['mb_zip']) ? substr(trim($_REQUEST['mb_zip']), 0, 3) : "";
$mb_zip2 = isset($_REQUEST['mb_zip']) ? substr(trim($_REQUEST['mb_zip']), 3) : "";
$mb_addr1 = isset($_REQUEST['mb_addr1']) ? trim($_REQUEST['mb_addr1']) : "";
$mb_addr2 = isset($_REQUEST['mb_addr2']) ? trim($_REQUEST['mb_addr2']) : "";
$mb_addr3 = isset($_REQUEST['mb_addr3']) ? trim($_REQUEST['mb_addr3']) : "";
$mb_addr_jibeon = isset($_REQUEST['mb_addr_jibeon']) ? trim($_REQUEST['mb_addr_jibeon']) : "";
$mb_signature = isset($_REQUEST['mb_signature']) ? trim($_REQUEST['mb_signature']) : "";
$mb_profile = isset($_REQUEST['mb_profile']) ? trim($_REQUEST['mb_profile']) : "";
$mb_recommend = isset($_REQUEST['mb_recommend']) ? trim($_REQUEST['mb_recommend']) : "";
$mb_mailling = isset($_REQUEST['mb_mailling']) ? trim($_REQUEST['mb_mailling']) : "";
$mb_sms = isset($_REQUEST['mb_sms']) ? trim($_REQUEST['mb_sms']) : "";
$mb_1 = isset($_REQUEST['mb_1']) ? trim($_REQUEST['mb_1']) : "";
$mb_2 = isset($_REQUEST['mb_2']) ? trim($_REQUEST['mb_2']) : "";
$mb_3 = isset($_REQUEST['mb_3']) ? trim($_REQUEST['mb_3']) : "";
$mb_4 = isset($_REQUEST['mb_4']) ? trim($_REQUEST['mb_4']) : "";
$mb_5 = isset($_REQUEST['mb_5']) ? trim($_REQUEST['mb_5']) : "";
$mb_6 = isset($_REQUEST['mb_6']) ? trim($_REQUEST['mb_6']) : "";
$mb_7 = isset($_REQUEST['mb_7']) ? trim($_REQUEST['mb_7']) : "";
$mb_8 = isset($_REQUEST['mb_8']) ? trim($_REQUEST['mb_8']) : "1";
$mb_9 = isset($_REQUEST['mb_9']) ? trim($_REQUEST['mb_9']) : "";
$mb_10 = isset($_REQUEST['mb_10']) ? trim($_REQUEST['mb_10']) : "";
$mb_grade = isset($_REQUEST['mb_grade']) ? trim($_REQUEST['mb_grade']) : "";
$mb_name = clean_xss_tags($mb_name);
$mb_email = get_email_address($mb_email);
$mb_homepage = clean_xss_tags($mb_homepage);
$mb_tel = clean_xss_tags($mb_tel);
$mb_zip1 = preg_replace('/[^0-9]/', '', $mb_zip1);
$mb_zip2 = preg_replace('/[^0-9]/', '', $mb_zip2);
$mb_addr1 = clean_xss_tags($mb_addr1);
$mb_addr2 = clean_xss_tags($mb_addr2);
$mb_addr3 = clean_xss_tags($mb_addr3);
$mb_addr_jibeon = preg_match("/^(N|R)$/", $mb_addr_jibeon) ? $mb_addr_jibeon : '';
$tmp_mb_name = iconv('UTF-8', 'UTF-8//IGNORE', $mb_name);
$tmp_mb_nick = iconv('UTF-8', 'UTF-8//IGNORE', $mb_nick);

if (!trim($mb_id)) {
    $response["returnMessage"] = '회원아이디를 입력해 주십시오.';
}
else if (preg_match("/[^0-9a-z_]+/i", $mb_id)){
    $response["returnMessage"] = '회원아이디는 영문자, 숫자, _ 만 입력하세요.';
}
else if (strlen($mb_id) < 3) {
    $response["returnMessage"] = '회원아이디는 최소 3글자 이상 입력하세요.';
}
else if ($tmp_mb_name != $mb_name) {
    $response["returnMessage"] = '이름을 올바르게 입력해 주십시오.';
}
else if ($tmp_mb_nick != $mb_nick) {
    $response["returnMessage"] = '닉네임을 올바르게 입력해 주십시오.';
}
else if (!$mb_password)
    $response["returnMessage"] = '비밀번호가 넘어오지 않았습니다.';
else if ($mb_password != $mb_password_re)
    $response["returnMessage"] = '비밀번호가 일치하지 않습니다.';
else if (!trim($mb_name))
    $response["returnMessage"] = '이름을 입력하세요';
else if (!trim($mb_nick))
    $response["returnMessage"] = '닉네임을 입력하세요';
else if (!check_string($mb_nick, G5_HANGUL + G5_ALPHABETIC + G5_NUMERIC))
    $response["returnMessage"] = "닉네임은 숫자, 한글, 영어만 허용됩니다.";
else{
    $id_row = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where mb_id = '$mb_id'");
    $nick_row = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where mb_nick = '$mb_nick'");
    $email_row = sql_fetch(" select count(*) as cnt from `{$g5['member_table']}` where mb_email = '$mb_email' ");
    if ($id_row['cnt'])
        $response["returnMessage"] = '이미 존재하는 아이디입니다.';
    else if ($nick_row['cnt'])
        $response["returnMessage"] = '이미 존재하는 닉네임입니다.';
    else {
        $sql = " insert into {$g5['member_table']}
                set mb_id = '{$mb_id}',
                     mb_password = '" . get_encrypt_string($mb_password) . "',
                     mb_name = '{$mb_name}',
                     mb_nick = '{$mb_nick}',
                     mb_nick_date = '" . G5_TIME_YMD . "',
                     mb_email = '{$mb_email}',
                     mb_homepage = '{$mb_homepage}',
                     mb_tel = '{$mb_tel}',
                     mb_zip1 = '{$mb_zip1}',
                     mb_zip2 = '{$mb_zip2}',
                     mb_addr1 = '{$mb_addr1}',
                     mb_addr2 = '{$mb_addr2}',
                     mb_addr3 = '{$mb_addr3}',
                     mb_addr_jibeon = '{$mb_addr_jibeon}',
                     mb_signature = '{$mb_signature}',
                     mb_profile = '{$mb_profile}',
                     mb_today_login = '" . G5_TIME_YMDHIS . "',
                     mb_datetime = '" . G5_TIME_YMDHIS . "',
                     mb_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_level = '{$config['cf_register_level']}',
                     mb_recommend = '{$mb_recommend}',
                     mb_login_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_mailling = '{$mb_mailling}',
                     mb_sms = '{$mb_sms}',
                     mb_hp = '{$mb_hp}',
                     mb_open = '{$mb_open}',
                     mb_open_date = '" . G5_TIME_YMD . "',
                     mb_1 = '{$mb_1}',
                     mb_2 = '{$mb_2}',
                     mb_3 = '{$mb_3}',
                     mb_4 = '{$mb_4}',
                     mb_5 = '{$mb_5}',
                     mb_6 = '{$mb_6}',
                     mb_7 = '{$mb_7}',
                     mb_8 = '{$mb_8}',
                     mb_9 = '{$mb_9}',
                     storeNumber = '1',
                     mb_10 = '{$mb_10}'
                     {$sql_certify} ";
        if (!$config['cf_use_email_certify']) // 이메일 인증을 사용하지 않는다면 이메일 인증시간을 바로 넣는다
            $sql .= " , mb_email_certify = '" . G5_TIME_YMDHIS . "' ";
        $result = dbInsert($sql);
        if ($result) {
            //insert_point($mb_id, $config['cf_register_point'], '회원가입 축하', '@member', $mb_id, '회원가입'); // 회원가입 포인트 부여
//            if ($config['cf_use_recommend'] && $mb_recommend) // 추천인에게 포인트 부여
//                insert_point($mb_recommend, $config['cf_recommend_point'], $mb_id . '의 추천인', '@member', $mb_recommend, $mb_id . ' 추천');
            if ($config['cf_email_mb_member']) { // 회원님께 메일 발송
                $subject = '[' . $config['cf_title'] . '] 회원가입을 축하드립니다.';
                // 어떠한 회원정보도 포함되지 않은 일회용 난수를 생성하여 인증에 사용
                if ($config['cf_use_email_certify']) {
                    $mb_md5 = md5(pack('V*', rand(), rand(), rand(), rand()));
                    sql_query(" update {$g5['member_table']} set mb_email_certify2 = '$mb_md5' where mb_id = '$mb_id' ");
                    $certify_href = G5_BBS_URL . '/email_certify.php?mb_id=' . $mb_id . '&amp;mb_md5=' . $mb_md5;
                }
                ob_start();
                include_once($misc_skin_path . '/register_form_update_mail1.php');
                $content = ob_get_contents();
                ob_end_clean();
                mailer($config['cf_admin_email_name'], $config['cf_admin_email'], $mb_email, $subject, $content, 1);
                // 메일인증을 사용하는 경우 가입메일에 인증 url이 있으므로 인증메일을 다시 발송되지 않도록 함
                if ($config['cf_use_email_certify'])
                    $old_email = $mb_email;
            }

            if ($config['cf_email_mb_super_admin']) { // 최고관리자님께 메일 발송
                $subject = '[' . $config['cf_title'] . '] ' . $mb_nick . ' 님께서 회원으로 가입하셨습니다.';

                ob_start();
                include_once($misc_skin_path . '/register_form_update_mail2.php');
                $content = ob_get_contents();
                ob_end_clean();

                mailer($mb_nick, $mb_email, $config['cf_admin_email'], $subject, $content, 1);
            }
            $mb = get_member($mb_id);
            $entity["mb_no"] = $mb[mb_no];
            $entity["mb_id"] = $mb[mb_id];
            $entity["mb_nick"] = $mb[mb_nick];
            $entity["mb_point"] = $mb[mb_point];
            $entity["mb_hp"] = $mb[mb_hp];
            $entity["mb_1"] = $mb[mb_1];
            $entity["mb_2"] = $mb[mb_2];
            $entity["mb_3"] = $mb[mb_3];
            $entity["mb_4"] = $mb[mb_4];
            $entity["mb_5"] = $mb[mb_5];
            $entity["mb_6"] = $mb[mb_6];
            $entity["mb_7"] = $mb[mb_7];
            $entity["mb_8"] = $mb[mb_8];
            $entity["storeType"] = $mb[mb_09];
            $entity["registrationKey"] = $mb[mb_10];
            $response["returnCode"] = 1;
            $response["returnMessage"] = "회원가입완료";

        } else {
            $response["returnMessage"] = "가입실패";
        }
    }
}



$response["entity"] = $entity;
echo json_encode($response);


?>
