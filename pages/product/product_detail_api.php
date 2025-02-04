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

if($type == "product_view"){
    $harumarket_product_index = $_POST["harumarket_product_index"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select 
            t1.harumarket_product_name
            ,	t1.harumarket_product_insertTime
            ,   t1.harumarket_product_picture
            ,   format(t1.harumarket_product_originPrice,0) harumarket_product_originPrice
            ,   format(t1.harumarket_product_salePrice,0) harumarket_product_salePrice
            ,   t1.harumarket_product_content
            ,   t1.harumarket_product_sizeView
            ,   t1.harumarket_product_colorView
            ,   t1.harumarket_product_colorIndexs
            ,   t1.harumarket_product_sizeIndexs
        from	harumarket_product t1
        where   t1.harumarket_product_view=1
        and     t1.harumarket_product_index=$harumarket_product_index;
    ";

    $result = mysqli_query($con, $sql);

    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    message($data,200);
    return;
}
if($type == "harumarket_product_optionSelect"){
    $table_name = $_POST["table_name"];
    $harumarket_product_optionIndexs = $_POST["harumarket_product_optionIndexs"];
    $option_name = "";
    if($table_name == "harumarket_productcolor"){
        $option_name = "harumarket_productColor_index";
    }
    else{
        $option_name = "harumarket_productSize_index";
    }

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select
            *
        from $table_name t1
        where t1.$option_name in $harumarket_product_optionIndexs;
    ";

    $result = mysqli_query($con, $sql);

    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    message($data,200);
    return;
}
if($type == "harumarket_loginCheck"){
    session_start();
    $haruMarket_user_index = $_SESSION['haruMarket_user_index'];

    if($haruMarket_user_index == null){
        message("로그인 후에 해당 기능을 이용하여 주십시오.","500");
        return;
    }
    else{
        message("로그인 인증 됨","200");
        return;
    }
}
if($type == "harumarket_userbasket"){
    session_start();
    $haruMarket_user_index = $_SESSION['haruMarket_user_index'];
    $harumarket_product_index = $_POST["harumarket_product_index"];
    $harumarket_productColor_index = $_POST["harumarket_productColor_index"];
    $harumarket_productSize_index = $_POST["harumarket_productSize_index"];
    $harumarket_userBasket_account = $_POST["harumarket_userBasket_account"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');
    $sql = "SELECT * FROM harumarket_userbasket where haruMarket_user_index='$haruMarket_user_index';";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    $total_rows = mysqli_num_rows($result);
    if($total_rows > 10){
        message("장바구니는 10개까지만 등록 가능합니다.","500");
        return;
    }

    $sql = "SELECT * FROM harumarket_userbasket where ";
    $sql .= "haruMarket_user_index='$haruMarket_user_index' and ";
    $sql .= "harumarket_product_index='$harumarket_product_index' and ";
    $sql .= "harumarket_productColor_index='$harumarket_productColor_index' and ";
    $sql .= "harumarket_productSize_index='$harumarket_productSize_index';";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $total_rows = mysqli_num_rows($result);
    if($total_rows == 0){
        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
        $pdo->beginTransaction();

        try{
            $sql = "insert into harumarket_userbasket(";
            $sql .= "haruMarket_user_index,";
            $sql .= "harumarket_product_index,";
            $sql .= "harumarket_productColor_index,";
            $sql .= "harumarket_productSize_index,";
            $sql .= "harumarket_userBasket_account) ";
            $sql .= "values(?,?,?,?,?);";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $haruMarket_user_index);
            $stmt->bindParam(2, $harumarket_product_index);
            $stmt->bindParam(3, $harumarket_productColor_index);
            $stmt->bindParam(4, $harumarket_productSize_index);
            $stmt->bindParam(5, $harumarket_userBasket_account);
            $stmt->execute();
            $pdo->commit();

            message("장바구니를 등록하였습니다.","200");
        }
        catch(Exception $e){
            $pdo->rollBack();
            //message($e->getMessage() ,"500");
            message("장바구니 등록을 실패하였습니다.","500");
            return;
        }
    }
    else{
        $harumarket_userBasket_index = $row["harumarket_userBasket_index"];
        $_harumarket_userBasket_account = $row["harumarket_userBasket_account"];

        $harumarket_userBasket_account_real = intval($_harumarket_userBasket_account)+intval($harumarket_userBasket_account);

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
        $pdo->beginTransaction();

        try{
            $sql = "update harumarket_userbasket set ";
            $sql .= "harumarket_userBasket_account=?,";
            $sql .= "harumarket_userBasket_updateTime=now(),";
            $sql .= "harumarket_userBasket_updateUserIndex=? ";
            $sql .= "where harumarket_userBasket_index=?";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $harumarket_userBasket_account_real);
            $stmt->bindParam(2, $haruMarket_user_index);
            $stmt->bindParam(3, $harumarket_userBasket_index);
            $stmt->execute();
            $pdo->commit();

            message("장바구니를 등록하였습니다.","200");
        }
        catch(Exception $e){
            $pdo->rollBack();
            //message($e->getMessage() ,"500");
            message("장바구니 등록을 실패하였습니다.","500");
            return;
        }
    }
}
?>