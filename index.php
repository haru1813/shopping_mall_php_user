<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>
<div class="container-fluid ps-4 pt-5 pb-5" style='padding-right: 2.6rem !important;'>
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center">
            <span class="display-6 text-dark fw-bold">
                WEEKLY BEST
            </span><br/>
        </div>
        <div class="col-12 d-flex justify-content-center align-items-center">
            <span class="text-secondary fw-bold">
                지금 가장 사랑받는 상품입니다 :)
            </span>
        </div>
        <div class="col-12">
            <!-- Swiper -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper" id="advertise">

                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                        <div class="card-body">
                            <p class="card-title fs-6" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">[벨트set❤연말룩] 라펠 오프숄더 카라 벨트 니트 미니 원피스 겨울 연말룩 / 니트원피스 겨울원피스 가을원피스 클래식블랑</p>
                            <span class="badge rounded-pill text-bg-secondary" style="text-decoration: line-through;">50,000원</span>
                            <span class="badge rounded-pill text-bg-primary">25,000원</span><br/>
                            <span class="badge rounded-pill text-bg-success">무료배송</span> 
                        </div>
                    </div>
                    
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="height: 80px;">
            <span class="display-6 text-dark fw-bold">
                NEW ARRIVALS
            </span>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row" id="new_products"></div>
    </div>
</div>
<script src="/index.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>