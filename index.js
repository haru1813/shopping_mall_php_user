let index = {
    swiper : new Swiper(".mySwiper", {
        slidesPerView: 6,
        spaceBetween: 10,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    }),
    init: function(){
        let _this = this;
        _this.new_products();
        // document.getElementById("next").addEventListener("click", () => {
        //     _this.next();
        // });
        // document.getElementById("allCheck").addEventListener("click", () => {
        //     _this.allCheck();
        // });
    },
    new_products: function(){
        const new_products = document.querySelector('#new_products'); 
        new_products.innerHTML = '';

        var formData = new FormData();
        formData.append("type", "new_products");
        data = this.ajax_send(formData,"/index_api.php");

        const imgRegex = /<img[^>]*>/g;


        data.msg.forEach(function(item) {
            const imgTags = item.harumarket_product_picture.match(imgRegex);
            //console.log(imgTags);
            new_products.innerHTML += `
            <div class="col-2 pb-3">
                <div class="card" style="width: 18rem;">
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
    // next: function(){
    //     const check1 = document.getElementById('check1');
    //     const check2 = document.getElementById('check2');

    //     if(check1.checked && check2.checked){
    //         location.href = "./join2.php";
    //     }
    //     else{
    //         toastr.error('이용약관 동의를 체크하지 않으셨습니다.');
    //     }
    // },
    // allCheck: function(){
    //     let allCheck = document.getElementById('allCheck');
    //     let check1 = document.getElementById('check1');
    //     let check2 = document.getElementById('check2');

    //     check1.checked = allCheck.checked;
    //     check2.checked = allCheck.checked;
    // }
}

index.init();