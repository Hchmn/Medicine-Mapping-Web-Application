
$(
  function(){
    $("#loginForm").submit(function(e){
      e.preventDefault();

      var formData = $("#loginForm").serialize();

      var baseUrl = window.location.origin;

      var apiPath = "/verify/credentials";

      var url = baseUrl + apiPath;


      $.ajax({
        type: 'post',
        url: url,
        data: formData,
        success: function(data){
          // do something
          if(!data){
            $("#inputUsername").val("");
            $("#inputPassword").val("");
            $("#inputUsername").addClass("is-invalid");
            $("#inputPassword").addClass("is-invalid");
          }else{
            window.location.replace(baseUrl+"/admin/dashboard");
          }
        },
        error: function(xhr, textStatus, errorMessage){
          // do something
          console.log(xhr.status);
        }
      });

    });
  }
);
