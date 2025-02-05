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

    if($type == "order_select"){
        session_start();
        $haruMarket_user_index = $_SESSION['haruMarket_user_index'];

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

        $sql = "
        select
                    t1.harumarket_buyDetail_index
                ,   t2.harumarket_product_index
                ,	t2.harumarket_product_picture
                ,	t2.harumarket_product_name
                ,	t1.harumarket_productColor_index
                ,	(select harumarket_productColor_name from harumarket_productcolor where harumarket_productColor_index=t1.harumarket_productColor_index) harumarket_productColor_name
                ,	t1.harumarket_productSize_index
                ,	(select harumarket_productSize_name from harumarket_productsize where harumarket_productSize_index=t1.harumarket_productSize_index) harumarket_productSize_name
                ,	t1.harumarket_buyDetail_account
                ,	t1.harumarket_buyDetail_amount harumarket_product_salePrice
                ,   (select haruMarket_BuyMaster_buyerName from harumarket_buymaster where haruMarket_BuyMaster_order=t1.haruMarket_BuyMaster_order) haruMarket_BuyMaster_buyerName
                ,   (select haruMarket_BuyMaster_buyerPostcode from harumarket_buymaster where haruMarket_BuyMaster_order=t1.haruMarket_BuyMaster_order) haruMarket_BuyMaster_buyerPostcode
                ,   (select haruMarket_BuyMaster_buyerAddr from harumarket_buymaster where haruMarket_BuyMaster_order=t1.haruMarket_BuyMaster_order) haruMarket_BuyMaster_buyerAddr
                ,   (select haruMarket_BuyMaster_buyerMethod from harumarket_buymaster where haruMarket_BuyMaster_order=t1.haruMarket_BuyMaster_order) haruMarket_BuyMaster_buyerMethod
                ,   (select haruMarket_BuyMaster_status from harumarket_buymaster where haruMarket_BuyMaster_order=t1.haruMarket_BuyMaster_order) haruMarket_BuyMaster_status
                ,   (select haruMarket_BuyMaster_insertTime from harumarket_buymaster where haruMarket_BuyMaster_order=t1.haruMarket_BuyMaster_order) haruMarket_BuyMaster_insertTime
        from    harumarket_buydetail t1
        inner join	harumarket_product t2 on t1.harumarket_product_index = t2.harumarket_product_index
        where t1.haruMarket_user_index = $haruMarket_user_index;
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