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
            <span class="display-6 text-dark fw-bold" id="haruMarket_productCategory_name"></span>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row" id="new_products"></div>
    </div>
    <div id="pagination-container" class="d-flex justify-content-center">
      <ul id="pagination-demo" class="pagination-sm"></ul>
    </div>
</div>
<script src="./product_list.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>