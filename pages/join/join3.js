let join3 = {
    init: function(){
        let _this = this;
        document.getElementById("addressFind").addEventListener("click", () => {
            _this.addressFind();
        });
        document.getElementById("join").addEventListener("click", () => {
            _this.join();
        });
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
    join: function(){
        let haruMarket_user_id = document.getElementById('haruMarket_user_id').value;
        let haruMarket_user_pw = document.getElementById('haruMarket_user_pw').value;
        let haruMarket_user_pwCheck = document.getElementById('haruMarket_user_pwCheck').value;
        let haruMarket_user_postCode = document.getElementById('haruMarket_user_postCode').value;
        let haruMarket_user_basicAddress = document.getElementById('haruMarket_user_basicAddress').value;
        let haruMarket_user_detailAddress = document.getElementById('haruMarket_user_detailAddress').value;

        if(haruMarket_user_id == ""){
            toastr.error('아이디를 입력하여 주십시오.');
            document.getElementById('haruMarket_user_id').focus();
            return;
        }
        if(!this.validataTest(haruMarket_user_id)){
            toastr.error('아이디는 영소문자 또는 숫자만 포함하여 4~20자(20자) 입력하여주십시오.');
            document.getElementById('haruMarket_user_id').focus();
            return;
        }
        if(haruMarket_user_pw == ""){
            toastr.error('비밀번호를 입력하여 주십시오.');
            document.getElementById('haruMarket_user_pw').focus();
            return;
        }
        if(!this.validataTest(haruMarket_user_pw)){
            toastr.error('비밀번호는 영소문자 또는 숫자만 포함하여 4~20자(20자) 입력하여주십시오.');
            document.getElementById('haruMarket_user_pw').focus();
            return;
        }
        if(haruMarket_user_pw != haruMarket_user_pwCheck){
            toastr.error('비밀번호와 비밀번호 확인 값이 서로 다릅니다.');
            document.getElementById('haruMarket_user_pw').focus();
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
        formData.append("type", "join");
        formData.append("haruMarket_user_id", haruMarket_user_id);
        formData.append("haruMarket_user_pw", haruMarket_user_pw);
        formData.append("haruMarket_user_postCode", haruMarket_user_postCode);
        formData.append("haruMarket_user_basicAddress", haruMarket_user_basicAddress);
        formData.append("haruMarket_user_detailAddress", haruMarket_user_detailAddress);
        data = ajax_send(formData,"./join3_api.php");
        
        if(data.code == "200"){
            location.href = "./join4.php";
        }
        else{
            toastr.error(data.msg);
        }
    },
    validataTest: function(text){
        const regex = /^[a-z0-9]{1,20}$/;
        return regex.test(text);
    }
}

join3.init();