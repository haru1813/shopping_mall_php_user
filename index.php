<?php include $_SERVER['DOCUMENT_ROOT']."/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/nav.php";?>
<div class="container-fluid">
    <?php
        for ($i = 1; $i <= 100; $i++) {
                echo "<p>상품목록</p>";
        }
    ?>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/layout/footer.php";?>