<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>

<?php
    session_start();

    if (isset($_SESSION['haruMarket_user_index'])){
        echo "<script>location.href = '/index.php';</script>";
    }
?>

<div class="container-fluid ps-4 pt-5 pb-5" style='padding-right: 2.6rem !important;'>
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="height: 80px;">
            <span class="display-5 text-dark fw-bold">
                FIND PASSWARD
            </span>
        </div>
        <div class="col-12" style="height: 700px;">
            <div class="card h-100 w-100">
                <div class="card-header">
                    비밀번호 찾기
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h5 class="card-title">
                    <label for="haruMarket_user_id" class="form-label">아이디</label>
                    <input type="text" id="haruMarket_user_id" class="form-control mb-3">
                        <p class="fs-5 text-dark fw-bold">
                            비밀번호를 찾기 위하여 아이디를 입력 후<br/>
                            아래의 본인인증하기 버튼을 눌러서<br/>
                            본인인증을 진행하여 주시기 바랍니다.
                        </p>
                        <p class="fs-5 text-danger fw-bold" id="msg">
                        </p>
                    </h5>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="identity">본인인증 하기</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.iamport.kr/v1/iamport.js"></script>
<script src="./pw_find.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>