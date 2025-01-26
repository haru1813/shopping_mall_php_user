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

if($type == "new_products"){
    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select 
            t1.harumarket_product_name
            ,	t1.harumarket_product_insertTime
            ,   t1.harumarket_product_picture
            ,   format(t1.harumarket_product_originPrice,0) harumarket_product_originPrice
            ,   format(t1.harumarket_product_salePrice,0) harumarket_product_salePrice
        from	harumarket_product t1
        order by t1.harumarket_product_insertTime desc
        limit 30;
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