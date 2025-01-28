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
                장바구니
            </span>
        </div>
        <div class="col-12" style="height: 700px;">
            <div class="card h-100 w-100">
                <div class="card-body d-flex justify-content-center align-items-center m-0 p-0">
                    <div id="grid" class="h-100 w-100"></div>
                </div>
                <div class="m-0 p-0">
                    <span class="badge bg-info text-dark fs-6 mt-2">TOTAL(수량)</span>
                    <span class="badge bg-info text-dark fs-6" id="total">0원 (0개)</span>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="change2">수정</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>
<script src="./basket.js?v=<?php echo rand(); ?>"></script>