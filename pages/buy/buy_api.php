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
                empty($row['harumarket_productColor_index']) ||
                empty($row['harumarket_productSize_index']) ||
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
?>