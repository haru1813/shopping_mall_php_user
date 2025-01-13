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

    if($type == "id_find"){
        session_start();
        $haruMarket_user_index = $_SESSION['haruMarket_user_index'];

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');
        $sql = "select * FROM harumarket_user where haruMarket_user_index=$haruMarket_user_index;";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $haruMarket_user_id = $row["haruMarket_user_id"];
        $haruMarket_user_postCode = $row["haruMarket_user_postCode"];
        $haruMarket_user_basicAddress = $row["haruMarket_user_basicAddress"];
        $haruMarket_user_detailAddress = $row["haruMarket_user_detailAddress"];

        $data = array(
            "haruMarket_user_id" => $haruMarket_user_id,
            "haruMarket_user_postCode" => $haruMarket_user_postCode,
            "haruMarket_user_basicAddress" => $haruMarket_user_basicAddress,
            "haruMarket_user_detailAddress" => $haruMarket_user_detailAddress
        );

        message($data,"200");
    }
    if($type == "change1"){
        $haruMarket_user_pw = $_POST["haruMarket_user_pw"];
        $haruMarket_user_postCode = $_POST["haruMarket_user_postCode"];
        $haruMarket_user_basicAddress = $_POST["haruMarket_user_basicAddress"];
        $haruMarket_user_detailAddress = $_POST["haruMarket_user_detailAddress"];

        session_start();
        $haruMarket_user_index = $_SESSION['haruMarket_user_index'];

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');
        $sql = "select * FROM harumarket_user where haruMarket_user_index=$haruMarket_user_index;";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        $haruMarket_user_pw_origin = $row["haruMarket_user_pw"];

        if($haruMarket_user_pw != $haruMarket_user_pw_origin){
            message("비밀번호가 다릅니다.","500");
            return;
        }
        if($haruMarket_user_postCode == "" || $haruMarket_user_basicAddress == "" || $haruMarket_user_detailAddress == ""){
            message("주소를 입력하여 주십시오.","500");
            return;
        }

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
        $pdo->beginTransaction();

        try{
            $sql = "update harumarket_user set ";
            $sql .= "haruMarket_user_postCode=?,";
            $sql .= "haruMarket_user_basicAddress=?,";
            $sql .= "haruMarket_user_detailAddress=?,";
            $sql .= "haruMarket_user_updateTime=now(),";
            $sql .= "haruMarket_user_updateUserIndex=? ";
            $sql .= "where haruMarket_user_index=?";
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $haruMarket_user_postCode);
            $stmt->bindParam(2, $haruMarket_user_basicAddress);
            $stmt->bindParam(3, $haruMarket_user_detailAddress);
            $stmt->bindParam(4, $haruMarket_user_index);
            $stmt->bindParam(5, $haruMarket_user_index);
            $stmt->execute();
            $pdo->commit();
    
            message("고객님의 정보가 수정되었습니다.","200");
        }
        catch(Exception $e){
            $pdo->rollBack();
            //message($e->getMessage() ,"500");
            message("회원정보 수정 실패","500");
            return;
        }
    }
?>