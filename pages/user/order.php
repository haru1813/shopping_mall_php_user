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
                주문 조회
            </span>
        </div>
        <div class="col-12">
            <div class="card h-100 w-100">
                <div class="card-body d-flex justify-content-center align-items-center m-0 p-0">
                    <div id="grid" class="h-100 w-100"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>
<script src="./order.js?v=<?php echo rand(); ?>"></script>