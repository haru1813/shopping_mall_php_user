<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>

<?php
    session_start();

    if (!isset($_SESSION['haruMarket_user_index'])){
        echo "<script>location.href = '/index.php';</script>";
    }

    // if (isset($_SESSION['haruMarket_buy_ready'])){
    //     $haruMarket_buy_ready = $_SESSION['haruMarket_buy_ready'];

    //     if($haruMarket_buy_ready != "OK"){
    //         echo "<script>location.href = '/index.php';</script>";
    //     }
    // }
    // else{
    //     echo "<script>location.href = '/index.php';</script>";
    // }
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
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
                        <label class="form-check-label" for="inlineRadio1">회원정보와 동일</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                        <label class="form-check-label" for="inlineRadio2">새로운 배송지</label>
                    </div>
                    <div class="mt-3">
                        <label for="exampleFormControlInput1" class="form-label">* 받는 사람 이름</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="이름 입력">
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
                    <div class="container-fluid">
                        <?php
                        for ($i = 1; $i <= 3; $i++) {
                        ?>
                        <div class="row border border-dark rounded mb-2">
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <img src="https://classic-blanc.com/web/product/big/202501/8ddd9d14e095e72f4604237de8fd49b3.webp" class="img-thumbnail" width="100">
                            </div>
                            <div class="col-10">
                                <p class="text-dark">
                                    [날씬핏🤎] 루나 체크 리본 플리츠 미니 스커트 겨울 봄 가을 / 소개팅룩 데이트룩 연말룩 클래식블랑
                                </p>
                                <p class="text-secondary mb-0">
                                    [옵션: 블랙/S]
                                </p>
                                <p class="text-secondary">
                                    수량: 1개
                                </p>
                                <p class="text-dark mb-0">
                                    23,800원
                                </p>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="card-footer">
                    최종 결제 금액 : 57,800원
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary">카드 결제</button>
                    <button type="button" class="btn btn-primary">휴대폰 소액 결제</button>
                    <button type="button" class="btn btn-primary">네이버페이 결제</button>
                    <button type="button" class="btn btn-primary">카카오페이 결제</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>
<script src="https://cdn.iamport.kr/v1/iamport.js"></script>
<!-- <script src="./basket.js?v=<?php echo rand(); ?>"></script> -->