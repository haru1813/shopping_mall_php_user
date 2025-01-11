if (/Android|iPhone/i.test(navigator.userAgent)) {
    const pc = document.getElementById("pc");
    pc.style.display = 'none';
}
else {
    const pc = document.getElementById("pc");
    pc.style.width = (screen.width + 0) + "px";
    pc.style.display = 'block';
}

function ajax_send(formData, url){
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
}