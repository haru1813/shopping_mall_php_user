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
            name: 'harumarket_product_numbers',
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

        document.getElementById("test").addEventListener("click", () => {
            _this.test();
        });

        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-btn')) {
                const rowKey = event.target.dataset.rowKey;
                this.grid.removeRow(rowKey);
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
    },
    product_view: function(){
        //const new_products = document.querySelector('#new_products'); 
        //new_products.innerHTML = '';

        var formData = new FormData();
        formData.append("type", "product_view");
        let harumarket_product_index = localStorage.getItem("harumarket_product_index");
        formData.append("harumarket_product_index", harumarket_product_index);
        data = this.ajax_send(formData,"./product_detail_api.php");

        console.log(`상품 인덱스 ${harumarket_product_index}`);

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
                harumarket_product_name.innerText = item.harumarket_product_name

                const harumarket_product_originPrice = document.querySelector('#harumarket_product_originPrice'); 
                harumarket_product_originPrice.innerText = `${item.harumarket_product_originPrice}원`;

                const harumarket_product_salePrice = document.querySelector('#harumarket_product_salePrice'); 
                harumarket_product_salePrice.innerText = `${item.harumarket_product_salePrice}원`;

                const harumarket_product_content = document.querySelector('#harumarket_product_content'); 
                harumarket_product_content.innerHTML = item.harumarket_product_content;

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
    test:function(){
        const newRowData = {
            harumarket_product_index:1,
            harumarket_product_name: '상품 이름',
            harumarket_productColor_name: '상품 색상',
            harumarket_productSize_name: '상품 크기',
            harumarket_product_numbers: '1',
            delete: '삭제',
            harumarket_product_salePrice: 5000
        };

        this.grid.appendRow(newRowData);
    },
    impl_up: function(){
        const checkedRowKeys = this.grid.getCheckedRowKeys();

        if(checkedRowKeys.length == 0){
            toastr.error('개수를 증가할 상품을 선택하여 주십시오.');
            return;
        }

        checkedRowKeys.forEach(rowKey => {
            const row = this.grid.getRow(rowKey);
            let harumarket_product_numbers = Number(row.harumarket_product_numbers);

            if(harumarket_product_numbers >= 1){
                harumarket_product_numbers+=1;
                this.grid.setValue(rowKey, 'harumarket_product_numbers', harumarket_product_numbers);
            }
        });
    },
    impl_down : function(){
        const checkedRowKeys = this.grid.getCheckedRowKeys();

        if(checkedRowKeys.length == 0){
            toastr.error('개수를 감소할 상품을 선택하여 주십시오.');
            return;
        }

        checkedRowKeys.forEach(rowKey => {
            const row = this.grid.getRow(rowKey);
            let harumarket_product_numbers = Number(row.harumarket_product_numbers);

            if(harumarket_product_numbers > 1){
                harumarket_product_numbers-=1;
                this.grid.setValue(rowKey, 'harumarket_product_numbers', harumarket_product_numbers);
            }
        });
    },
    impl_alldelete : function(){
        this.grid.clear();
        toastr.error('선택한 상품을 전체 삭제하였습니다.');
    },
}

product_detail.init();