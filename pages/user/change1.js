let change1 = {
    init: function(){
        let _this = this;

        _this.change1_init();

        document.getElementById("change1").addEventListener("click", () => {
            _this.change1();
        });
        document.getElementById("addressFind").addEventListener("click", () => {
            _this.addressFind();
        });
    },
    change1_init: function(){
        let formData = new FormData();
        formData.append("type", "id_find");
        data = ajax_send(formData,"./change1_api.php");

        document.getElementById('haruMarket_user_id').value = data.msg.haruMarket_user_id;
        document.getElementById('haruMarket_user_postCode').value = data.msg.haruMarket_user_postCode;
        document.getElementById('haruMarket_user_basicAddress').value = data.msg.haruMarket_user_basicAddress;
        document.getElementById('haruMarket_user_detailAddress').value = data.msg.haruMarket_user_detailAddress;
    },
    change1: function(){
        let haruMarket_user_pw = document.getElementById('haruMarket_user_pw').value;
        if(haruMarket_user_pw == ""){
            toastr.error('비밀번호를 입력하여 주십시오.');
            document.getElementById('haruMarket_user_pw').focus();
            return;
        }

        let haruMarket_user_postCode = document.getElementById('haruMarket_user_postCode').value;
        let haruMarket_user_basicAddress = document.getElementById('haruMarket_user_basicAddress').value;
        let haruMarket_user_detailAddress = document.getElementById('haruMarket_user_detailAddress').value;

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
        formData.append("type", "change1");

        formData.append("haruMarket_user_pw", haruMarket_user_pw);
        formData.append("haruMarket_user_postCode", haruMarket_user_postCode);
        formData.append("haruMarket_user_basicAddress", haruMarket_user_basicAddress);
        formData.append("haruMarket_user_detailAddress", haruMarket_user_detailAddress);

        data = ajax_send(formData,"./change1_api.php");

        if(data.code == "200"){
            toastr.success(data.msg);
        }
        else{
            toastr.error(data.msg);
        }
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
}

change1.init();