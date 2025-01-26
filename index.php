<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>
<div class="container-fluid ps-4 pt-5 pb-5" style='padding-right: 2.6rem !important;'>
    <div class="row">
        <div class="col-12">
            <!-- <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://picsum.photos/1140/420" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="https://picsum.photos/1140/420" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="https://picsum.photos/1140/420" class="d-block w-100">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div> -->
            <!-- Swiper -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card" style="width: 18rem;">
                            <img src="https://classic-blanc.com/web/product/big/202412/a981724593eea665e6910065f17a301b.webp" alt="image" contenteditable="false">
                        </div>
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
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