let basket = {
    init: function(){
        let _this = this;

        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('img-link') || event.target.classList.contains('span-link')) {
                const rowKey = event.target.dataset.rowKey;
                //console.log(rowKey);
                // product_detail.grid.removeRow(rowKey);
                // product_detail.total();

                const row = basket.grid.getRow(rowKey);
                //console.log(row);
                localStorage.setItem("harumarket_product_index", row.harumarket_product_index);
                location.href = `/pages/product/product_detail.php`;
            }
        });

        _this.basket_select();

        document.getElementById("delete").addEventListener("click", () => {
            _this.delete();
        });
        document.getElementById("order").addEventListener("click", () => {
          _this.order();
      });
    },
    grid: new tui.Grid({
        el: document.getElementById('grid'),
        data: null,
        scrollX: false,
        scrollY: true,
        bodyHeight: 560,
        rowHeaders: ['checkbox'],
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
            header: '상품 이름',
            name: 'harumarket_product_name',
            align: 'center',
            formatter: function(val) {
              return `<span style="cursor:pointer" class="span-link" data-row-key="${val.row.rowKey}">${val.value}</span>`;
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
            name: 'harumarket_userBasket_account',
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

        basket.total();
    },
    total : function(){
      let allData = basket.grid.getData();

      if(allData.length == 0){
          document.getElementById("total").innerText = `0원 (0개)`;
      }
      else{
          let total_count = 0;
          let total_price = 0;

          allData.forEach(function(data, index) {
              let harumarket_product_account = Number(data.harumarket_userBasket_account);
              total_count += harumarket_product_account;
              let harumarket_product_salePrice = Number(data.harumarket_product_salePrice.replace(/,/g, '').replace(/원/g, ''));
              total_price += harumarket_product_salePrice;
          });

          document.getElementById("total").innerText = `${total_price.toLocaleString('ko-KR')}원 (${total_count}개)`;
      }
  },
  delete: function(){
    const checkedRowKeys = basket.grid.getCheckedRowKeys();

    if(checkedRowKeys.length == 0){
      toastr.error('삭제할 상품을 선택하여 주십시오.');
      return;
    }
    checkedRowKeys.forEach(rowKey => {
        const row = basket.grid.getRow(rowKey);

        var formData = new FormData();
        formData.append("type", "basket_delete");
        formData.append("harumarket_userBasket_index", row.harumarket_userBasket_index);
        data = basket.ajax_send(formData,"./basket_api.php");

        if(data.code == "200"){
            toastr.success(data.msg);
        }
        else{
            toastr.error(data.msg);
        }
    });
    basket.basket_select();
    basket.total();
  },
  order: function(){
    const checkedRowKeys = basket.grid.getCheckedRowKeys();

    if(checkedRowKeys.length == 0){
      toastr.error('주문할 상품을 선택하여 주십시오.');
      return;
    }
    const harumarket_userBasket_indexs = [];
    const harumarket_userBuy = [];
    
    checkedRowKeys.forEach(rowKey => {
        const row = basket.grid.getRow(rowKey);

        harumarket_userBasket_indexs.push(row.harumarket_userBasket_index);

        const harumarket_userBuyItem = {};
        harumarket_userBuyItem["harumarket_product_index"] = row.harumarket_product_index;
        harumarket_userBuyItem["harumarket_productColor_index"] = row.harumarket_productColor_index; 
        harumarket_userBuyItem["harumarket_productSize_index"] = row.harumarket_productSize_index; 
        harumarket_userBuyItem["harumarket_product_count"] = row.harumarket_userBasket_account; 

        harumarket_userBuy.push(harumarket_userBuyItem);
    });
    //console.log(harumarket_userBasket_indexs);
    //console.log(harumarket_userBuy);

    var formData = new FormData();
    formData.append("type", "buy_ready");
    formData.append("harumarket_userBasket_indexs", JSON.stringify(harumarket_userBasket_indexs));
    formData.append("harumarket_userBuy", JSON.stringify(harumarket_userBuy));
    data = basket.ajax_send(formData,"/pages/buy/buy_api.php");

    if(data.code == "200"){
      location.href = "/pages/buy/buy.php";
    }
  },
}

basket.init();