<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>
<style>
  .dt-container .dt-layout-row:first-child {
    display: none;
  }
  #example_info{
    display: none;
  }

  @media (max-width: 768px) {
    .dt-container .dt-layout-row:first-child {
      display: none !important;
    }
  }
  
</style>
<div class="container-fluid ps-4 pt-5 pb-5" style='padding-right: 2.6rem !important;'>
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="height: 80px;">
            <span class="display-6 text-dark fw-bold">
              상품 검색
            </span>
        </div>
        <div class="col-12 d-flex justify-content-center align-items-center pb-2">
          <div class="w-100 rounded border border-dark p-5">
            <div class="input-group mb-2">
              <span class="input-group-text">상품 카테고리</span>
              <select class="form-select" aria-label="Default select example" id="harumarket_productcategory_select">
                <option selected>상품 카테고리 선택</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">상품 이름</span>
              <input type="text" aria-label="First name" class="form-control" id="harumarket_product_name">
            </div>
            <button class="btn btn-primary" type="button" id="product_search_btn">검색</button>
          </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row" id="new_products"></div>
    </div>
    <div id="pagination-container" class="d-flex justify-content-center">
      <ul id="pagination-demo" class="pagination-sm"></ul>
    </div>
</div>
<script src="./product_search.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>