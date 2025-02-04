let nav = {
    init: function(){
        let _this = this;
        _this.harumarket_productcategory();

        const inputElement = document.getElementById('haruMarket_productCategory_name_search');
        inputElement.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') { // Enter 키를 눌렀을 때
                nav.move2();
            }
        });

        document.getElementById("haruMarket_productCategory_name_searchbtn").addEventListener("click", () => {
            nav.move2();
        });
    },
    harumarket_productcategory: function(){
        const harumarket_productcategory = document.querySelector('#harumarket_productcategory'); 
        harumarket_productcategory.innerHTML = '';

        harumarket_productcategory.innerHTML += `
            <li class="nav-item" style="cursor:pointer;">
                <a class="nav-link text-black" aria-current="page" onclick="nav.move(0)">전체상품</a>
            </li>
        `;

        var formData = new FormData();
        formData.append("type", "harumarket_productcategory");
        data = this.ajax_send(formData,"/layout/nav_api.php");

        data.msg.forEach(function(item) {
            harumarket_productcategory.innerHTML += `
                <li class="nav-item" style="cursor:pointer;">
                    <a class="nav-link text-black" aria-current="page" onclick="nav.move(${item.haruMarket_productCategory_index})">${item.haruMarket_productCategory_name}</a>
                </li>
            `;
        });

        // harumarket_productcategory.innerHTML += `
        //     <li class="nav-item">
        //         <span class="nav-link text-black" aria-current="page" href="#">/</span>
        //     </li>
        //     <li class="nav-item">
        //         <a class="nav-link text-black" aria-current="page" href="#">NOTICE</a>
        //     </li>
        //     <li class="nav-item">
        //         <a class="nav-link text-black" aria-current="page" href="#">Q & A</a>
        //     </li>
        //     <li class="nav-item">
        //         <a class="nav-link text-black" aria-current="page" href="#">REVIEW</a>
        //     </li>
        // `;
    },
    move:function(haruMarket_productCategory_index){
        localStorage.setItem("haruMarket_productCategory_index", haruMarket_productCategory_index);
        location.href = `/pages/product/product_list.php`;
    },
    move2:function(){
        localStorage.setItem("haruMarket_productCategory_index", 0);
        localStorage.setItem("harumarket_product_name", document.getElementById('haruMarket_productCategory_name_search').value);
        location.href = `/pages/product/product_search.php`;
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
    }
}

nav.init();