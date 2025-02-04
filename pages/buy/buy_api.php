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

    if($type == "buy_ready"){
        $harumarket_userBasket_indexs = $_POST["harumarket_userBasket_indexs"];
        $harumarket_userBuy = $_POST["harumarket_userBuy"];
        $data = json_decode($harumarket_userBuy, true);

        foreach ($data as $row){
            if(
                empty($row['harumarket_product_index']) || 
                //empty($row['harumarket_productColor_index']) ||
                //empty($row['harumarket_productSize_index']) ||
                empty($row['harumarket_product_count'])
            )
            {
                message("구매 불가능",500);
                return;
            }
        }

        session_start();
        $_SESSION["harumarket_userBasket_indexs"] = $harumarket_userBasket_indexs;
        $_SESSION["harumarket_userBuy"] = $harumarket_userBuy;
        $_SESSION["haruMarket_buy_ready"] = "OK";

        message("구매 가능",200);
        return;
    }
    if($type == "information_find"){
        session_start();
        $haruMarket_user_index = $_SESSION['haruMarket_user_index'];

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');
        $sql = "select * FROM harumarket_user where haruMarket_user_index=$haruMarket_user_index;";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $haruMarket_user_name = $row["haruMarket_user_name"];
        $haruMarket_user_postCode = $row["haruMarket_user_postCode"];
        $haruMarket_user_basicAddress = $row["haruMarket_user_basicAddress"];
        $haruMarket_user_detailAddress = $row["haruMarket_user_detailAddress"];

        $data = array(
            "haruMarket_user_name" => $haruMarket_user_name,
            "haruMarket_user_postCode" => $haruMarket_user_postCode,
            "haruMarket_user_basicAddress" => $haruMarket_user_basicAddress,
            "haruMarket_user_detailAddress" => $haruMarket_user_detailAddress
        );

        message($data,"200");
    }
    if($type == "product_information_find"){
        session_start();
        $harumarket_userBuy = $_SESSION["harumarket_userBuy"];
        message($harumarket_userBuy,"200");
    }
    if($type == "product_information_view"){
        $harumarket_product_index = $_POST["harumarket_product_index"];
        $harumarket_productColor_index = $_POST["harumarket_productColor_index"];
        $harumarket_productSize_index = $_POST["harumarket_productSize_index"];
        $harumarket_product_count = $_POST["harumarket_product_count"];

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

        $sql = "
        select
                    t1.harumarket_product_name
                ,   (t1.harumarket_product_salePrice*$harumarket_product_count) harumarket_product_salePrice
                ,   t1.harumarket_product_picture
                ,   (select harumarket_productColor_name from harumarket_productcolor where harumarket_productColor_index=$harumarket_productColor_index) harumarket_productColor_name
                ,   (select harumarket_productSize_name from harumarket_productsize where harumarket_productSize_index=$harumarket_productSize_index) haruMarket_productCategory_name
        from    harumarket_product t1
        where   t1.harumarket_product_index=$harumarket_product_index;
        ";

        $result = mysqli_query($con, $sql);

        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        message($data,200);
        return;
    }
    if($type == "product_buy_try"){
        session_start();
        $harumarket_userBuy = $_SESSION["harumarket_userBuy"];
        $data = json_decode($harumarket_userBuy, true);

        $harumarket_product_salePrice = 0;

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

        foreach ($data as $row){
            $harumarket_product_index = $row['harumarket_product_index'];
            $harumarket_product_count = $row['harumarket_product_count'];

            $sql = "
            select
                    (t1.harumarket_product_salePrice*$harumarket_product_count) harumarket_product_salePrice
            from    harumarket_product t1
            where   t1.harumarket_product_index=$harumarket_product_index;
            ";

            $result = mysqli_query($con, $sql);
            $row2 = mysqli_fetch_assoc($result);

            $harumarket_product_salePrice += intval($row2["harumarket_product_salePrice"]);
        }

        $haruMarket_user_index = $_SESSION['haruMarket_user_index'];
        $sql = "select * FROM harumarket_user where haruMarket_user_index=$haruMarket_user_index;";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $haruMarket_user_phone = $row["haruMarket_user_phone"];

        $data = array(
            "harumarket_product_salePrice" => $harumarket_product_salePrice,
            "haruMarket_user_phone" => $haruMarket_user_phone,
        );

        message($data,"200");
    }
    if($type == "product_buy"){
        session_start();
        $haruMarket_user_index = $_SESSION['haruMarket_user_index'];
        $haruMarket_BuyMaster_order = $_POST["haruMarket_BuyMaster_order"];
        $haruMarket_BuyMaster_buyerName = $_POST["haruMarket_BuyMaster_buyerName"];
        $haruMarket_BuyMaster_buyerPostcode = $_POST["haruMarket_BuyMaster_buyerPostcode"];
        $haruMarket_BuyMaster_buyerAddr = $_POST["haruMarket_BuyMaster_buyerAddr"];
        $haruMarket_BuyMaster_buyerMethod = $_POST["haruMarket_BuyMaster_buyerMethod"];
        $haruMarket_BuyMaster_status = "결제완료";
        $haruMarket_BuyMaster_amount = $_POST["haruMarket_BuyMaster_amount"];

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
        $pdo->beginTransaction();

        try{
            $sql = "insert into harumarket_buymaster(";
            $sql .= "haruMarket_user_index,";
            $sql .= "haruMarket_BuyMaster_order,";
            $sql .= "haruMarket_BuyMaster_buyerName,";
            $sql .= "haruMarket_BuyMaster_buyerPostcode,";
            $sql .= "haruMarket_BuyMaster_buyerAddr,";
            $sql .= "haruMarket_BuyMaster_buyerMethod,";
            $sql .= "haruMarket_BuyMaster_status,";
            $sql .= "haruMarket_BuyMaster_amount) ";
            $sql .= "values(?,?,?,?,?,?,?,?);";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $haruMarket_user_index);
            $stmt->bindParam(2, $haruMarket_BuyMaster_order);
            $stmt->bindParam(3, $haruMarket_BuyMaster_buyerName);
            $stmt->bindParam(4, $haruMarket_BuyMaster_buyerPostcode);
            $stmt->bindParam(5, $haruMarket_BuyMaster_buyerAddr);
            $stmt->bindParam(6, $haruMarket_BuyMaster_buyerMethod);
            $stmt->bindParam(7, $haruMarket_BuyMaster_status);
            $stmt->bindParam(8, $haruMarket_BuyMaster_amount);
            $stmt->execute();
        }
        catch(Exception $e){
            $pdo->rollBack();
            message($e->getMessage() ,"500");
            //message("결제 실패","500");
            return;
        }

        $harumarket_userBuy = $_SESSION["harumarket_userBuy"];
        $data = json_decode($harumarket_userBuy, true);

        foreach ($data as $row){
            $harumarket_product_index = $row['harumarket_product_index'];
            $harumarket_productColor_index = $row['harumarket_productColor_index'];
            $harumarket_productSize_index = $row['harumarket_productSize_index'];
            $harumarket_buyDetail_account = $row['harumarket_product_count'];

            $sql = "select harumarket_product_salePrice from harumarket_product where harumarket_product_index=$harumarket_product_index;";
            $result = mysqli_query($con, $sql);
            $row2 = mysqli_fetch_assoc($result);

            $harumarket_product_salePrice = $row2["harumarket_product_salePrice"];

            $harumarket_buyDetail_amount = intval($harumarket_buyDetail_account) * intval($harumarket_product_salePrice);

            try{
                $sql = "insert into harumarket_buydetail(";
                $sql .= "haruMarket_user_index,";
                $sql .= "harumarket_product_index,";
                $sql .= "harumarket_productColor_index,";
                $sql .= "harumarket_productSize_index,";
                $sql .= "harumarket_buyDetail_account,";
                $sql .= "haruMarket_BuyMaster_order,";
                $sql .= "harumarket_buyDetail_amount) ";
                $sql .= "values(?,?,?,?,?,?,?);";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $haruMarket_user_index);
                $stmt->bindParam(2, $harumarket_product_index);
                $stmt->bindParam(3, $harumarket_productColor_index);
                $stmt->bindParam(4, $harumarket_productSize_index);
                $stmt->bindParam(5, $harumarket_buyDetail_account);
                $stmt->bindParam(6, $haruMarket_BuyMaster_order);
                $stmt->bindParam(7, $harumarket_buyDetail_amount);
                $stmt->execute();
            }
            catch(Exception $e){
                $pdo->rollBack();
                message($e->getMessage() ,"500");
                //message("결제 실패","500");
                return;
            }
        }

        $harumarket_userBasket_indexs = $_SESSION["harumarket_userBasket_indexs"];
        if($harumarket_userBasket_indexs != ""){
            $array = json_decode($harumarket_userBasket_indexs);

            foreach ($array as $value){
                try{
                    $sql = "delete from harumarket_userbasket where harumarket_userBasket_index=?;";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(1, $value);
                    $stmt->execute();
                }
                catch(Exception $e){
                    $pdo->rollBack();
                    message($e->getMessage() ,"500");
                    //message("결제 실패","500");
                    return;
                }
            }
        }

        $pdo->commit();
        $_SESSION["haruMarket_buy_ready"] = "OK";
        message("결제 완료","200");
    }
    if($type == "testtest"){
        session_start();
        $harumarket_userBasket_indexs = $_SESSION["harumarket_userBasket_indexs"];
        message($harumarket_userBasket_indexs,"200");
    }
?>