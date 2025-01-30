let buy_complete = {
    init: function(){
        let _this = this;

        buy_complete.product_information_find();
    },
    product_information_find:function(){
        let formData = new FormData();
        formData.append("type", "product_information_find");
        data = ajax_send(formData,"./buy_api.php");
        const product_informations = JSON.parse(data.msg);

        let harumarket_product_totalPrice = 0;

        product_informations.forEach(product_information => {
            let formData = new FormData();
            formData.append("type", "product_information_view");
            formData.append("harumarket_product_index", product_information.harumarket_product_index);
            formData.append("harumarket_productColor_index", product_information.harumarket_productColor_index);
            formData.append("harumarket_productSize_index", product_information.harumarket_productSize_index);
            formData.append("harumarket_product_count", product_information.harumarket_product_count);
            data = ajax_send(formData,"./buy_api.php");

            const regex = /<img[^>]*src="([^"]*)"/g; // 정규 표현식
            const match = regex.exec(data.msg[0].harumarket_product_picture);
            const srcValue = match[1];

            harumarket_product_totalPrice += Number(data.msg[0].harumarket_product_salePrice);

            document.getElementById('order_products').innerHTML += `
                <div class="row border border-dark rounded mb-2">
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <img src="${srcValue}" class="img-thumbnail" width="100" style="cursor:pointer" onclick="buy_complete.location_href(${product_information.harumarket_product_index})">
                    </div>
                    <div class="col-10">
                        <p class="text-dark" style="cursor:pointer" onclick="buy_complete.location_href(${product_information.harumarket_product_index})">
                            ${data.msg[0].harumarket_product_name}
                        </p>
                        <p class="text-secondary mb-0">
                            [옵션: ${data.msg[0].harumarket_productColor_name === null ? "" : data.msg[0].harumarket_productColor_name} ${data.msg[0].haruMarket_productCategory_name === null ? "" : data.msg[0].haruMarket_productCategory_name}]
                        </p>
                        <p class="text-secondary">
                            수량: ${product_information.harumarket_product_count}개
                        </p>
                        <p class="text-dark mb-0">
                            ${data.msg[0].harumarket_product_salePrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')}원
                        </p>
                    </div>
                </div>
            `;
        });

        document.getElementById('harumarket_product_totalPrice').innerHTML = `최종 결제 금액 : ${harumarket_product_totalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')}원`;
    },
    location_href: function(harumarket_product_index){
        localStorage.setItem("harumarket_product_index", harumarket_product_index);
        location.href = `/pages/product/product_detail.php`;
    },
}

buy_complete.init();