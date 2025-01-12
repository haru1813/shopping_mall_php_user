let pw_find = {
    init: function(){
        let _this = this;
        document.getElementById("identity").addEventListener("click", () => {
            _this.identity();
        });
    },
    identity: function(){
        let haruMarket_user_id = document.getElementById('haruMarket_user_id').value;
        if(haruMarket_user_id == ""){
            toastr.error('아이디를 입력하여 주십시오.');
            document.getElementById('haruMarket_user_id').focus();
            return;
        }

        var IMP = window.IMP; // 생략 가능
        IMP.init("imp43126142");

        // 본인인증
        IMP.certification({ // param
        pg:'inicis.{MIIiasTest}',
        merchant_uid: "harubarter "+this.getYmd10(), // 주문 번호 개인적으로 설정 가능 
        popup:false
        }, function (rsp) { // callback
            console.log(rsp);
            if (rsp.success) {
                // 인증 성공 시 로직
                console.log("인증 성공");
                let formData = new FormData();
                formData.append('imp_uid',rsp.imp_uid);
                formData.append('haruMarket_user_id',haruMarket_user_id);
                data = ajax_send(formData,"./pw_find_api.php");
                //alert(data.msg);

                document.getElementById('msg').innerHTML = data.msg;
            } else {
                // 인증 실패 시 로직
                toastr.error('인증을 실패하였습니다.');
            }
        });
    },
    getYmd10: function () {
        var d = new Date();
        return d.getFullYear() + "-" + ((d.getMonth() + 1) > 9 ? (d.getMonth() + 1).toString() : "0" + (d.getMonth() + 1)) + "-" + (d.getDate() > 9 ? d.getDate().toString() : "0" + d.getDate().toString());
    },
}

pw_find.init();