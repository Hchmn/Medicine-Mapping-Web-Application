$(document).ready(function(){
  // do something

  // search
  $('#searchPharmacy').on('keyup', function(){
    var value = $(this).val().toLowerCase();
    $("#tableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(function(){
  $("#verifyPharmacy").submit(function(e){
    e.preventDefault();
    var formData = $("#verifyPharmacy").serialize();
    
    var baseUrl = window.location.origin;
    
    var apiPath = "/verify/pharmacy";
    
    var url = baseUrl + apiPath;
    
    $.ajax({
      type: 'post',
      url: url,
      data: formData,
      success: function(data){
        // do something

        window.location.reload();
      },
      error: function(xhr, textStatus, errorMessage){
        // do something
        console.log(xhr.status);
      }
    });
  });
});
