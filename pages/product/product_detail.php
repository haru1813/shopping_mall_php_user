<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>
<div class="container-fluid ps-4 pt-5 pb-5" style='padding-right: 2.6rem !important;'>
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center">
            <div class="card w-100">
                <div class="row">
                    <div class="col-4 p-0" id="harumarket_product_picture">
                        <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" class="img-fluid rounded-start">
                    </div>
                    <div class="col-8 p-0 pt-2 ps-2 pe-3">
                        <div class="card-body p-0 h-100">
                            <h5 class="card-title"></h5>
                            <p class="card-title fs-3" id="harumarket_product_name"></p>
                            <span class="badge rounded-pill text-bg-secondary" style="text-decoration: line-through;" id="harumarket_product_originPrice"></span>
                            <span class="badge rounded-pill text-bg-primary" id="harumarket_product_salePrice"></span><br/>
                            <span class="badge rounded-pill text-bg-success">무료배송</span>

                            <!-- <select class="form-select mt-2" aria-label="Default select example" id="">
                                <option value="" selected>[필수] 옵션을 선택해주세요.</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select> -->
                            <p class="card-body mb-0" id="harumarket_options"></p>

                            <div class="d-grid gap-2 d-md-block mt-2">
                                <button class="btn btn-success btn-sm" type="button" id="buy">구매하기</button>
                                <button class="btn btn-primary btn-sm" type="button" id="basket">장바구니 담기</button>
                            </div>

                            <span class="badge bg-info text-dark fs-6 mt-2">TOTAL(수량)</span>
                            <span class="badge bg-info text-dark fs-6" id="total">0원 (0개)</span>
                            <div class="d-grid gap-2 d-md-block mt-2">
                                <button class="btn btn-secondary btn-sm" type="button" id="impl_up">상품 개수 증가</button>
                                <button class="btn btn-secondary btn-sm" type="button" id="impl_down">상품 개수 감소</button>
                                <button class="btn btn-secondary btn-sm" type="button" id="impl_alldelete">상품 전체 삭제</button>
                            </div>
                            <div class="mt-2" id="grid"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 pt-2 text-center" id="harumarket_product_content"></div>
        
    </div>
</div>
<script src="./product_detail.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>