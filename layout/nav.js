let nav = {
    init: function(){
        let _this = this;
        _this.harumarket_productcategory();
    },
    harumarket_productcategory: function(){
        const harumarket_productcategory = document.querySelector('#harumarket_productcategory'); 
        harumarket_productcategory.innerHTML = '';

        harumarket_productcategory.innerHTML += `
            <li class="nav-item">
                <a class="nav-link text-black" aria-current="page" href="#">전체상품</a>
            </li>
        `;

        var formData = new FormData();
        formData.append("type", "harumarket_productcategory");
        data = this.ajax_send(formData,"/layout/nav_api.php");

        data.msg.forEach(function(item) {
            harumarket_productcategory.innerHTML += `
                <li class="nav-item">
                    <a class="nav-link text-black" aria-current="page" href="#">${item.haruMarket_productCategory_name}</a>
                </li>
            `;
        });

        harumarket_productcategory.innerHTML += `
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
            </li>
        `;
    },
    // allCheck: function(){
    //     let allCheck = document.getElementById('allCheck');
    //     let check1 = document.getElementById('check1');
    //     let check2 = document.getElementById('check2');

    //     check1.checked = allCheck.checked;
    //     check2.checked = allCheck.checked;
    // }
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