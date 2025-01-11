<?php
function message($message,$code = "999"){
  header('Content-Type: application/json');  
  $data = array("code" => $code, "msg" => $message);  
  $result = json_encode($data);
  echo $result;
}
?>
<?php
  $imp_uid = "";
  $msg = "";

  if(isset($_POST['imp_uid']))
  {
    $imp_uid = $_POST["imp_uid"];
    $msg = "post";
  }

  $ch = curl_init();

    $url = "https://api.iamport.kr/users/getToken";

    // 옵션 설정
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // post 형태로 데이터를 전송할 경우
    $postdata = array(
      "imp_key"=>"0612271828576128",
      "imp_secret"=>"iaCDp6uyoZwaXToAAeCCKODuZhLoSNnVKiHhOdgMSL4ILNhnmxF1PSRxHf8jeeS34a1Yzou5vRuG4sOs"
    );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));

    $output = curl_exec($ch); // 데이터 요청 후 수신

    //echo $output;
    //echo "<br/>";

    $data = json_decode($output);

    $access_token = $data->response->access_token;

    //echo $access_token;
    //echo "<br/>";

    curl_close($ch);

    // ----------------------------------------------------------------------------------------------------------------------

    $ch = curl_init(); // 리소스 초기화

    $url = "https://api.iamport.kr/certifications/".$imp_uid;

    // 옵션 설정
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization:'.$access_token
    ));

    $output = curl_exec($ch); // 데이터 요청 후 수신

    $output = mb_convert_encoding($output, "UTF-8","EUC-KR");

    //echo $output;

    /*
    "birth":689785200,
    "birthday":"1991-11-11",
    "certified":true,
    "certified_at":1723369106,
    "foreigner":false,
    "foreigner_v2":false,
    "gender":"male",
    "imp_uid":"imp_894072796825",
    "merchant_uid":"harubarter 2024-08-11",
    "name":"\ubc15\ud558\ub8e8",
    "origin":"http:\/\/localhost:201\/index.php?p=common&m=join&c=join2",
    "pg_provider":"inicis_unified",
    "pg_tid":"INISA_MIIiasTest202408111837529392113202",
    "phone":"01052916094",
    "unique_in_site":null,
    "unique_key":"AB4+z\/XnnK9NNYV2Om7LMmBQ2q\/tqebfhmVaWzoWW0oIqqcdQzqY\/B\/kP56Z0zeeHF4hgpQ1zk68CjiWf7BANQ=="
    */

    $data = json_decode($output);

    $birthday = $data->response->birthday;
    $gender = $data->response->gender;
    $foreigner = $data->response->foreigner;
    $name = $data->response->name;
    $phone = $data->response->phone;
    $unique_key = $data->response->unique_key;

    session_start();
    $_SESSION["haruMarket_user_birthday"] = $birthday;
    $_SESSION["haruMarket_user_gender"] = $gender;
    $_SESSION["haruMarket_user_name"] = $name;
    $_SESSION["haruMarket_user_phone"] = $phone;
    $_SESSION["haruMarket_user_uniqueKey"] = $unique_key;
    $_SESSION["haruMarket_join_certification"] = "OK";

    message("인증 성공","200");

    // include($_SERVER["DOCUMENT_ROOT"].'/db_connect.php');
    // $sql = "SELECT * FROM User where user_key='$unique_key';";
    // $result = mysqli_query($con, $sql);
    // $row = mysqli_fetch_assoc($result);

    // $total_rows = mysqli_num_rows($result);

    // if($total_rows != 0){
    //   message("이미 가입되셨습니다.","500");
    // }
    // else
    // {
    //   session_start();
    //   $_SESSION["name"] = $name;
    //   $_SESSION["phone"] = $phone;
    //   $_SESSION["gender"] = $gender;
    //   $_SESSION["birthday"] = $birthday;
    //   $_SESSION["unique_key"] = $unique_key;
    //   message("인증 성공","200");
    // }
?>