<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>

<?php
    session_start();

    if (isset($_SESSION['haruMarket_join_certification'])){
        $haruMarket_join_certification = $_SESSION['haruMarket_join_certification'];

        if($haruMarket_join_certification != "OK"){
            echo "<script>location.href = '/index.php';</script>";
        }
    }
    else{
        echo "<script>location.href = '/index.php';</script>";
    }
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
                    회원가입 완료
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h5 class="card-title">
                        <p class="fs-5 text-dark fw-bold">
                            반갑습니다. 회원가입이 완료 되었습니다.<br/>
                            저희 쇼핑몰을 이용해 주셔서 감사합니다.
                        </p>
                    </h5>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="ok">확인</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./join4.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>