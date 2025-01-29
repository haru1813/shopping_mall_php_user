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

    if($type == "basket_select"){
        session_start();
        $haruMarket_user_index = $_SESSION['haruMarket_user_index'];

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

        $sql = "
        select
                    t1.harumarket_userBasket_index
                ,   t2.harumarket_product_index
                ,	t2.harumarket_product_picture
                ,	t2.harumarket_product_name
                ,	t1.harumarket_productColor_index
                ,	(select harumarket_productColor_name from harumarket_productcolor where harumarket_productColor_index=t1.harumarket_productColor_index) harumarket_productColor_name
                ,	t1.harumarket_productSize_index
                ,	(select harumarket_productSize_name from harumarket_productsize where harumarket_productSize_index=t1.harumarket_productSize_index) harumarket_productSize_name
                ,	t1.harumarket_userBasket_account
                ,	(t1.harumarket_userBasket_account*t2.harumarket_product_salePrice) harumarket_product_salePrice
        from harumarket_userbasket t1
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
    if($type == "basket_delete"){
        session_start();
        $haruMarket_user_index = $_SESSION['haruMarket_user_index'];
        $harumarket_userBasket_index = $_POST["harumarket_userBasket_index"];

        include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
        $pdo->beginTransaction();

        try{
            $sql = "delete from harumarket_userbasket where haruMarket_user_index=? and harumarket_userBasket_index=?;";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $haruMarket_user_index);
            $stmt->bindParam(2, $harumarket_userBasket_index);
            $stmt->execute();
            $pdo->commit();

            message("장바구니 상품을 삭제하였습니다.","200");
        }
        catch(Exception $e){
            $pdo->rollBack();
            //message($e->getMessage() ,"500");
            message("장바구니 상품 삭제를 실패하였습니다.","500");
            return;
        }
    }
?>