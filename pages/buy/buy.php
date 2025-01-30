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
                주문/결제
            </span>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">배송지</h5>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="informationRadio" value="1" checked>
                        <label class="form-check-label" for="inlineRadio1">회원정보와 동일</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="informationRadio" value="0">
                        <label class="form-check-label" for="inlineRadio2">새로운 배송지</label>
                    </div>
                    <div class="mt-3">
                        <label for="haruMarket_user_name" class="form-label">* 받는 사람 이름</label>
                        <input type="text" class="form-control" id="haruMarket_user_name" placeholder="이름 입력">
                    </div>
                    <label class="form-label mt-3 mb-0">* 주소</label>
                    <div id="haruMarket_user_address_msg" class="form-text">
                        우편번호를 클릭하여 주소를 입력하여 주십시오.
                    </div>
                    <div class="row g-3 align-items-center mb-1">
                        <div class="col-auto">
                            <input type="text" id="haruMarket_user_postCode" class="form-control" placeholder="우편번호" disabled readonly>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" id="addressFind">우편번호</button>
                        </div>
                    </div>
                    <input type="text" id="haruMarket_user_basicAddress" class="form-control mb-1" placeholder="기본 주소" disabled readonly>
                    <input type="text" id="haruMarket_user_detailAddress" class="form-control" placeholder="상세 주소">
                </div>
            </div>
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
                    <button type="button" class="btn btn-primary" id="card">카드 결제</button>
                    <button type="button" class="btn btn-primary" id="phone">휴대폰 소액 결제</button>
                    <button type="button" class="btn btn-primary" id="naverpay">네이버페이 결제</button>
                    <button type="button" class="btn btn-primary" id="kakaopay">카카오페이 결제</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="https://cdn.iamport.kr/v1/iamport.js"></script>
<script src="./buy.js?v=<?php echo rand(); ?>"></script>