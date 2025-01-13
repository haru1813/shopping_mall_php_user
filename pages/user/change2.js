let change2 = {
    init: function(){
        let _this = this;

        document.getElementById("change2").addEventListener("click", () => {
            _this.change2();
        });
    },
    change2: function(){
        let haruMarket_user_pw = document.getElementById('haruMarket_user_pw').value;
        if(haruMarket_user_pw == ""){
            toastr.error('비밀번호를 입력하여 주십시오.');
            document.getElementById('haruMarket_user_pw').focus();
            return;
        }

        let haruMarket_user_changePw1 = document.getElementById('haruMarket_user_changePw1').value;
        let haruMarket_user_changePw2 = document.getElementById('haruMarket_user_changePw2').value;

        if(haruMarket_user_changePw1 == ""){
            toastr.error('바꿀 비밀번호를 입력하여 주십시오.');
            document.getElementById('haruMarket_user_changePw1').focus();
            return;
        }
        if(!this.validataTest(haruMarket_user_changePw1)){
            toastr.error('바꿀 비밀번호는 영소문자 또는 숫자만 포함하여 4~20자(20자) 입력하여주십시오.');
            document.getElementById('haruMarket_user_changePw1').focus();
            return;
        }
        if(haruMarket_user_changePw1 != haruMarket_user_changePw2){
            toastr.error('바꿀 비밀번호와 바꿀 비밀번호 확인 값이 서로 다릅니다.');
            document.getElementById('haruMarket_user_changePw1').focus();
            return;
        }

        let formData = new FormData();
        formData.append("type", "change2");

        formData.append("haruMarket_user_pw", haruMarket_user_pw);
        formData.append("haruMarket_user_changePw1", haruMarket_user_changePw1);

        data = ajax_send(formData,"./change2_api.php");

        if(data.code == "200"){
            toastr.success(data.msg);
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

change2.init();