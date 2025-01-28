let product_detail = {
    grid: new tui.Grid({
        el: document.getElementById('grid'),
        data: null,
        scrollX: false,
        scrollY: true,
        bodyHeight: 300,
        rowHeaders: ['checkbox'],
        columns: [
          {
            header: '상품 이름',
            name: 'harumarket_product_name',
            align: 'center',
          },
          {
            header: '상품 색상',
            name: 'harumarket_productColor_name',
            align: 'center',
          },
          {
            header: '상품 크기',
            name: 'harumarket_productSize_name',
            align: 'center',
          },
          {
            header: '상품 개수',
            name: 'harumarket_product_account',
            align: 'center'
          },
          {
            header: '삭제',
            name: 'delete',
            align: 'center',
            formatter: function(value) {
                console.log(value);
                console.log(value.row.rowKey);

                return `<button type="button" class="btn btn-danger btn-sm delete-btn" data-row-key="${value.row.rowKey}">삭제</button>`;
            }
          },
          {
            header: '상품 가격',
            name: 'harumarket_product_salePrice',
            align: 'center',
          },
        ]
    }),
    init: function(){
        let _this = this;
        _this.product_view();

        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-btn')) {
                const rowKey = event.target.dataset.rowKey;
                product_detail.grid.removeRow(rowKey);
                product_detail.total();
            }
        });

        document.addEventListener('change', (event) => {
            const targetElement = event.target;
            const elementId = targetElement.id;
        
            if(elementId == "harumarket_product_colorIndexs" || elementId == "harumarket_product_sizeIndexs"){
                _this.option_select();
            }
        });

        document.getElementById("impl_up").addEventListener("click", () => {
            _this.impl_up();
        });
        document.getElementById("impl_down").addEventListener("click", () => {
            _this.impl_down();
        });
        document.getElementById("impl_alldelete").addEventListener("click", () => {
            _this.impl_alldelete();
        });
        document.getElementById("buy").addEventListener("click", () => {
            _this.buy();
        });
        document.getElementById("basket").addEventListener("click", () => {
            _this.basket();
        });
    },
    harumarket_product_index: "",
    harumarket_product_name: "",
    harumarket_product_salePrice:"",
    harumarket_product_colorView:0,
    harumarket_product_sizeView:0,
    product_view: function(){
        //const new_products = document.querySelector('#new_products'); 
        //new_products.innerHTML = '';

        var formData = new FormData();
        formData.append("type", "product_view");
        product_detail.harumarket_product_index = localStorage.getItem("harumarket_product_index");
        formData.append("harumarket_product_index", this.harumarket_product_index);
        data = this.ajax_send(formData,"./product_detail_api.php");

        console.log(`상품 인덱스 : ${this.harumarket_product_index}`);

        const imgRegex = /<img[^>]*>/g;

        if(data.msg.length<=0){
            location.href="/index.php";
        }
        else{
            data.msg.forEach(function(item) {
                const imgTags = item.harumarket_product_picture.match(imgRegex);
                //console.log(imgTags);
                const harumarket_product_picture = document.querySelector('#harumarket_product_picture'); 
                harumarket_product_picture.innerHTML = '';
                harumarket_product_picture.innerHTML += `
                    ${imgTags}
                `;

                const image = harumarket_product_picture.querySelector('img');
                image.classList.add('img-fluid', 'rounded-start');

                const harumarket_product_name = document.querySelector('#harumarket_product_name'); 
                harumarket_product_name.innerText = item.harumarket_product_name;
                product_detail.harumarket_product_name = item.harumarket_product_name;

                const harumarket_product_originPrice = document.querySelector('#harumarket_product_originPrice'); 
                harumarket_product_originPrice.innerText = `${item.harumarket_product_originPrice}원`;

                const harumarket_product_salePrice = document.querySelector('#harumarket_product_salePrice'); 
                harumarket_product_salePrice.innerText = `${item.harumarket_product_salePrice}원`;
                product_detail.harumarket_product_salePrice = `${item.harumarket_product_salePrice}원`;

                const harumarket_product_content = document.querySelector('#harumarket_product_content'); 
                harumarket_product_content.innerHTML = item.harumarket_product_content;

                product_detail.harumarket_product_colorView = item.harumarket_product_colorView;
                if(item.harumarket_product_colorView==1){
                    let harumarket_product_colorIndexs = item.harumarket_product_colorIndexs.replace(/\{/g, "(").replace(/\}/g, ")");

                    formData.append("type", "harumarket_product_optionSelect");
                    formData.append("table_name", "harumarket_productcolor");
                    formData.append("harumarket_product_optionIndexs", harumarket_product_colorIndexs);
                    data2 = product_detail.ajax_send(formData,"./product_detail_api.php");

                    const harumarket_options = document.querySelector('#harumarket_options'); 
                    harumarket_options.innerHTML += '<select class="form-select mt-2" aria-label="Default select example" id="harumarket_product_colorIndexs">';
                    const harumarket_product_colorIndexsOption = document.querySelector('#harumarket_product_colorIndexs');
                    harumarket_product_colorIndexsOption.innerHTML += '<option value="" selected>[필수] 색상 옵션을 선택해주세요.</option>';
                    data2.msg.forEach(function(item2) {
                        harumarket_product_colorIndexsOption.innerHTML += `<option value="${item2.harumarket_productColor_index}">${item2.harumarket_productColor_name}</option>`;
                    });
                    harumarket_options.innerHTML += '</select>';
                }
                product_detail.harumarket_product_sizeView = item.harumarket_product_sizeView;
                if(item.harumarket_product_sizeView==1){
                    console.log(item.harumarket_product_sizeIndexs);

                    let harumarket_product_sizeIndexs = item.harumarket_product_sizeIndexs.replace(/\{/g, "(").replace(/\}/g, ")");

                    formData.append("type", "harumarket_product_optionSelect");
                    formData.append("table_name", "harumarket_productsize");
                    formData.append("harumarket_product_optionIndexs", harumarket_product_sizeIndexs);
                    data2 = product_detail.ajax_send(formData,"./product_detail_api.php");

                    const harumarket_options = document.querySelector('#harumarket_options'); 
                    harumarket_options.innerHTML += '<select class="form-select mt-2" aria-label="Default select example" id="harumarket_product_sizeIndexs">';
                    const harumarket_product_sizeIndexsOption = document.querySelector('#harumarket_product_sizeIndexs');
                    harumarket_product_sizeIndexsOption.innerHTML += '<option value="" selected>[필수] 크기 옵션을 선택해주세요.</option>';
                    data2.msg.forEach(function(item2) {
                        harumarket_product_sizeIndexsOption.innerHTML += `<option value="${item2.harumarket_productSize_index}">${item2.harumarket_productSize_name}</option>`;
                    });
                    harumarket_options.innerHTML += '</select>';
                }
            });
        }
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
    impl_up: function(){
        const checkedRowKeys = product_detail.grid.getCheckedRowKeys();

        if(checkedRowKeys.length == 0){
            toastr.error('개수를 증가할 상품을 선택하여 주십시오.');
            return;
        }

        checkedRowKeys.forEach(rowKey => {
            const row = product_detail.grid.getRow(rowKey);
            let harumarket_product_account = Number(row.harumarket_product_account);

            if(harumarket_product_account >= 1){
                harumarket_product_account+=1;
                product_detail.grid.setValue(rowKey, 'harumarket_product_account', harumarket_product_account);

                let price = Number(product_detail.harumarket_product_salePrice.replace(/,/g, '').replace(/원/g, '')) * harumarket_product_account;
                const currency = '원';
                const formattedPrice = price.toLocaleString('ko-KR') + currency;
                product_detail.grid.setValue(rowKey, 'harumarket_product_salePrice', formattedPrice);
            }
        });
        product_detail.total();
    },
    impl_down : function(){
        const checkedRowKeys = product_detail.grid.getCheckedRowKeys();

        if(checkedRowKeys.length == 0){
            toastr.error('개수를 감소할 상품을 선택하여 주십시오.');
            return;
        }

        checkedRowKeys.forEach(rowKey => {
            const row = product_detail.grid.getRow(rowKey);
            let harumarket_product_account = Number(row.harumarket_product_account);

            if(harumarket_product_account > 1){
                harumarket_product_account-=1;
                product_detail.grid.setValue(rowKey, 'harumarket_product_account', harumarket_product_account);

                let price = Number(product_detail.harumarket_product_salePrice.replace(/,/g, '').replace(/원/g, '')) * harumarket_product_account;
                const currency = '원';
                const formattedPrice = price.toLocaleString('ko-KR') + currency;
                product_detail.grid.setValue(rowKey, 'harumarket_product_salePrice', formattedPrice);
            }
        });
        product_detail.total();
    },
    impl_alldelete : function(){
        product_detail.grid.clear();
        toastr.error('선택한 상품을 전체 삭제하였습니다.');
        product_detail.total();
    },
    option_select: function(){
        let newRowData = {
            harumarket_product_index:product_detail.harumarket_product_index,
            harumarket_product_name: product_detail.harumarket_product_name,
            harumarket_product_account: '1',
            delete: '삭제',
            harumarket_product_salePrice: product_detail.harumarket_product_salePrice
        };
        let harumarket_productColor_index = "";
        let harumarket_productSize_index = "";

        if(product_detail.harumarket_product_colorView == 1 && product_detail.harumarket_product_sizeView == 1){
            let harumarket_product_colorIndexs = document.getElementById('harumarket_product_colorIndexs');
            let harumarket_productColor_obtion = harumarket_product_colorIndexs.options[harumarket_product_colorIndexs.selectedIndex];
            let harumarket_productColor_name = harumarket_productColor_obtion.text;
            harumarket_productColor_index = harumarket_productColor_obtion.value;

            if(harumarket_productColor_index == "")
                return;

            let harumarket_product_sizeIndexs = document.getElementById('harumarket_product_sizeIndexs');
            let harumarket_productSize_obtion = harumarket_product_sizeIndexs.options[harumarket_product_sizeIndexs.selectedIndex];
            let harumarket_productSize_name = harumarket_productSize_obtion.text;
            harumarket_productSize_index = harumarket_productSize_obtion.value;

            if(harumarket_productSize_index == "")
                return;

            newRowData.harumarket_productColor_name = harumarket_productColor_name;
            newRowData.harumarket_productColor_index = harumarket_productColor_index;
            newRowData.harumarket_productSize_name = harumarket_productSize_name;
            newRowData.harumarket_productSize_index = harumarket_productSize_index;
        };
        if(product_detail.harumarket_product_colorView == 1 && product_detail.harumarket_product_sizeView == 0){
            let harumarket_product_colorIndexs = document.getElementById('harumarket_product_colorIndexs');
            let harumarket_productColor_obtion = harumarket_product_colorIndexs.options[harumarket_product_colorIndexs.selectedIndex];
            let harumarket_productColor_name = harumarket_productColor_obtion.text;
            harumarket_productColor_index = harumarket_productColor_obtion.value;

            if(harumarket_productColor_index == "")
                return;

            newRowData.harumarket_productColor_name = harumarket_productColor_name;
            newRowData.harumarket_productColor_index = harumarket_productColor_index;
        };
        if(product_detail.harumarket_product_colorView == 0 && product_detail.harumarket_product_sizeView == 1){
            let harumarket_product_sizeIndexs = document.getElementById('harumarket_product_sizeIndexs');
            let harumarket_productSize_obtion = harumarket_product_sizeIndexs.options[harumarket_product_sizeIndexs.selectedIndex];
            let harumarket_productSize_name = harumarket_productSize_obtion.text;
            harumarket_productSize_index = harumarket_productSize_obtion.value;

            if(harumarket_productSize_index == "")
                return;

            newRowData.harumarket_productSize_name = harumarket_productSize_name;
            newRowData.harumarket_productSize_index = harumarket_productSize_index;
        };

        //product_detail.grid.appendRow(newRowData);
        const allData = product_detail.grid.getData();

        if(allData.length == 0){
            product_detail.grid.appendRow(newRowData);
        }

        let dataadd = true;

        allData.forEach(function(data, index) {
            if(product_detail.harumarket_product_colorView == 1 && product_detail.harumarket_product_sizeView == 1){
                if((harumarket_productColor_index == data.harumarket_productColor_index) &&
                (harumarket_productSize_index == data.harumarket_productSize_index)){
                    toastr.error("이미 해당 옵션으로 선택되어 있습니다.");
                    dataadd = false;
                }
            }
            if(product_detail.harumarket_product_colorView == 1 && product_detail.harumarket_product_sizeView == 0){
                if((harumarket_productColor_index == data.harumarket_productColor_index)){
                    toastr.error("이미 해당 옵션으로 선택되어 있습니다.");
                    dataadd = false;
                }
            }
            if(product_detail.harumarket_product_colorView == 0 && product_detail.harumarket_product_sizeView == 1){
                if((harumarket_productSize_index == data.harumarket_productSize_index)){
                    toastr.error("이미 해당 옵션으로 선택되어 있습니다.");
                    dataadd = false;
                }
            }
        });

        if(allData.length != 0 && dataadd){
            product_detail.grid.appendRow(newRowData);
        }

        product_detail.total();
    },
    total : function(){
        let allData = product_detail.grid.getData();

        if(allData.length == 0){
            document.getElementById("total").innerText = `0원 (0개)`;
        }
        else{
            let total_count = 0;
            let total_price = 0;

            allData.forEach(function(data, index) {
                let harumarket_product_account = Number(data.harumarket_product_account);
                total_count += harumarket_product_account;
                let harumarket_product_salePrice = Number(data.harumarket_product_salePrice.replace(/,/g, '').replace(/원/g, ''));
                total_price += harumarket_product_salePrice;
            });

            document.getElementById("total").innerText = `${total_price.toLocaleString('ko-KR')}원 (${total_count}개)`;
        }
    },
    buy:function(){},
    basket:function(){
        let allData = product_detail.grid.getData();

        if(allData.length == 0){
            toastr.error("상품 옵션을 선택하여 주십시오.");
        }
        else{
            allData.forEach(function(data, index) {
                var formData = new FormData();
                formData.append("type", "harumarket_userbasket");
                formData.append("harumarket_product_index", product_detail.harumarket_product_index);
                formData.append("harumarket_productColor_index", data.harumarket_productColor_index !== undefined ? data.harumarket_productColor_index : 0);
                formData.append("harumarket_productSize_index", data.harumarket_productSize_index !== undefined ? data.harumarket_productSize_index : 0);
                formData.append("harumarket_userBasket_account", data.harumarket_product_account);

                // for (const [key, value] of formData.entries()) {
                //     console.log(key, value);
                // }

                data = this.ajax_send(formData,"./product_detail_api.php");

                if(data.code == "200"){
                    toastr.success(data.msg);
                }
                else{
                    toastr.error(data.msg);
                }
            });
        }
    },
}

product_detail.init();