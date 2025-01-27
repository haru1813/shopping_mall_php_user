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
?>