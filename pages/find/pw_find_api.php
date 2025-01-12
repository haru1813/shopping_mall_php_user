<?php
function message($message,$code = "999"){
  header('Content-Type: application/json');  
  $data = array("code" => $code, "msg" => $message);  
  $result = json_encode($data);
  echo $result;
}
function generateRandomPassword($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
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

    $haruMarket_user_id = $_POST["haruMarket_user_id"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');
    $sql = "SELECT * FROM harumarket_user where haruMarket_user_uniqueKey='$unique_key' and haruMarket_user_id='$haruMarket_user_id';";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    $total_rows = mysqli_num_rows($result);
    if($total_rows == 0){
      message("아직 회원가입을 진행하지 않으시거나<br/>아이디를 잘못 입력하셨습니다.","500");
    }
    else{
      // 임시 비밀번호 생성
      $haruMarket_user_pw = generateRandomPassword(10);

      $haruMarket_user_index = $row["haruMarket_user_index"];

      include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
      $pdo->beginTransaction();

      try{
        $sql = "update harumarket_user set ";
        $sql .= "haruMarket_user_pw=?,";
        $sql .= "haruMarket_user_updateTime=now(),";
        $sql .= "haruMarket_user_updateUserIndex=? ";
        $sql .= "where haruMarket_user_index=?";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $haruMarket_user_pw);
        $stmt->bindParam(2, $haruMarket_user_index);
        $stmt->bindParam(3, $haruMarket_user_index);
        $stmt->execute();
        $pdo->commit();

        message("고객님의 임시 비밀번호는<br/>$haruMarket_user_pw 입니다.","200");
      }
      catch(Exception $e){
        $pdo->rollBack();
        //message($e->getMessage() ,"500");
        message("비밀번호 찾기 실패","500");
        return;
    }
    }

    //$haruMarket_user_id = $row["haruMarket_user_id"];
    //message("고객님의 아이디는 $haruMarket_user_id 입니다.","200");
?>