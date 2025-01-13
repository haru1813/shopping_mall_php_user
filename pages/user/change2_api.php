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

    if($type == "change2"){
        $haruMarket_user_pw = $_POST["haruMarket_user_pw"];
        $haruMarket_user_changePw1 = $_POST["haruMarket_user_changePw1"];

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

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
        $pdo->beginTransaction();

        try{
            $sql = "update harumarket_user set ";
            $sql .= "haruMarket_user_pw=?,";
            $sql .= "haruMarket_user_updateUserIndex=? ";
            $sql .= "where haruMarket_user_index=?";
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $haruMarket_user_changePw1);
            $stmt->bindParam(2, $haruMarket_user_index);
            $stmt->bindParam(3, $haruMarket_user_index);
            $stmt->execute();
            $pdo->commit();
    
            message("고객님의 비밀번호가 수정되었습니다.","200");
        }
        catch(Exception $e){
            $pdo->rollBack();
            //message($e->getMessage() ,"500");
            message("비밀번호 변경 실패","500");
            return;
        }
    }
?>