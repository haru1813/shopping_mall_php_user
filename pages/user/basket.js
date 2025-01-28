let basket = {
    init: function(){
        let _this = this;

        _this.basket_select();
    },
    grid: new tui.Grid({
        el: document.getElementById('grid'),
        data: null,
        scrollX: false,
        scrollY: true,
        bodyHeight: 560,
        rowHeaders: ['checkbox'],
        rowHeight: 135,
        columns: [
          {
            header: '이미지',
            name: 'harumarket_product_picture',
            align: 'center',
            width:120,
            formatter: function(val) {
                //console.log(val.value);
                //console.log(value.row.rowKey);
                // const imgRegex = /<img[^>]*>/g;
                // const imgTags = val.value.match(imgRegex);
                // console.log(imgTags);

                const regex = /<img[^>]*src="([^"]*)"/g; // 정규 표현식
                const match = regex.exec(val.value);
                const srcValue = match[1];

                return `<img src="${srcValue}" width="100"></img>`;
            }
          },
          {
            header: '상품 이름',
            name: 'harumarket_product_name',
            align: 'center',
          },
          {
            header: '상품 색상',
            name: 'harumarket_productColor_name',
            align: 'center',
            width:100,
          },
          {
            header: '상품 크기',
            name: 'harumarket_productSize_name',
            align: 'center',
            width:100,
          },
          {
            header: '상품 개수',
            name: 'harumarket_userBasket_account',
            align: 'center',
            width:100,
          },
          {
            header: '상품 가격',
            name: 'harumarket_product_salePrice',
            align: 'center',
            width:100,
          },
        ],
    }),
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
    basket_select:function(){
        var formData = new FormData();
        formData.append("type", "basket_select");
        data = basket.ajax_send(formData,"./basket_api.php");

        basket.grid.resetData(data.msg);
    },
}

basket.init();