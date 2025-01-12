<?php
function message($message,$code = "999"){
  header('Content-Type: application/json');  
  $data = array("code" => $code, "msg" => $message);  
  $result = json_encode($data);
  echo $result;
}
?>
<?php
    $type = $_POST["type"];

    if($type == "login"){
        $haruMarket_user_id = $_POST["haruMarket_user_id"];
        $haruMarket_user_pw = $_POST["haruMarket_user_pw"];

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');
        $sql = "SELECT * FROM harumarket_user where haruMarket_user_id='$haruMarket_user_id';";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        $total_rows = mysqli_num_rows($result);
        if($total_rows == 0){
            message("존재하지 않는 아이디입니다.","500");
            return;
        }

        $sql = "SELECT * FROM harumarket_user where haruMarket_user_id='$haruMarket_user_id' and haruMarket_user_pw='$haruMarket_user_pw';";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        $total_rows = mysqli_num_rows($result);
        if($total_rows == 0){
            message("비밀번호를 틀리셨습니다.","500");
            return;
        }
        else{
            // 로그인 인증 처리
            session_start();
            $haruMarket_user_index = $row["haruMarket_user_index"];
            $_SESSION["haruMarket_user_index"] = $haruMarket_user_index;
            message("로그인 인증 완료","200");
        }
    }
?>