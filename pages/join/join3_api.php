<?php
function message($message,$code = "999"){
  header('Content-Type: application/json');  
  $data = array("code" => $code, "msg" => $message);  
  $result = json_encode($data);
  echo $result;
}
function validateText($text) {
    $pattern = "/^[a-z0-9]{1,20}$/";
    return preg_match($pattern, $text);
}
?>
<?php
    $type = $_POST["type"];

    if($type == "join"){
        $haruMarket_user_id = $_POST["haruMarket_user_id"];
        $haruMarket_user_pw = $_POST["haruMarket_user_pw"];
        $haruMarket_user_postCode = $_POST["haruMarket_user_postCode"];
        $haruMarket_user_basicAddress = $_POST["haruMarket_user_basicAddress"];
        $haruMarket_user_detailAddress = $_POST["haruMarket_user_detailAddress"];

        session_start();
        $haruMarket_user_birthday = $_SESSION["haruMarket_user_birthday"];
        $haruMarket_user_gender = $_SESSION["haruMarket_user_gender"];
        $haruMarket_user_name = $_SESSION["haruMarket_user_name"];
        $haruMarket_user_phone = $_SESSION["haruMarket_user_phone"];
        $haruMarket_user_uniqueKey = $_SESSION["haruMarket_user_uniqueKey"];
        $haruMarket_user_role = "사용자";

        if($haruMarket_user_id == ""){
            message("아이디를 입력하여 주십시오.","500");
            return;
        }
        if(!validateText($haruMarket_user_id)){
            message("아이디는 영소문자 또는 숫자만 포함하여 4~20자(20자) 입력하여주십시오.","500");
            return;
        }
        if($haruMarket_user_pw == ""){
            message("비밀번호를 입력하여 주십시오.","500");
            return;
        }
        if(!validateText($haruMarket_user_pw)){
            message("비밀번호는 영소문자 또는 숫자만 포함하여 4~20자(20자) 입력하여주십시오.","500");
            return;
        }
        if($haruMarket_user_postCode == "" || $haruMarket_user_basicAddress == "" || $haruMarket_user_detailAddress == ""){
            message("주소를 입력하여 주십시오.","500");
            return;
        }

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');
        $sql = "SELECT * FROM harumarket_user where haruMarket_user_id='$haruMarket_user_id';";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        $total_rows = mysqli_num_rows($result);
        if($total_rows != 0){
            message("이미 존재하는 아이디입니다. 다른 아이디를 입력하여 주십시오.","500");
            return;
        }

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
        $pdo->beginTransaction();

        try{
            $sql = "insert into harumarket_user(";
            $sql .= "haruMarket_user_id,";
            $sql .= "haruMarket_user_pw,";
            $sql .= "haruMarket_user_postCode,";
            $sql .= "haruMarket_user_basicAddress,";
            $sql .= "haruMarket_user_detailAddress,";
            $sql .= "haruMarket_user_birthday,";
            $sql .= "haruMarket_user_gender,";
            $sql .= "haruMarket_user_name,";
            $sql .= "haruMarket_user_phone,";
            $sql .= "haruMarket_user_uniqueKey,";
            $sql .= "haruMarket_user_role) ";
            $sql .= "values(?,?,?,?,?,?,?,?,?,?,?);";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $haruMarket_user_id);
            $stmt->bindParam(2, $haruMarket_user_pw);
            $stmt->bindParam(3, $haruMarket_user_postCode);
            $stmt->bindParam(4, $haruMarket_user_basicAddress);
            $stmt->bindParam(5, $haruMarket_user_detailAddress);
            $stmt->bindParam(6, $haruMarket_user_birthday);
            $stmt->bindParam(7, $haruMarket_user_gender);
            $stmt->bindParam(8, $haruMarket_user_name);
            $stmt->bindParam(9, $haruMarket_user_phone);
            $stmt->bindParam(10, $haruMarket_user_uniqueKey);
            $stmt->bindParam(11, $haruMarket_user_role);
            $stmt->execute();
        }
        catch(Exception $e){
            $pdo->rollBack();
            //message($e->getMessage() ,"500");
            message("회원가입 실패","500");
            return;
        }
        $pdo->commit();

        // 로그인 인증 처리
        $sql = "SELECT haruMarket_user_index FROM harumarket_user where haruMarket_user_id='$haruMarket_user_id';";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $haruMarket_user_index = $row["haruMarket_user_index"];
        $_SESSION["haruMarket_user_index"] = $haruMarket_user_index;
        $_SESSION["haruMarket_join_certification"] = "OK";

        message("회원 가입 완료","200");
    }
?>