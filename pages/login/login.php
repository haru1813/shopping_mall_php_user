<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>

<?php
    session_start();

    if (isset($_SESSION['haruMarket_user_index'])){
        echo "<script>location.href = '/index.php';</script>";
    }
?>

<div class="container-fluid px-5 pt-5 pb-5">
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="height: 80px;">
            <span class="display-5 text-dark fw-bold">
                LOGIN
            </span>
        </div>
        <div class="col-12" style="height: 700px;">
            <div class="card h-100 w-100">
                <div class="card-header">
                    로그인
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h5 class="card-title">
                        <label for="haruMarket_user_id" class="form-label">아이디</label>
                        <input type="text" id="haruMarket_user_id" class="form-control mb-2">
                        <label for="haruMarket_user_pw" class="form-label">비밀번호</label>
                        <input type="password" id="haruMarket_user_pw" class="form-control">
                    </h5>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="login">로그인</button>
                    <button type="button" class="btn btn-primary" id="join">회원가입</button>
                    <button type="button" class="btn btn-primary" id="id_find">아이디 찾기</button>
                    <button type="button" class="btn btn-primary" id="pw_find">비밀번호 찾기</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./login.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>