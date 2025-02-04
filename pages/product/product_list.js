let product_list = {
    init: function(){
        let _this = this;

        var formData = new FormData();
        formData.append("type", "haruMarket_productCategory_name");
        formData.append("haruMarket_productCategory_index", localStorage.getItem("haruMarket_productCategory_index"));
        data = this.ajax_send(formData,"./product_list_api.php");
        if(data.msg.length > 1){
            document.getElementById("haruMarket_productCategory_name").innerHTML = "전체상품";
        }
        else{
            document.getElementById("haruMarket_productCategory_name").innerHTML = data.msg[0].haruMarket_productCategory_name;
        }

        formData = new FormData();
        formData.append("type", "total_page");
        formData.append("haruMarket_productCategory_index", localStorage.getItem("haruMarket_productCategory_index"));
        data = this.ajax_send(formData,"./product_list_api.php");
        totalPages = data.msg;

        $('#pagination-demo').twbsPagination({
            totalPages: totalPages,
            visiblePages: 5,
            onPageClick: function (event, page) {
                $('#page-content').text('Page ' + page);
                console.log(page);
                formData = new FormData();
                formData.append("type", "page_view");
                formData.append("haruMarket_productCategory_index", localStorage.getItem("haruMarket_productCategory_index"));
                formData.append("page", page);
                data = product_list.ajax_send(formData,"./product_list_api.php");

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
}

product_list.init();