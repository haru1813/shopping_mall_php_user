!(function () {
    function detectDevTool(allow) {
      if (isNaN(+allow)) allow = 100;
      var start = +new Date();
      debugger;
      var end = +new Date();
      if (isNaN(start) || isNaN(end) || end - start > allow) {
        document.write("F12 개발자 도구를 끄고 다시 접속해주시기 바랍니다.");
        alert("F12 개발자 도구를 끄고 다시 접속해주시기 바랍니다.");
      }
    }
  
    if (window.attachEvent) {
      if (
        document.readyState === "complete" ||
        document.readyState === "interactive"
      ) {
        detectDevTool();
        window.attachEvent("onresize", detectDevTool);
        window.attachEvent("onmousemove", detectDevTool);
        window.attachEvent("onfocus", detectDevTool);
        window.attachEvent("onblur", detectDevTool);
      } else {
        setTimeout(argument.callee, 0);
      }
    } else {
      window.addEventListener("load", detectDevTool);
      window.addEventListener("resize", detectDevTool);
      window.addEventListener("mousemove", detectDevTool);
      window.addEventListener("focus", detectDevTool);
      window.addEventListener("blur", detectDevTool);
    }
  })();
  
document.addEventListener('contextmenu', (event) => {
    event.preventDefault();
    alert('마우스 오른쪽 클릭은 허용되지 않습니다.');
});