        <nav class="navbar border-top border-1 border-secondary">
            <div class="container-fluid">
                <a class="navbar-brand">
                    <p class="display-5 text-primary fw-bold">
                        HARU MARKET
                    </p>
                    <p class="display-7 text-dark">
                    COMPANY : ㈜ 하루 컴퍼니 OWNER : 박하루 ADDRESS : 경기도 안양시<br/>
                    BUSINESS LICENSE : 000-00-00000
                    </p>
                </a>
            </div>
        </nav>
    </div>
</body>
    <!-- <script src="/assets/js/secure.js?v=<?php echo rand(); ?>"></script> -->
    <script src="/assets/js/common.js?v=<?php echo rand(); ?>"></script>
</html>

<?php
    session_start();
    $_SESSION["haruMarket_join_certification"] = "NO";
    $_SESSION["haruMarket_buy_ready"] = "NO";
?>