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

        let formData = new FormData();
        formData.append("type", "testtest");
        data = ajax_send(formData,"./buy_api.php");
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
        let haruMarket_user_name = document.getElementById('haruMarket_user_name').value;
        let haruMarket_user_postCode = document.getElementById('haruMarket_user_postCode').value;
        let haruMarket_user_basicAddress = document.getElementById('haruMarket_user_basicAddress').value;
        let haruMarket_user_detailAddress = document.getElementById('haruMarket_user_detailAddress').value;

        if(haruMarket_user_name == ""){
            toastr.error('받는 사람 이름이 입력되지 않았습니다.');
            document.getElementById('haruMarket_user_name').focus();
            return;
        }
        if(haruMarket_user_name.length > 20){
            toastr.error('이름은 20자를 넘지 않도록 입력하여 주십시오.');
            document.getElementById('haruMarket_user_name').focus();
            return;
        }
        if(haruMarket_user_postCode == "" || haruMarket_user_basicAddress == ""){
            toastr.error('우편번호 버튼을 클릭하여 주소를 검색하여 주십시오.');
            return;
        }
        if(haruMarket_user_detailAddress == ""){
            toastr.error('상세 주소가 입력되지 않았습니다.');
            document.getElementById('haruMarket_user_detailAddress').focus();
            return;
        }
        if(haruMarket_user_detailAddress.length > 30){
            toastr.error('상세 주소는 30자를 넘지 않도록 입력하여 주십시오.');
            document.getElementById('haruMarket_user_detailAddress').focus();
            return;
        }

        let formData = new FormData();
        formData.append("type", "product_buy_try");
        data = ajax_send(formData,"./buy_api.php");

        IMP.init("imp43126142");
        IMP.request_pay(
            {
                pg: "html5_inicis", // PG사 코드표에서 선택
                pay_method: pay_method_value, // 결제 방식
                merchant_uid: `harumarket_${data.msg.haruMarket_user_phone}_${buy.merchant_uid_output()}`, // 결제 고유 번호
                name: `harumarket_${data.msg.haruMarket_user_phone}_${buy.merchant_uid_output()}`, // 제품명
                amount: data.msg.harumarket_product_salePrice, // 가격
                //구매자 정보 ↓
                buyer_email: "",
                buyer_name: haruMarket_user_name,
                buyer_tel: data.msg.haruMarket_user_phone,
                buyer_addr: `${haruMarket_user_basicAddress} ${haruMarket_user_detailAddress}`,
                buyer_postcode: haruMarket_user_postCode,
                },
                function (rsp) {
                if (rsp.success) {
                    // 인증 성공 시 로직,
                    //console.log(rsp);

                    let formData = new FormData();
                    formData.append("type", "product_buy");
                    formData.append("haruMarket_BuyMaster_order", rsp.merchant_uid);
                    formData.append("haruMarket_BuyMaster_buyerName", rsp.buyer_name);
                    formData.append("haruMarket_BuyMaster_buyerPostcode", rsp.buyer_postcode);
                    formData.append("haruMarket_BuyMaster_buyerAddr", rsp.buyer_addr);
                    formData.append("haruMarket_BuyMaster_buyerMethod", rsp.pay_method);
                    formData.append("haruMarket_BuyMaster_amount", rsp.paid_amount);
                    data = ajax_send(formData,"./buy_api.php");

                    if(data.code == "200"){
                        location.href="./buy_complete.php";
                    }
                    else{
                        toastr.error(data.msg);
                    }
                }
            }
        );
    },
    merchant_uid_output:function(){
        const today = new Date();

        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // 월은 0부터 시작하므로 1을 더하고, 2자리로 맞춤
        const day = String(today.getDate()).padStart(2, '0'); // 2자리로 맞춤
        const hours = String(today.getHours()).padStart(2, '0'); // 2자리로 맞춤
        const minutes = String(today.getMinutes()).padStart(2, '0'); // 2자리로 맞춤

        const formattedDate = `${year}${month}${day}${hours}${minutes}`;

        return formattedDate;
    },
}

buy.init();