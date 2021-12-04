$(document).ready(function(){
  // do something

  // search through table
  $('#search').on('keyup', function(){
    var value = $(this).val().toLowerCase();
    $("#tableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

});

/**
  This function will add new drug classification
*/
$("#addDrugClassificationForm").submit(function(e){
  e.preventDefault();  // prevent window to reload
  var formData = $(this).serialize(); // get all the data in the form

  var baseUrl = window.location.origin; // get base url e.g http://example.com
  var apiPath = "/admin/medicine/drug_classification/add"; // api path
  var url = baseUrl+apiPath; // combine

  // send ajax request
  $.ajax({
    type: 'post', // set method to post
    url: url, // url
    data: formData, // attach formData
    success: function(data){
      window.location.reload(); // if no error reload window
    },
    error: function(xhr, textStatus, errorMessage){
      console.log(xhr.status); // otherwise display error
    }
  });
});
