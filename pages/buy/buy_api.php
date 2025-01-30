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
?>