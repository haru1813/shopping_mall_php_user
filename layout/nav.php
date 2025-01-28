<body style="overflow-x: hidden;">
    <div id="pc">
        <div class="container-fluid border-bottom border-1 border-secondary" style="height: 80px;">
            <div class="row h-100">
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <ul class="nav">
                        <?php
                            session_start();

                            if (isset($_SESSION['haruMarket_user_index']))
                            {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link text-black" aria-current="page" href="/logout.php">LOGOUT</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-black" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">MY PAGE</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/pages/user/change1.php">회원 정보 수정</a></li>
                                <li><a class="dropdown-item" href="/pages/user/change2.php">비밀번호 변경</a></li>
                                <li><a class="dropdown-item" href="/pages/user/basket.php">장바구니</a></li>
                                <li><a class="dropdown-item" href="#">주문 조회</a></li>
                            </ul>
                        </li>
                        <?php
                            }
                            else{
                        ?>
                        <li class="nav-item">
                            <a class="nav-link text-black" aria-current="page" href="/pages/login/login.php">LOGIN</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black" href="/pages/join/join1.php">JOIN</a>
                        </li>
                        <?php
                            }
                        ?>
                        
                    </ul>
                </div>
                <div class="col-8 d-flex justify-content-center align-items-center">
                    <span class="display-5 text-primary fw-bold">
                        <a class="text-decoration-none" href="/index.php">HARU MARKET</a>
                    </span>
                </div> 
                <div class="col-2 d-flex align-items-center">
                    <div class="input-group m-3">
                        <input type="text" class="form-control" placeholder="상품을 검색하세요." aria-label="Search" style="width:20px;">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div> 
            </div>
        </div>
        <ul class="nav border-bottom border-1 border-secondary justify-content-center" id="harumarket_productcategory">
            <!-- <li class="nav-item">
                <a class="nav-link text-black" aria-current="page" href="#">전체상품</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black" aria-current="page" href="#">원피스/세트</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black" aria-current="page" href="#">상의</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black" aria-current="page" href="#">하의</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black" aria-current="page" href="#">아우터</a>
            </li>
            <li class="nav-item">
                <span class="nav-link text-black" aria-current="page" href="#">/</span>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black" aria-current="page" href="#">NOTICE</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black" aria-current="page" href="#">Q & A</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black" aria-current="page" href="#">REVIEW</a>
            </li> -->
        </ul>
<script src="/layout/nav.js?v=<?php echo rand(); ?>"></script>