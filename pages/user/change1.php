<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>

<?php
    session_start();

    if (!isset($_SESSION['haruMarket_user_index'])){
        echo "<script>location.href = '/index.php';</script>";
    }
?>

<div class="container-fluid ps-4 pt-5 pb-5" style='padding-right: 2.6rem !important;'>
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="height: 80px;">
            <span class="display-5 text-dark fw-bold">
                회원 정보 수정
            </span>
        </div>
        <div class="col-12" style="height: 700px;">
            <div class="card h-100 w-100">
                <div class="card-header">
                    회원 정보 수정
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h5 class="card-title">
                        <label for="haruMarket_user_id" class="form-label">아이디</label>
                        <input type="text" id="haruMarket_user_id" class="form-control" disabled readonly>
                        <label for="haruMarket_user_pw" class="form-label">비밀번호</label>
                        <input type="password" id="haruMarket_user_pw" class="form-control">
                        <label class="form-label">주소</label>
                        <div id="haruMarket_user_address_msg" class="form-text mb-2">
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
                    </h5>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="change1">수정</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="./change1.js?v=<?php echo rand(); ?>"></script>