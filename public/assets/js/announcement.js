$("#announcement").submit(function(e){
  e.preventDefault();
  var formData = $(this).serializeArray();
  var err = $("#errMessage");
  var suc = $("#succMessage");

  // console.log(formData);
  if(formData[1].value == ""){
    err.removeClass("d-none");
    suc.addClass("d-none");
  }else{
    var baseUrl = window.location.origin;
    var apiPath = "/admin/announcement/new";
    var url = baseUrl+apiPath;

    $.ajax({
      type: 'post',
      url: url,
      data: formData,
      success: function(data){
        // do something
        // console.log(data);
        err.addClass("d-none");
        suc.removeClass("d-none");
        window.location.reload();
      },
      error: function(xhr, textStatus, errorMessage){
        // do something
        console.log(xhr.status);
      }
    });
  }

});
