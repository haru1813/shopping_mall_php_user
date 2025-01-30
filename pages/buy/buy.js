let buy = {
    init: function(){
        let _this = this;

        const informationRadio = document.querySelectorAll('input[name="informationRadio"]');
        informationRadio.forEach(radioButton => {
          radioButton.addEventListener('change', () => {
            if (radioButton.checked) {
              if(radioButton.value==1){
                buy.information_find();
              }
              else{
                buy.information_clear();
              }
            }
          });
        });

        buy.information_find();

        document.getElementById("addressFind").addEventListener("click", () => {
            _this.addressFind();
        });

        buy.product_information_find();

        document.addEventListener('click', (event) => {
            const clickedElement = event.target;
            const clickedElementId = clickedElement.id;
            if (clickedElementId){
                if( 
                    clickedElementId=="card"||
                    clickedElementId=="phone"||
                    clickedElementId=="naverpay"||
                    clickedElementId=="kakaopay"
                ){
                    buy.purchase(clickedElementId);
                }
            }
        });
    },
    information_find: function(){
        let formData = new FormData();
        formData.append("type", "information_find");
        data = ajax_send(formData,"./buy_api.php");
        //console.log(data);

        document.getElementById('haruMarket_user_name').value = data.msg.haruMarket_user_name;
        document.getElementById('haruMarket_user_postCode').value = data.msg.haruMarket_user_postCode;
        document.getElementById('haruMarket_user_basicAddress').value = data.msg.haruMarket_user_basicAddress;
        document.getElementById('haruMarket_user_detailAddress').value = data.msg.haruMarket_user_detailAddress;
    },
    information_clear: function(){
        document.getElementById('haruMarket_user_name').value = "";
        document.getElementById('haruMarket_user_postCode').value = "";
        document.getElementById('haruMarket_user_basicAddress').value = "";
        document.getElementById('haruMarket_user_detailAddress').value = "";
    },
    addressFind: function(){
        new daum.Postcode({
            oncomplete: function(data) {
                var roadAddr = data.roadAddress; // 도로명 주소 변수
                var jibunAddress = data.jibunAddress; // 지번 주소 변수
                var extraRoadAddr = ''; // 참고 항목 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }

                document.getElementById('haruMarket_user_postCode').value = data.zonecode;
                if(roadAddr == ""){
                    document.getElementById('haruMarket_user_basicAddress').value = roadAddr;
                }
                else{
                    document.getElementById('haruMarket_user_basicAddress').value = jibunAddress;
                }
            }
        }).open();
    },
    product_information_find:function(){
        let formData = new FormData();
        formData.append("type", "product_information_find");
        data = ajax_send(formData,"./buy_api.php");
        const product_informations = JSON.parse(data.msg);

        let harumarket_product_totalPrice = 0;

        product_informations.forEach(product_information => {
            let formData = new FormData();
            formData.append("type", "product_information_view");
            formData.append("harumarket_product_index", product_information.harumarket_product_index);
            formData.append("harumarket_productColor_index", product_information.harumarket_productColor_index);
            formData.append("harumarket_productSize_index", product_information.harumarket_productSize_index);
            formData.append("harumarket_product_count", product_information.harumarket_product_count);
            data = ajax_send(formData,"./buy_api.php");

            const regex = /<img[^>]*src="([^"]*)"/g; // 정규 표현식
            const match = regex.exec(data.msg[0].harumarket_product_picture);
            const srcValue = match[1];

            harumarket_product_totalPrice += Number(data.msg[0].harumarket_product_salePrice);

            document.getElementById('order_products').innerHTML += `
                <div class="row border border-dark rounded mb-2">
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <img src="${srcValue}" class="img-thumbnail" width="100" style="cursor:pointer" onclick="buy.location_href(${product_information.harumarket_product_index})">
                    </div>
                    <div class="col-10">
                        <p class="text-dark" style="cursor:pointer" onclick="buy.location_href(${product_information.harumarket_product_index})">
                            ${data.msg[0].harumarket_product_name}
                        </p>
                        <p class="text-secondary mb-0">
                            [옵션: ${data.msg[0].harumarket_productColor_name === null ? "" : data.msg[0].harumarket_productColor_name} ${data.msg[0].haruMarket_productCategory_name === null ? "" : data.msg[0].haruMarket_productCategory_name}]
                        </p>
                        <p class="text-secondary">
                            수량: ${product_information.harumarket_product_count}개
                        </p>
                        <p class="text-dark mb-0">
                            ${data.msg[0].harumarket_product_salePrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')}원
                        </p>
                    </div>
                </div>
            `;
        });

        document.getElementById('harumarket_product_totalPrice').innerHTML = `최종 결제 금액 : ${harumarket_product_totalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')}원`;
    },
    location_href: function(harumarket_product_index){
        localStorage.setItem("harumarket_product_index", harumarket_product_index);
        location.href = `/pages/product/product_detail.php`;
    },
    purchase:function(pay_method_value){
        IMP.init("imp43126142");
        IMP.request_pay(
            {
                pg: "html5_inicis", // PG사 코드표에서 선택
                pay_method: pay_method_value, // 결제 방식
                merchant_uid: `test`, // 결제 고유 번호
                name: "harumarket", // 제품명
                amount: 1000, // 가격
                //구매자 정보 ↓
                buyer_email: "",
                buyer_name: "박하루",
                buyer_tel: "???",
                //buyer_addr: document.getElementById("order_address").value,
                //buyer_postcode: document.getElementById("order_postcode").value,
                //m_redirect_url: window.location.origin + "/common/account2.php",
                },
                function (rsp) {
                if (rsp.success) {
                    // 인증 성공 시 로직,
                }
            }
        );
    },
}

buy.init();