<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>

<?php
    session_start();

    if (!isset($_SESSION['haruMarket_user_index'])){
        echo "<script>location.href = '/index.php';</script>";
    }

    if (isset($_SESSION['haruMarket_buy_ready'])){
        $haruMarket_buy_ready = $_SESSION['haruMarket_buy_ready'];

        if($haruMarket_buy_ready != "OK"){
            echo "<script>location.href = '/index.php';</script>";
        }
    }
    else{
        echo "<script>location.href = '/index.php';</script>";
    }
?>

<div class="container-fluid ps-4 pt-5 pb-5" style='padding-right: 2.6rem !important;'>
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="height: 80px;">
            <span class="display-5 text-dark fw-bold">
                결제 완료
            </span>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">주문 상품</h5>
                    <div class="container-fluid" id="order_products">
                    </div>
                </div>
                <div class="card-footer" id="harumarket_product_totalPrice">
                    
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" onclick="location.href='/pages/user/order.php'">주문 조회로 이동</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="https://cdn.iamport.kr/v1/iamport.js"></script>
<script src="./buy_complete.js?v=<?php echo rand(); ?>"></script>