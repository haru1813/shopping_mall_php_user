let join1 = {
    init: function(){
        let _this = this;
        document.getElementById("next").addEventListener("click", () => {
            _this.next();
        });
        document.getElementById("allCheck").addEventListener("click", () => {
            _this.allCheck();
        });
    },
    next: function(){
        const check1 = document.getElementById('check1');
        const check2 = document.getElementById('check2');

        if(check1.checked && check2.checked){
            location.href = "./join2.php";
        }
        else{
            toastr.error('이용약관 동의를 체크하지 않으셨습니다.');
        }
    },
    allCheck: function(){
        let check1 = document.getElementById('check1');
        let check2 = document.getElementById('check2');

        check1.checked = !check1.checked;
        check2.checked = !check2.checked;
    }
}

join1.init();