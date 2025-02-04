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

if($type == "haruMarket_productCategory_name"){
    $haruMarket_productCategory_index = $_POST["haruMarket_productCategory_index"];

    $and = "";
    if($haruMarket_productCategory_index != "0"){
        $and = "and     t1.haruMarket_productCategory_index=$haruMarket_productCategory_index";
    }

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select 
            t1.haruMarket_productCategory_name
        from	harumarket_productcategory t1
        where   t1.haruMarket_productCategory_view=1
        $and;
    ";

    $result = mysqli_query($con, $sql);

    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    message($data,200);
    return;
}
if($type == "total_page"){
    $haruMarket_productCategory_index = $_POST["haruMarket_productCategory_index"];

    $and = "";
    if($haruMarket_productCategory_index != "0"){
        $and = "and     t1.haruMarket_productCategory_index=$haruMarket_productCategory_index";
    }

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select 
            count(*) total
        from	harumarket_product t1
        where   t1.harumarket_product_view=1
        $and
        order by t1.harumarket_product_insertTime desc
    ";

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_posts = $row["total"];

    // 총 페이지 수 계산
    $posts_per_page = 30;
    $total_pages = ceil($total_posts / $posts_per_page);

    message($total_pages,200);
    return;
}
if($type == "page_view"){
    $_page = $_POST["page"];
    $page = (intval($_page)-1)*30;

    $haruMarket_productCategory_index = $_POST["haruMarket_productCategory_index"];

    $and = "";
    if($haruMarket_productCategory_index != "0"){
        $and = "and     t1.haruMarket_productCategory_index=$haruMarket_productCategory_index";
    }

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select 
                t1.harumarket_product_index
            ,   t1.harumarket_product_name
            ,	t1.harumarket_product_insertTime
            ,   t1.harumarket_product_picture
            ,   format(t1.harumarket_product_originPrice,0) harumarket_product_originPrice
            ,   format(t1.harumarket_product_salePrice,0) harumarket_product_salePrice
            ,   t1.harumarket_product_index
        from	harumarket_product t1
        where   t1.harumarket_product_view=1
        $and
        order by t1.harumarket_product_insertTime desc
        limit $page,30;
    ";

    $result = mysqli_query($con, $sql);

    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    message($data,"200");
    return;
}
?>