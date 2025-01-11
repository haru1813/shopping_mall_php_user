<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>

<?php
    // session_start();

    // if (isset($_SESSION['haruMarket_join_certification'])){
    //     $haruMarket_join_certification = $_SESSION['haruMarket_join_certification'];

    //     if($haruMarket_join_certification != "OK"){
    //         echo "<script>location.href = '/index.php';</script>";
    //     }
    // }
?>

<div class="container-fluid px-5 pt-5 pb-5">
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="height: 80px;">
            <span class="display-5 text-dark fw-bold">
                JOIN
            </span>
        </div>
        <div class="col-12" style="height: 700px;">
            <div class="card h-100 w-100">
                <div class="card-header">
                    회원가입 (3/3) 회원정보 입력
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h5 class="card-title">
                        <label for="haruMarket_user_id" class="form-label">* 아이디</label>
                        <input type="text" id="haruMarket_user_id" class="form-control" aria-describedby="haruMarket_user_id_msg">
                        <div id="haruMarket_user_id_msg" class="form-text mb-2">
                            영소문자 또는 숫자만 포함하여 4~20자(20자) 입력하여주십시오.
                        </div>
                        <label for="haruMarket_user_pw" class="form-label">* 비밀번호</label>
                        <input type="password" id="haruMarket_user_pw" class="form-control" aria-describedby="haruMarket_user_pw_msg">
                        <div id="haruMarket_user_pw_msg" class="form-text mb-2">
                            영소문자 또는 숫자만 포함하여 4~20자(20자) 입력하여주십시오.
                        </div>
                        <label for="haruMarket_user_pw_check" class="form-label">* 비밀번호 확인</label>
                        <input type="password" id="haruMarket_user_pw_check" class="form-control" aria-describedby="haruMarket_user_pw_check_msg">
                        <div id="haruMarket_user_pw_check_msg" class="form-text mb-2">
                            입력하신 비밀번호를 한번 더 입력하여 주십시오.
                        </div>

                        <label class="form-label">* 주소</label>
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
                        <input type="text" id="haruMarket_user_detail_Address" class="form-control" placeholder="상세 주소">
                    </h5>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="join">회원가입</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="./join3.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>