let product_search = {
    init: function(){
        let _this = this;

        document.getElementById("harumarket_product_name").value = localStorage.getItem("harumarket_product_name");
        product_search.category_select();

        document.getElementById("product_search_btn").addEventListener("click", () => {
            _this.product_search_btn();
        });
        _this.product_search_btn();
    },
    ajax_send: function(formData, url){
        let return_date;
        $.ajax({
          type: "POST",
          url: url,
          data: formData,
          contentType: false,
          processData: false,
          async: false,
          dataType: "json",
          success: function (data) {
            console.log(data);
            return_date = data;
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
          },
        });
        return return_date;
    },
    location_href: function(harumarket_product_index){
        localStorage.setItem("harumarket_product_index", harumarket_product_index);
        location.href = `/pages/product/product_detail.php`;
    },
    category_select: function(){
        let harumarket_productcategory = document.getElementById("harumarket_productcategory_select");
        harumarket_productcategory.innerHTML = `
        <option value="0" selected>상품 카테고리 선택</option>
        `;

        formData = new FormData();
        formData.append("type", "category_select");
        data = this.ajax_send(formData,"./product_search_api.php");

        data.msg.forEach(function(item) {
            harumarket_productcategory.innerHTML += `
            <option value="${item.haruMarket_productCategory_index}">${item.haruMarket_productCategory_name}</option>
            `;
        });
    },
    product_search_btn: function(){
        formData = new FormData();
        formData.append("type", "total_page");
        formData.append("haruMarket_productCategory_index", document.getElementById("harumarket_productcategory_select").value);
        formData.append("harumarket_product_name", document.getElementById("harumarket_product_name").value);
        data = this.ajax_send(formData,"./product_search_api.php");
        totalPages = data.msg;

        $('#pagination-demo').twbsPagination('destroy');

        if(totalPages == 0){
            toastr.error("데이터가 존재하지 않습니다.");
            const new_products = document.querySelector('#new_products'); 
            new_products.innerHTML = '';
            return;
        }

        $('#pagination-demo').twbsPagination({
            totalPages: totalPages,
            visiblePages: 5,
            onPageClick: function (event, page) {
                $('#page-content').text('Page ' + page);
                formData = new FormData();
                formData.append("type", "page_view");
                formData.append("haruMarket_productCategory_index", document.getElementById("harumarket_productcategory_select").value);
                formData.append("harumarket_product_name", document.getElementById("harumarket_product_name").value);
                formData.append("page", page);
                data = product_search.ajax_send(formData,"./product_search_api.php");

                const new_products = document.querySelector('#new_products'); 
                new_products.innerHTML = '';

                const imgRegex = /<img[^>]*>/g;

                data.msg.forEach(function(item) {
                    const imgTags = item.harumarket_product_picture.match(imgRegex);
                    //console.log(imgTags);
                    new_products.innerHTML += `
                    <div class="col-2 pb-3">
                        <div class="card" style="width: 18rem;" id="${item.harumarket_product_index}">
                            ${imgTags}
                            <div class="card-body">
                                <p class="card-title fs-6" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${item.harumarket_product_name}</p>
                                <span class="badge rounded-pill text-bg-secondary" style="text-decoration: line-through;">${item.harumarket_product_originPrice}원</span>
                                <span class="badge rounded-pill text-bg-primary">${item.harumarket_product_salePrice}원</span><br/>
                                <span class="badge rounded-pill text-bg-success">무료배송</span> 
                            </div>
                        </div>
                    </div>
                    `;
                });

                const cards = document.querySelectorAll('.card');
                cards.forEach(card => {
                    const image = card.querySelector('img');
                    const cardBody = card.querySelector('.card-body');
                    
                    if (image) {
                    image.style.cursor = 'pointer';
                    image.addEventListener('click', function() {
                        localStorage.setItem("harumarket_product_index", card.id);
                        location.href = `/pages/product/product_detail.php`;
                    });
                    }
                    if (cardBody != null) {
                        const cardTitle = cardBody.querySelector('.card-title');
                        cardTitle.style.cursor = 'pointer';
                            cardTitle.addEventListener('click', function() {
                            localStorage.setItem("harumarket_product_index", card.id);
                            location.href = `/pages/product/product_detail.php`;
                        });
                    }
                });
            }
        });
    },
}

product_search.init();