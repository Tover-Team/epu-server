  <div class="header">
    <meta charset="UTF-8">
<a href="http://bjeong.com/pushmanager/main.php">HOME</a>
  </div>
  
  <div>
<h2>ok</h2>
  </div>
  
   <style type="text/css">
   a:link {text-decoration:none; color:#000000;} // 링크 걸렸을 시
a:visited {text-decoration:none; color:#000000;} // 방문 했을 시
a:active {text-decoration:none; color:#000000;} // 방문 중
a:hover {text-decoration:none; color:#000000;} // 링크에 마우스를 올렸을 시
                *,
                *:before,
                *:after {
                box-sizing: border-box;
                }
                body {background-color: #efefef;margin:0px;padding:0px;}
                .messageWrapper {width:500px; margin:0 auto;background:white;padding:10px;}

                ul li {width: 500px; margin:0 auto;}

                #submitButton {
                width: 90px;
                padding:5px;
                border:2px solid #ccc;
                -webkit-border-radius: 5px;
                border-radius: 5px;
                font: 14px/1.4 "Helvetica Neue", Helvetica, Arial, sans-serif;
                }
                .header{
                  margin:0px;padding:20px;
                  width:100%;
                   height:50px;
                  background:#e45959
                }
				.header a{
					color:white;
				}
              </style>
<?php 
	
	function send_notification ($tokens, $message)
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
       curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
	}

	function send_notification_ios($tokensIos, $messageIos){

        // 개발용
        $apnsHost = 'gateway.sandbox.push.apple.com';
        $apnsCert = './ios.pem';
        // 실서비스용
        //$apnsHost = 'gateway.push.apple.com';
        //$apnsCert = 'apns-production.pem';
        $apnsPort = 2195;
        $tokenCount = count($tokensIos);
        if(true){
            echo "<script>alert(\"".$tokenCount."\");</script>";
            return;
        }

	    for($i=0;i< count($tokensIos);$i++){
            $deviceToken = $tokensIos[$i];
            $message = $messageIos;
            $payload = array('aps' => array('alert' => $message, 'badge' => 0, 'sound' => 'default','urlPath' => "http://naver.com/"));
            $payload = json_encode($payload);
            $streamContext = stream_context_create();
            stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
            $apns = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
            if (!$apns) {
                print "Failed to connect $error $errorString\n";
                return;
            }
            $apnsMessage = chr(0).chr(0).chr(32).pack('H*', str_replace(' ', '', $deviceToken)).chr(0).chr(strlen($payload)).$payload;
            $writeResult = fwrite($apns, $apnsMessage);
            socket_close($apns);
            fclose($apns);
        }
    }
	

	//데이터베이스에 접속해서 토큰들을 가져와서 FCM에 발신요청
	include_once 'config.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$sql = "Select Token From users";

	$result = mysqli_query($conn,$sql);
	$tokens = array();
    $tokensIos = array();
	if(mysqli_num_rows($result) > 0 ){
		while ($row = mysqli_fetch_assoc($result)) {
		    if( $row["storeNumber"] == "1"){
                $tokens[] = $row["Token"];
            }else{
                $tokensIos[] = $row["Token"];
            }

		}
	}

	mysqli_close($conn);
	
        $myMessage = $_POST['message']; //폼에서 입력한 메세지를 받음
	if ($myMessage == ""){
		$myMessage = "새글이 등록되었습니다.";
	}

	$message = array("message" => $myMessage);
	//$message_status = send_notification($tokens, $message);
    send_notification_ios($tokensIos,$message);
	echo $message_status;
 ?>
  <script>
    alert('푸시전송완성');
    window.close();
  </script>
  