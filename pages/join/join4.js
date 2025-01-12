let join4 = {
    init: function(){
        let _this = this;
        document.getElementById("ok").addEventListener("click", () => {
            _this.ok();
        });
    },
    ok: function(){
        location.href = "/index.php";
    },
}

join4.init();