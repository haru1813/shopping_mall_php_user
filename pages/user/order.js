let order = {
    init: function(){
        let _this = this;

        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('img-link') || event.target.classList.contains('span-link')) {
                const rowKey = event.target.dataset.rowKey;

                const row = order.grid.getRow(rowKey);

                localStorage.setItem("harumarket_product_index", row.harumarket_product_index);
                location.href = `/pages/product/product_detail.php`;
            }
        });

        _this.order_select();
    },
    grid: new tui.Grid({
        el: document.getElementById('grid'),
        data: null,
        scrollX: false,
        scrollY: true,
        bodyHeight: 650,
        // rowHeaders: ['checkbox'],
        rowHeight: 140,
        columns: [
          {
            header: '이미지',
            name: 'harumarket_product_picture',
            align: 'center',
            width:120,
            formatter: function(val) {
                const regex = /<img[^>]*src="([^"]*)"/g; // 정규 표현식
                const match = regex.exec(val.value);
                const srcValue = match[1];

                return `<img src="${srcValue}" width="100" style="cursor:pointer" class="img-thumbnail img-link" data-row-key="${val.row.rowKey}"></img>`;
            }
          },
          {
            header: '결제 정보',
            name: 'harumarket_product_name',
            align: 'center',
            formatter: function(val) {
              console.log(val.row);
              return `
                <span style="cursor:pointer" class="span-link" data-row-key="${val.row.rowKey}">${val.value}</span><br/><br/>
                <p>주문자 성함 : ${val.row.haruMarket_BuyMaster_buyerName}</p>
                <p>주문자 우편번호 : ${val.row.haruMarket_BuyMaster_buyerPostcode}</p>
                <p>주문자 주소 : ${val.row.haruMarket_BuyMaster_buyerAddr}</p>
                <p>주문 날짜 : ${val.row.haruMarket_BuyMaster_insertTime}</p>
              `;
            }
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
            name: 'harumarket_buyDetail_account',
            align: 'center',
            width:100,
          },
          {
            header: '상품 가격',
            name: 'harumarket_product_salePrice',
            align: 'center',
            width:100,
            formatter: function(val) {
              return `<span>${val.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')}원</span>`;
            }
          },
          {
            header: '주문 상태',
            name: 'haruMarket_BuyMaster_status',
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
    order_select:function(){
        var formData = new FormData();
        formData.append("type", "order_select");
        data = order.ajax_send(formData,"./order_api.php");

        order.grid.resetData(data.msg);
    },
}

order.init();