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
                비밀번호 변경
            </span>
        </div>
        <div class="col-12" style="height: 700px;">
            <div class="card h-100 w-100">
                <div class="card-header">
                    비밀번호 변경
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h5 class="card-title">
                        <label for="haruMarket_user_pw" class="form-label">현재 비밀번호</label>
                        <input type="password" id="haruMarket_user_pw" class="form-control mb-2">
                        
                        <label for="haruMarket_user_changePw1" class="form-label">* 바꿀 비밀번호</label>
                        <input type="password" id="haruMarket_user_changePw1" class="form-control" aria-describedby="haruMarket_user_changePw1_msg">
                        <div id="haruMarket_user_changePw1_msg" class="form-text mb-2">
                            영소문자 또는 숫자만 포함하여 4~20자(20자) 입력하여주십시오.
                        </div>
                        <label for="haruMarket_user_changePw2" class="form-label">* 바꿀 비밀번호 확인</label>
                        <input type="password" id="haruMarket_user_changePw2" class="form-control" aria-describedby="haruMarket_user_changePw2_msg">
                        <div id="haruMarket_user_changePw2_msg" class="form-text mb-2">
                            입력하신 비밀번호를 한번 더 입력하여 주십시오.
                        </div>
                    </h5>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="change2">수정</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>
<script src="./change2.js?v=<?php echo rand(); ?>"></script>